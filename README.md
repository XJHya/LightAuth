# LightAuth
一个PHP账号管理系统，用于高级账号管理系统。

# Nginx配置
```
location / {
  try_files $uri $uri/ /index.php?$query_string;
}
```
