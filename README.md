## php swoole 聊天室 ##
*Author by wells(1174955828@qq.com)*

[https://github.com/wuqishan/php-swoole-websocket.git](https://github.com/wuqishan/php-swoole-websocket.git "项目代码下载")
# 简介 #

这是一个利用php7 swoole2 里面的swoole_websocket_server对象开发的websocket聊天小系统。

# 搭建该项目 #


1. 首先需要composer install
2. 修改.env配置WEBSOCKET_SERVER(监听ip)、WEBSOCKER_PORT(监听端口)、REDIS_SERVER(redis服务)、REDIS_PORT(redis端口)、REDIS_PASS(redis密码)
3. 客户端js的websocket连接配置(js/modules/index.js)
4. 执行 > php server/server.php，其中swoole_websocket_server的详细配置查看server/server.php文件详解即可。

	