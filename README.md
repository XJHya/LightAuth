# LightAuth
> 本项目符合`psr-4`标准，支持composer

一个PHP账号管理系统，用于高级账号管理系统。

# Config设置
```
FileCache: 账号中心是否开启客户端文件缓存
title: 站点标题
description: 网站描述
keywords: 网站关键词
template: 模板名(默认default)
```

# Nginx配置
```
location / {
  try_files $uri $uri/ /index.php?$query_string;
}
```

# Composer仓库
Packagist: https://packagist.org/packages/aztice/light-auth
