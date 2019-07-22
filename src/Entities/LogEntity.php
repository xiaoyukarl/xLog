<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 * Time: 17:40
 */

namespace Xlog\Entities;

/**
 * 单独一行的对象
 * Class LogEntity
 * @package Xlog\Lib\Entities
 */
class LogEntity
{

    /**
     * @var string $time
     */
    public $time;

    /**
     * @var string $level
     */
    public $level;

    /**
     * @var string $message
     */
    public $message;

    /**
     * @var string $context
     */
    public $context;

    /**
     * 将单行数据储存为一个对象
     * LogEntity constructor.
     * @param $time
     * @param $level
     * @param $message
     * @param $context
     */
    public function __construct($time, $level, $message, $context)
    {
        $this->setTime($time);
        $this->setLevel($level);
        $this->setMessage($message);
        $this->setContext($context);
    }

    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setContext($context)
    {
        $this->context = json_encode($context, JSON_UNESCAPED_UNICODE|JSON_BIGINT_AS_STRING);
        return $this;
    }


    public function toArray()
    {
        return [
            'level' => $this->level,
            'message' => $this->message,
            'context' => $this->context,
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}