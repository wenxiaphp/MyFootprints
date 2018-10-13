# APP版本升级业务开发
本章先带领大家分析APP版本升级业务，然后带领小伙伴设计版本表，最后带领大家一一攻破此业务的开发，让您轻轻松松应对APP版本升级业务。

## App版本升级业务介绍

### 为什么要做App版本升级

- APP更新迭代快
- APP是安装在用户手机设备上的软件

### APP版本升级的类型

- 用户自主选择安装升级
- 强制用户升级更新

### 如何做

- 开设APP接口
- 服务端APP识别接口做相关判定

## App版本表结构的设计

- id 版本唯一标识id号
- app_type app类型（android还是ios）
- version 内部版本号（也就是我们开发区别的版本号，例如：1、2、3 ...）
- version_code 外部版本号（APP中显示的版本号，例如：1.0.2、1.0.3、1.0.4 ...）
- is_force 是否强制性更新
- apk_url 更新下载路径
- upgrade_point 更新信息介绍
- status 状态
- create_time 发布时间
- update_time 修改时间

## App版本升级接口开发（一）

增加一条版本信息数据

访问接口：http://域名/public/index.php/api/v1/init，同时header中需要传递参数

1、创建接口路由 `qpp/route.php`：

```php
Route::get('api/:ver/init', 'api/:ver.index/init');
```

2、编辑客户端初始化接口，获取最后一天版本内容 `app/api/controller/v1/Index.php`：

```php
	/**
     * 客户端初始化接口
     * 1、检测APP是否需要升级
     */
        public function init() {
        // app_type 去ent_version 查询
        $header = $this->headers;
//        $version = model('Version')->get(['app_type' => $header['app-type']]);
//        halt($version);

        $version = model('Version')->getLastNormalVersionByAppType($header['app-type']);
        if(empty($version)) {
            return new ApiException('error', 404);
        }

        if($version->version > $this->headers['version']) {
			// 是否强制更新
            $version->is_update = $version->is_force == 1 ? 2 : 1;
        }else {
            $version->is_update = 0;  // 0 不更新 ， 1需要更新, 2强制更新
        }
        return show(config('code.success'), 'OK', $version, 200);
    }
```

3、创建model中Version文件，获取数据库中版本内容 `app/common/model/Version.php`：

```php
<?php
namespace app\common\model;
use think\Model;
use app\common\model\Base;
class Version extends Base {
    /**
     * 通过apptype获取最后一条版本内容
     * @param string $appType
     */
    public function getLastNormalVersionByAppType($appType = '') {
        $data = [
            'status' => 1,
            'app_type' => $appType,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->limit(1)->find();
    }
}
```

## 版本升级接口开发（二）

在开发一上进行优化，把更新的设备号，版本号等信息同步到数据库中

创建一个表：更新app信息表

- id 更新id号
- version 版本好
- app_type app型号
- version_code 对外版本号
- did 设备号
- create_time 添加时间
- update_time 更新时间
- status 状态

记录数据的基本信息 在 `app/api/controller/v1/Index.php` 中的 init() 方法增加同步信息：

```php

    /**
     * 客户端初始化接口
     * 1、检测APP是否需要升级
     */
    public function init() {
        // app_type 去ent_version 查询
        $header = $this->headers;
//        $version = model('Version')->get(['app_type' => $header['app-type']]);
//        halt($version);

        $version = model('Version')->getLastNormalVersionByAppType($header['app-type']);
        if(empty($version)) {
            return new ApiException('error', 404);
        }

        if($version->version > $this->headers['version']) {
            $version->is_update = $version->is_force == 1 ? 2 : 1;
        }else {
            $version->is_update = 0;  // 0 不更新 ， 1需要更新, 2强制更新
        }
				
        // 记录用户的基本信息 用于统计
        $actives = [
            'version' => $header['version'],
            'app_type' => $header['app-type'],
            'did' => $header['did'],
        ];
        try {
            model('AppActive')->add($actives);
        }catch (\Exception $e) {
            // todo 初始化的时候没必要暴露，这是我们后台自己需要查询的，可以写入日志
            //Log::write();
//            return new ApiException($e->getMessage(), 404);
        }

        return show(config('code.success'), 'OK', $version, 200);
    }
```

创建增加记录的model，AppActive.php直接继承了Base中的add()方法 `app/common/model/AppActive.php`：

```php
<?php
namespace app\common\model;
use think\Model;
use app\common\model\Base;

class AppActive extends Base {

}
```

返回值：

```json
{
    "status": 1,
    "message": "OK",
    "data": {
        "id": 1,
        "app_type": "android",
        "version": 1,
        "version_code": "1.1.1",
        "is_force": 0,
        "apk_url": "http://www.wenxiaphp.com",
        "upgrade_point": "1，优化了用户体验效果",
        "status": 1,
        "create_time": "1970-01-01 08:00:12",
        "update_time": "1970-01-01 08:00:12",
        "is_update": 0
    }
}
```

## 版本升级联调

- 打开app
- 查看是否有检测更新的文案提示
- 用户自主选择安装升级的话，可以取消也可以更新