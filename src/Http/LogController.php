<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-18
 */

namespace Xlog\Http;


use Xlog\Lib\Heplers;
use Xlog\Lib\Xlog;

class LogController
{
    protected $xlog;

    public function __construct()
    {
        $this->xlog = new Xlog();
    }

    public function dashboard()
    {
        Heplers::display('dashboard', $this->xlog->dash());
    }

    public function logList()
    {
        Heplers::display('logs', $this->xlog->logList());
    }

    public function show($date)
    {
        Heplers::display('show', $this->xlog->show($date));
    }

    public function download($date)
    {
        $filePath = Heplers::getFilePathByDate($date);
        $fileName = Heplers::getFileNameByDate($date);
        //下载
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename=' . $fileName); //文件名
        header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header('Content-Length: ' . filesize($filePath)); //告诉浏览器，文件大小
        readfile($filePath);
    }

    public function delete($date)
    {
        $path = Heplers::getFilePathByDate($date);

        @unlink($path);
    }
    
    
}