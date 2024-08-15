# LightAuth
> 本项目符合`psr-4`标准，支持composer

一个PHP账号管理系统，用于高级账号管理系统。

# Nginx配置
```
location / {
  try_files $uri $uri/ /index.php?$query_string;
}
```

# Composer仓库
Packagist: https://packagist.org/packages/aztice/light-auth
