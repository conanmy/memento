<?php
/*
 * 接受用户的传入，计算时间线中要展示的数据
 * 需要传入的参数有key(sessionkey)、用户id(uid)、查询对象id(targetid)
 */
set_time_limit(300);
//error_reporting(-9);
//ini_set("display_errors","Off");
$sessionkey = $_GET["key"];//改成测试用户的
$uid = $_GET["uid"];
$uname = $_GET["uname"];
$targetid = $_GET["targetid"];
$targetname = $_GET["targetname"];
require_once 'RenrenRestApiService.class.php';

$rrObj = new RenrenRestApiService;

function getStatus($ownerid,$ownername,$replierid,$repliername,$sessionkey){
	$rrObj = new RenrenRestApiService;
	
	/*获取用户所有状态
	 */
	$flag = true;
	$i = 1;
	$status = array();
	/*  status中每项的结构
	 *  {
	 *      "comment_count": 1,
	 *      "message": "6666",
	 *      "time": "2010-11-22 14:36:12",
	 *      "status_id": 1531567276
	 *  }
	 */
	while($flag == true){
		$params = array('session_key'=>$sessionkey,'uid'=>$ownerid,'count'=>500,'page'=>$i);//使用session_key调api的情况
		//echo $ownerid;
		$temp = $rrObj->rr_post_curl('status.gets', $params);
		//echo json_encode($temp);
		if(count($temp) == 0){
			$flag = false;
		}else{
			$status = array_merge($status,$temp);//curl函数发送请求
			$i ++;
		}
	}
	//echo count($status);
	$memento_status = array();
	/*  返回comment数组中每项的结构
	 *  {
	 *		"uid ":66271, 
	 *      "name":TerryTsui, 
	 *      "tinyurl": "http://hd45.renren.com/photos/hd45/20080916/11/25/head_2IVe_2413k200150.jpg",
	 *      "comment_id":123124321432,
	 *      "time": 2009-06-02 16:32:41,
	 *      "text":"团购进行时～"
	 *  }
	 */
	//$b = 0;
	$flag_plus = 0;
	foreach($status as $item){
		//$b ++;
		if(isset($item["comment_count"]) && $item["comment_count"] != 0){
			//设置返回status数组中每项的name属性值
			$item["name"] = $ownername;
			$item["time"] = substr($item["time"], 0, 10);
			//echo $item["status_id"]." ".$ownerid."<br>";
			$params = array('session_key'=>$sessionkey,'status_id'=>$item["status_id"],'owner_id'=>$ownerid);
			$temp = $rrObj->rr_post_curl('status.getComment', $params);
			//print_r($temp);
			if(!isset($temp)){
				echo "超时但是执行了后续代码";
				$flag_plus = 1;
			};
			$flag_added = false;//标识该项目是否被添加进了$memento_status
			/*if(array_key_exists("error_code",$temp)){
				echo "error";
			}else{
				echo "true";
			}
			echo "<br>";*/
			if(isset($temp)&&!array_key_exists("error_code",$temp)){
				foreach($temp as $item_comment){
					if(($item_comment["uid"] == $replierid) || (strchr($item_comment["text"],"回复".$repliername) != false)){
						if($flag_added == false){
							array_push($memento_status,$item);
							$memento_status[count($memento_status)-1]["comment"] = array();
							$flag_added = true;
						}
						array_push($memento_status[count($memento_status)-1]["comment"],$item_comment);
					}
				}
			}
		}
	}
	echo "执行到了return函数前前面";
	return $memento_status;
}
$return_array1 = getStatus($targetid,$targetname,$uid,$uname,$sessionkey);
$return_array2 = getStatus($uid,$uname,$targetid,$targetname,$sessionkey);
$return_array = array_merge($return_array1,$return_array2);
function my_sort($a, $b)
{
	if ($a["time"] == $b["time"]) return 0;
	return ($a["time"] > $b["time"]) ? 1 : -1;
}
usort($return_array, "my_sort");
echo json_encode($return_array);//输出结果
?>