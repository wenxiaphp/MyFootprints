#  APP-API基础信息接口开发以及接口文档详解

本章主要讲解了非登录状态下的接口，包括首页、栏目页、详情页、搜索、相关推荐等接口，还教大家如何解决API接口版本方案、如何编写接口文档、如何联调数据，包括postman工具， APP调试(编辑器调试、手机调试)等

服务端 + 客户端 讨论接口返回

服务端接口调试好 -> 接口文档 -> 客户端调 -> 服务端和客户端联调

## 新闻栏目接口开发(上)

- 读取之前设置的栏目分类数据

创建一个栏目类Cat.php `app/api/controller/Cat.pjp`：

```php
<?php
namespace app\api\controller\v1;

use app\api\controller\Common;
use think\Controller;

class Cat extends Common {
	/**
     * 栏目接口
     */
    public function read() {
        $cats = config('cat.lists');
		halt($cats);
    }
}
```


## 新闻栏目接口开发（下）

访问接口：http://域名/index.php/api/cat

1、创建接口路由 `qpp/route.php`：

```php
Route::get('api/cat', 'api/cat/read');
```

2、更新接口信息 `app/api/controller/Cat.php`：

```php
    /**
     * 栏目接口
     */
    public function read() {
        $cats = config('cat.lists');
        //halt($cats);
        $result[] = [
            'catid' => 0,
            'catname' => '首页',
        ];

        foreach($cats as $catid => $catname) {
            $result[] = [
                'catid' => $catid,
                'catname' => $catname,
            ];
        }
        return show(config('code.success'), 'OK', $result, 200);
    }
```

3、如果因为授权sign报错的话：可以开启app_debug，开发阶段设置为true，上线之后改成false

```php
// 应用调试模式
'app_debug' => true,
```

4、然后在 `app/common/lib/IAuth.php` 中的checkSignPass()方法中加层判断:

```php
    public static function checkSignPass($data) {
		······
        if(!config('app_debug')) {
            if ((time() - ceil($arr['time'] / 1000)) > config('app.app_sign_time')) {
                return false;
            }
            //echo Cache::get($data['sign']);exit;
            // 唯一性判定
            if (Cache::get($data['sign'])) {
                return false;
            }
        }
        return true;
    }
```

5、设置返回状态值 `app/extra/code.php`：

```php
    'success' => 1,
    'error' => 0,
```

## api接口版本控制

- 创建一个目录v1（第一个版本），把Cat.php放入v1
- 当需要第二个版本的时候，把v1目录的所有文件复制一份，放入v2中
- 修改命名空间，如果common不在同级目录下的话，则引入

```php
namespace app\api\controller\v1;
use app\api\controller\Common;
```

- 修改路由设置

```php
Route::get('api/:ver/cat', 'api/:ver.cat/read');
```

## api接口文档编写

### 什么是API接口文档

- API的入参、出参的格式

### 为什么要写API接口文档

- 有利于客户端工程师熟悉接口
- 有利于服务端工程师接手项目

### 怎么写API接口文档

- word
- pdf
- wiki 文档管理平台

### 需要包换那些内容

- API接口地址
- 请求方式：get、put、post、delete
- 入参格式
- 出参格式
- http code 状态码

例如：
1、接口地址：api/v1/cat
2、请求方式：get
3、请求参数：header头的基本参数
4、http code：200
5、接口返回
 1、catid：栏目ID
 2、catname：栏目名称

```json
{
    "status": 1,
    "message": "OK",
    "data": [
        {
            "catid": 0,
            "catname": "首页"
        },
        {
            "catid": 1,
            "catname": "综艺"
        },
        {
            "catid": 2,
            "catname": "明星"
        }
    ]
}
```

## App客户端及后台功能联调

### 调试的方式

- android studio
- 手机

### 部署环境

- 设置成客户端可以访问的地址
- 把本地的数据放到线上，给客户端使用
- 客户端配置调试环境进行调试

通过linux命令 `scp [可选参数] file_source file_target `，把文件拷贝到客户端能访问的域名下面

## APP首页接口开发

根据首页图片分析，头部有4-6个模块，下面是详情

1、创建接口类 `app/api/controller/v1/Index.php` 中的index()方法，返回首页中的头部和推荐的新闻列表：

```php
	/**
     * 获取首页接口
     * 1、头图  4-6
     * 2、推荐位列表 默认40条
     */
    public function index() {
        $heads = model('NewsList')->getIndexHeadNormalNews();
        $heads = $this->getDealNews($heads);

        $positions = model('NewsList')->getPositionNormalNews();
        $positions = $this->getDealNews($positions);

        $result = [
            'heads' => $heads,
            'positions' => $positions,
        ];
        return show(config('code.success'), 'OK', $result, 200);
    }
```

2、获取首页头部数据

创建getIndexHeadNormalNews()的方法在 `model/NewsList.php`中：

