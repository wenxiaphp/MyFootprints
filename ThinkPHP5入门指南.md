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

通过助手函数input()可以获取的值有：get, post,put, patch, delete, route, param, request, session, cookie, server, env, path, file

使用方式：
```php
public function index(Request $request){
    $patch = input('id');
    dump($patch);//id的值

    //当post和get方式同时传相同的值时，post传1，get传2
    $get = input('get.id');
    $post = input('post.id');
    dump($get); // 2
    dump($post);    // 1

    //当要获取的参数不存在
    $empty = input('get.name','meng');
    dump($empty);// meng

    // session('ss','  123  ');
    dump(input('session.ss','sss@qq.com','trim'));//123（左右空格都被去掉了）
}
```

input的具体实现原理（think/help.php）:
```php
//function_exists() input函数是否存在
if (!function_exists('input')) {
    /**
     * 获取输入数据 支持默认值和过滤
     * @param string    $key 获取的变量名
     * @param mixed     $default 默认值（如果获取某个变量，但是这个变量在系统中不存在，则返回default）
     * @param string    $filter 过滤方法
     * @return mixed
     */
    function input($key = '', $default = null, $filter = '')
    {
        //如果key值以？号开头，会把？号去掉，并且还要把has设置为true
        if (0 === strpos($key, '?')) {
            $key = substr($key, 1);
            $has = true;
        }
        //如果key值存在‘.’，将用‘.’进行分割成两个成两个变量
        if ($pos = strpos($key, '.')) {
            // 指定参数来源
            list($method, $key) = explode('.', $key, 2);
            if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete', 'route', 'param', 'request', 'session', 'cookie', 'server', 'env', 'path', 'file'])) {
                $key    = $method . '.' . $key;
                $method = 'param';
            }
        } else {
            //如果key值不存在‘.’，会直接设置为param
            // 默认为自动判断
            $method = 'param';
        }
        if (isset($has)) {
            //以？开头
            return request()->has($key, $method, $default);
        } else {
            //不是以？开头
            return request()->$method($key, $default, $filter);
        }
    }
}
```
测试post传值，可以使用 Postman 或者 Fiddler 进行测试。

## return 返回数据类型

return返回的数据格式配置文件：think/convention.php 中

```php
'default_return_type' => 'html'
```

如果在接口中返回的数据不想用html，可以修改返回类型

```php
//把返回数据的类型设置为：json（默认是：html）
Config::set('default_return_type','json');
```
常用的修改类型的方式是（把返回类型当参数传入，进行动态修改）：
```php
public function getUserInfo($type='json'){
    if(!in_array($type,['json','xml'])){
        $type = 'json';
    }
    Config::set('default_return_type',$type);
    $data = [
        'code' => 200,
        'result' => [
            'username' => 'meng',
            'useremail' => 'dreaming99@126.com'
        ]
    ];
    return $data;
}
```
或者 创建响应的配置文件，进行类的整体修改（具体见模块配置）

# 视图view和模板model

## 视图View

助手函数view()的使用：
```php
public function index(){
    # 默认模板的地址
    # view() app/index/view/index/index.html
    # 传递的第一个参数是修改模板文件目录的
    # view(upload) app/index/view/index/upload.html
    # view(public/upload) app/index/view/public/upload.html
    # 如果以 ./ 开头 那么就找到入口文件同级开始的模板文件

    # 传递的第二个参数：是传递到第一个参数所对应页面的值
    # 传递的第三个参数：将页面中所有大写的 STATIC 替换成当前是static的替换内容
    return view('index',[
        'email' => '123@qq.com',
        'user' => 'meng'
    ],[
        'STATIC' => '当前是static的替换内容'
    ]);
}
```
一般编写web应用不推荐使用，如果想使用view可以使用Controller类下的fetach()方法，参数和函数 view() 一样。
（如果控制器继承了\think\Controller类的话，则无需自己实例化视图类，可以直接调用控制器基础类封装的相关视图类的方法）

