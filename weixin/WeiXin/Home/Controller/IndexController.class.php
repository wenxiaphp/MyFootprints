<?php
namespace Home\Controller;
use Think\Controller;
//header('content-type:html/text;charset=utf-8');

class IndexController extends Controller {
    public function show(){
        echo "sjsks";
    }

    public function index(){
        // 只是验证token可以使用
        //定义TOKEN
        define('TOKEN',"weixin");

        //接收请求的参数(都是来自微信服务器)
        $echostr = $_GET['echostr'];
        $signature = $_GET['signature'];//微信的加密签名
        $timestamp = $_GET['timestamp'];//时间戳
        $nonce = $_GET['nonce'];//随机数
        $token = "weixin";

        //把$nonce $timestamp TOKEN 放在数组里面
        $stempArr = array($nonce,$timestamp,$token);
        //排序  SORT_STRING(快速的排序)
        sort($stempArr);
        //把数组转换为字符串
        $stmpStr = implode('',$stempArr);
        //进行sha1算法加密
        $stmpStr = sha1($stmpStr);
        //校验 请求是否来自微信服务器

        if($stmpStr == $signature && $echostr){
            echo $echostr;
            exit;
        }else{
            $this->responseMsg();
        }
    }

    // 接受时间推送并回复
    public function responseMsg()
    {
        // 获取到微信推送过来的POST数据（xml格式）
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if(!$postStr){
            $postStr = file_get_contents("php://input");
        }
        libxml_disable_entity_loader(true);
        // 处理消息类型，并设置回复类型和内容
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        // 判断该数据包是否是订阅的事件推送
        if(strtolower($postObj->MsgType) == "event"){
            if(strtolower($postObj->Event) == 'subscribe'){
                if( strtolower($postObj->EventKey) == 'qrscene_2222'){
                    $Content = "扫描我的永久二维码
欢迎关注我的公众号
这是我的微信
你知道吗？
你要取消关注吗？
如果取消了，我可是会不高兴哦。。
你要想清楚哦！！！";
                }else if(strtolower($postObj->EventKey) == 'qrscene_3333'){
                    $Content = "扫描我的临时二维码
欢迎关注我的公众号
这是我的微信
你知道吗？
你要取消关注吗？
如果取消了，我可是会不高兴哦。。
你要想清楚哦！！！";
                }else{
                    $Content = "欢迎关注我的公众号
这是我的微信
你知道吗？
你要取消关注吗？
如果取消了，我可是会不高兴哦。。
你要想清楚哦！！！";
                }
                // 如果是关注subscribe事件
                // 回复用户消息
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();
                $Msgtype = 'text';
                $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";

                $info = sprintf($template, $toUser, $fromUser, $time, $Msgtype, $Content);
                echo $info;
            }
            // 扫码并且已经关注过的
            if(strtolower($postObj->Event) == 'scan'){
                // 临时
                if( trim(strtolower($postObj->EventKey)) == '3333' ){
                    // 如果是关注subscribe事件
                    // 回复用户消息
                    $toUser = $postObj->FromUserName;
                    $fromUser = $postObj->ToUserName;
                    $time = time();
                    $Msgtype = 'text';
                    $Content = "这个是临时微信二维码";
                    $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";

                    $info = sprintf($template, $toUser, $fromUser, $time, $Msgtype, $Content);
                    echo $info;
                }
                // 永久
                if( trim($postObj->EventKey) == 2222 ){
                    // 如果是关注subscribe事件
                    // 回复用户消息
                    $toUser = $postObj->FromUserName;
                    $fromUser = $postObj->ToUserName;
                    $time = time();
                    $Msgtype = 'text';
                    $Content = "这个是永久微信二维码";
                    $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";

                    $info = sprintf($template, $toUser, $fromUser, $time, $Msgtype, $Content);
                    echo $info;
                }

            }
        }

        if(strtolower($postObj->MsgType) == 'text'){
            if(trim($postObj->Content) == '图文'){
                // 数组长度不能超过8个，这个可以对应数据库
                $array = [
                    [
                        'Title' => "文件1",
                        'Description' => "今天是个好日子",
                        'PicUrl' => "http://www.jiyouge.net.cn/Public/shuffling/40c73855d2055e5c0ef6341666bda06c.jpg",
                        'Url' => "https://www.wenxiaphp.com"
                    ],
                    [
                        'Title' => "文件2",
                        'Description' => "哗啦啦啦啦天再下雨，哗啦啦啦啦云在哭泣",
                        'PicUrl' => "https://www.yilaitong.net/Public/UserAdmin/header/201710278276.jpg",
                        'Url' => "http://www.jiyouge.net.cn"
                    ]
                ];
                // 回复用户消息
                $template = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>".count($array)."</ArticleCount>
<Articles>";
                foreach ($array as $key => $value) {
                    $template .= "<item>
<Title><![CDATA[" . $value['Title'] . "]]></Title>
<Description><![CDATA[" . $value['Description'] . "]]></Description>
<PicUrl><![CDATA[" . $value['PicUrl'] . "]]></PicUrl>
<Url><![CDATA[" . $value['Url'] . "]]></Url>
</item>";
                }

                $template .= "</Articles>
</xml>";
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();
                $Msgtype = 'news';
                $info = sprintf($template, $toUser, $fromUser, $time, $Msgtype);
                echo $info;
            }else{
                switch (trim($postObj->Content)){
                    case "1":
                        $Content = "这是1";
                        break;
                    case "2":
                        $Content = "这是2";
                        break;
                    case "3":
                        $Content = "这是3";
                        break;
                    case "4":
                        $Content = "这是4";
                        break;
                    case "链接":
                        $Content = "<a href='http://www.wenxiaphp.com'>网站</a>";
                        break;

                }
                // 回复用户消息
                $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();
                $Msgtype = 'text';
                $info = sprintf($template, $toUser, $fromUser, $time, $Msgtype, $Content);
                echo $info;
            }

        }

        if(strtolower($postObj->Event) == 'click') {
            switch ($postObj->EventKey){
                case "clickOne":
                    $Content = "这是clickOne";
                    break;
                case "clickTwo":
                    $Content = "这是clickTwo";
                    break;
            }
            // 回复用户消息
            $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
            $toUser = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $time = time();
            $Msgtype = 'text';
            $info = sprintf($template, $toUser, $fromUser, $time, $Msgtype, $Content);
            echo $info;
        }

    }

