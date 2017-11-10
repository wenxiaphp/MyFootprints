## HTTP 超文本传输协议（HyperText Transfer Protocol)

http协议是web工作的核心，php为web而生
http是一种让web服务器与浏览器通过Internet 发送与接收数据的协议，建立在tcp协议之上，通常监听tcp的80端口，他是一个请求响应的协议，也就是说客户端发出一个请求、服务器响应这个请求，在http中，客户端总是通过建立一个连接与发送一个http请求来发起一个事务，服务器不能主动的与客户端联系，也不能给客户端发出一个回调连接，客户端和服务端都可以中断一个连接，例如：我们在浏览器下载一个文件时，可以通过点击停止按钮，中止下载，关闭服务器与客户端的http连接。
http协议是无状态的，同一个客户端的请求，本次和上次是没有任何的对应关系，对于服务器来说，他并不知道两个请求是否来自同一个客户，为了解决这个问题，web程序引入了cookie机制，来维持连接的可持续状态。
http由两部分组成：Header + Body 组成，Header也就是我们所说的头信息，Body就是我们的身体部分，也就是参数部分。
![http的组成部分](C:/Users/Administrator/Desktop/微信截图_20171110160156.png)
http是应用层的协议，那么他就会比tcp更加高级，http是一个短连接，这类连接发送请求，拿到服务器响应断开连接。

http协议分为四步：
1、客户端通过TCP/IP协议建立到服务器的TCP连接
2、客户端向服务器发送HTTP协议请求
3、服务器向客户端发送HTTP协议应答包
4、断开连接。客户端渲染HTML文档

![coogle首页](C:/Users/Administrator/Desktop/http.png)
![WebServer服务](C:/Users/Administrator/Desktop/WebServer.png)

## 多进程

分为：系统进程和用户进程

## WebServerSocket

一个应用层协议
长链接
主流即使通讯协议
需要借助http来进行握手
![WebSocket](C:/Users/Administrator/Desktop/webSocket.png)

## GitHub

GitHub是全世界最著名的代码托管软件
Star 收藏
Fork 复制
Branch 分支  tage 版本号


## PHP Socket 框架 MeepoPS

官网：http://meepops.lanecn.com/
关于MEEPOPS：
MeepoPS是Meepo PHP Socket的缩写. 旨在提供高效稳定的由纯PHP开发的多进程SocketService.
MeepoPS可以轻松构建在线实时聊天, 即时游戏, 视频流媒体播放, RPC, 以及原本使用HTTP的接口/定时任务的场景中等.
手册地址: http://meepops.lanecn.com
Github: https://github.com/lixuancn/MeepoPS-PHP
Bug提交: https://github.com/lixuancn/MeepoPS-PHP/issues
微博: http://weibo.com/lanephp

MeepoPS的最低运行要求是安装了PHP的PCNTL库.
MeepoPS的定位是一个插件/扩展. 不但可以独立运行, 也可以依附与ThinkPHP, CodeIgniter, YII等MVC框架中.