| 方法    | 说明           |
| ------- | -------------- |
| fetch   | 渲染模板输出   |
| display | 渲染内容输出   |
| assign  | 模板变量赋值   |
| engine  | 初始化模板引擎 |

```php
//相当于第二个参数，传到页面的值
$this->assign('assign','assign传递的值');
return $this->fetch('index',[
    'email' => '123@qq.com',
    'user' => 'meng'
],[
    'STATIC' => '当前是static的替换内容'
]);
```
```php
$this ->assign('user','meng');
return $this->display('这是{$email}一个字符串{$user}',[
    'email' => '123@qq.com'
]);
//返回内容：这是123@qq.com一个字符串meng
```

## 变量的输出、赋值和替换

### 变量的输出

在视图html中，我们通过使用一对 “{}” 加 “$+返回的变量名” 来获取控制器返回的值：
```html
<p>{$email}</p>
```
如果想修改这对“{}”，可以在thinkphp\convention.php中找到‘模板设置’使用配置文件的修改方法进行修改下面的两个值：
```php
// 模板引擎普通标签开始标记
'tpl_begin' => '{meng',
// 模板引擎普通标签结束标记
'tpl_end' => '}',
```
结果是：
```html
<p>{meng$email}</p>
```
### 变量的赋值

在继承Controller下变量赋值的四种方式：
```php
 use think\Controller;
 use think\View;
```
1. 通过是用 fetch() 的第二个参数
```php
return $this->fetch('index',[
    'email' => '123@qq.com',
    'user' => 'meng'
]);
```
2. 通过是用 assign() 方法
```php
// 变量名：key；变量值：value
$this->assign('key','value');
```
3. 通过 view 获取
```php
// 获取view对象，给view对象设置一个属性key2（变量名），把key2的值设置成value2（变量值）
$this->view->key2 = 'value2';
```
4. 通过view下的share()方法赋值（静态方法）
```php
//变量名：key3，变量值：value3
View::share('key3','value3');
```
在分配变量时，这四种方法同时向模板中分配的变量同时有效，系统会把这四种方式传递的变量进行合并，统一向页面中进行分配，这样就可以在页面中使用。

### 变量的替换

1、通过是用 fetch() 的第三个参数，进行替换
```php
return $this->fetch('index',[],[
    'STATIC' => '要替换的内容'
]);
```
对应的html为：
```html
<p>STATIC</p>
```

2、通过在配置文件config.php中定义进行设置替换：
```php
'view_replace_str' => [
    '__123__' => '一二三'
],
```
对应的html中获取值为：
```html
<p>__123__</p>
```

3、通过直接使用 ‘thinkphp/library/think/View.php’ 系统中设置的替换(优先级最低)：
```html
<p>__URL__</p>
<p>__STATIC__</p>
<p>__JS__</p>
<p>__CSS__</p>
<p>__ROOT__</p>
```
优先级（低->高）：系统默认的配置 -> 模块配置文件中的配置（相同的替换）-> 方法中的配置

## 模板中使用系统变量原生标签

以下面例子为例：
```html
<p>{$Think.server.HTTP_HOST}</p>

<p>get:{$Think.get.id}</p>
<p>post:{$Think.post.sid}</p>
<p>request:{$Think.request.id}</p>
<p>session:{$Think.session.email}</p>
<p>cookie:{$Think.cookie.username}</p>

<p>获取常量APP_PATH: {$Think.const.APP_PATH}</p>
<p>获取常量APP_PATH: {$Think.APP_PATH}</p>
<p>不提倡这样写,在模板中直接写原生的（如下面样式，这样在以后的维护中是比较麻烦的）</p>
<?php
    echo APP_PATH.'<br/>';
    $a = 10;
    $b = 20;
    if($a > $b){
        echo '1';
    } else{
        echo '2';
    }
?>
```

## 变量的输出调节器

