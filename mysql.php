

一、安装编译工具及库文件
    yum -y install gcc gcc-c++ make autoconf libtool-ltdl-devel gd-devel freetype-devel libxml2-devel libjpeg-devel libpng-devel openssl-devel curl-devel bison patch unzip libmcrypt-devel libmhash-devel ncurses-devel sudo bzip2 flex libaio-devel

二、 安装cmake 编译器
    cmake 版本：cmake-3.1.1。
    1、下载地址：http://www.cmake.org/files/v3.1/cmake-3.1.1.tar.gz

        wget http://www.cmake.org/files/v3.1/cmake-3.1.1.tar.gz

    2、解压安装包

        tar zxvf cmake-3.1.1.tar.gz
    3、进入安装包目录

        cd cmake-3.1.1
    4、编译安装

        ./bootstrap
        make && make install


三、安装 MySQL
    MySQL版本：mysql-5.6.15。

    1、下载地址： http://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.15.tar.gz

        wget http://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.15.tar.gz
    2、解压安装包

        tar zxvf mysql-5.6.15.tar.gz
    3、进入安装包目录

        cd mysql-5.6.15
    4、编译安装

        cmake -DCMAKE_INSTALL_PREFIX=/usr/local/webserver/mysql/ -DMYSQL_UNIX_ADDR=/tmp/mysql.sock -DDEFAULT_CHARSET=utf8 -DDEFAULT_COLLATION=utf8_general_ci -DWITH_EXTRA_CHARSETS=all -DWITH_MYISAM_STORAGE_ENGINE=1 -DWITH_INNOBASE_STORAGE_ENGINE=1 -DWITH_MEMORY_STORAGE_ENGINE=1 -DWITH_READLINE=1 -DWITH_INNODB_MEMCACHED=1 -DWITH_DEBUG=OFF -DWITH_ZLIB=bundled -DENABLED_LOCAL_INFILE=1 -DENABLED_PROFILING=ON -DMYSQL_MAINTAINER_MODE=OFF -DMYSQL_DATADIR=/usr/local/webserver/mysql/data -DMYSQL_TCP_PORT=3306
        make && make install
    5、查看mysql版本:

        /usr/local/webserver/mysql/bin/mysql --version

