生产环境实用之LNMP架构的编译安装+SSL加密实现 http://www.linuxidc.com/Linux/2013-05/85099.htm

LNMP 全功能编译安装 for CentOS 6.3笔记 http://www.linuxidc.com/Linux/2013-05/83788.htm

CentOS 6.3 安装LNMP (PHP 5.4,MyySQL5.6) http://www.linuxidc.com/Linux/2013-04/82069.htm

在部署LNMP的时候遇到Nginx启动失败的2个问题 http://www.linuxidc.com/Linux/2013-03/81120.htm

Ubuntu安装Nginx php5-fpm MySQL(LNMP环境搭建) http://www.linuxidc.com/Linux/2012-10/72458.htm

一:安装依赖包

yum install cmake make gcc gcc-c++ libjpeg libjpeg-devel libpng \
libpng-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glibc \
glibc-devel glib2 glib2-devel bzip2 bzip2-devel ncurses ncurses-devel curl \
curl-devel e2fsprogs e2fsprogs-devel krb5-devel libidn libidn-devel openssl expat expat-devel \
openssl-devel nss_ldap openldap openldap-devel openldap-clients openldap-servers unixODBC-devel \
libxslt-devel libevent-devel libtool-ltdl bison libtool pcre-devel zip unzip gmp-devel gd gd-devel

二：下载LNMP所需软件

wget http://downloads.mysql.com/archives/mysql-5.5/mysql-5.5.19.tar.gz
wget http://ftp.gnu.org/pub/gnu/libiconv/libiconv-1.14.tar.gz
wget http://iweb.dl.sourceforge.net/project/mcrypt/Libmcrypt/2.5.8/libmcrypt-2.5.8.tar.gz
wget http://iweb.dl.sourceforge.net/project/mhash/mhash/0.9.9.9/mhash-0.9.9.9.tar.gz
wget http://vps.googlecode.com/files/mcrypt-2.6.8.tar.gz
wget http://download-euro.oldapps.com/PHP/php-5.3.18.tar.bz2
wget http://superb-dca2.dl.sourceforge.net/project/eaccelerator/eaccelerator/eAccelerator%200.9.6.1/eaccelerator-0.9.6.1.tar.bz2
wget http://pecl.php.net/get/PDO_MYSQL-1.0.2.tgz
wget http://pecl.php.net/get/memcache-2.2.7.tgz
wget http://www.imagemagick.org/download/legacy/ImageMagick-6.8.3-10.tar.gz
wget http://pecl.php.net/get/imagick-3.0.1.tgz
wget http://pecl.php.net/get/pecl_http-1.7.5.tgz
wget http://jaist.dl.sourceforge.net/project/pcre/pcre/8.33/pcre-8.33.tar.gz
wget http://nginx.org/download/nginx-1.2.9.tar.gz
wget http://sourceforge.net/projects/re2c/files/re2c/0.13.5/re2c-0.13.5.tar.gz/download
wget http://pecl.php.net/get/igbinary-1.1.1.tgz
wget https://github.com/nicolasff/phpredis/archive/master.zip

三、安装mysql

tar zxf mysql-5.5.19.tar.gz
cd mysql-5.5.19
groupadd mysql
useradd -g mysql -s /sbin/nologin -M mysql
cmake \
-DCMAKE_INSTALL_PREFIX=/usr/local/mysql \
-DSYSCONFDIR=/etc/mysql \
-DMYSQL_UNIX_ADDR=/usr/local/mysql/tmp/mysql.sock \
-DWITH_READLINE=1 \
-DWITH_EMBEDDED_SERVER=1 \
-DMYSQL_DATADIR=/usr/local/mysql/data \
-DMYSQL_USER=mysql \
-DMYSQL_TCP_PORT=3306
make && make install
chown -R mysql.mysql /usr/local/mysql
cd ..

因为有专门的mysql服务器，所以mysql安装到此结束。如果想要在本地运行mysql的话还要做其他配置。比如my.cnf配置文件，mysql启动脚本等等。