以下面例子进行解析：
在index.php中设置变量值：
```php
public function index(){
    $this->assign('email','123@qq.com');
    $this->assign('time',time());
    $this->assign('a',10);
    $this->assign('b',30);
    return $this->fetch();
}
```
在对应的视图模板里面进行设置：
```html
{/* 注释是：页面返回的数据信息 （这种格式也是注释，而这种注释是在页面和查看源码时里面都看不到的注释格式）*/}

<p>{$email} : {$email|md5}</p>
<!-- 使用md5加密邮箱  123@qq.com : 487f87505f619bf9ea08f26bb34f8118 -->
<p>{$email} : {$email|substr=0,2}</p>
<!-- 使用substr函数截取字符串 123@qq.com : 12 -->
<p>{$email} : {$email|md5} : {$email|md5|strtoupper}</p>
<!--使用md5加密邮箱，并且使用strtoupper把字符串转换成大写 123@qq.com : 487f87505f619bf9ea08f26bb34f8118 : 487F87505F619BF9EA08F26BB34F8118 -->
<h2>{$time} : {$time|date='Y-m-d',###}</h2>
<!--获取时间戳，并且把时间戳转换成时间格式，使用的‘###’是占位符代表前面的$time，返回结果：1510207933 : 2017-11-09 -->
<hr />
<p>a+b={$a+$b}</p>  <!-- a+b=40 -->
<p>a-b={$a-$b}</p>  <!-- a-b=-20 -->
<p>a*b={$a*$b}</p>  <!-- a*b=300 -->
<p>a/b={$a/$b}</p>  <!-- a/b=0.33333333333333 -->
<p>a%b={$a%$b}</p>  <!-- a%b=10 -->
<p>b%a={$b%$a}</p>  <!-- b%a=0 -->
<p>a++={$a++}</p>   <!-- a++=10 -->
<p>a--={$a--}</p>   {/* a--=11  */}
<p>++a={++$a}</p>   <!-- ++a=11 -->
<p>--a={--$a}</p>   {/* --a=10  */}
<hr/>
<p>{$emails|default='123345@qq.com'}</p>
<!--在模板中进行赋值：123345@qq.com -->
<p>在 literal 里面的变量不会被解析</p>
{literal}
    {$email}
{/literal}
```

# 标签

## 循环标签

ThinkPHP5 提供了三种标签：
### 1、volist 循环

volist的用法：
```html
{volist name='list' id='vo' offset='0' length='3' mod='2'  empty="$empty" key='s'}
    <p></p>
    <p>{$mod}:{$s}:{$vo.name}</p>
{/volist}
offset ：指定了从哪个开始遍历<br>
length ：指定遍历的次数<br>
mod ：取余（当前循环次数和mod的值取余，并赋值给mod）<br>
empty ：当list返回为空时，要在页面上打印的内容<br>
key : 默认值为‘i’，如果冲突可以修改，表示当前循环的次数<br>
```
设置`empty="$empty"`的三种方式：
第一种写在控制器中的：
```php
$empty = "<h1>这里是分配为空的状态</h1>";
$this->assign('empty',$empty);
```
第二种写在页面布局html中的：
```html
<?php
    $empty = "<h1>这里是分配为空的状态</h1>";
?>
```
第三种写在页面布局html中的：
```html
{php}
    $empty = "<h1>这里是分配为空的状态</h1>";
{/php}
```

### 2、foreach 循环

第一种用法：
```html
{foreach $list as $val}
    <p>{$val.name} : {$val.email}</p>
{/foreach}
```
第二种用法：
```html
{foreach name='list' item='val' key='s'}
    <p>{$key} == {$s}</p>
    <p>{$val.name} : {$val.email}</p>
{/foreach}
key : 数组的下标,也可以起别名，默认为key<br>
```

### 3、 for循环

用法：
```html
{for start='1' end='10' step='2' name='k'}
    <p>{$k}</p>
{/for}
start ：从几开始<br>
end ：从几结束<br>
step ：默认是1，每次隔几个<br>
name : 默认是 ‘i’ ，可以通过 name 进行重新命名<br>
```
相当于PHP中的：
```php
for($i=1;$i<10;$i++){
    echo "<p>{$i}</p>";
}
```
在序列里面用法：
```html
<ol>
    {for start='1' end='10'}
        <li>{$i}</li>
    {/for}
</ol>
```
返回结果：
```html
1. 1
2. 2
3. 3
4. 4
5. 5
6. 6
7. 7
8. 8
9. 9
```

