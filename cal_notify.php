<?php
/*
 *接收时间线页面发来的信息，发送通知
 */

require_once 'RenrenRestApiService.class.php';

$rrObj = new RenrenRestApiService;

/*发送通知
 */
$params = array('to_ids'=>$_GET["targetid"],'type'=>"user_to_user",'notification'=>"您的好友".$_GET["uname"]."找到了了你们之间的记忆碎片<a href='".$_GET["url"]."'>去看看</a>",'session_key'=>$_GET["key"]);//使用access_token调api的情况
$res = $rrObj->rr_post_curl('notifications.send', $params);//curl函数发送请求

echo json_encode($res);//输出结果
?>