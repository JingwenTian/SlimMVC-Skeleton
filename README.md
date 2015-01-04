SlimMVC-Skeleton
================

Slim Framework skeleton application with MVC Schema

[Slim](slimframework.com)是一款基于PHP的web开发微框架，帮助 PHP 开发者快速编写简单强大的web应用和API。[SlimMVC-Skeleton](https://github.com/JingwenTian/SlimMVC-Skeleton)建立Slim的基础上,增加了MVC支持,集成了各种功能类(如: `medoo`, `twig`, `monolog` 等)。

**目录结构**

    | - /config 配置文件
    | - /lib 功能类
    | - /logs 日志
    | - /models Model层
    | - /routers 路由层(Controller层)
    | - /templates 视图层(View层)
    | - /public
          | - index.php 入口文件
          | - css/js/images/libs 静态文件目录
    | - bootstrap.php 引导文件
  
**安装**

 - 在项目根目录运行 `php composer.phar install` 如需了解composer [请查看](http://www.jingwentian.com/t-421)
 - 将配置文件 `config/config.php.sample` 重命名为 `config/config.php` 并且修改基本的配置信息(如数据库信息以及一些常亮)
 - Enjoy 

**URL-rewriting**

- nginx.conf(nginx)

```
location / {
   try_files $uri $uri/ /index.php?$args;
}
```

- .htaccess(apache)

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```
  
---

更多的Slim学习资源可参考 [链接](http://www.jingwentian.com/t-450)



