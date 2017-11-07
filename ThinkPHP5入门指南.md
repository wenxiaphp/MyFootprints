# ThinkPHP

## ThinkPHP 简介

1、ThinkPHP 是一个免费开源的、快速简单的、面向对象的、轻量级PHP开发框架
2、创立于2006年初，遵循Apache2开源协议发布
3、秉承简洁实用的设计原则，注重框架的易用性
4、拥有众多的原创功能和特性，在易用性、扩展性和性能方面不断优化和改进
5、已经成长为国内最领先和最具有影响力的WEB应用开发框架

## 为什么选择ThinkPHP5

1、ThinkPHP5采用了全新的构架思想
2、优化了核心是一个颠覆性的版本
3、支持composer 方式安装（composer：包管理工具）
4、对API进行了大量的优化更符合了现代Web的开发方式
（ThinkPHP5和ThinkPHP之前的版本是不兼容的。ThinkPHP之前的版本不能直接无缝升级到ThinkPHP5的，因为ThinkPHP5中对API进行了大量的更新）

## 学习前的准备工作

1、需要有一定PHP基础，最好有使用过框架的经验
2、本机安装好开发环境
3、对git和composer有一定的了解
4、对编程有较强的兴趣，能坚持学习
（window：PHPStudy 和 WAMP，MAC：MAMP）

# MVC 简介

MVC全名是Model View Controller，是模型（Model）-视图（View）-控制器（Controller）的缩写，是一种软件设计典范（用途是一种设计模式），用一张业务逻辑、数据、界面显示分离的方法组织代码，将业务逻辑聚集到一个部件里面，在改进和个性定制界面及用户交互的同时，不需要重新编写业务逻辑。

## 传统模式和MVC模式对比

### 传统模式

没有层次划分
显示的代码比较凌乱
在小项目中效率比较高，项目稍微大一点的开发起来就会比较慢，而且后期维护是十分不方便的

### MVC分层开发模式
把代码分别封装：
Model层主要用来处理用户的数据
View层主要用来用户的展示
Controller层主要用来数据的输入、输出

### MVC优势

耦合度低
重用性高（相同的操作，调用相同的Model,不需要编写相同的代码）
可维护性高
有利于软件的工程化（后期很好的调试）

### MVC变形

无Model模式的Web开发
无View模式的API接口开发
Model再分层和Controller再分层

# ThinkPHP5安装

## 开发环境介绍

  PHP >= 5.4.0(小于的话，很多新的特性不能使用，程序运行失败)
  PDO MbString CURL PHP Extension（安装这些扩展，ThinkPHP运行才能顺利进行）
  Mysql （大于5.5以上的环境）
  Apache Nginx（ThinkPHP5内置的也有简易的PHP运行环境，无需我们安装，但是使用起来不太方便，还是推荐自己安装本机的Apache或Nginx环境）

## ThinkPHP的安装

### 通过git安装

主页地址（ThinkPhP的官方主页）：https://github.com/top-think
同时安装think和framework（框架）这两个才可以执行
先安装think，点击进入，复制地址->进入控制台->cd wamp目录中，然后克隆

```bash
$ git clone --depth=1 https://github.com/top-think/think.git think_git
```

安装framwork步骤一样
```bash
$ git clone --depth=1 https://github.com/top-think/framework.git thinkphp
```

 ### 通过composer方式安装

中文网站：http://www.phpcomposer.com
查看当前composer版本号：
```bash
$ composer --version
```

安装thinkPHP命令：
```bash
$ composer create-project --prefer-dist topthink/think think_composer
```

其中：think_composer 我们的安装目录地址

### 通过download 方式安装

官方网站：http://www.thinkphp.com
下载不是最新版本，但是一个稳定的版本，下载需要登录，通过QQ登录，登录成功之后点击下载就行
我们一般下载完整版，而不选择核心板
下载完成，解压，移动到wamp目录下
如果想获得较新的版本，我们可以从git中下载，需要同时下载think和framework框架，然后进行解压，把framework框架重新命名为ThinkPHP5，并放入之前解压的think中，最后把think文件夹移动到wamp目录下即可

### 调节目录结构

调整ThinkPHP5的目录结构
调整网站Document Root目录到Public目录

# ThinkPHP 的目录结构

application 应用目录
project  应用部署目录

