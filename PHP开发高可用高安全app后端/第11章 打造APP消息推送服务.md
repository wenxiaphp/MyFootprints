# 打造APP消息推送服务

一款完整的app，推送功能是必不可少的。本章先讲解APP消息推送业务，接下来讲解两种推送方案：原始轮训以及第三方极光推送，并对两种不同的推送方案进行优缺点解析，让小伙伴对APP推送有新的认知。

## APP消息推送介绍

实现消息推送的几种方式：

- 原生方式（轮训）
- 自己开发消息推送系统
- 第三方提供的SDK
- 极光、百度云、等等

## 原始解决方案-轮训法处理

中小型公司使用的、基本被淘汰

每一分钟 抛送一个http请求地址，查看是否有消息返回

## 使用第三方推送平台 -- 极光

登录极光账号
进入控制台
创建应用、上传logo
可以推送进行测试
需要设置推送设置内容

## SDK下载和安装

开发者服务
极光推送
sdk下载
服务端sdk
php
下载的代码放入 vendor、或者通过composer安装

安装在项目目录下运行：composer require jpush/jpush 

## 发送第一个demo

如何使用推送，在测试控制器 `app/api/controller/test.php` 中封装进行测试 ：

```php
public function pushtest(){
	$client = new \JPush\Client('自己的key','自己的secret');
	$pusher = $client->push();
	$pusher->setPlatform('all');
	$pusher->addAllAudience();
	$pusher->setNotificationAlert('Hello, 测试');
	try {
		$pusher->send();
	} catch (\JPush\Exceptions\JPushException $e) {
		// try something else here
		print $e;
	}
}
```

> 流程：PHPSDK -> 第三方推送消息平台jspush -> 第三方平台发送给app

## 发送消息类库 - 基础封装

1、在公共模板下创建 `app/common/lib/Jpush.php` 文件：
 
```php
<?php
	namespace app\common\lib;
	// 极光推送封装
	class Jpush{
		// 推送消息
		public static function push($title , $newId = 0 , $type = 'android'){
			try{
				// 可以定义一个配置文件，把key和secret放入配置文件中
				$client = new \JPush\Client('自己的key','自己的secret');
				$client->setPlatform('all')// 设备型号：android、ios
						->addAllAudience()
						->setNotificationAlert($title)
						->androidNotification($title, array( // 这个根据机型$type 判断
							'title' => $title,
							extras' => array(
								'id' => $newId, // 根据自己业务调整（带参数调转详情页）
								//'catidid' => $newId
							),
						)
			}catch(\Exception $e){
				//echo $e->getMessage();
				return false;
			}	
			return true;
		}
	}
```

2、在测试控制器 `app/api/controller/test.php` 中封装一个测试接口push()进行测试 ：

```php

use app\common\lib\Jpush;

public  function push(){
	$obj = new Jpush();
	Jpush::push('ceshiceshi',17);
}
```

3、访问接口：http://域名/api/test/push