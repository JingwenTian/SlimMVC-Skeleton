# slim-skeleton

> Slim Framework skeleton application with MVC Schema
>
> Slim Website: https://www.slimframework.com/
>
> DEMO: http://slim.dev.jingplus.com/

## 目录结构

```bash
.
├── app  
│   ├── controller
│   ├── helper
│   ├── middleware
│   └── model
├── bootstrap # 启动依赖
│   ├── app.php # 入口依赖
│   ├── dependencies.php # 核心依赖
│   ├── middleware.php # 中间件配置
│   ├── settings.php # 配置文件
│   └── utils.php # 函数库
├── composer.json
├── public
│   ├── assets # 静态文件目录
│   │   ├── css
│   │   ├── fonts
│   │   ├── img
│   │   └── js
│   └── index.php # 入口文件
├── README.md
├── resources # 资源目录
│   └── views # 模板
│       └── index.phtml
├── routers # 路由
│   └── index.router.php
├── storage # 存储相关
│   └── logs # 日志
```

## 安装

```
composer install
```

## 路由重写

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

## 依赖

- [slim-jwt-auth](https://github.com/tuupola/slim-jwt-auth)
- [slim-basic-auth](https://github.com/tuupola/slim-basic-auth)


## 参考

- [slim-api-skeleton](https://github.com/tuupola/slim-api-skeleton)