├─application           应用目录（可设置）
│  ├─common             公共模块目录（可更改）
│  ├─index              模块目录(可更改)
│  │  ├─config.php      模块配置文件
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  └─ ...            更多类库目录
│  ├─command.php        命令行工具配置文件
│  ├─common.php         应用公共（函数）文件
│  ├─config.php         应用（公共）配置文件
│  ├─database.php       数据库配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─route.php          路由配置文件
├─extend                扩展类库目录（可定义）
├─public                WEB 部署目录（对外访问目录）
│  ├─static             静态资源存放目录(css,js,image)
│  ├─index.php          应用入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于 apache 的重写
├─runtime               应用的运行时目录（可写，可设置）
├─vendor                第三方类库目录（Composer）
├─thinkphp              框架系统目录
│  ├─lang               语言包目录
│  ├─library            框架核心类库目录
│  │  ├─think           Think 类库包目录
│  │  └─traits          系统 Traits 目录（核心文件）
│  ├─tpl                系统模板目录
│  ├─.htaccess          用于 apache 的重写
│  ├─.travis.yml        CI 定义文件
│  ├─base.php           基础定义文件
│  ├─composer.json      composer 定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     惯例配置文件
│  ├─helper.php         助手函数文件（可选）
│  ├─LICENSE.txt        授权说明文件
│  ├─phpunit.xml        单元测试配置文件
│  ├─README.md          README 文件
│  └─start.php          框架引导文件
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件

## ThinkPHP5目录和文件开发规范

1. 目录使用小写+下划线的方式命名
2. 类库函数文件名均以“.php”结尾
3. 类库的文件名均以命名空间定义，并且命名空间和类库文件所在的路径一致
4. 类文件采用驼峰 首字母大写 其余文件为小写+下划线命名
5. 类名和类文件名保持一致，采用驼峰命名，首字母大写

### ThinkPHP5函数 、类属性命名

1. 类采用驼峰命名，首字母大写不需要添加后缀controller，如：HomePage
2. 函数使用驼峰命名，首字母小写,如：getUserInfo
3. 属性名采用驼峰，首字母小写，如：tableName
4. 以双下划线_ 开头的函数或者方法为魔术方法

### ThinkPHP5常量和配置

常量以大写字母和下划线命名（最好不要以下划线开头）
配置参数以小写字母和下划线命名

### ThinkPHP5其他开发规范

表和字段采用小写+下划线的命名方式，不能以下划线开头
应用类库名的命名空间应该统一为app（可以配置）

# ThinkPHP5 模块设计

5.0版本对模块的功能做了灵活设计，默认采用多模块的架构，并且支持单一模块设计，所有模块的命名空间均以app作为根命名空间（可配置更改）

# ThinkPHP5配置

- 惯例配置
- 应用配置
- 扩展配置
- 场景配置
- 模块配置
- 动态配置

先定义配置文件，再在创建conf的文件夹中的config.php中修改配置信息，不然在文件config.php中的配置不起作用

场景配置：修改数据库配置时，需要把数据库的所有配置都copy一下，不能只单独拉出来配置某个字段，因为单独配置某个/某些配置时，会把它的所有配置替换掉

模块配置：conf下面的目录和app下面的目录文件名相同时，conf文件夹下的配置文件只对app下相同文件夹下的文件配置有效

动态配置：我们可以利用__construct构造方法进行文件配置，这样只在该控制器中使用
```php
public function __construct(){
    config('before','beforeAction');
}
```
如果只在方法中修改配置文件，那么只能在该方法中使用
```php
public function index(){
    config('indexaction','indexaction');
    dump(config());
}
```

## Config类和助手函数config

Config类文件路径：./thinkphp/library/think/Config.php
Config类和config函数对比：
```php
//获取配置文件
$res = Config::get();
$res = config();
```
```php
//获取配置文件中的某个值
$res = Config::get('app_status');
$res = config('app_status');
```
```php
//设置配置文件中的某个配置('键','值','作用域')
Config::set('username','meng');
config('username','mengwenxia');
//或者：
Config::set('username','meng','index');
config('username','index_config','index');
```
```php
//判断该配置是否存在，返回值为：bool（false/true）
$res = Config::has('username');
$res = config('?username');
```

## 环境变量配置和使用

