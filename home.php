<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>welcome</title>
        <link type="text/css" rel="stylesheet" href="style/timeline.css" />
        <link type="text/css" rel="stylesheet" href="style/home.css" />
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.query.js"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="js/jquery-jtemplates.js"></script>
        <script type="text/javascript" src="http://static.connect.renren.com/js/v1.0/FeatureLoader.jsp"></script>
        <script type="text/javascript" src="js/home.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div id="hide" class="midLayer"></div>
            <div class="input_area">
                                                 想寻找 Ta<input type="text" id="target" />和你之间的记忆碎片?
                <a id="target_confirm">开始</a>
                <p>
                                                输入好友名字或者从提示列表中选择
                </p>
            </div>
            <div id="chart"></div>
            <textarea id="template" style="display:none">
    			<div id="container">
    				{#foreach $T as status}
    				<div class="post content">
    					<a class="date">{$T.status.time}</a>
    					<div class="conversation">
    						<div class="time_dot">
    						</div>
    						<h2>
    						<span class="label">{$T.status.name}:</span>{$T.status.message}
    						</h2>
    						<ul>
    							{#foreach $T.status.comment as m}
    							<li>
    								<span class="label">{$T.m.name}:</span>
    								{$T.m.text}
    							</li>
    							{#/for}
    						</ul>
    					</div>
    				</div>
    				{#/for}
    			</div>
    		</textarea>
            <div id="jTemplatesTest"></div>
            <ul id="tools">
                <li id="MakeLine">
                                                            生成时间线文件
                </li>
                <li>
                    <a id="invite" target="_blank" href="http://apps.renren.com/request.do?app_id=161474&action=http://apps.renren.com/xnmlshelll/shell.jsp">邀请好友来玩</a>
                </li>
                <li id="TryAgain">
                    重新查找
                </li>
                <li id="check_feed">
                    <input type="checkbox" id="CheckFeedInput" checked="checked" />
                    让好友知道你在玩记忆碎片
                </li>
            </ul>
            <div id="TipLayer" class="up_layer">
                <div class="close_button">
                    <input type="button" value="关闭" href="javascript:void(0)" onclick="layerHide('TipLayer')" />
                </div>
                <div class="tip_text"></div>
            </div>
        </div>
    </body>
</html>