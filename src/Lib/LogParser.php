<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 */

namespace Xlog\Lib;


/**
 * 日志读取
 * Class LogParser
 * @package Xlog\Lib
 */
class LogParser
{


    /**
     * 读取文件
     * @param $file
     * @return array
     * @throws \Exception
     */
    public static function parse($file)
    {
        try{
            $response = [];
            $fd = fopen($file, 'r+');
            while (true){
                $row = fgets($fd);
                if($row == ''){
                    break;
                }
                $time = substr($row,1,19);
                $json =  substr($row, 21);
                $data =  json_decode($json, true);
                $response[] = [
                    'time' => $time,
                    'level' => $data['level'],
                    'message' => $data['message'],
                    'context' => $data['context']
                ];
            }
            return $response;
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

    }

}