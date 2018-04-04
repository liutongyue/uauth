<?php
///**
// * Created by PhpStorm.
// * User: reatang
// * Date: 2017/9/8
// * Time: 下午4:58
// */
//
//namespace UAuth;
//
//
//use App\Library\Crypt\Aes;
//use Illuminate\Contracts\Container\Container;
//use Illuminate\Contracts\Session\Session;
//use Illuminate\Support\Facades\Auth;
//use UAuth\Models\AppInfo;
//
//class OAuthService
//{
//    /**
//     * @var Container
//     */
//    protected $session;
//
//    /**
//     * @var UserManage
//     */
//    protected $user_model;
//
//    /**
//     * @var string
//     */
//    protected $session_name = '_oauth_info';
//
//    public function __construct(Session $session, AppInfo $app)
//    {
//        $this->session = $session;
//        $this->user_model = $userManage;
//    }
//
//    /**
//     * 获取当前登录的用户
//     *
//     * @return UserManage
//     */
//    public function getLoginUser()
//    {
//        return $this->user_model->find($this->getUserId());
//    }
//
//    /**
//     * 加密的用户信息
//     *
//     * @param AppInfo $app 指向应用
//     *
//     * @return $string
//     */
//    public function getAccess(AppInfo $app)
//    {
//        $crypt_key = $app->crypt_key;
//
//        $aes = new Aes($crypt_key);
//
//        $data = [
//            'user_id' => $this->getUserId()
//        ];
//
//        return $aes->encrypt(json_encode($data, JSON_UNESCAPED_UNICODE));
//    }
//
//    /**
//     * 检查sign
//     *
//     * @param AppInfo $app
//     * @param $data
//     *
//     * @return bool
//     */
//    public static function checkSign(AppInfo $app, $data)
//    {
//        $crypt_key = $app->crypt_key;
//        $params['app_id'] = $app->app_id;
//        $params['redirect_url'] = $data['redirect_url'];
//        $params['time'] = $data['time'];
//        ksort($params);
//        $sign_key = sha1($crypt_key . http_build_query($params));
//
//        return $sign_key === $data['sign_key'];
//    }
//
//    /**
//     * @return bool
//     */
//    public static function hasLogin()
//    {
//        return self::getUserId() > 0;
//    }
//
//    /**
//     * @return bool
//     */
//    public function login($user)
//    {
//
//        if ($this->hasLogin()) {
//            throw new \Exception("请先退出已登录的账号:" . $this->getLoginUser()['display_name'], 403);
//        }
//
//        $session = $this->session->get($this->session_name, []);
//
//        $this->session->put($this->session_name, array_merge($session, [
//            'user_id' => $user->id
//        ]));
//
//        return true;
//    }
//
//    /**
//     * 登出
//     */
//    public static function logout()
//    {
////        $this->session->remove($this->session_name);
//    }
//
//    /**
//     * 获取当前OAUTH登录用户ID
//     *
//     * @return mixed
//     */
//    protected static function getUserId()
//    {
//
//        return Auth::id();
//    }
//
//}