```php
	/**
     * 获取首页头图数据
     * @param int $num
     * @return array
     */
    public function getIndexHeadNormalNews($num = 4) {
        $data = [
            'status' => 1, // 状态可用
            'is_head_figure' => 1, // 头部展示
        ];
        $order = [ // 排序
            'id' => 'desc',
        ];
        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }
```

3、获取推荐的数据

创建getPositionNormalNews()的方法在 `model/NewsList.php`中：

```php
    /**
     * 获取推荐的数据
     */
    public function getPositionNormalNews($num = 20) {
        $data = [
            'status' => 1,
            'is_position' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }
```

4、添加访问路由 `app/route.php`：

```php
Route::get('api/:ver/index', 'api/:ver.index/index');
```

5、数据返回字段太多，进行过滤字段封装 `app/common/model/NewsList.php`:

- 通用化获取参数的数据字段

```php
    private function _getListField() {
        return [
            'id',
            'catid',
            'image',
            'title',
            'read_count',
            'status',
            'is_position',
            'update_time',
            'create_time'
        ];
    }
```

6、获取处理的新闻的内容数据 `app/api/controller/common.php`：

```php
    protected  function getDealNews($news = []) {
        if(empty($news)) {
            return [];
        }
        $cats = config('cat.lists');
        foreach($news as $key => $new) {
            $news[$key]['catname'] = $cats[$new['catid']] ? $cats[$new['catid']] : '-';
        }
        return $news;
    }
```

7、 访问接口：http://域名/public/index.php/api/v1/index

8、返回值：

```json
{
    "status": 1,
    "message": "OK",
    "data": {
        "heads": [
            {
                "id": 10,
                "catid": 1,
                "image": "/thinkphp/public/upload/20180925/52a096811efd6e11a4d4966df89f86bb.png",
                "title": "y",
                "read_count": 0,
                "status": 1,
                "is_position": 1,
                "update_time": "2018-09-30 16:26:53",
                "create_time": "2018-09-25 16:36:48",
                "catname": "综艺"
            }
        ],
        "positions": [
            {
                "id": 11,
                "catid": 1,
                "image": "",
                "title": "u",
                "read_count": 0,
                "status": 1,
                "is_position": 1,
                "update_time": "2018-09-26 18:31:14",
                "create_time": "2018-09-25 16:37:55",
                "catname": "综艺"
            }
        ]
    }
}
```

## App列表页面接口开发

1、创建接口类 `app/api/controller/v1/News.php` 中的index()方法，返回首页中切换头部返回的列表信息：

```php
    public function index() {
        // 小伙伴仿照我们之前讲解的validate验证机制 去做相关校验
        $data = input('get.');

        $whereData['status'] = config('code.status_normal'); 
		$whereData['catid'] = input('get.catid');

        $this->getPageAndSize($data);
		// 获取列表的数据的总数
        $total = model('NewsList')->getNewsCountByCondition($whereData);
        $news = model('NewsList')->getNewsByCondition($whereData, $this->from, $this->size);

        $result = [
            'total' => $total,
            'page_num' => ceil($total / $this->size),
            'list' => $this->getDealNews($news),
        ];

        return show(config('code.success'), 'OK', $result, 200);
    }
```

2、根据条件来获取列表的数据的总数 `app/model/NewsList.php`：

```php
    /**
     * 根据条件来获取列表的数据的总数
     * @param array $param
     */
    public function getNewsCountByCondition($condition = []) {
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }
        return $this->where($condition)
            ->count();
    }
```

3 、根据来获取列表的数据`app/common/model/NewsList.php`：

```php
    public function getNewsByCondition($condition = [], $from=0, $size = 5) {
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }

        $order = ['id' => 'desc'];

        $result = $this->where($condition)
            ->field($this->_getListField())
            ->limit($from, $size)
            ->order($order)
            ->select();
        return $result;
    }
```

4、添加访问路由`app/route.php`：

```php
// news
Route::resource('api/:ver/news', 'api/:ver.news');
```

7、 接口信息：

- API接口地址 `http://域名/public/index.php/api/v1/news?catid=1&size=1&page=3`
- 请求方式：get
- 入参格式 
	- catid 栏目id值
	- size 每一页的几条数据 默认是系统配置的默认值15
	- page 查看第几页 默认值为第1页
- 出参格式 json
- http code 状态码 1

8、返回值：

```json
{
    "status": 1,
    "message": "OK",
    "data": {
        "total": 7, // 总条数
        "page_num": 7, // 总页数
        "list": [ // 数据
            {
                "id": 11,
                "catid": 1,
                "image": "",
                "title": "u",
                "read_count": 0,
                "status": 1,
                "is_position": 1,
                "update_time": "2018-09-26 18:31:14",
                "create_time": "2018-09-25 16:37:55",
                "catname": "综艺"
            }
        ]
    }
}
```

## 新闻搜索功能接口开发

在app/api/controller/v1/New.php中index()增加搜索条件：