    /*
     * $url 接口路径
     * $type  请求类型
     * $res  返回数据类型
     * $arr  post请求参数
     */
    public function httpCurl($url,$type='get',$res = 'json',$arr = ''){
        //1.初始化curl
        $ch = curl_init();
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($type == 'post'){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);
        if($res == 'json'){
            if( curl_errno($ch) ){
                // 错误信息
                return curl_error();
            }else{
                // 请求成功
                return json_decode($output,true);
            }
        }
    }
    // 获取token 考虑token定期过期，所以存session中
    public function getToken(){
        // 判断session中token是否可以使用
        if($_SESSION['token'] && $_SESSION['time'] > time()){
            return $_SESSION['token'];
        }else{
            //1.请求url地址
            $appid = 'wx8577fb4202f2b573';
            $appsecret = '4fc9bdaf6d60a80680511fd3ef1e7081';
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $res = $this->httpCurl($url,"get",'json');
            // 将token 存入SESSION中
            $_SESSION['token'] = $res['access_token'];
            $_SESSION['time'] = time() + $res['expires_in'];
            return $res['access_token'];
        }
    }

    // 获取微信ip地址
    public function getWxServerIp(){
        $accessToken = $this->getToken();
        var_dump($accessToken);
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
        $res = $this->httpCurl($url,'get','json');
        var_dump($res);
    }
    // 自定义菜单
    public function defaultItem(){
        $postArray = array(
            "button" => array(
                array(
                    "name" => urlencode("官网"),
                    "type" => "view",
                    "url" => "http://www.wenxiaphp.com/"
                ),
                array(
                    "name" => urlencode("小程序"),
                    "type" => "view",
//                    "type" => "miniprogram",
                    "url" => "http://www.jiyouge.net.cn/phoneBack/home.html#/index",
//                    "appid" => "wx0c26e3a854a842b6",
//                    "pagepath" => urlencode("pages/index/index")
                ),
                array(
                    "name" => urlencode("亿来通"),
                    "sub_button" => array(
                        array(
                            "name" => urlencode("点击"),
                            "type" => "click",
                            "key" => "clickOne"
                        ),
                        array(
                            "name" => urlencode("亿来通"),
                            "type" => "view",
                            "url" => "http://www.yilaitong.net/"
                        ),
                        array(
                            "name" => urlencode("点击2"),
                            "type" => "click",
                            "key" => "clickTwo"
                        ),
                    )
                )
            )
        );

        $token = $this->getToken();
        echo $token;
        echo "<hr/>";
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
        echo $url;
        echo "<hr/>";
        $postJson = urldecode(json_encode($postArray));
        echo $postJson;
        echo "<hr/>";
        $res = $this->httpCurl($url,"post",'json',$postJson);
        var_dump($res);
        echo "<hr/>";
    }
    // 生成一个带参数的临时二维码  http://www.wenxiaphp.com/weixin/index.php/Home/Index/getCode
    public function getCode(){
        $token = $this->getToken();
        var_dump($token);
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
        //{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "test"}}}
        $postArr = array(
            'expire_seconds' => 604800,
            'action_name'=>"QR_STR_SCENE",
            'action_info'=>array(
                'scene'=>array(
                    'scene_str'=>3333
                ),
            ),
        );
        $postJson = json_encode($postArr);
        $res = $this->httpCurl($url,'post','json',$postJson);
        var_dump($res);
        $ticket = $res['ticket'];
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        echo "<img src='".$url."'/>";
    }
    // 生成一个带参数的永久二维码  http://www.wenxiaphp.com/weixin/index.php/Home/Index/getQrCode
    public function getQrCode(){
        $token = $this->getToken();
        var_dump($token);
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;

        //{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
        $postArr = array(
            'action_name'=>"QR_LIMIT_SCENE",
            'action_info'=>array(
                'scene'=>array(
                    'scene_id'=>2222
                ),
            ),
        );
        $postJson = json_encode($postArr);
        $res = $this->httpCurl($url,'post','json',$postJson);
        var_dump($res);
        $ticket = $res['ticket'];
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        echo "<img src='".$url."'/>";
    }



}