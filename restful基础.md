# 什么是Restful

本质：一种软件架构风刮
核心：面向资源
解决问题：（1）降低开发的复杂性（2）提高系统的可伸缩性
设计概念和准则：
（1）网络上的所有事物都是可以被抽象为资源
（2）每一个资源都有唯一的资源标识，对资源的操作不会改变这些标识
（3）所有的操作都是无状态的
什么是资源：就是网络上的一个实提，或者说是网络上的一个具体信息

# restful 中http协议介绍  

HTTP：是属于应用层的协议，特点是简捷，快速。
schema://host[:port]/path[?query-string][#anchor]

schema：指定底层使用的协议（http、https）
host：服务器的ip地址或者域名
port：服务器端口号，默认80
path：访问资源的路径
query-string：发送给http服务器的数据
anchor：锚

## HTTP协议-请求

组成格式：请求行、消息报头、请求正文
请求行：格式如下
Method Requery-URI HTTP-Version CRLF
例子：GET /HTTP/1.1 CRLF

请求方式：

GET：请求获取Requery-URI所标识的资源
POST：在Requery-URI所标识的资源后附加的新的数据
HEAD：请求获取由Requery-URI所标识的资源的响应消息报头（例如：资源的创建时间）
PUT：请求服务器存储一个资源，并用Requery-URI作为其标识
DELETE：请求服务器删除Requery-URI所标识的资源
OPTIONS：请求查询服务器的性能，或者查询与资源相关的选项和需求

## HTTP协议-响应

组成格式：状态行、消息报头、响应正文
状态行：
格式如下：HTTP-Version Status-Code Reason-Phrase CRLF
例子：HTTP/1.1 200 OK

常用响应状态码：
200 OK  客户端请求成功
400 Bad Request 客户端请求有语法错误，不能被服务器所理解
401 Unauthorized 服务器收到请求，但是拒绝提供服务
404 Not Found 请求资源不存在
500 Internal Server Error 服务器发生不可预期的错误
503 Server Unavailable 服务器当前不能处理客户端的请求（服务器达到瓶颈之后拒绝提供服务）

# 架构区别

restful 架构与其他架构的区别

SOAP WebService

WebService 是一种跨编程语言和跨操作系统平台的远程调用技术
WebService 通过HTTP协议发送请求和接收结果时采用XML格式封装，并增加了一些特定的HTTP消息头，这些特定的HTTP消息头和XML内容格式就是SOAP协议

## 效率和易用性

SOAP 由于各种需求不断扩充其本身协议的内容，导致在SOAP处理方面的性能有所下降，同时在易用性方面以及学习成本上也有所增加

restful 由于其面向资源接口设计以及操作抽象简化了开发者的不良设计，同时也最大限度的利用了HTTP最初的应用协议设计理念
 
## 安全性（restful < SOAP）

restful 对于资源型服务接口来说很适合，同时特别适合对于效率要求很高，但是对于安全要求不高的场景
SOAP 的成熟型可以给需要提供给多开发语言的，对于安全性要求较高的接口设计带来便利，所以我觉得纯粹说什么设计模式将会占据主导地位没有什么意义，关键还是看应用场景

# restful 设计要素

如何设计 RESTful API

- 资源路径（URI）

在 RESTful 架构中，每个网站代表一种资源，所以网址中不能有动词，只能有名词，一般来说API中的名词应该使用复数
例如：https://api.example.com/v1/zoos  动物园资源

- HTTP动词

对于资源的操作（CURD），由HTTP动词（谓词）表示
- GET：从服务器取出资源（一项或者多项）
- POST：在服务器新建一个资源
- PUT：在服务器更新资源（客户端提供改变后的完成资源）
- PATCH：在服务器更新资源（客户端提供改变的属性）（用的比较少）
- DELETE：从服务器删除资源

例如：
- POST/zoos ：新建一个动物园
- GET/zoos/ID ：获取某个指定动物园的信息
- PUT/zoos/ID ：更新某个指定动物园的信息
- DELETE/zoos/ID ：删除某个动物园

- 过滤信息
 
如果记录数量很多，服务器不可能都将他们返回给用户
API应该提供参数，过滤返回结果

例如：
- ?offset=10 ：指定返回记录的开始位置
- ?page=2&per_page=100 ：指定第几页，以及每页的记录数

- 状态码
 
服务器向用户返回的状态和提示信息，使用标准HTTP状态码
 - 200 OK 服务器成功返回用户请求的数据，该操作是幂等的
 - 201 CREATED 新建或者修改数据成功
 - 204 NO CONTENT 删除数据成功
 - 400 Bad Request 用户发出的请求有语法错误，该操作是幂等的
 - 401 Unauthorized 表示用户没有认证，无法进行当前操作
 - 403 Forbidden 表示用户访问是被禁止的
 - 422 Unprocesable Entity 当创建一个对象时，发生一个验证错误
 - 500 Internal Server Error 服务器发生错误，用户将无法判断发出的请求是否成功

- 错误处理
 
如果状态码是4XX 或者5XX ，就应该向用户返回出错误信息，一般来说，返回的信息中将error作为键名，出错信息作为键值即可
```
{
	"error":"参数错误"
}
```

- 返回结果
  
针对不同操作，服务器向用户返回的结果应该符合以下规范：
- GET/collections：返回资源对象的列表（数组）
- GET/collections/identity：返回单个资源对象
- POST/collections：返回新生成的资源对象
- PUT/collections/identity：返回完整的资源对象
- PATCH/collections/identity：返回被修改的属性
- DELETE/collections/identity：返回一个空文档

# 安装DHC Client插件

谷歌安装
在chrome网上应用店进行搜索安装，搜索：Restlet Client（需翻墙）
也可以在网上下载成功之后，把文件直接拖到chrome的扩展列表内（注意谷歌版本）
也可以是用postman

# 开发环境搭建

- 下载upupw.net集成环境

[下载链接](http://www.upupw.net)
当前选择的配置为 apach PHP5.5

- 添加虚拟主机，已经取消跨站目录限制

- 添加虚拟主机的本地hosts解析

设计要素

- 资源路径（URI）
- HTTP动词（GET、PUT、POST、DELETE）
- 过滤信息（分页，某关键词进行过滤）
- 状态码（200、204、400、403、401、500）
- 错误处理（配合http状态码事件）
- 返回结果

数据库设计

设计数据库工具：MySQLworkbentch，navicat







