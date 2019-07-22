<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 */

return [

    'extension' => '.log',//日志文件后缀

    'prefix' => 'xlog-',//日志文件前缀,在使用过程中,请不要修改日志文件前缀, 将会导致文件无法读取

    'prePage' => '2',//分页数

    /* -----------------------------------------------------------------
     | 日志保存目录,需要修改为各自项目制定的日志目录
     | -----------------------------------------------------------------
     */
    'storagePath' => __DIR__.'/../logs/',//日志保存目录

    /* -----------------------------------------------------------------
     | 日志显示模板文件目录,必须修改
     | -----------------------------------------------------------------
     */
    'viewsPath' => __DIR__.'/../resources/views/',//模板目录

    /* -----------------------------------------------------------------
     | 静态文件目录,必须修改
     | -----------------------------------------------------------------
     */
    'staticPath' => '/resources/static/',//静态文件目录


    /* -----------------------------------------------------------------
     |  为了使用不同的框架,需要自定义下面几个url
     | -----------------------------------------------------------------
     */
    'dashboardUrl' => 'http://xlog.test/test/dashboard.php/',//仪表台url
    'logListUrl' => 'http://xlog.test/test/logs.php/',//日志文件列表url
    'showUrl' => 'http://xlog.test/test/show.php/',//详情url
    'downloadUrl' => 'http://xlog.test/test/download.php/',//下载url
    'deleteUrl' => 'http://xlog.test/test/delete.php/',//删除url

    'levels' => [
        'all'       => '全部',
        'emergency' => '危急',
        'alert'     => '紧急',
        'critical'  => '严重',
        'error'     => '错误',
        'warning'   => '警告',
        'notice'    => '注意',
        'info'      => '信息',
        'debug'     => '调试',
    ],

    /* -----------------------------------------------------------------
     |  Icons
     | -----------------------------------------------------------------
     */
    'icons' =>  [
        /**
         * Font awesome >= 4.3
         * http://fontawesome.io/icons/
         */
        'all'       => 'fa fa-fw fa-list',                 // http://fontawesome.io/icon/list/
        'emergency' => 'fa fa-fw fa-bug',                  // http://fontawesome.io/icon/bug/
        'alert'     => 'fa fa-fw fa-bullhorn',             // http://fontawesome.io/icon/bullhorn/
        'critical'  => 'fa fa-fw fa-heartbeat',            // http://fontawesome.io/icon/heartbeat/
        'error'     => 'fa fa-fw fa-times-circle',         // http://fontawesome.io/icon/times-circle/
        'warning'   => 'fa fa-fw fa-exclamation-triangle', // http://fontawesome.io/icon/exclamation-triangle/
        'notice'    => 'fa fa-fw fa-exclamation-circle',   // http://fontawesome.io/icon/exclamation-circle/
        'info'      => 'fa fa-fw fa-info-circle',          // http://fontawesome.io/icon/info-circle/
        'debug'     => 'fa fa-fw fa-life-ring',            // http://fontawesome.io/icon/life-ring/
    ],
    /* -----------------------------------------------------------------
     |  Colors
     | -----------------------------------------------------------------
     */
    'colors' =>  [
        'levels'    => [
            'empty'     => '#D1D1D1',
            'all'       => '#8A8A8A',
            'emergency' => '#B71C1C',
            'alert'     => '#D32F2F',
            'critical'  => '#F44336',
            'error'     => '#FF5722',
            'warning'   => '#FF9100',
            'notice'    => '#4CAF50',
            'info'      => '#1976D2',
            'debug'     => '#90CAF9',
        ],
    ],
];