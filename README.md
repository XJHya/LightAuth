# LightAuth
> 轻雨科技自研发的项目,且高扩展性,在Github几乎没有这种项目。

一个PHP账号管理系统，用于高级账号管理系统。

# 功能
```
1. 登录 & 注册 & 授权
2. 短语自定义
3. 模板自由切换 (高级模板系统)
4. 自带RateLimit以及图片验证码以拦截攻击
5. 可自定义用户数据存储位置
6. 支持SEO优化
```

# Config设置
```
FileCache: 账号中心是否开启客户端文件缓存
title: 站点标题
description: 网站描述
keywords: 网站关键词
Template: 模板名(默认default)
captcha: 是否启用注册验证码(true|false)
```

# Nginx伪静态配置
```
location / {
    try_files $uri $uri/ /index.php?do=$uri;
}
location ~* ^/assets/(css|js)/* {
    try_files $uri /assets.php?file=$uri;
}
location ~* ^/api/* {
    try_files $uri /api.php?do=$uri;
}
```

# Composer仓库
Packagist: https://packagist.org/packages/aztice/light-auth
