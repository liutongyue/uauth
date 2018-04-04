<?php
/**
 * Created by PhpStorm.
 * User: liutongyue
 * Date: 2018/4/3
 * Time: 下午4:58
 */

namespace UAuth\Modules;


use App\Library\Crypt\Aes;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Session\Session;
use UAuth\Models\AppInfo;

class OAuthModule
{
    /**
     * @var Container
     */
    protected $session;

    /**
     * @var AppInfo
     */
    protected $app;

    /**
     * @var UserModule
     */
    protected $user_module;

    /**
     * @var string
     */
    protected $session_name = 'oauth_info_';


    public function __construct(Session $session, AppInfo $app)
    {
        $this->session = $session;
        $this->app = $app;

        $this->user_module = new UserModule($this->app);
    }

    /**
     * 获取当前登录的用户
     *
     * @return array
     */
    public function getLoginUser()
    {
        return $this->user_module->getUserInfo($this->getUserId());
    }

    /**
     * 加密的用户信息
     *
     * @param AppInfo $app 指向应用
     *
     * @return $string
     */
    public function getAccess()
    {
        $crypt_key = $this->app->crypt_key;

        $aes = new Aes($crypt_key);

        $data = [
            'user_id' => $this->getUserId()
        ];

        return $aes->encrypt(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 检查sign
     *
     * @param $data
     * @return bool
     */
    public function checkSign($data)
    {
        $crypt_key = $this->app->crypt_key;
        $params['app_id'] = $this->app->app_id;
        $params['redirect_url'] = $data['redirect_url'];
        $params['time'] = $data['time'];
        ksort($params);
        $sign_key = sha1($crypt_key . http_build_query($params));

        return $sign_key === $data['sign_key'];
    }

    /**
     * @return bool
     */
    public function hasLogin()
    {
        return self::getUserId() > 0;
    }

    /**
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function login($user)
    {

        if ($this->hasLogin()) {
            throw new \Exception("请先退出已登录的账号", 403);
        }

        $session_key = $this->getSessionKey();
        $session = $this->session->get($session_key, []);

        $this->session->put($session_key, array_merge($session, [
            'user_id' => $user->id
        ]));

        return true;
    }

    /**
     * 登出
     */
    public function logout()
    {
        $this->session->remove($this->getSessionKey());
    }

    /**
     * 获取当前OAUTH登录用户ID
     *
     * @return mixed
     */
    protected function getUserId()
    {
        $session = $this->session->get($this->getSessionKey(), []);

        return array_get($session, 'user_id', null);
    }

    private function getSessionKey()
    {
        return $this->session_name . $this->app->sys_key;
    }

}