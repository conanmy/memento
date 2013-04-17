<?php
/*
 *接收前端发来的用户（target）。返回搜索结果
 *返回格式
[{ “uid”:222332 , ”name”:”Ramos” , ”sex”:1 , ”star”:1 ,”zidou”:1 ”birthday”:”2008-10-12”,
"email_hash”:” 650628530_9c6b2b93842c46155b75b14a34054924”,
  “tinyurl”:” http://head.xiaonei.com/photos/tiny_10942g177.jpg”,
  “headurl”:” http://head.xiaonei.com/photos/tiny_10942g177.jpg”,
  “mainurl”:” http://head.xiaonei.com/photos/tiny_10942g177.jpg”
],}
 */

require_once 'RenrenRestApiService.class.php';

$rrObj = new RenrenRestApiService;
//sessionkey和accesstoken，传任何一个都可以；“测试1”用的是sessionkey，“测试2”用的是accesstoken
$sessionkey=$_GET["key"];//改成测试用户的
$uid = $_GET["uid"];
/*查询用户信息
 */
$params = array('session_key'=>$sessionkey,'uids'=>$uid,'fields'=>'name,tinyurl');//使用session_key调api的情况
$temp = $rrObj->rr_post_curl('users.getInfo', $params);

echo json_encode($temp[0]);//输出结果
?>