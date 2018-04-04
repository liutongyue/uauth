<?php
/**
 * Created by PhpStorm.
 * User: liutongyue
 * Date: 2018/4/3
 * Time: 下午3:07
 */

return [

    //一个登录系统配置
    [
        'sys_key' => '2kA9G5qOmBs4Pv6mmB2lAHsH',//用于apps中登录的统一session标识
        'apps' => [//多个app共享一个登录
            [
                'name' => 'Demo系统1',
                'app_id' => 'uauth-demo',
                'crypt_key' => '6b45225992a2e42f22551f39945fed2e1adbf658',
            ],

            [
                'name' => 'Demo系统2',
                'app_id' => 'uauth-demo-second',
                'crypt_key' => '7a1c77ece7f6ad768146dbbd761a7112bb7a7a63',
            ],
            
            //...
        ],
        'db' => [
            //用户表
            'user_table' => 'users',
            'user_table_username' => ['name', 'email'],//支持多列登录，如手机号、邮箱
            'user_table_password' => 'password',

            //数据库配置
            'name' => 'oauth',
            'host' => '127.0.0.1',
            'port' => '3306',
            'username' => 'root',
            'password' => '1qaz2wsx',

            //数据库额外配置
            'driver' => 'mysql',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]
    ],

    //...

];