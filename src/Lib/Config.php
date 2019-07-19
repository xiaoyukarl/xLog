<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 */

namespace Xlog\Lib;



class Config
{

    protected static $config;

    /**
     * 获取配置
     * @param string $key
     * @return string
     */
    public static function get($key = '')
    {
        if(!is_array(self::$config)){
            $configData = require_once __DIR__ .'/../../config/xlog-config.php';
            self::$config = $configData;
        }

        if (isset(self::$config[$key])){
            return self::$config[$key];
        }
        return '';
    }

    public static function all()
    {
        if(!is_array(self::$config)){
            $configData = require_once __DIR__ .'/../../config/xlog-config.php';
            self::$config = $configData;
        }
        return self::$config;
    }

    /**
     * 添加配置
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function set($key, $value)
    {
        if(!is_array(self::$config)){
            $configData = require_once __DIR__ .'/../../config/xlog-config.php';
            self::$config = $configData;
        }
        self::$config[$key] = $value;

        return $value;
    }

}