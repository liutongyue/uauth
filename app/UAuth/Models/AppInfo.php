<?php
/**
 * Created by PhpStorm.
 * User: liutongyue
 * Date: 2018/4/3
 * Time: 下午5:22
 */

namespace UAuth\Models;

/**
 * App信息
 * Class AppInfo
 * @package UAuth\Models
 */
class AppInfo
{
    public $sys_key;

    public $name;
    public $app_id;
    public $crypt_key;

    /**
     * @var DbUserInfo
     */
    public $db;


    function __construct($configs)
    {
        $this->sys_key = array_get($configs, 'sys_key');

        $this->name = array_get($configs, 'name');
        $this->app_id = array_get($configs, 'app_id');
        $this->crypt_key = array_get($configs, 'crypt_key');

        $this->db = new DbUserInfo(array_get($configs, 'db'));
    }

}