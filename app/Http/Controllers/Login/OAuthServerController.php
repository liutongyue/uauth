<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\UnauthorizedException;
use UAuth\Modules\OAuthModule;
use UAuth\Modules\UserModule;
use UAuth\OutServiceManager;

class OAuthServerController extends Controller
{

    private $outServiceManager;

    private $app;

    /**
     * @var OAuthModule
     */
    private $authModule;


    public function __construct(OutServiceManager $outServiceManager, Request $request)
    {
        $this->outServiceManager = $outServiceManager;
    }

    //登录页面
    public function oauthLoginPage(Request $request)
    {
        $this->validate($request, [
            'app_id' => 'required',
            'redirect_url' => 'required',
            'time' => 'required',
            'sign_key' => 'required',
        ]);
        //初始化OAuth
        $this->initOAuth($request);

        //2分钟超时
        if ($request->input('time') <= time() - 1200000) {
            return '验证超时';
        }

//todo:待取消注释后测试
//        //验证签名
//        if (!OAuthService::checkSign($app, $request->all())) {
//            return '非法操作';
//        }

        //验证当前是否登录
        if ($this->authModule->hasLogin()) {

            //已登录跳转回相应应用
            return $this->jumpTo($request->input('redirect_url'), $this->authModule->getAccess());
        } else {
            //未登录显示登录页面
            return view('sso.oauth_login', ['app' => $this->app]);
        }
    }

    //验证页面
    public function oauthLogin(Request $request)
    {
        $this->validate($request, [
            'app_id' => 'required',
            'username' => 'required',
            'password' => 'required',
            'redirect_url' => 'required',
            'sms' => ''
        ]);

        //初始化OAuth
        $this->initOAuth($request);

        //验证用户信息
        $user_module = new UserModule($this->app);
        list($isLogin, $user) = $user_module->checkUserLogin($request->input('username'), $request->input('password'));

        if ($isLogin) {

            //登录
            try {
                $this->authModule->login($user);
            } catch (\Exception $e) {
                return '错误：' . $e->getMessage();
            }

            //跳转回相应应用
            return $this->jumpTo($request->input('redirect_url'), $this->authModule->getAccess());
        } else {

            return redirect()->back()->withErrors(['msg' => '您的账号或密码错误！'])->withInput();
        }
    }

    /**
     * 登出
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function oauthLogout(Request $request)
    {
        $this->initOAuth($request);

//todo:待取消注释后测试
//        //验证签名
//        if (!OAuthService::checkSign($app, $request->all())) {
//            return '非法操作';
//        }

        //如已登录，则触发登出
        if ($user = $this->authModule->hasLogin()) {

            //登出
            $this->authModule->logout();
        }

        //跳转回相应应用
        return $this->jumpTo($request->input('redirect_url'));
    }

    /**
     * 生成跳转回相应应用的response
     *
     * @param $redirect_url
     * @param null|string $access
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function jumpTo($redirect_url, $access = null)
    {
        //添加加密的用户信息
        if ($access) {
            $redirect_url .= '?' . http_build_query(['access' => $access]);
        }

        return redirect($redirect_url);
    }


    /**
     * 初始化OAuth
     * @param Request $request
     */
    private function initOAuth(Request $request)
    {
        $this->app = $this->outServiceManager->getAppById($request->get('app_id'));

        if (!$this->app) {
            throw new UnauthorizedException('未授权的登录');
        }

        $this->authModule = app()->makeWith(OAuthModule::class, ['app' => $this->app]);
    }
}