在app的同级目录下创建.env文件
当在控制器下执行$_ENV返回空数组时，可以修改php.ini文件中的

   `Default Value: "EGPCS" 前面的';'号去掉，或者把 variables_order = "GPCS" 改成 variables_order = "EGPCS"`

 保存之后重启Apache即可，但是在.env中的设置的变量并不能使用'$_ENV'获取，需要用 think\Env::get('email') 获取
```php
//获取环境变量的值可以使用下面的两种方式获取
Env::get('database.username');
Env::get('database_username');

//如果emails存在的话，返回值为emails的值；如果不存在则返回的是第二个值'ddd'
Env::get('emails','ddd');
dump($res);
```

# 入口文件

## 单入口文件

应用程序的所有http请求都由某一个文件接受并由这个文件转发到相应的功能代码中。

## 单入口优势

- 安全监测
- 请求过滤（过滤掉某些无用的请求）

## 隐藏url中的index.php

打开Apache配置文件（H:\wamp64\bin\apache\apache2.4.27\conf\httpd.conf）：
`LoadModule rewrite_module modules/mod_rewrite.so` 前面的注释去掉

找到网站根目录：
```
<Directory "${INSTALL_DIR}/www/">
    #
    # Possible values for the Options directive are "None", "All",
    # or any combination of:
    #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
    #
    # Note that "MultiViews" must be named *explicitly* --- "Options All"
    # doesn't give it to you.
    #
    # The Options directive is both complicated and important.  Please see
    # http://httpd.apache.org/docs/2.4/mod/core.html#options
    # for more information.
    #
    Options +Indexes +FollowSymLinks +Multiviews

    #
    # AllowOverride controls what directives may be placed in .htaccess files.
    # It can be "All", "None", or any combination of the keywords:
    #   AllowOverride FileInfo AuthConfig Limit
    #
    AllowOverride all （把这个 ‘ None ’ 改成 ‘ all ’）

    #
    # Controls who can get stuff from this server.
    #

#   onlineoffline tag - don't remove
    Require local
</Directory>
```
重启Apache；同时，定义重写文件的规则：H:\wamp64\www\thinkphp\public\.htaccess（没有该文件或者文件名不是.htaccess都不能隐藏入口文件的）

## 入口文件绑定

如果开启了入口文件自动绑定操作，优先访问和文件名相同的模块。
```php
// 开启入口文件自动绑定操作
'auto_bind_module' => true
```
例如：在public文件夹下，有文件名为api.php的文件，api.php的内容为：
```php
<?php
define('APP_PATH',__DIR__.'/../app/');
define('CONF_PATH',__DIR__.'/../conf/');
require(__DIR__.'/../thinkphp/start.php');
?>
```

同时还存在文件 app/api/controller/Index.php 文件，那么当我们访问 http://127.0.0.1/thinkphp/public/api.php 会优先读取 api/controller 文件夹下的 index.php 文件；当不存在 app/api/controller/Index.php 文件时，会打开文件app/index/controller/Index.php 文件。
入口文件绑定模块，可以限定访问的模块

```php
//只能访问api的模块，不能访问其他的模块
define('BIND_MODULE','admin');
```

例如：同上面的内容在入口文件index.php中，当我们在浏览器访问 http://127.0.0.1/thinkphp/public/index/Index/index ，虽然要打开的是index模块下的Index类中的index方法，但是真实打开的文件是admin模块下的Index类中的index方法，无法打开index模块下的Index类中的index方法。
通过这种方式，限定了只能有一个模块可以访问。
同理如果常量定义为： define('BIND_MODULE','admin/index') ，通过这个方法限定了只能访问Index类中的方法 http://127.0.0.1/thinkphp/public/demo 相当于打开 http://127.0.0.1/thinkphp/public/admin/Index/demo
通过这种方式，限定了只能有一个模块下的类可以访问。

## 路由

目的：美化了URL和简化用户的访问

查看当前是否开启路由：H:\wamp64\www\thinkphp\thinkphp\convention.php
```php
// 是否开启路由
'url_route_on' => true,
// 是否强制使用路由
'url_route_must' => false
```

创建路由配置文件，文件名是固定的：route.php

```php
return [
    'news/:id' => 'index/Index/info',
    'index/Index/demo' => 'index/Index/demo'
];
```

