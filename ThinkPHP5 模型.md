# 数据库

## 数据库连接

#### 数据库连接的四种方式

1、使用配置文件config.php进行配置
在控制器中使用Db类下的connect方法连接（别忘了：use think\Db;）
```php
$res = Db::connect();
dump($res);
```
2、使用在控制器中的要连接数据库的方法中，进行数组配置数据库
```php
// 在module里面直接使用，说明当前使用传递一个数组的方式来对当前的连接进行配置
$res = Db::connect([
   'type'            => 'mysql',
   'hostname'        => '127.0.0.1',
   'database'        => 'course',
   'username'        => 'root',
   'password'        => 'ddd',
   'hostport'        => '3306',
   'charset'         => 'utf8',
   'prefix'          => ''
]);
```
3、使用DNS方式进行配置
格式：`数据库类型://用户名:密码@数据库地址:数据库端口/数据库名#字符编码`
```php
// 可以使用DSN配置，直接传递字符串给Db::connect()：
$res = Db::connect("mysql://root:password@127.0.0.1:3306/course#utf8");
dump($res);
```
4、使用Config类中的get方式进行配置
注意：要先引入Config类（use think\Config;）
```php
$res = Db::connect(Config::get('db_config01'));
dump($res);
```

#### 数据库的查询操作

1、通过sql语句查询
```php
//添加一天记录
// $res = Db::query('insert into tp_user set username=?,password=?,email=? ',['mengwenxia',md5('meng'),'12334@qq.com']);
//查询一条记录
$res = Db::query('select * from tp_user where id=?',[1]);
dump($res);
```
2、通过select()函数查询：查询全部的记录
如果查询某条记录可以使用where()进行条件判断，它返回所有的记录，结果是一个二维数组；如果所查询的结果不存在，则返回一个空数组
```php
//选择数据表，返回所有的记录，结果是一个二维数组
//如果结果不存在返回一个空数组
$res = Db::table('tp_user')->where("id=1")->select();
dump($res);
```
##### 获取数据表的三种方式（后两种要配置表前缀）
- table()
```php
// 使用table()获取表
$res = Db::table('tp_user')->select();
dump($res);
```
- name()

注意：使用配置文件中设置的表前缀：`'prefix'=>'tp_'`
```php
// 使用配置中的表前缀 'prefix'=>'tp_', 获取表（前提是表前缀要做配置中进行设置）
$res = Db::name("user")->select();
dump($res);
```
- db()
Db类：是一个单例模式，不需要再每次使用时进行实例化
db助手函数：它会在每次调用的时候进行实例化，如果不想每次进行实例化，需要传递第三个参数“false”，就不会每次调用的时候进行实例化了

注意：使用配置文件中设置的表前缀：`'prefix'=>'tp_'`
```php
$res = db('user',[],false)->select();
dump($res);
```
3、通过find()函数查询：查询一条记录
返回一条记录，返回的结果是一个一维数组，如果结果不存在返回null
```php
// $find = Db::table("tp_user")->find();
$find = Db::table("tp_user")->where('id=100')->find();
dump($find);
```
4、通过value()函数查询：查询数据表中的某个字段的值
返回一条记录，并且是这条记录中要查询的字段的值；如果查询条件不存在，返回空NULL
```php
// $res = Db::table("tp_user")->value('username');
$res = Db::table("tp_user")->where("id=20")->value('username');
dump($res);
```
5、通过column()函数查询：查询记录中的某字段的全部值
返回一个一维数组，数组中的value值是我们要获取的列的值；如果存在第二个参数，就返回这个数组并且用第二个参数的值作为键值，第一个参数作为值；如果结果不存在，返回空数组
```php
// $res = Db::table("tp_user")->column('email','username');
$res = Db::table("tp_user")->where('id=10')->column('email','username');
dump($res);
```

#### 数据表添加记录

1、使用sql语句插入
```php
$res = Db::query('insert into tp_user set username=?,password=?,email=? ',['张三',md5('zhangsan'),'zhangsan123@qq.com']);
dump($res);
```
2、使用insert()函数
返回值是影响记录的行数，也是插入数
```php
$res = $db->insert([
    'email'=>'zhangsan@qq.com',
    'username' => '张三',
    'password' => MD5('zhangsan')
]);
dump($res);
//返回结果：int(1)
```
3、使用insertGetId()函数
通过这个方式添加记录，返回插入数据的自增id号
```php
$res = $db->insertGetId([
   'email'=>'meng001@qq.com',
   'username' => 'meng001',
   'password' => MD5('meng001')
]);
dump($res);
// 返回数据：string(10)
```
4、使用insertAll()函数
可以插入多条数据，返回值是插入数据成功的条数/行数
```php
$data = [];
for ($i=10;$i<20;$i++){
    $data[] = [
        'username' => "meng_{$i}",
        'password' => md5("meng_{$i}"),
        'email' => "meng_{$i}@qq.com"
    ];
}
$res = $db->insertAll($data);
dump($res);
//返回数据：int(10)
```

