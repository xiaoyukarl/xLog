<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 */

namespace Xlog\Lib;

/**
 * 写入日志的通用方法
 * Class Log
 * @package Xlog\Lib
 */
class LogWriter
{


    /**
     * @param $level
     * @param string $message
     * @param array $context
     * @return string
     * @throws \Exception
     */
    public static function log($level, $message, array $context = [])
    {
        //composer dump-autoload生成vendor文件夹和autoload.php文件
        $pre = '[' . date('Y-m-d H:i:s') .']';
        $data = [
            'level' => $level,
            'message' => $message,
            'context' => $context
        ];
        $log = $pre . json_encode($data, JSON_UNESCAPED_UNICODE);
        self::writeLog($log);
        return $log;
    }

    /**
     * 写入日志
     * @param $log
     * @throws \Exception
     */
    public static function writeLog($log)
    {
        $path = Heplers::getLogPath();
        $fileName = Heplers::getFileNameByDate(date('Y-m-d'));
        file_put_contents($path.$fileName , $log.PHP_EOL, FILE_APPEND );
    }


    /**
     * 生成静态方法
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        $levels = Config::get('levels');

        if(!array_key_exists($name, $levels)){
            throw new \Exception("method ".$name. " not exist");
        }
        if(count($arguments) != 2){
            throw new \Exception("this method signature uses 2 parameters");
        }
        if(!is_string($arguments[0])){
            throw new \Exception("parameter 1 need string");
        }
        if(!is_array($arguments[1])){
            throw new \Exception("parameter 2 need array");
        }

        return call_user_func_array(function ($message, $context)use($name){
            return self::log($name, $message, $context);
        }, $arguments);
    }
}