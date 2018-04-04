<?php
/**
 * Created by PhpStorm.
 * User: liutongyue
 * Date: 2018/4/3
 * Time: 下午3:16
 */

namespace UAuth\Modules;


use UAuth\Models\AppInfo;
use UAuth\Models\SysInfo;
use UAuth\Models\User;

/**
 * 用户管理
 * Class UserManager
 * @package UAuth
 */
class UserModule
{

    private $app;

    function __construct(AppInfo $app)
    {
        $this->app = $app;
    }

    /**
     * 检查用户登录，并返回用户信息
     * @param $userName
     * @param $userPwd
     * @return array
     */
    public function checkUserLogin($userName, $userPwd)
    {
        $user = User::getUserInfoByUName($this->app, $userName);

        return [password_verify($userPwd, $user->{$this->app->db->user_table_password}), $user];
    }

    /**
     * 根据用户Id获取用户信息
     * @param $user_id
     * @return array
     */
    public function getUserInfo($user_id)
    {
        $user = User::getUserInfoByUId($this->app, $user_id);

        return $user;
    }
}