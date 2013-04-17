<?php
/*
 *接收时间线页面发来的信息，发送通知
 */

require_once 'RenrenRestApiService.class.php';

$rrObj = new RenrenRestApiService;

/*发送通知
 */
$params = array('name'=>'也来试试记忆碎片吧！','description'=>"记忆碎片-寻找遗失的美好。",'url'=>"http://apps.renren.com/memento/welcome.php",'session_key'=>$_GET["key"],'image'=>"http://app.xnimg.cn/application/20120528/23/55/LAtJk133d018153.jpg");//使用access_token调api的情况
$res = $rrObj->rr_post_curl('feed.publishFeed', $params);//curl函数发送请求

echo json_encode($res);//输出结果
?>