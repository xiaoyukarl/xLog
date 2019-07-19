<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 */

namespace Xlog\Entities;


use Xlog\Lib\Config;
use Xlog\Lib\LogParser;

/**
 * 单个日志文件对象集合
 * Class LogEntityCollection
 * @package Xlog\Lib\Entities
 */
class LogEntityCollection extends Collection
{

    /**
     * @var array 根据级别分组之后的数据
     */
    public $levelData = [];

    public function __construct($url)
    {
        $this->setUrl($url);
    }

    /**
     * 根据单个文件内容,将内容变为一个集合
     * @param $file
     * @return $this
     * @throws \Exception
     */
    public function load($file)
    {
        foreach (LogParser::parse($file) as $entry) {
            list($time,$level, $message, $context) = array_values($entry);
            $this->push(new LogEntity($time,$level, $message, $context));
        }
        $this->groupByLevel();

        $this->_initPaginate(count($this->items));

        return $this;
    }


    /**
     * 筛选级别
     * @param $level
     * @return mixed
     */
    public function filterByLevel($level)
    {
        return isset($this->levelData[$level]) ? $this->levelData[$level] : [];
    }

    /**
     * 将数据根据级别分组
     * @return $this
     */
    public function groupByLevel()
    {
        $levels = Config::get('levels');
        foreach ($this->items as $item) {
            if(isset($levels[$item->level]) ){
                $this->levelData[$item->level][] = $item;
            }
        }
        return $this;
    }
}