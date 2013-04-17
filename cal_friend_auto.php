<?php
/*
 *获取查询条件（q）和sessionkey（key）返回数据
 * 格式{
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

/*根据用户输入搜索
 */
$params = array('session_key'=>$sessionkey,'name'=>$_GET["q"],'count'=>5);//使用session_key调api的情况
$res = $rrObj->rr_post_curl('friends.search', $params);//curl函数发送请求

echo json_encode($res["friends"]);//输出结果
?>