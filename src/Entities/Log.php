<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 */

namespace Xlog\Entities;


use Xlog\Lib\Config;

/**
 * 日志文件对象
 * Class Log
 * @package Xlog\Lib\Entities
 */
class Log
{

    public $date;

    public $path;

    public $file;

    public $entries;

    public function __construct($date, $path)
    {
        $this->date    = $date;
        $this->path    = $path;
        $this->file = new \SplFileInfo($path);

        $url = Config::get('showUrl') . '?date=' . $this->date;

        $this->entries = (new LogEntityCollection($url))->load($path);
    }

    public static function make($date, $path)
    {
        return new self($date, $path);
    }

    /**
     * @return LogEntityCollection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    public function getListData()
    {
        $levelData = [];
        $levels = Config::get('levels');
        $levelData['date'] = $this->date;
        foreach ($levels as $level => $levelName){
            $items = $this->entries->filterByLevel($level);
            $levelData[$level] = count($items);
        }
        $levelData['all'] = count($this->getEntries()->items);
        return $levelData;
    }

    /**
     * 详细页菜单列表
     * @return array
     */
    public function menu()
    {
        $menu = [];
        $levels = Config::get('levels');
        $icons = Config::get('icons');
        foreach ($levels as $level => $levelName){
            $url = Config::get('showUrl') . '?date=' . $this->date;
            $items = $this->entries->filterByLevel($level);
            $menu[$level]['name'] = $levelName;
            $menu[$level]['count'] =  $level=='all' ? count($this->getEntries()->items) : count($items);
            $menu[$level]['icon'] = $icons[$level];
            $menu[$level]['url'] = $url .= $level=='all' ? '': '&level='.$level;
        }
        return $menu;
    }

    public function total()
    {
        return count($this->entries->items);
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return \SplFileInfo
     */
    public function file()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function size()
    {
        return $this->formatSize($this->file->getSize());
    }

    /**
     * @return false|string
     */
    public function createdAt()
    {
        return date('Y-m-d H:i:s', $this->file()->getATime());
    }

    /**
     * @return false|string
     */
    public function updatedAt()
    {
        return date('Y-m-d H:i:s', $this->file()->getMTime());
    }

    private function formatSize($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);

        return round($bytes / pow(1024, $pow), $precision).' '.$units[$pow];
    }
}