打开index模块下Index类中的info方法，同时传递参数id值，当没有配置路由时，访问路径为： http://127.0.0.1/thinkphp/public/index/Index/info/id/5 ，然后进行上面方式设置路由之后，访问文件路径就可以简化为：http://127.0.0.1/news/5.html。

如果开启强制使用路由
例如：当访问index模块下的Index类中的demo方法时，没有开启强制使用路由时可以访问，开启之后就必须配置路由方可访问（'index/Index/demo' => 'index/Index/demo'）。

# 请求和响应

## 请求对象 Request

要获取当前的请求信息，可以使用\think\Request类

获取请求数据信息的三种方式：

1、利用助手函数 request() 直接获取；
```php
$request = request();
dump($request);
```
2、使用think下的Request类中的方法获取；
```php
use think\Request;
$request = Request::instance();
dump($request);
```
3、直接使用think下的Request类获取；
```php
public function index(Request $request){
    dump($request);
}
```

## 请求对象参数获取

### 获取url路径

例如：输入框中的路径是： http://127.0.0.1/thinkphp/public/index/Index/index/type/5.html?id=10
```php
echo '获取当前域名: ' . $request->domain().'<br/>';
//返回数据：获取当前域名: http://127.0.0.1
echo '获取当前入口文件: ' . $request->baseFile().'<br/>';
//返回数据：获取当前入口文件: /thinkphp/public/index.php
echo '获取当前URL地址 不含域名: '.$request->url().'<br/>';
//返回数据：获取当前URL地址 不含域名: /thinkphp/public/index/Index/index/type/5.html?id=10
echo '获取包含域名的完整URL地址: ' . $request->url(true) . '<br/>';
//返回数据：获取包含域名的完整URL地址: http://127.0.0.1/thinkphp/public/index/Index/index/type/5.html?id=10
echo '获取当前URL地址 不含QUERY_STRING: ' . $request->baseUrl() . '<br/>';
//返回数据：获取当前URL地址 不含QUERY_STRING: /thinkphp/public/index/Index/index/type/5.html
echo '获取URL访问的ROOT地址:' . $request->root() . '<br/>';
//返回数据：获取URL访问的ROOT地址:/thinkphp/public
echo '获取URL访问的ROOT地址,包含用域名:' . $request->root(true) . '<br/>';
//返回数据：获取URL访问的ROOT地址,包含用域名: http://127.0.0.1/thinkphp/public
echo '获取URL地址中的PATH_INFO信息: ' . $request->pathinfo() . '<br/>';
//返回数据：获取URL地址中的PATH_INFO信息: index/Index/index/type/5.html
echo '获取URL地址中的PATH_INFO信息 不含后缀: ' . $request->path() . '<br/>';
//返回数据：获取URL地址中的PATH_INFO信息 不含后缀: index/Index/index/type/5
echo '获取URL地址中的后缀信息: ' . $request->ext() . '<br/>';
//返回数据：获取URL地址中的后缀信息: html
```

### 获取模块、控制器、操作方法

```php
dump($request->module()); // index
dump($request->controller()); // Index
dump($request->action()); // index
```

### 获取请求信息

```php
// 获取url的请求方式。返回数据：GET
dump($request->method());
//判断是不是get请求。返回数据：true
dump($request->isGet());
// 判断是不是post请求。返回数据：false
dump($request->isPost());
// 判断是不是ajax请求。返回数据：false
dump($request->isAjax());
//获取url请求所传参数。返回的是参数组成的数组
dump($request->param());
// 获取url请求所传参数的某个具体值。返回数据：5
dump($request->param('type'));
// 获取访问url的ip地址。返回数据：127.0.0.1
dump($request->ip());
```

### 获取session、cookie值

```php
// 如果没有值，可以先设置session值，在测试
session('name','meng');
// 获取session值，返回是数组
dump($request->session());
// 获取session中的某个值。返回数据：meng
dump($request->session('name'));
// 如果没有值，可以先设置cookie值，在测试
cookie('name','dreaming');
// 获取cookie值，返回是数组
dump($request->cookie());
// 获取cookie中的某个值。返回数据：dreaming
dump($request->cookie('name'));
```
## 助手函数 input

定义函数时，不能定义与系统中助手函数相同的函数名。如果定义，在之前引用会导致系统中助手函数不能使用，在之后的引用程序会报错。


## 响应对象