```php
   public function index() {
           // 小伙伴仿照我们之前讲解的validate验证机制 去做相关校验
           $data = input('get.');
   
           $whereData['status'] = config('code.status_normal');
           if(!empty($data['catid'])) {
               $whereData['catid'] = input('get.catid', 0, 'intval');
           }
           if(!empty($data['title'])) {
               $whereData['title'] = ['like', '%'.$data['title'].'%'];
           }
           ······
       } 
```

接口信息和返回值同上，入参参数加一个：

- title 要搜索的信息

## 新闻排行接口开发

1、创建接口类 `app/api/controller/v1/Rank.php` 中的index()方法，返回排行榜数据列表信息：

```php
    /**
     * 获取排行榜数据列表
     * 1、获取数据库 然 read_count排序  5 - 10
     * 2、优化 redis
     */
    public function index() {
        try {
            $rands = model('NewsList')->getRankNormalNews();
            $rands = $this->getDealNews($rands);
        }catch (\Exception $e) {
            return new ApiException('error', 400);
        }

        return show(config('code.success'), 'OK', $rands, 200);
    }
```

2 、获取排行榜数据 `app/common/model/NewsList.php`：

```php
    /**
     * 获取排行榜数据
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRankNormalNews($num = 5) {
        $data = [
            'status' => 1,
        ];
        $order = [
            'read_count' => 'desc',
        ];
        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }
```

3、添加排序接口路由 `app/route.php`：

```php
//排行
Route::get('api/:ver/rank', 'api/:ver.rank/index');
```

4、 接口信息：

- API接口地址 `http://域名/public/index.php/api/v1/ranks`
- 请求方式：get
- 出参格式 json

5、返回值：

```json
{
    "status": 1,
    "message": "OK",
    "data": {
        "total": 7, // 总条数
        "page_num": 7, // 总页数
        "list": [ // 数据
            {
                "id": 11,
                "catid": 1,
                "image": "",
                "title": "u",
                "read_count": 0,
                "status": 1,
                "is_position": 1,
                "update_time": "2018-09-26 18:31:14",
                "create_time": "2018-09-25 16:37:55",
                "catname": "综艺"
            }
        ]
    }
}
```

## 新闻详情页面接口开发

添加 `app/api/controller/v1/News.php` 中的read()方法，返回获取详情接口信息：

```php
	/**
     * 获取详情接口
     */
    public function read() {
        // 详情页面 APP -》 1、x.com/3.html  2、 接口

        $id = input('param.id', 0, 'intval');
        if(empty($id)) {
            return new ApiException('id is not ', 404);
        }

        // 通过id 去获取数据表里面的数据
		try {
			$news = model('NewsList')->get($id);
		}catch(\Exception $e) {
			return new ApiException('error', 400);
		}
		//判断内容是否存在
        if(empty($news) || $news->status != config('code.status_normal')) {
            return new ApiException('不存在该新闻', 404);
        }
		// tp5自带方法setInc()自增或自减一个字段的值
        try {
            model('NewsList')->where(['id' => $id])->setInc('read_count');
        }catch(\Exception $e) {
            return new ApiException('error', 400);
        }

		// 栏目名称转换
        $cats = config('cat.lists');
        $news->catname = $cats[$news->catid];
		
        return show(config('code.success'), 'OK', $news, 200);
    }
```

2、 接口信息：

- API接口地址 `http://域名/public/index.php/api/v1/news/10`
- 请求方式：get
- 出参格式 json

3、返回值：

```json
{
    "status": 1,
    "message": "OK",
    "data": {
        "id": 10,
        "title": "y",
        "small_title": "y",
        "catid": 1,
        "image": "/thinkphp/public/upload/20180925/52a096811efd6e11a4d4966df89f86bb.png",
        "content": "<p>yyyyttt</p>",
        "description": "yyy",
        "is_position": 1,
        "is_head_figure": 1,
        "is_allowcomments": 1,
        "listorder": 0,
        "source_type": 0,
        "create_time": "2018-09-25 16:36:48",
        "update_time": "2018-09-30 16:26:53",
        "status": 1,
        "read_count": 0,
        "catname": "综艺"
    }
}
```

## 本章功能整体调试

### 调试方式

- 手机调试
- 通过内容中串查图片的时候，如果图片在手机端无法展示，可以修改里面的图片路径

设置图片路径需要的域名连接，定义为常量 `public/static/hadmin/lib/ueditor/1.4.3/php/controller.php`：

```php
define('DOMAIN', 'http://imooc.app.singwa.com');
```

图片使用常量不全图片的路径 `public/static/hadmin/lib/ueditor/1.4.3/php/Uploader.class.php`：

```php
	/**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo()
    {
        return array(
            "state" => $this->stateInfo,
            "url" => DOMAIN.$this->fullName,
            "title" => $this->fileName,
            "original" => $this->oriName,
            "type" => $this->fileType,
            "size" => $this->fileSize
        );
    }

```


