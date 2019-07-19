# notes

[![Build Status](https://travis-ci.org/guanguans/notes.svg?branch=master)](https://travis-ci.org/guanguans/notes)

学习笔记

## xLog

此包大部分思想参考 arcanedev/log-viewer, 如有雷同,纯属抄袭

因公司有多个项目是使用其他框架开发, 日志查看十分不方便, 因此开始学习参考log-viewer写一个相对通用的日志工具.
   
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
 │  │  │  ├─bootstrap-4     模板文件目录
 │  │  │  │  ├─dashboard.html   仪表台模板
 │  │  │  │  ├─footer.html   
 │  │  │  │  ├─header.html   
 │  │  │  │  ├─logs.html   日志文件列表
 │  │  │  │  ├─show.html   日志文件内容
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