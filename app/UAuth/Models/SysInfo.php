<?php
/**
 * Created by PhpStorm.
 * User: liutongyue
 * Date: 2018/4/3
 * Time: 下午5:22
 */

namespace UAuth\Models;

/**
 * 系统信息
 * Class AppInfo
 * @package UAuth\Models
 */
class SysInfo
{
    public $sys_key;
    public $apps;

    /**
     * @var DbUserInfo
     */
    public $db;


    function __construct($configs)
    {
        $this->sys_key = array_get($configs, 'sys_key');
        $this->apps = [];

        $apps = array_get($configs, 'apps');
        $db = array_get($configs, 'db');

        foreach ($apps as $app_config) {
            $app_config = array_merge($db, $app_config);
            $app_config['sys_key'] = $this->sys_key;

            $this->apps[] = new AppInfo($app_config);
        }

    }

}