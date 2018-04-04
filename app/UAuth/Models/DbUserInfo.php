<?php
/**
 * Created by PhpStorm.
 * User: liutongyue
 * Date: 2018/4/3
 * Time: 下午5:22
 */

namespace UAuth\Models;


/**
 * DB用户信息
 * Class DbUserInfo
 * @package UAuth\Models
 */
class DbUserInfo
{
    public $name;

    public $host;
    public $port;
    public $username;
    public $password;

    public $user_table;
    public $user_table_usernames;
    public $user_table_password;

    public $attrs = [];


    function __construct($configs)
    {
        $user_table_username = array_get($configs, 'user_table_username');

        $this->name = array_get($configs, 'name');
        $this->host = array_get($configs, 'host', '127.0.0.1');
        $this->port = array_get($configs, 'port', 3306);
        $this->username = array_get($configs, 'username');
        $this->password = array_get($configs, 'password');

        $this->user_table = array_get($configs, 'user_table');
        $this->user_table_usernames = is_array($user_table_username) ? $user_table_username : [$user_table_username];
        $this->user_table_password = array_get($configs, 'user_table_password');

        foreach ($configs as $key => $value) {

            if (!isset($this->{$key})) {
                $this->attrs[$key] = $value;
            }
        }

    }

    /**
     * 转换为DB配置
     * @return array
     */
    public function convertToDB()
    {
        $origin = [
            'host' => $this->host,
            'port' => $this->port,
            'database' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
        ];

        return array_merge($origin, $this->attrs);
    }

}