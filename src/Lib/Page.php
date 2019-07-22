<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-19
 */

namespace Xlog\Lib;

//默认样式 共45条记录,每页显示10条,当前第1/4页 [首页] [上页] [1] [2] [3] .. [下页] [尾页]
class Page{
    protected $count;       //总条数
    protected $showPages;   //需要显示的页数
    protected $countPages;  //总页数
    protected $currPage;    //当前页
    protected $subPages;    //每页显示条数
    protected $href;        //连接
    protected $pageName;    //分页GET参数名称
    protected $page_arr=array();    //保存生成的页码 键页码 值为连接

    /**
     * __construct  构造函数（获取分页所需参数）
     * @param int $count     总条数
     * @param int $showPages 显示页数
     * @param int $currPage  当前页数
     * @param int $subPages  每页显示数量
     * @param string $pageName  分页GET参数名称
     * @param string $href   连接（不设置则获取当前URL）
     */
    public function __construct($count,$showPages,$currPage,$subPages,$pageName,$href=''){
        $this->count=$count;
        $this->showPages=$showPages;
        $this->currPage=$currPage;
        $this->subPages=$subPages;
        $this->pageName = $pageName;

        //如果链接没有设置则获取当前连接

        $this->href=$href;
        $this->construct_Pages();
    }

    /**
     * getPages 返回页码数组
     * @return array 一维数组 键为页码 值为链接
     */
    public function getPages(){
        return $this->page_arr;
    }

    /**
     * showPages 返回生成好的页码
     * @param  int $style 样式
     * @return string     生成好的页码
     */
    public function showPages($style=1){
        $func = 'pageStyle'.$style;
        return $this->$func();
    }

    /**
     * pageStyle1 分页样式（可参照这个添加自定义样式 例如pageStyle2（））
     * 样式 共45条记录,每页显示10条,当前第1/4页 [首页] [上页] [1] [2] [3] .. [下页] [尾页]
     * @return string
     */
    protected function pageStyle1(){
        /* 构造普通模式的分页
        共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [1] [2] [3] .. [下页] [尾页]
        */
        $style = 'style="padding:3px;"';
        $pageStr='共'.$this->count.'条记录，每页显示'.$this->subPages.'条';
        $pageStr.='当前第'.$this->currPage.'/'.$this->countPages.'页 ';

        $_GET['page'] = 1;
        $pageStr.='<span>[<a href="'.$this->href.'&'.$this->pageName . '='.$_GET['page'].'&perPage='.$this->subPages.'">首页</a>] </span>';
        //如果当前页不是第一页就显示上页
        if($this->currPage>1){
            $_GET['page'] = $this->currPage-1;
            $pageStr.='<span '.$style.'>[<a href="'.$this->href.'&'.$this->pageName . '='.$_GET['page'].'&perPage='.$this->subPages.'">上页</a>] </span>';
        }

        foreach ($this->page_arr as $k => $v) {
            $_GET['page'] = $k;
            $pageStr.='<span '.$style.'>[<a href="'.$v.'">'.$k.'</a>] </span>';
        }

        //如果当前页小于总页数就显示下一页
        if($this->currPage<$this->countPages){
            $_GET['page'] = $this->currPage+1;
            $pageStr.='<span '.$style.'>[<a href="'.$this->href.'&'.$this->pageName . '='.$_GET['page'].'&perPage='.$this->subPages.'">下页</a>] </span>';
        }

        $_GET['page'] = $this->countPages;
        $pageStr.='<span '.$style.'>[<a href="'.$this->href.'&'.$this->pageName . '='.$_GET['page'].'&perPage='.$this->subPages.'">尾页</a>] </span>';

        return $pageStr;
    }

    /**
     * construct_Pages 生成页码数组
     * 键为页码，值为链接
     * $this->page_arr=Array(
     *                  [1] => index.php?page=1
     *                  [2] => index.php?page=2
     *                  [3] => index.php?page=3
     *                  ......)
     */
    protected function construct_Pages(){
        //计算总页数
        $this->countPages=ceil($this->count/$this->subPages);
        //根据当前页计算前后页数
        $leftPage_num=floor($this->showPages/2);
        $rightPage_num=$this->showPages-$leftPage_num;

        //左边显示数为当前页减左边该显示的数 例如总显示7页 当前页是5  左边最小为5-3  右边为5+3
        $left=$this->currPage-$leftPage_num;
        $left=max($left,1); //左边最小不能小于1
        $right=$left+$this->showPages-1; //左边加显示页数减1就是右边显示数
        $right=min($right,$this->countPages);  //右边最大不能大于总页数
        $left=max($right-$this->showPages+1,1); //确定右边再计算左边，必须二次计算

        for ($i=$left; $i <= $right; $i++) {
            $_GET['page'] = $i;
            $this->page_arr[$i]=$this->href.'&'.$this->pageName . '='.$_GET['page'].'&perPage='.$this->subPages;
        }
    }
}