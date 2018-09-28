# restful api那些事

## restful api简介

### 传统 api

- 获取用户信息 get /api/user/read
- 更新用户信息 post /api/user/updata
- 新增用户信息 post /api/user/add
- 删除用户信息 post /api/user/delete

### restful api

- 获取用户信息 get /api/user/1
- 更新用户信息 put /api/user/1
- 新增用户信息 post /api/user
- 删除用户信息 delete /api/user/1

[注意] 1指的是id为1的数据信息

### HTTP 状态码

- 200 请求成功 （例如：查询）
- 201 创建成功 （例如：添加）
- 202 更新成功 （例如：修改、删除）
- 400 无效请求 （例如：接口不正确，找不到访问的方法）
- 401 地址不存在
- 403 禁止访问
- 404 请求资源不存在
- 500 内部错误

### API数据结构格式

- status 业余状态码
- message 提示信息
- data 数据层

## 如何使用restful

[参考链接](https://www.kancloud.cn/manual/thinkphp5/118035)

TP5使用方式：

- Route::get
- Route::post
- Route::put
- Route::delete
- Route::resource

| 标识 | 请求类型 | 生成路由规则 | 对应操作方法（默认）|
|---:|---:|---:|---:|
| index  | GET | blog | index |
| create | GET | blog/create | create |
| save | POST | blog | save |
| read | GET | blog/:id | read |
| edit | GET | blog/:id/edit | edit |
| update | PUT | blog/:id | update |
| delete | DELETE | blog/:id | delete |

1、设置返回数据格式（app/api/config.php）：

```php
return [
    'default_return_type' => 'json',
];
```

2、设置路由（app/route.php）:

```php
use think\Route;
//get
Route::get('test', 'api/test/index');
Route::put('test/:id', 'api/test/update');// 修改
// x.com/test  post  => api test save
Route::resource('test', 'api/test');
```

3、创建test控制器，测试路由（app/api/test.php）：

```php
<?php
namespace app\api\controller;
class Test extends Controller {
	
	//get 测试上面设置的路由  接口：http://域名/test
	public function index() {
		return [
			'sgsg',
			'sgsgs',
		];
	}
	
	//put  修改 接口：http://域名/test/100
	public function update($id = 0) {
		//echo $id;exit;
		// 选择 x-www-form-urlencoded 可以传参数
		halt(input('put.'));
		//return $id;
		//id   data
	}

	//post 新增 接口：http://域名/test
	public function save() {
		return input('post.');
	}
}
```

## 通用化API接口数据封装






## 不可预知的内部异常api数据输出解决方案(一)


## 不可预知的内部异常api数据输出解决方案（二）



