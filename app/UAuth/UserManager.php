<?php
///**
// * Created by PhpStorm.
// * User: liutongyue
// * Date: 2018/4/3
// * Time: 下午3:16
// */
//
//namespace UAuth;
//
//
//use UAuth\Models\AppInfo;
//use UAuth\Models\SysInfo;
//use UAuth\Models\User;
//
///**
// * 用户管理
// * Class UserManager
// * @package UAuth
// */
//class UserManager
//{
//
//    /**
//     * 检查用户登录，并返回用户信息
//     * @param AppInfo $app
//     * @param $userName
//     * @param $userPwd
//     * @return array
//     */
//    public static function checkUserLogin(AppInfo $app, $userName, $userPwd)
//    {
//        $user = User::getUserInfoByUName($app, $userName);
//
//        return [password_verify($userPwd, $user->{$app->db->user_table_password}), $user];
//    }
//
//}