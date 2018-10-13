# API数据安全解决方案

安全问题现在越来越多的受到大家的关注，如何对数据进行保密？如何进行数据传输更安全？本章会教大家APP-API数据安全解决方案，并从多个维度进行讲解。如：加密算法之aes引入，授权码sign算法，token唯一性支持；API一次性请求支持，APP本地时间和服务器时间一致性完美解决方案等。让大家对安全有一个新的认识！

## APP-API数据安全介绍

### 背景

- 接口请求地址和参数暴露
- 重要接口返回数据明文暴露
- app登录态请求的数据完全性问题
- 代码层的数据完全问题

### 解决方式

- 加密

### 加密方式

- MD5 （常用）
- AES（对称、高权级别高、下一代加密标准）
- RSA （非对称、效果差、适用于小数据加密）

### 如何做

- 基本参数放入header
- 每次http请求都携带sign
- sign唯一性保证
- 请求参数、返回数据按安全性适当加密
- access_token

## API接口数据安全解决方案之开篇

headers 包含信息：

- Content-type   application/x-www-form-urlencoded
- sign  加密字符串
- version 版本号
- app_type 类型（android、 android pad、...）
- did  移动端设备号
- model  app机器（手机机型：sanxing5.6）

创建一个公共的控制器（app/api/controller/Common.php）:

```php
<?php
namespace app\api\controller;
use think\Controller;

class Common extends Controller {
	
	/**
	 * 初始化的方法
	 */
	public function _initialize(){
		$this->checkRequestAuth();
	}
	
	/**
	 * 检查每次app请求的数据是否合法
	 */
	public function checkRequestAuth(){
		// 首先获取headers (thin/Request.php中的header())
		$headers = request()->header();
		halt($headers);
	}
}
```

测试：把Test.php控制器中继承的controller改成继承Common

```php
class Test extends Common {	
}
// headers 中传递参数
// 运行接口：http://域名/index.php/test  
// 返回结果：
array(9) {
  ["connection"] => string(10) "keep-alive"
  ["accept-encoding"] => string(13) "gzip, deflate"
  ["host"] => string(17) "www.wenxiaphp.com"
  ["accept"] => string(3) "*/*"
  ["user-agent"] => string(20) "PostmanRuntime/6.4.1"
  ["sign"] => string(19) "1234574dfdaasdfadfa"
  ["postman-token"] => string(36) "548defeb-a9f8-46c3-a0c4-45db8fb71a80"
  ["cache-control"] => string(8) "no-cache"
  ["content-type"] => string(33) "application/x-www-form-urlencoded"
}
```


## API接口数据安全解决方案之授权码sign解剖

- aes加密解密算法的使用
- sign算法生成

1、导入Aes.php（app/common/lib/Aes.php）

```php
<?php
namespace app\common\lib;

/**
 * aes 加密 解密类库
 * @by singwa
 * Class Aes
 * @package app\common\lib
 */
class Aes {
    private $key = null;
    /**
     * @param $key 		密钥
     * @return String
     */
    public function __construct() {
        // 需要小伙伴在配置文件app.php中定义aeskey
        $this->key = config('app.aeskey');
    }

    /**
     * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
     * @return HexString
     */
    public function encrypt($input = '') {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->key, $iv);

        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);

        return $data;

    }
    /**
     * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
     * @return String
     */
    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public function decrypt($sStr) {
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->key,base64_decode($sStr), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);

        return $decrypted;
    }
}
```

2、添加aes 密钥，服务端和客户端必须保持一致（app/extra/app.php）：

```php
//只支持长度为16、24或32的键  在Aes.php中用到的
'aeskey' => 'sgg45747ss223455',//aes 密钥 , 服务端和客户端必须保持一致 
```

3、测试加密方式（app/api/controller/Common.php）:

