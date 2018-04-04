<?php
/**
 * Created by PhpStorm.
 * User: liutongyue
 * Date: 2018/4/3
 * Time: 下午3:16
 */

namespace UAuth;


use UAuth\Models\AppInfo;
use UAuth\Models\SysInfo;

/**
 * 外部服务管理
 * Class OutServiceManager
 * @package UAuth
 */
class OutServiceManager
{

    public static $apps = null;

    function __construct()
    {
        if (self::$apps === null) {
            $this->loadConfig();
        }
    }

    private function loadConfig()
    {
        $configs = config('outservice');
        self::$apps = [];

        foreach ($configs as $sys_config) {
            $sys_key = array_get($sys_config, 'sys_key');
            $db = array_get($sys_config, 'db');

            $app_configs = array_get($sys_config, 'apps');

            foreach ($app_configs as $app_config) {
                $app_config['db'] = $db;
                $app_config['sys_key'] = $sys_key;

                self::$apps[] = new AppInfo($app_config);
            }
        }
    }

    /**
     * 通过app_id获取App信息
     * @param $app_id
     * @return mixed
     */
    public function getAppById($app_id)
    {
        $app = array_first(self::$apps, function (AppInfo $app) use ($app_id) {
            return $app->app_id === $app_id;
        });

        return $app;
    }

}