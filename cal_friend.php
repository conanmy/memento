<?php
/*接收前端发来的好友名字（target）。返回搜索结果
 * 返回格式
{
    "total": 100,
    "friends": [{
        "id": 200804508,
        "tinyurl": "http://hdn.xnimg.cn/phoc019116.jpg",
        "isFriend": 1,
        "name": "李廷勇",
        "info": "大连理工,四川省仪陇县中学,北京"
    },
    {
        "id": 27640369,
        "tinyurl": "http://hdn.xnimg.cn/pho4234.jpg",
        "isFriend": 1,
        "name": "李勇",
        "info": "千橡互动,朝阳二外,北京"
    }]
}
 */

require_once 'RenrenRestApiService.class.php';

$rrObj = new RenrenRestApiService;
//sessionkey和accesstoken，传任何一个都可以；“测试1”用的是sessionkey，“测试2”用的是accesstoken
$sessionkey=$_GET["key"];//改成测试用户的

//$rrObj->setEncode("GB2312");//如果是utf-8的环境可以不用设，如果当前环境不是utf8编码需要在这里设定

/*@POST暂时有两个参数，第一个是需要调用的方法，具体的方法跟人人网的API一致，注意区分大小写
 *@第二个参数是一维数组，除了api_key,method,v,format,callid之外的其他参数/

/*根据用户输入搜索
 */
$params = array('session_key'=>$sessionkey,'name'=>$_GET["target"],'count'=>2);//使用session_key调api的情况
$res = $rrObj->rr_post_curl('friends.search', $params);//curl函数发送请求
echo json_encode($res);//输出结果
?>