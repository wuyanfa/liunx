

1, 下载各版本nginx地址http://nginx.org/download/

2. 检查80端口是否被暂用 命令  netstat -ntulp |grep 80
    命令如下 kill -9 PID是强制杀死进程/服务
    kill -9 6963

Nginx 安装
系统平台：CentOS release 6.6 (Final) 64位


一、安装编译工具及库文件
yum -y install make zlib zlib-devel gcc-c++ libtool  openssl openssl-devel

二、首先要安装 PCRE
PCRE 作用是让 Nginx 支持 Rewrite 功能。

1、下载 PCRE 安装包，下载地址： http://downloads.sourceforge.net/project/pcre/pcre/8.35/pcre-8.35.tar.gz
    1.1 wget http://downloads.sourceforge.net/project/pcre/pcre/8.35/pcre-8.35.tar.gz
    1.2 tar zxvf pcre-8.35.tar.gz
    1,3 cd pcre-8.35
    1.4  ./configure
    1.5  make && make install
    1.6 pcre-config --version # 查看版本

2 . PCRE 安装包
    yum -y install pcre-devel
    yum -y install openssl openssl-devel


三、安装 Nginx
    1.1 下载 Nginx，下载地址：http://nginx.org/download/nginx-1.6.2.tar.gz
     wget http://nginx.org/download/nginx-1.6.2.tar.gz
    1.2 tar zxvf nginx-1.6.2.tar.gz
    1.3 cd nginx-1.6.2
    1.4 ./configure --prefix=/usr/local/webserver/nginx --with-http_stub_status_module --with-http_ssl_module --with-pcre=/usr/local/src/pcre-8.35
    1.5 make
    1.6 make install
    1.7 查看nginx 版本
    /usr/local/webserver/nginx/sbin/nginx -v


四 、Nginx 配置
    创建 Nginx 运行使用的用户 www：
    1.1 /usr/sbin/groupadd www
    1.2 /usr/sbin/useradd -g www www

    2. 配置nginx.conf ，将/usr/local/webserver/nginx/conf/nginx.conf替换为以下内容

    user www www;
    worker_processes 2; #设置值和CPU核心数一致
    error_log /usr/local/webserver/nginx/logs/nginx_error.log crit; #日志位置和日志级别
    pid /usr/local/webserver/nginx/nginx.pid;
    #Specifies the value for maximum file descriptors that can be opened by this process.
    worker_rlimit_nofile 65535;
    events
    {
    use epoll;
    worker_connections 65535;
    }
    http
    {
    include mime.types;
    default_type application/octet-stream;
    log_format main  '$remote_addr - $remote_user [$time_local] "$request" '
    '$status $body_bytes_sent "$http_referer" '
    '"$http_user_agent" $http_x_forwarded_for';

    #charset gb2312;

    server_names_hash_bucket_size 128;
    client_header_buffer_size 32k;
    large_client_header_buffers 4 32k;
    client_max_body_size 8m;

    sendfile on;
    tcp_nopush on;
    keepalive_timeout 60;
    tcp_nodelay on;
    fastcgi_connect_timeout 300;
    fastcgi_send_timeout 300;
    fastcgi_read_timeout 300;
    fastcgi_buffer_size 64k;
    fastcgi_buffers 4 64k;
    fastcgi_busy_buffers_size 128k;
    fastcgi_temp_file_write_size 128k;
    gzip on;
    gzip_min_length 1k;
    gzip_buffers 4 16k;
    gzip_http_version 1.0;
    gzip_comp_level 2;
    gzip_types text/plain application/x-javascript text/css application/xml;
    gzip_vary on;

    #limit_zone crawler $binary_remote_addr 10m;
    #下面是server虚拟主机的配置
    server
    {
    listen 80;#监听端口
    server_name localhost;#域名
    index index.html index.htm index.php;
    root /usr/local/webserver/nginx/html;#站点目录
    location ~ .*\.(php|php5)?$
    {
    #fastcgi_pass unix:/tmp/php-cgi.sock;
    fastcgi_pass 127.0.0.1:9000;
    fastcgi_index index.php;
    include fastcgi.conf;
    }
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf|ico)$
    {
    expires 30d;
    # access_log off;
    }
    location ~ .*\.(js|css)?$
    {
    expires 15d;
    # access_log off;
    }
    access_log off;
    }

    }


    3. 检查配置文件nginx.conf的正确性命令：
        3.1 /usr/local/webserver/nginx/sbin/nginx -t
        nginx: the configuration file /usr/local/webserver/nginx/conf/nginx.conf syntax is ok
        nginx: configuration file /usr/local/webserver/nginx/conf/nginx.conf test is successful
    五、启动 Nginx
        Nginx 启动命令如下：
        /usr/local/webserver/nginx/sbin/nginx

        /usr/local/webserver/nginx/sbin/nginx -s reload            # 重新载入配置文件
        /usr/local/webserver/nginx/sbin/nginx -s reopen            # 重启 Nginx
        /usr/local/webserver/nginx/sbin/nginx -s stop              # 停止 Nginx