```php
use app\common\lib\Aes;
	
	/**
	 * 初始化的方法
	 */
	public function _initialize(){
		//$this->checkRequestAuth();
		$this->testAes();
	}
    public function testAes() {
		// 测试加密
		$str = "id=1&ms=12&username=wenxia";
		$res = (new Aes())->encrypt($str);
		echo $res;exit;
			
		// 测试解密
		$res = 'JhKK2mvdPNDTmRVEtxKtX/wtIqaIgoYYHrwRGrbFhg0=';
        echo (new Aes())->decrypt($res);exit;
    }
```

4、生成每次请求的sign（app/common/lib/IAuth.php）:

```php
// 使用到Aes 需要引入
use app\common\lib\Aes;
    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data = []) {
        // 1 按字段排序
        ksort($data);
        // 2拼接字符串数据  &
        $string = http_build_query($data);
        // 3通过aes来加密,引入use app\common\lib\Aes;
        $string = (new Aes())->encrypt($string);
        return $string;
    }
```

5、测试加密方式（app/api/controller/Common.php）:

```php
// 使用到IAuth 需要引入
use app\common\lib\IAuth;
	
	/**
	 * 初始化的方法
	 */
	public function _initialize(){
		//$this->checkRequestAuth();
		$this->testAes();
	}
    public function testAes() {
		$data = [
			'did' => '12345dg',
			'version' => 1,
		];
		// 加密
		$res = IAuth::setSign($data);
		echo $res ;exit;
		
		// 解密
		echo (new Aes())->decrypt($res);exit;
    }
```

## API接口数据安全解决方案之sign检验

1、修改配置(app/config.php)：

```php
app_debug => false;
```

2、设置手机配型app_type（app/extra/app.php）：

```php
    'apptypes' => [
        'ios',
        'android',
    ],
```

3、验证sign值是否存在（api/controller/Common.php）：

```php
	// 使用ApiException ，需引入
	use app\common\lib\exception\ApiException;
	public $headers = '';
    /**
     * 检查每次app请求的数据是否合法
     */
    public function checkRequestAuth(){
        // 首先获取headers (thin/Request.php中的header())
        $headers = request()->header();
         //halt($headers);

        // sign 加密需要客户端工程师完成，解密需要服务端工程师完成

        // 基础参数校验
        if(empty($headers['sign'])){
            throw new ApiException("sign不存在",400);
        }
		// 我测试header不支持下划线，app_type
		if(!in_array($headers['app_type'],config("app.apptypes"))){
            throw new ApiException("类型不合法",403);
        }
		
		// 需要检验sign 的合法性
		if(!IAuth::checkSignPass($headers)){
			throw new ApiException("授权码sign失败",401);
		}
		$this->headers = $headers;
    }
```

4、封装检查sign是否正常的方法到IAuth.php（app/common/lib/IAuth.php）：

```php
	**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {
		// 解密是空
        $str = (new Aes())->decrypt($data['sign']);
        if(empty($str)) {
            return false;
        }

        // diid=xx&app_type=3
		// 把字符串转换成数组
        parse_str($str, $arr);
        if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']) {
            return false;
        }
        return true;
    }
```

## API接口数据安全解决方案之sign有效时间处理

1、创建一个时间类（app/common/lib/Time.php）：

```php
<?php
namespace app\common\lib;

/**
 * 时间
 * Class IAuth
 */
class Time {
    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13TimeStamp() {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }
}
```

2、引入时间，获取sign值（api/controller/Common.php）：

```php
use app\common\lib\Time;
public function testAes() {
	// 增加一个时间显示
	$data = [
		'did' => '12345dg',
		'version' => 1,
		'time' => Time::get13TimeStamp(),
	];

	// header中sign值：col9j6cqegAKiiey3IrXWo2zCRGHw8vogniwQZab0fgIVnKDb7Rin03dOqY2qLWP
	echo IAuth::setSign($data);exit;
}
```

3、增加checkSignPass()方法中时间校验sign值是否正常（app/common/lib/IAuth.php）：