#### 数据更新

1、updata()：更新数据，如果不加where条件，会报错（如果想改变某字段的全部值，可以把条件设置为true的条件）
返回的结果是影响数据的行数
```php
$db = Db::name('user');
$res = $db->where([
    'id' => '1'
])->update([
    'username' => 'wenxia',
    'email' => '12771258@qq.com'
]);
dump($res);
// 返回结果：int(1)
```
2、setField()：每次只更新一个字段
返回结果是影响数据的行数
```php
$db = Db::name('user');
$res = $db->where([
    'id'=>'3'
])->setField('username','17771258');
dump($res);
// 返回结果：int(1)
```
3、setInc()：自增
只传递一个参数（数据表中的某个字段名）时，该字段每次自增1；第二个参数是自增的量，如果是5，就是每次执行自增5
返回的结果是影响数据的行数
```php
$db = Db::name('user');
$res = $db->where([
    'id' => '4'
])->setInc('num',5);
dump($res);
// 返回结果：int(1)
```
4、setDec()：自减
只传递一个参数（数据表中的某个字段名）时，该字段每次自减1；第二个参数是自减的量，如果是5，就是每次执行自减5
返回的结果是影响数据的行数
```php
$db = Db::name('user');
$res = $db->where([
    'id' => '4'
])->setDec('num',2);
dump($res);
// 返回结果：int(1)
```

#### 数据删除操作

delete()：删除函数
返回值是影响数据的条数
```php
$db = Db::name('user');
// 删除指定的某字段对应的值
// $res = $db->where([
//     'id' => '1'
// ])->delete();
// 返回数据：int(1)
// 如果要删除的是主键，可以把要删除的值写在delete()函数里面
// $res = $db->delete('2');
// 返回数据：int(1)
// 如果想删除全部，可以把条件where设置为true的条件
$res = $db->where('1=1')->delete();
dump($res);
//返回：int(28)
```
#### 条件构造器

