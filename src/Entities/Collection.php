<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-18
 */

namespace Xlog\Entities;


use Xlog\Lib\Config;
use Xlog\Lib\Page;

class Collection
{
    public $total = 0;

    public $lastPage = 1;

    public $perPage = 30;

    public $currentPage = 1;

    public $query = [];

    public $pageName = 'page';

    public $pageItems = [];

    public $items = [];

    public $url;



    protected function _initPaginate($total)
    {
        $this->setTotal($total);//总条数

        $perPage = Config::get('prePage') ? Config::get('prePage') : $this->perPage;
        $this->setPerPage($perPage);//单页数
        $this->sort();//排序数据
        $this->setQuery($_GET);//查询条件
        $this->setLastPage();//总页数
    }


    public function paginate()
    {
        $this->setCurrentPage();

        //筛选条件,特殊处理
        if(isset($this->query['level']) && isset($this->levelData) && isset($this->levelData[$this->query['level']])){
            $allItems = $this->levelData[$this->query['level']];
            $this->_initPaginate(count($allItems));
            $this->pageItems = $this->cutItems($allItems);
        }else{
            $this->_initPaginate(count($this->items));
            $this->pageItems = $this->cutItems($this->items);
        }

        $paginate = [
            'total' => $this->total,
            'lastPage' => $this->lastPage,
            'perPage' => $this->perPage,
            'query' => $this->query,
            'currentPage' => $this->currentPage,
            'items' => $this->pageItems,
            'links' => $this->links()
        ];

        return $paginate;
    }

    public function links()
    {
        //* @param int $count     总条数
        //* @param int $showPages 显示页数
        //* @param int $currPage  当前页数
        //* @param int $subPages  每页显示数量
        //* @param string $href   连接（不设置则获取当前URL）
        $pageLinks = new Page($this->getTotal(), $this->lastPage, $this->currentPage, $this->perPage, $this->pageName,$this->url );

        return $pageLinks->showPages();
    }

    /**
     * 根据分页配置剪裁数据分页
     * @param $items
     * @return array
     */
    protected function cutItems($items)
    {
        $chuckData = array_chunk($items, $this->getPerPage(), true);
        $page = $this->currentPage - 1;
        return isset($chuckData[$page]) ? $chuckData[$page] :[];
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * @return $this
     */
    public function setLastPage()
    {
        $this->lastPage = ceil($this->getTotal()/$this->perPage);
        return $this;
    }

    /**
     * @return int|string
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int|string $perPage
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $perPage = (int) $perPage;
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function setCurrentPage()
    {
        $query = $this->getQuery();
        if(!isset($query[$this->pageName]) || $query[$this->pageName] > $this->lastPage || $query[$this->pageName] == 0){
            $currentPage  = 1;
        }else{
            $currentPage  = $query[$this->pageName];
        }
        $currentPage = (int) $currentPage;
        if(!is_int($currentPage) || !$currentPage){
            throw new \Exception('page must be int');
        }
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * @param string $pageName
     * @return $this
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
        return $this;
    }

    /**
     * 设置总数量
     * @param int $total
     * @return $this
     */
    protected function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }


    /**
     * @return int
     */
    protected function getTotal()
    {
        return $this->total ;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * 插入数组
     * @param $value
     * @param $key
     */
    public function push($value, $key = null)
    {
        if($key){
            $this->items[$key] = $value;
        }else{
            $this->items[] = $value;
        }
    }

    /**
     * 排序items
     */
    protected function sort()
    {
        krsort($this->items);
    }



    public function toArray()
    {
        return $this->items;
    }

    public function toJson()
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}