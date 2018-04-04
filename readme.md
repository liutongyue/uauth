# 用户授权中心

用户授权中心项目目的是为了提供中心化的用户登录功能。

## 配置

修改config/outservice.php

一个登录系统配置Demo如下：

```
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
            'user_table_username' => ['mobile', 'email'],//支持多列登录，如手机号、邮箱
            'user_table_password' => 'password',
    
            //数据库配置
            'name' => 'oauth',
            'host' => '127.0.0.1',
            'port' => '3306',
            'username' => 'root',
            'password' => 'password',
    
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
```
