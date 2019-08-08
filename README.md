
## xLog

此包大部分思想参考 arcanedev/log-viewer, 如有雷同,纯属抄袭

因公司有多个项目是使用其他框架开发, 日志查看十分不方便, 因此参考log-viewer写一个相对通用的日志工具.

若条件许可,各位最好使用elasticsearch + kibana, es提供日志储存,kibana提供视图查看和分析
   
#### 使用说明

##### 获取此包
```composer require xiaoyukarl/xlog```

##### 修改配置文件


```
    'storagePath' => __DIR__.'/../logs/',//日志保存目录, 请修改为你的项目日志保存目录
    'viewsPath' => __DIR__.'/../resources/views/',//模板目录, 如需修改请将文件夹复制到你的项目模板目录
    'staticPath' => '/resources/static/',//静态文件目录, 必须修改,否则无法读取
    
    /* -----------------------------------------------------------------
    |  为了适配不同的框架,需要重新定义下面几个url
    | -----------------------------------------------------------------
    */
    'dashboardUrl' => 'http://xlog.test/test/dashboard.php/',//仪表台url
    'logListUrl' => 'http://xlog.test/test/logs.php/',//日志文件列表url
    'showUrl' => 'http://xlog.test/test/show.php/',//详情url
    'downloadUrl' => 'http://xlog.test/test/download.php/',//下载url
    'deleteUrl' => 'http://xlog.test/test/delete.php/',//删除url
```

#####  图片展示

![参考 logviewer 重写了一个日志读写包](https://cdn.learnku.com/uploads/images/201908/08/29585/e2Zzf1IIuC.jpg!/fw/1240)

![参考 logviewer 重写了一个日志读写包](https://cdn.learnku.com/uploads/images/201908/08/29585/igDzOhGQXN.jpg!/fw/1240)

![参考 logviewer 重写了一个日志读写包](https://cdn.learnku.com/uploads/images/201908/08/29585/xFMefkLEES.jpg!/fw/1240)

* 目录说明

```

 ├─xLog                扩展包根目录
 │  ├─config                    扩展包代码目录
 │  │  ├─xlog-config.php    配置文件
 │  ├─logs   临时日志保存目录      
 │  ├─resources     资源文件目录      
 │  │  ├─static
 │  │  │  ├─fonts     字体库
 │  │  │  ├─bootstrap.min.css     
 │  │  │  ├─bootstrap.min.js    
 │  │  │  ├─Chart.min.js
 │  │  │  ├─font-awesome.min.css
 │  │  │  ├─googleapis.css
 │  │  │  ├─jquery-3.2.1.min.js
 │  │  │  ├─popper.min.js
 │  │  ├─views
 │  │  │  ├─dashboard.html   仪表台模板
 │  │  │  ├─footer.html   
 │  │  │  ├─header.html   
 │  │  │  ├─logs.html   日志文件列表
 │  │  │  ├─show.html   日志文件内容
 │  ├─src                   测试目录
 │  │  ├─Entities
 │  │  │  ├─Controller.php     集合类
 │  │  │  ├─Log.php    日志类
 │  │  │  ├─LogCollection.php    日志文件集合类
 │  │  │  ├─LogEntity.php    日志实体类
 │  │  │  ├─LogEntityCollection.php     日志集合
 │  │  ├─Http
 │  │  │  ├─LogController.php     控制器
 │  │  ├─Lib
 │  │  │  ├─Config.php     配置文件类
 │  │  │  ├─Helpers.php    公共方法
 │  │  │  ├─LogParser.php     日志处理类
 │  │  │  ├─LogWriter.php     写日志类
 │  │  │  ├─Page.php     分页类
 │  │  │  ├─Xlog.php     日志处理类
 │  ├─test    测试目录
 │  │  ├─dashboard.php  仪表台测试文件
 │  │  ├─delete.php     删除日志测试文件
 │  │  ├─download.php     下载日志测试文件
 │  │  ├─logs.php     日志列表测试文件
 │  │  ├─show.php     日志详细测试文件
 │  ├─.gitignore
 │  ├─composer.json
 │  ├─LICENSE
 │  └─README.md
 
```

##  License

[Apache License 2.0](./LICENSE)