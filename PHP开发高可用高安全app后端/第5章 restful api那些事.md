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
use think\Controller;
class Test extends Controller {
	
	//get 测试上面设置的路由  接口：http://域名/test（或者：http://域名/index.php/test）
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

### TP5 json方法的使用

测试tp5自带json()格式（app/controller/test.php）：

```php
	//post 新增 接口：http://域名/test
	public function save() {
		$data = input('post.');
		// 获取到提交数据 插入库，
		// 给客户端APP  =》 接口数据
		$data = [
			'status' => 1,
			'message' => 'OK',
			'data' => $data,
		];

		return json($data, 201);
	}
```

### 封装

1、设置api数据输出格式（app/common.php）：

```php
	/**
	 * 通用化API接口数据输出
	 * @param int $status 业务状态码
	 * @param string $message 信息提示
	 * @param [] $data  数据
	 * @param int $httpCode http状态码
	 * @return array
	 */
	function show($status, $message, $data=[], $httpCode=200) {

		$data = [
			'status' => $status,
			'message' => $message,
			'data' => $data,
		];

		return json($data, $httpCode);
	}
```

2、测试数据输出格式（app/controller/test.php）:

```php
	//post 新增 接口：http://域名/test
    public function save() {
        $data = input('post.');

        // 获取到提交数据 插入库，
        // 给客户端APP  =》 接口数据
        return show(1, 'OK', data, 201); 
    }
```

## 不可预知的内部异常api数据输出解决方案(一)

1、创建一个错误处理类（app/common/lib/exception/ApiHandleException.php）:

```php
<?php
namespace app\common\lib\exception;
use think\exception\Handle;

class ApiHandleException extends  Handle {

    /**
     * http 状态码
     * @var int
     */
    public $httpCode = 400;

	// 继承Handle 重写tp5中自带的render()方法
    public function render(\Exception $e) {
        return  show(0, $e->getMessage(), [], $this->httpCode);
    }
}
```

2、同时需要修改配置文件中的错误处理路径（app/config.php）:

```php
// 异常处理handle类 留空使用 \think\exception\Handle
//    'exception_handle'       => '', // 注释掉，处理异常走自己定义的
'exception_handle' => "\app\common\lib\exception\ApiHandleException" // 自己定义异常路径
```

3、测试接口（app/controller/test.php）：

```php
	//post 新增 接口：http://域名/test
    public function save() {
        if($data['ids']){
			echo 1;exit;
		}

        // 获取到提交数据 插入库，
        // 给客户端APP  =》 接口数据
        return show(1, 'OK', input('post.'), 201); 
    }
	// 返回结果报错
	{
		"status":0,
		'message':"undefined varlable:data",
		'data':[]
	}
```

## 不可预知的内部异常api数据输出解决方案（二）

创建一个内部错误码类（app/common/lib/exception/ApiException.php）:

```php
<?php
namespace app\common\lib\exception;
use think\Exception;

class ApiException extends Exception {

    public $message = '';
    public $httpCode = 500;
    public $code = 0;
    /**
     * @param string $message
     * @param int $httpCode
     * @param int $code
     */
    public function __construct($message = '', $httpCode = 0, $code = 0) {
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
    }
}
```

更新返回状态码（app/common/lib/exception/ApiHandleException.php）:

```php
<?php
namespace app\common\lib\exception;
use think\exception\Handle;

class ApiHandleException extends  Handle {

    /**
     * http 状态码
     * @var int
     */
    public $httpCode = 500;

	// 继承Handle 重写tp5中自带的render()方法
    public function render(\Exception $e) {
		// 服务端 开启调试状态，上线后需要改成false 查看错误信息
		if(config('app_debug') == true) {
			return parent::render($e);
		} 
		// 客户端 展示的错误信息 检测状态码是否异常
        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }
        return  show(0, $e->getMessage(), [], $this->httpCode);
    } 
}
```

测试自定义异常端口状态码，访问接口： http://域名/test

```php
	use app\common\lib\exception\ApiException;

	//post 新增 接口：http://域名/test
    public function save() {
		$data = input('post.');

		if($data['mt'] != 1){
			throw new ApiException("您提交的数据不合法",403);
		}
        // 获取到提交数据 插入库，
        // 给客户端APP  =》 接口数据
        return show(1, 'OK', $data, 201); 
    }
```