## 比较标签

定义两个变量分别如下：

```html
<p>a的值：{$a}</p>
<!-- a的值：10 -->
<p>b的值:{$b}</p>
<!-- b的值:20 -->
```

### eq 和 equal 标签（相等）

```html
{eq name='a' value="$b"}
    <p>a eq b : 正确</p>
{else/}
    <p>a eq b : 不相等</p>
{/eq}
{equal name='a' value="$b"}
    <p>a equal b : 相等</p>
{else/}
    <p>a equal 10 : 不相等</p>
{/equal}
```

### neq 和 notequal 标签（不相等）

```html
{neq name='a' value="$b"}
    <p>a neq 20 : 不相等</p>
{else/}
    <p>a neq 20 : 相等</p>
{/neq}
{notequal name='a' value="$b"}
    <p>不相等</p>
{else/}
    <p>相等</p>
{/notequal}
```

### gt 和 egt 标签（大于、大于等于）

```html
{gt name='a' value='8'}
    <p>正确</p>
{else/}
    <p>错误</p>
{/gt}
{egt name='a' value='10'}
    <p>正确</p>
{else/}
    <p>错误</p>
{/egt}
```

### lt 和 elt 标签（小于、小于等于）

```html
{lt name='a' value='8'}
    <p>正确</p>
{else/}
    <p>错误</p>
{/lt}
{elt name='a' value='10'}
    <p>正确</p>
{else/}
    <p>错误</p>
{/elt}
```
## 判断标签

### switch 标签

`switch标签`：当比较多个值时，使用“|”隔开。
switch用法如下：
```html
{switch name="Think.get.level"}
    {case value='1|2' } <p>铜牌会员</p>{/case}
    {case value='3' } <p>黄金会员</p>{/case}
    {case value='4' } <p>钻石会员</p>{/case}
    {default /} <p>游客</p>
{/switch}
```
### if 标签

`if标签` ：在模板中不建议使用，因为在模板中大量的判断是有问题的，让模板不够干净。如果想使用这种逻辑判断，一般使用switch就可以；如果必须使用if的话，需要检查一下控制器，大多的判断需要在控制器中进行；如果模板中存在大量的if，那说明控制器写的有问题。
```html
{if condition="($Think.get.level == 1) AND ($Think.get.id == 10)"}
    <p>当前的值为1 并且id等于10</p>
{else/}
    <p>当前的值不为1 或者 id的值不等于10</p>
{/if}
```

### range标签

1、如果 `type='in'` 表示 name值是value值里面的任何一个
```html
{range name="Think.get.level" value="1,2,3" type="in"}
    <p>当前level值是1,2,3中的任何一个</p>
{else/}
    <p>当前level值不是1,2,3中的任何一个</p>
{/range}
{in name="Think.get.level" value="1,2,3"}
    <p>当前level值是1,2,3中的任何一个</p>
{else/}
    <p>当前level值不是1,2,3中的任何一个</p>
{/in}
```
2、如果 `type='notin'` 表示 name值不是value里面的任何一个
```html
{range name="Think.get.level" value="1,2,3" type="notin"}
    <p>当前level值不是1,2,3中的任何一个</p>
{else/}
    <p>当前level值是1,2,3中的任何一个</p>
{/range}
{notin name="Think.get.level" value="1,2,3"}
    <p>当前level值不是1,2,3中的任何一个</p>
{else/}
    <p>当前level值是1,2,3中的任何一个</p>
{/notin}
```
3、如果`type='between'`表示 name值在value的两个值之间,包含这两个值
```html
{range name="Think.get.level" value="1,10" type="between"}
    <p>当前level值在1到10之间</p>
{else/}
    <p>当前level值不在1到10之间</p>
{/range}
{between name="Think.get.level" value="1,10"}
    <p>当前level值在1到10之间</p>
{else/}
    <p>当前level值不在1到10之间</p>
{/between}
```
4、如果`type='notbetween'`表示 name值不在value的两个值之间，不包含这两个值
```html
{range name="Think.get.level" value="1,10" type="notbetween"}
    <p>当前level值不在1到10之间</p>
{else/}
    <p>当前level值在1到10之间</p>
{/range}
{notbetween name="Think.get.level" value="1,10"}
    <p>当前level值不在1到10之间</p>
{else/}
    <p>当前level值在1到10之间</p>
{/notbetween}
```
### defined 标签

