<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 */

namespace Xlog\Lib;


class Heplers
{

    /**
     * 获取日志文件名称
     * @param $date
     * @return string
     */
    public static function getFileNameByDate($date)
    {
        return  Config::get('prefix') . $date . Config::get('extension');
    }

    public static function getFilePathByDate($date)
    {
        return self::getLogPath() . self::getFileNameByDate($date);
    }

    /**
     * 获取日志储存目录
     * @return string
     * @throws \Exception
     */
    public static function getLogPath()
    {
        $path = Config::get('storagePath');
        if(!is_dir($path)){
            throw new \Exception('storage path "'.$path.'" not exist! please config you storage-path');
        }
        return $path;
    }

    /**
     * 获取所有的日志文件路径
     * @return array
     * @throws \Exception
     */
    public static function getAllLogs()
    {
        $path = self::getLogPath();
        $logFiles = scandir($path);
        $fileData = [];
        $prefix = Config::get('prefix');
        $len = strlen($prefix);
        $preg = "/^{$prefix}[a-z0-9_-]+.log/i";
        foreach ($logFiles as $file){
            if($file == '.' || $file == '..' || !preg_match($preg, $file)){
                continue;
            }
            $pathInfo = pathinfo($file);
            $date = substr($pathInfo['filename'], $len);
            $fileData[$date] = realpath(self::getLogPath() . $file);
        }
        return $fileData;
    }

    /**
     * 渲染模板
     * @param $template
     * @param $params
     * @throws \Exception
     */
    public static function display($template ,$params)
    {
        extract($params);
        if($template == 'logs'){
            $headers['date'] = '日期';
            $headers = array_merge($headers, Config::get('levels'));
        }else{
            $headers = Config::get('levels');
        }
        extract(Config::all());//加载所有配置

        require_once self::getTemplateDir('header');

        require_once self::getTemplateDir($template);

        require_once self::getTemplateDir('footer');

        exit;//退出,防止渲染非日志模板的内容
    }

    /**
     * 获取模板路径
     * @param $template
     * @return string
     * @throws \Exception
     */
    protected static function getTemplateDir($template)
    {
        $staticFile = Config::get('viewsPath').$template.'.html';
        if(!is_file($staticFile)){
            throw new \Exception($staticFile . ' template not exist');
        }
        return $staticFile;
    }

    /**
     * 处理url格式,防止部分get获取错误
     * @param $url
     * @return string
     */
    public static function parseUrl($url)
    {
        if(preg_match('/\?\w+/', $url)){
            $url = $url . '&';
        }else{
            $url = $url . '?&';
        }
        return $url;
    }
}