四：安装PHP
安装PHP(FastCGI)
### 安装PHP支持库 ###
tar zxf libiconv-1.14.tar.gz
cd libiconv-1.14
./configure --prefix=/usr/local
make
make install
cd ..
tar zxf libmcrypt-2.5.8.tar.gz
cd libmcrypt-2.5.8
./configure && make && make install
/sbin/ldconfig
cd libltdl/
./configure --enable-ltdl-install
make && make install
cd ../../
tar zxf mhash-0.9.9.9.tar.gz
cd mhash-0.9.9.9/
./configure
make
make install
cd ../
tar zxf mcrypt-2.6.8.tar.gz
cd mcrypt-2.6.8/
./configure
make
make install
cd ../
tar zxf re2c-0.13.5.tar.gz
cd re2c-0.13.5
./configure
make && make install
cd ..

在安装PHP主程序前，还需要做一些调整，不然会各种报错。

echo "/usr/local/lib"  > /etc/ld.so.conf.d/local.conf
echo "/usr/lib64" >> /etc/ld.so.conf.d/local.conf
ln -sv /usr/lib64/libldap* /usr/lib/
ln -sv /usr/include/sqlext.h /usr/local/include/sqlext.h
ln -sv /usr/local/mysql/bin/mysql_config /usr/bin/mysql_config
ln -sv  /usr/local/mysql/lib/libmysqlclient.so.18 /usr/lib64/
ln -sv /lib64/libexpat.* /lib/
ln -sv /usr/lib64/libexpat.* /usr/lib/
ldconfig

现在安装PHP

tar jxf php-5.3.18.tar.bz2
cd php-5.3.18
groupadd nginx
useradd -M -s /sbin/nologin -g nginx nginx
./configure \
--prefix=/usr/local/php --with-config-file-path=/etc --with-config-file-scan-dir=/etc/php.d \
--with-pic --with-bz2 --with-gettext --with-gmp --with-iconv --with-openssl \
--with-zlib --with-layout=GNU --with-kerberos --with-mhash --with-pcre-regex --enable-exif \
--enable-magic-quotes --enable-sockets  --enable-ucd-snmp-hack --enable-shmop --enable-calendar \
--enable-mbstring \
--enable-xml --enable-fpm --enable-gd-native-ttf --enable-exif --enable-soap --with-gd --with-curl \
--with-mcrypt \
--with-mysql=/usr/local/mysql --with-mysqli=/usr/local/mysql/bin/mysql_config --with-pdo-mysql \
--with-unixODBC \
--enable-wddx --with-libexpat-dir --with-xmlrpc --with-xsl --with-ldap --enable-bcmath \
--enable-dom --without-gdbm --disable-debug --disable-rpath --disable-fileinfo --without-pspell \
--disable-posix --disable-sysvmsg --disable-sysvshm --disable-sysvsem
make ZEND_EXTRA_LIBS='-liconv'
make install

拷贝配置文件及启动脚本

cp php.ini-production /etc/php.ini
cp sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm
chmod +x /etc/init.d/php-fpm
chkconfig --add php-fpm
chkconfig php-fpm on
cd ../

安装PHP扩展模块，别忘记在配置文件里开启模块，不然就白装了哈
### 安装扩展模块 ###
tar zxf memcache-2.2.7.tgz
cd memcache-2.2.7/
/usr/local/php/bin/phpize
./configure --enable-memcache --with-php-config=/usr/local/php/bin/php-config
make
make install
cd ../
tar jxf eaccelerator-0.9.6.1.tar.bz2
cd eaccelerator-0.9.6.1/
/usr/local/php/bin/phpize
./configure --enable-eaccelerator=shared --with-php-config=/usr/local/php/bin/php-config
make
make install
mkdir /tmp/cache/eaccelerator
chmod 0777 /tmp/cache/eaccelerator
cd ../
tar zxf PDO_MYSQL-1.0.2.tgz
cd PDO_MYSQL-1.0.2/
/usr/local/php/bin/phpize
./configure --with-php-config=/usr/local/php/bin/php-config --with-pdo-mysql=/usr/local/mysql
make
make install
cd ../
tar zxf igbinary-1.1.1.tgz
cd igbinary-1.1.1
/usr/local/php/bin/phpize
./configure --enable-igbinary --with-php-config=/usr/local/php/bin/php-config
make && make install
cd ..
unzip master
cd phpredis-master
/usr/local/php/bin/phpize
./configure --enable-redis --enable-redis-igbinary --with-php-config=/usr/local/php/bin/php-config
make && make install
cd ..
tar zxvf ImageMagick-6.8.3-10.tar.gz
cd ImageMagick-6.8.3-10/
./configure
make
make install
cd ../
tar zxvf imagick-3.0.1.tgz
cd imagick-3.0.1/
/usr/local/php/bin/phpize
./configure --with-php-config=/usr/local/php/bin/php-config
ln -s /usr/local/include/ImageMagick-6 /usr/local/include/ImageMagick
export PKG_CONFIG_PATH=/usr/local/lib/pkgconfig
make
make install
cd ../

