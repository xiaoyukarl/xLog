<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 */

namespace Xlog\Entities;


use Xlog\Lib\Config;
use Xlog\Lib\Heplers;

/**
 * 日志文件集合
 * Class LogCollection
 * @package Xlog\Entities
 */
class LogCollection extends Collection
{


    public function __construct()
    {
        if(empty($this->items)){
            $this->load();
        }
        $url = Config::get('logListUrl').'?';
        $this->setUrl($url);
    }

    /**
     * 将所有文件读取到当前对象集合中
     * @return $this
     * @throws \Exception
     */
    protected function load()
    {
        $allLogs = Heplers::getAllLogs();
        foreach($allLogs as $date => $file) {
            $value = Log::make($date, $file);
            $this->push($value, $date);
        }

        $this->_initPaginate(count($this->items));
        return $this;
    }

    public function stats()
    {
        return $this->items;
    }



}