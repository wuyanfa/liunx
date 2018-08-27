<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:35
 */
?>

worker_processes 16 # 启动进程，通常设置和cpu的数量相等

# 工作模式及连接数上限
events{
    worker_connections 1024  # 单个后台 worker_process 进程的最大并发连接数
}

# 设定 http 服务器，利用它的反响代理功能提供负载均衡支持
http{
    include mime.types;  # 设定mime 类型，类型由 mime.type 文件定义
    default_type  application/octet-stream; # 默认文件类型
    # 默认编码
    # charset utf-8;
    # sendfile 指令指定 nginx 是否调用 sendfile 函数 （ zero copy 方式 ）来输出文件，对于普通应用，必须设为 on,
    # 如果用来进行下载等应用磁盘IO重负载应用，可设置为 off，以平衡磁盘与网络I/O处理速度，降低系统的uptime.
    sendfile on;

    keepalive_timeout 90; # 连接超时时间，单位秒

    # 设定负载均衡的服务器列表
    upstream riskraiders {
        # weight=5;weigth参数表示权值，权值越高被分配到的几率越大
        server ip1:proxy ;
        server ip2:proxy ;
    }

    #2、ip_hash
    #每个请求按访问ip的hash结果分配，这样每个访客固定访问一个后端服务器，可以解决session的问题。
    #例如：
    #upstream bakend {
    #    ip_hash;
    #    server 192.168.0.14:88;
    #    server 192.168.0.15:80;
    #}

    #每个设备的状态设置为:
    #1.down表示单前的server暂时不参与负载
    #2.weight为weight越大，负载的权重就越大。
    #3.max_fails：允许请求失败的次数默认为1.当超过最大次数时，返回proxy_next_upstream模块定义的错误
    #4.fail_timeout:max_fails次失败后，暂停的时间。
    #5.backup： 其它所有的非backup机器down或者忙的时候，请求backup机器。所以这台机器压力会最轻。

}


# 虚拟主机的配置
server{

    # 监听端口
    listen 80;

    # 域名可以有多个，用空格隔开
    server_name www.jd.com jd.com;
    index index.html index.htm index.php;
    # 地址目录
    root /data/www/jd;

    # 定义本虚拟主机的访问日志
    access_log  /usr/local/nginx/logs/host.access.log  main;
    access_log  /usr/local/nginx/logs/host.access.404.log  log404;


    #对 "/" 启用反向代理
    location / {
        proxy_pass http://127.0.0.1:88;
        proxy_redirect off;
        proxy_set_header X-Real-IP $remote_addr;

        #后端的Web服务器可以通过X-Forwarded-For获取用户真实IP
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;

        #以下是一些反向代理的配置，可选。
        proxy_set_header Host $host;

        #允许客户端请求的最大单文件字节数
        client_max_body_size 10m;

        #缓冲区代理缓冲用户端请求的最大字节数，
        #如果把它设置为比较大的数值，例如256k，那么，无论使用firefox还是IE浏览器，来提交任意小于256k的图片，都很正常。如果注释该指令，使用默认的client_body_buffer_size设置，也就是操作系统页面大小的两倍，8k或者16k，问题就出现了。
        #无论使用firefox4.0还是IE8.0，提交一个比较大，200k左右的图片，都返回500 Internal Server Error错误
        client_body_buffer_size 128k;

        #表示使nginx阻止HTTP应答代码为400或者更高的应答。
        proxy_intercept_errors on;

        #后端服务器连接的超时时间_发起握手等候响应超时时间
        #nginx跟后端服务器连接超时时间(代理连接超时)
        proxy_connect_timeout 90;

        #后端服务器数据回传时间(代理发送超时)
        #后端服务器数据回传时间_就是在规定时间之内后端服务器必须传完所有的数据
        proxy_send_timeout 90;

        #连接成功后，后端服务器响应时间(代理接收超时)
        #连接成功后_等候后端服务器响应时间_其实已经进入后端的排队之中等候处理（也可以说是后端服务器处理请求的时间）
        proxy_read_timeout 90;

        #设置代理服务器（nginx）保存用户头信息的缓冲区大小
        #设置从被代理服务器读取的第一部分应答的缓冲区大小，通常情况下这部分应答中包含一个小的应答头，默认情况下这个值的大小为指令proxy_buffers中指定的一个缓冲区的大小，不过可以将其设置为更小
        proxy_buffer_size 4k;

        #proxy_buffers缓冲区，网页平均在32k以下的设置
        #设置用于读取应答（来自被代理服务器）的缓冲区数目和大小，默认情况也为分页大小，根据操作系统的不同可能是4k或者8k
        proxy_buffers 4 32k;

        #高负荷下缓冲大小（proxy_buffers*2）
        proxy_busy_buffers_size 64k;

        #设置在写入proxy_temp_path时数据的大小，预防一个工作进程在传递文件时阻塞太长
        #设定缓存文件夹大小，大于这个值，将从upstream服务器传
        proxy_temp_file_write_size 64k;
    }
}

