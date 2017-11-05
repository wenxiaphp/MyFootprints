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

    git clone --depth=1 https://github.com/top-think/think.git think_git

安装framwork步骤一样

    git clone --depth=1 https://github.com/top-think/framework.git thinkphp

 ### 通过composer方式安装

中文网站：http://www.phpcomposer.com
查看当前composer版本号：

    composer --version

安装thinkPHP命令：

    composer create-project --prefer-dist topthink/think think_composer

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

目录使用小写+下划线的方式命名
类库函数文件名均以“.php”结尾
类库的文件名均以命名空间定义，并且命名空间和类库文件所在的路径一致
类文件采用驼峰 首字母大写 其余文件为小写+下划线命名
类名和类文件名保持一致，采用驼峰命名，首字母大写

### ThinkPHP5函数 、类属性命名

类采用驼峰命名，首字母大写不需要添加后缀controller，如：HomePage
函数使用驼峰命名，首字母小写,如：getUserInfo
属性名采用驼峰，首字母小写，如：tableName
以双下划线_ 开头的函数或者方法为魔术方法

### ThinkPHP5常量和配置

常量以大写字母和下划线命名（最好不要以下划线开头）
配置参数以小写字母和下划线命名

### ThinkPHP5其他开发规范

表和字段采用小写+下划线的命名方式，不能以下划线开头
应用类库名的命名空间应该统一为app（可以配置）

# ThinkPHP5 模块设计

5.0版本对模块的功能做了灵活设计，默认采用多模块的架构，并且支持单一模块设计，所有模块的命名空间均以app作为根命名空间（可配置更改）

# ThinkPHP5配置

惯例配置
应用配置
扩展配置
场景配置
模块配置
动态配置

先定义配置文件，再在创建conf的文件夹中的config.php中修改配置信息，不然在文件config.php中的配置不起作用
