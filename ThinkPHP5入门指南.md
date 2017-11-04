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
重用性高（相同的操作，调用相同的Model）
可维护性高
有利于软件的工程化

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