到此PHP环境配置完毕，接下来安装大名鼎鼎的Nginx。它的好咱就不说了，大家都知道哈。



五：安装Nginx
Nginx的rewrite需要perl库，所以先安装下。

tar zxf pcre-8.33.tar.gz
cd pcre-8.33
./configure
make && make install
cd ../

在安装Nginx前，先对Nginx做一些修改，如隐藏真实版本号，取消debug模式，利用TCMalloc库提升Nginx对内存的使用效率。

#set TCMalloc
wget http://ftp.twaren.net/Unix/NonGNU//libunwind/libunwind-1.1.tar.gz
tar zxf libunwind-1.1.tar.gz
cd libunwind-1.1
CFLAGS=-fPIC ./configure
make CFLAGS=-fPIC
make CFLAGS=-fPIC install
cd ..
wget https://gperftools.googlecode.com/files/gperftools-2.0.tar.gz
tar zxf gperftools-2.0.tar.gz
cd gperftools-2.0
./configure
make && make install
echo "/usr/local/lib" > /etc/ld.so.conf.d/usr_local_lib.conf
/sbin/ldconfig
tar zxf nginx-1.2.9.tar.gz
cd nginx-1.2.9
sed -i 's@#define NGINX_VERSION.*$@#define NGINX_VERSION      "1.5.4"@g' src/core/nginx.h
sed -i 's@#define NGINX_VER.*NGINX_VERSION$@#define NGINX_VER          "tengine/" NGINX_VERSION@g' src/core/nginx.h
sed -i 's@CFLAGS="$CFLAGS -g"@#CFLAGS="$CFLAGS -g"@g' auto/cc/gcc
./configure --user=nginx --group=nginx --prefix=/usr/local/nginx  \
--conf-path=/etc/nginx/nginx.conf --with-pcre \
--http-client-body-temp-path=/usr/local/nginx/tmp/client_body \
--http-proxy-temp-path=/usr/local/nginx/tmp/proxy --http-fastcgi-temp-path=/usr/local/nginx/tmp/fastcgi \
--http-uwsgi-temp-path=/usr/local/nginx/tmp/uwsgi --http-scgi-temp-path=/usr/local/nginx/tmp/scgi \
--pid-path=/var/run/nginx.pid --lock-path=/var/lock/subsys/nginx  \
--with-http_ssl_module --with-http_realip_module --with-http_addition_module \
--with-http_image_filter_module --with-http_sub_module --with-http_dav_module \
--with-http_gzip_static_module --with-http_random_index_module \
--with-http_secure_link_module --with-http_degradation_module --with-http_stub_status_module \
--with-file-aio
make && make install

为tcmalloc添加线程目
mkdir /tmp/tcmalloc
chmod 0777 /tmp/tcmalloc

在nginx.conf中添加一行配置

google_perftools_profiles /tmp/tcmalloc;

到此，LNMP环境就搭建完成了。接下来就是配置文件的修改和具体参数的调整了。任务依旧艰巨啊！

安装Nginx，配置参数少了一个--with-google_perftools_module，不然Nginx不会支持