```php
    /**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {
        $str = (new Aes())->decrypt($data['sign']);

        if(empty($str)) {
            return false;
        }

        // diid=xx&app_type=3
        parse_str($str, $arr);
        if(!is_array($arr) || empty($arr['did'])
            || $arr['did'] != $data['did']
        ) {
            return false;
        }
		// 判断时间
        if ((time() - ceil($arr['time'] / 1000)) > config('app.app_sign_time')) {
        	return false;
        }
        return true;
    }
```

4、设置sign失效时间配置（app/extra/app.php）：

```php
 'app_sign_time' => 10,// sign失效时间 验证sign时使用 checkSignPass
```

5、获取校验结果返回值（app/api/controller/Common.php）：

```php
 /**
 * 检查每次app请求的数据是否合法
 */
public function checkRequestAuth() {
	// 首先需要获取headers
	$headers = request()->header();
	// 基础参数校验
	if(empty($headers['sign'])) {
		throw new ApiException('sign不存在', 400);
	}
	if(!in_array($headers['app_type'], config('app.apptypes'))) {
		throw new ApiException('app_type不合法', 400);
	}

	// 需要sign
	if(!IAuth::checkSignPass($headers)) {
		throw new ApiException('授权码sign失败', 401);
	}

	// 1、文件  2、mysql 3、redis
	$this->headers = $headers;
}
```

## API接口数据安全解决方案之授权sign唯一性支持

1、判断sign的唯一性三种方式：文件、mysql、redis

```php
use think\Cache;

 /**
 * 检查每次app请求的数据是否合法
 */
public function checkRequestAuth() {
	// 首先需要获取headers
	$headers = request()->header();
	// 基础参数校验
	if(empty($headers['sign'])) {
		throw new ApiException('sign不存在', 400);
	}
	if(!in_array($headers['app_type'], config('app.apptypes'))) {
		throw new ApiException('app_type不合法', 400);
	}

	// 需要sign
	if(!IAuth::checkSignPass($headers)) {
		throw new ApiException('授权码sign失败', 401);
	}
	
	Cache::set($headers['sign'], 1, config('app.app_sign_cache_time'));

	// 1、文件  2、mysql 3、redis
	$this->headers = $headers;
}
```

2、配置缓存失效时间（app/extra/app.php）：

```php
//（失效时间《 缓存失效时间）
 'app_sign_cache_time' => 20,// sign 缓存失效时间  查看是否缓存过期使用 checkRequestAuth
```

3、唯一性判定（app/api/controller/Common.php）：

```php
use think\Cache;

	**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {
		// 解密是空
        $str = (new Aes())->decrypt($data['sign']);
        if(empty($str)) {
            return false;
        }

        // diid=xx&app_type=3
		// 把字符串转换成数组
        parse_str($str, $arr);
        if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']) {
            return false;
        }
        if(!config('app_debug')) {
			// 先判断失效时间
            if ((time() - ceil($arr['time'] / 1000)) > config('app.app_sign_time')) {
                return false;
            }
			// 查看是否存入缓存
            //echo Cache::get($data['sign']);exit;
            // 唯一性判定
            if (Cache::get($data['sign'])) {
                return false;
            }
        }
        return true;
    }
```

4、返回给客户端加密之后的数据（test.php）：

```php
    /**
     * post 新增
     * @return mixed
     */
    public function save() {
        $data = input('post.');

        // 获取到提交数据 插入库， encrypt()参数是字符串，所以json转成字符串
        // 给客户端APP  =》 接口数据 
        return show(1, 'OK', (new Aes())->encrypt(json_encode(input('post.'))), 201); 
    }
```

## APP和服务器端时间一致性解决方案

### 背景

- app 时间和服务器时间不一致

### 解决方案

- 获取服务器端时间
- 判断客户端和服务器端时间差进行补齐

创建一个类获取服务器当前时间，返回给客户端（app/controller/Time.php）：

```php
<?php
namespace app\api\controller;
use think\Controller;

class Time extends Controller {
    public function index() {
        return show(1, 'OK', time());
    }
}
```

