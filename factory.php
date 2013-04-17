<?php
  	$content = stripslashes($_POST["content"]);
	
  	$title=$_POST["uname"]."与".$_POST["targetname"]."的记忆碎片";
  	$path='userlines/'.$_POST["uid"]."&".$_POST["targetid"].'.htm';
  	$fp=fopen("userlines/tmp.htm","r"); //只读打开模板
  	$str=fread($fp,filesize("userlines/tmp.htm"));//读取模板中内容
  	$str=str_replace("{title}",$title,$str);
	$str=str_replace("{key}",$_POST["key"],$str);
	$str=str_replace("{uname}",$_POST["uname"],$str);
	$str=str_replace("{targetid}",$_POST["targetid"],$str);
	$str=str_replace("{targetname}",$_POST["targetname"],$str);
  	$str=str_replace("{content}",$content,$str);//替换内容
  	fclose($fp);
	
  	$handle=fopen($path,"w"); //写入方式打开新闻路径
  	fwrite($handle,$str); //把刚才替换的内容写进生成的HTML文件
  	fclose($handle);
  	echo "success";
 	// unlink($path); //删除文件
?>