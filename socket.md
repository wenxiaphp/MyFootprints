1、创建 socket 文件夹

2、进入socket cd /home/www/yoka/socket/

3、执行：git clone https://github.com/lixuancn/MeepoPS.git

如果报错：
The program 'git' is currently not installed. You can install it by typing:
apt install git

则先执行：apt install git

再执行：git clone https://github.com/lixuancn/MeepoPS.git

4、安装成功后：
- 开启：sudo php demo-telnet.php start
- 关闭：sudo php demo-telnet.php kill

### 安装php的pcntl扩展

首先执行phpize命令
如果没有安装执行会返回：
The program 'phpize' is currently not installed. You can install it by typing:
apt install php7.0-dev

然后执行：apt install php7.0-dev



1. workerman

workerman是一个高性能的PHP socket 服务器框架，workerman基于PHP多进程以及libevent事件轮询库，PHP开发者只要实现一两个接口，便可以开发出自己的网络应用，例如Rpc服务、聊天室服务器、手机游戏服务器等。

workerman的目标是让PHP开发者更容易的开发出基于socket的高性能的应用服务，而不用去了解PHP socket以及PHP多进程细节。 workerman本身是一个PHP多进程服务器框架，具有PHP进程管理以及socket通信的模块，所以不依赖php-fpm、nginx或者apache等这些容器便可以独立运行。

下载：http://www.workerman.net/workerman



2.swoole 
PHP语言的高性能网络通信框架，提供了PHP语言的异步多线程服务器，异步TCP/UDP网络客户端，异步MySQL，数据库连接池，AsyncTask，消息队列，毫秒定时器，异步文件读写，异步DNS查询。

Swoole可以广泛应用于互联网、移动通信、企业软件、云计算、网络游戏、物联网、车联网、智能家居等领域。 使用PHP+Swoole作为网络通信框架，可以使企业IT研发团队的效率大大提升，更加专注于开发创新产品。 

下载：http://www.swoole.com/

---------------------

本文来自 持之以恒 的CSDN 博客 ，全文地址请点击：https://blog.csdn.net/qq1355541448/article/details/50364874?utm_source=copy 


[PHP开发高可用高安全App后端](https://blog.csdn.net/qq_33936481/article/details/79219653)