defined ：判断当前系统中某常量是否定义
```html
{defined name="APP_PATH"}
    <p>APP_PATH 已经定义</p>
{else/}
    <p>APP_PATH 未定义</p>
{/defined}
```
# 模板布局 包含 继承

## 模板引入机制：include
可以直接使用include方式引入不同的文件，来简化我们的模板，file表示要引入的文件路径。
```html
{include file='common/nav' /}
```

## 模板继承机制：block

首先编写一个被继承的模板，称之为父模板。然后直接在模板中使用 `extend` 这种方式直接继承父模板；如果要替换父模板中的内容，只需要使用 `block` 在父模板中进行位置的预留，之后就可以在模板中直接使用与父模板中bolck同名的name值的方式来替换父模板中的内容。
```html
/* extend中name表示父模板的路径 */
{extend name='common/base' /}
```
```html
/*父模板中的位置预留*/
{block name='body'}{/block}
```
```html
{block name='body'}
    <h1>这里是index页面的body内容</h1>
{/block}
```
如果在父模板中有要用的内容，不需要全部替换的话，可以使用“`{__block__}`”，来拼接父模板中的内容
```html
/*父模板中的位置预留，含有内容*/
{block name='footer'}底部{/block}
```
在子模板中的继承
```html
{block name='footer'}
    index页面中的_{__block__}
{/block}
/*
    返回结果：
    index页面中的底部
*/
```

## 模板布局机制：layout

要使用layout，首先要修改配置文件`conf/config.php`中在‘`template`’里面添加配置项：`layout_on` 和 `layout_name`
```php
'template' => [
    // 模板引擎类型 支持 php think 支持扩展
    'type'  => 'Think',
    // 视图基础目录，配置目录为所有模块的视图起始目录
    'view_base'    => '',
    // 当前模板的视图目录 留空为自动获取
    'view_path'    => '',
    // 模板后缀
    'view_suffix'  => 'html',
    // 模板文件名分隔符
    'view_depr'    => DS,
    // 模板引擎普通标签开始标记
    'tpl_begin'    => '{',
    // 模板引擎普通标签结束标记
    'tpl_end'      => '}',
    // 标签库标签开始标记
    'taglib_begin' => '{',
    // 标签库标签结束标记
    'taglib_end'   => '}',
    /*
        开启layout功能，在所有的模板中都会有效
    */
    'layout_on' => true,
    'layout_name' => 'layout'
],
```
如果开启了layout，优先找到view/layout.html（文件名要和配置中设置的layout_name值一样）文件，在layout文件中bolck是不起作用的，但是include是可以使用的。
首先在模板中不需要编写继承或者其他的一些标签，可以直接输出内容，它实现的效果其实就是和我们使用继承的方式中只挖一个坑是一样的，在这里只有一个“{__CONTENT__}”(这个名称是固定的)。
可以直接在模板（在该模板中不能使用其他机制的，但是可以使用include）中直接进行编写，它会把模板中的字符串和layout中“__CONTENT__”进行替换，之后对layout进行编译。

如果要修改部分内容，可以在layout模板中设置变量，然后通过控制器进行传值设置
```php
$this->assign('title','index');
return $this->fetch();
```
```html
<title>
    模板 {$title}页面的title值
</title>
/*
    返回结果：
    模板 index页面的title值
*/
```