where() 函数
用法：
1、直接传字符串表达式
```php
$res = $db->where("id=1")->buildSql
dump($res);
```
2、把条件封装成数组
```php
// $res = $db->where([
//    'id' => 1
// ])->buildSql();
// $res = $db->where([
//    'id' => ['egt',5]
// ])->buildSql();
$res = $db->where([
   'id' => ['in',[1,2,4,5,6]],
   'username' => 'meng'
])->buildSql();
dump($res);
```
3、使用多个字符串的方式
```php
$res = $db->where("id","1")->buildSql();
dump($res);
```
4、使用传参方式（备注：参数信息，表达式，不区分大小写）
表达式信息
| 第二个参数 | 解析之后 | 第三个参数 | 说明 | 例子|   返回结果  |
| ------ | ------- | ------- | ---- | ----- | --- |
| EQ   | = | '1' | 等于    | $res = $db->where("id","eq","1")->buildSql();dump($res); | SELECT * FROM `tp_user` WHERE  `id` = 1    |
| NEQ  | <>  | '1' | 不等于 |  $res = $db->where("id","NEQ","1")->buildSql();dump($res);   |  SELECT * FROM `tp_user` WHERE  `id` <> 1    |
| LT | < | '5' | 小于 | $res = $db->where("id","LT","5")->buildSql();dump($res);    |   SELECT * FROM `tp_user` WHERE  `id` < 5   |
| ELT | <=  | '5' | 小于等于 | $res = $db->where("id","ELT","5")->buildSql();dump($res);|  SELECT * FROM `tp_user` WHERE  `id` <= 5    |
| GT | > | '5'   | 大于 | $res = $db->where("id","GT","5")->buildSql();dump($res);  |  SELECT * FROM `tp_user` WHERE  `id` > 5   |
| EGT | >=  | '5'| 大于等于 | $res = $db->where("id","EGT","5")->buildSql();dump($res); |  SELECT * FROM `tp_user` WHERE  `id` >= 5    |
| BETWEEN | BETWEEN a AND b| '1,10'或者[1,10] | 在a和b之间（包含a和b） | $res = $db->where("id","between","1,10")->buildSql();dump($res);  |  SELECT * FROM `tp_user` WHERE  `id` BETWEEN 1 AND 10   |
| NOTBETWEEN | NOTBETWEEN * AND * | '1,10'或者[1,10]| 不在a和b之间 | $res = $db->where("id","NOTBETWEEN","1,10")->buildSql();dump($res);  |  SELECT * FROM `tp_user` WHERE  `id` NOT BETWEEN 1 AND 10   |
| IN  | IN(*,*,*)| '1,2,3,4'或者[1,2,3,4] | 在这些值里面  |$res = $db->where("id","IN",[1,2,3])->buildSql();dump($res); |   SELECT * FROM `tp_user` WHERE  `id` IN (1,2,3)    |
| NOTIN | NOT IN (*,*,*) | '1,2,3,4'或者[1,2,3,4] | 不在这些值里面|$res = $db->where("id","notin",[1,2,3,4])->buildSql();dump($res); |  SELECT * FROM `tp_user` WHERE  `id` NOT IN (1,2,3,4)   |
| EXP | 空  | not in [1,2,3,4,5] | 条件表达式，可以用正则 |$res = $db->where("id","EXP","not in [1,2,3,4,5,6]")->buildSql();dump($res); |  SELECT * FROM `tp_user` WHERE  ( `id` not in [1,2,3,4,5,6] )   |
```php
// $res = $db->where("id","eq","1")->buildSql();
// $res = $db->where("id","egt","1")->buildSql();
// $res = $db->where("id","between","1,5")->buildSql();
// $res = $db->where("id","notbetween",[1,10])->buildSql();
// $res = $db->where("id","in",[1,2,3,4])->buildSql();
// $res = $db->where("id","notin",[1,2,3,4])->buildSql();
//exp 条件表达式
$res = $db->where("id","EXP","not in [1,2,3,4,5,6]")->buildSql();
dump($res);
```
条件查询之and和or（并且和或）连接关系查询
```php
//条件之间 and 连接
$res = $db
   ->where("id","in",[1,2,3])
   ->where('username','meng')
   ->buildSql();
dump($res);
// 返回结果：SELECT * FROM `tp_user` WHERE  `id` IN (1,2,3)  AND `username` = 'meng'

//条件之间 or 连接
$res = $db
   ->where("id","in",[1,2,3])
   ->whereor('username','meng')
   ->buildSql();
dump($res);
// 返回结果：SELECT * FROM `tp_user` WHERE  `id` IN (1,2,3) OR `username` = 'meng'
```

#### 链式操作

以例子说明
注意：当group()存在的时候，order()、limit()、page()不起作用
```php
$res = Db::table('tp_user')
//查询条件
    ->where("id",">",10)
//过滤字段
    ->field("id,username,email,group")
//排序条件
//  ->order('id DESC')
// 查询条数条件,从第三条数据开始选，选5条
//  ->limit(3,5)
// 页数page(参数1，参数2)：参数1：表示第几页，参数2：表示每页多少条
//  ->page(2,5)
//当group()存在的时候，order()、limit()、page()不起作用
    ->group('group')
    ->select();
dump($res);
```

## ThinkPHP 5.0 模型

### 什么是模型

定义一个User模型类：
```php
namespace app\index\model;
use think\Model;
class User extends Model{
    # 命名 tp_user  对应的类是User.php  对应的模型名就是 User
    # tp_user_info 对应的类是UserInfo.php  对应的模型名就是 UserInfo
}
```
注意：
- 默认主键为自动识别
- 如果需要指定，可以设置属性
- 模型会自动对应数据表
```php
//设置指定字段
protected $pk = 'uid';
```

model文件命名方法：除去表前缀的数据表名称，采用驼峰法命名，并且首字母大写
命名规范  应该和字段名对应省掉表前缀用驼峰命名法

#### 模型的定义

三种引用model方法：

1、静态调用，直接使用；需要引用think\index\model\User文件（建议使用）
```php
use think\index\model\User;
$arr=User::get('2');
$arr=$arr->toArray();
dump($arr);
```

2、使用new实例化模型，需要引用think\index\model\User文件
```php
use think\index\model\User;
$user = new User;
$res = $user::get('3');
$res = $res->toArray();
dump($res);
```

3、使用Loader::model()实例化，引用think\Loader 文件
```php
use think\Loader;
$user = Loader::model('User');
$res = $user::get('4');
$arr=$res->toArray();
dump($arr);
```

4、使用助手函数model()，不用引用文件
```php
$user = model('User');
$res = $user::get('5');
$res = $res->toArray();
dump($res);
```
