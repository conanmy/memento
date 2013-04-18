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
        <script type="text/javascript">
            var Memento = {};
            var key = $.query.get("xn_sig_session_key");

            $(document).ready(function() {
                
                Memento.info = {
                    uid : $.query.get("xn_sig_user"),
                    uname : '',
                    uimg : '',
                    targetid : '',
                    targetname : '',
                    targetimg : ''
                };

                //隐藏“生成时间线”按钮
                //$("#MakeLine").hide();
                //隐藏"重新查找"按钮
                //$("#TryAgain").hide();

                //获取用户名字并存于Memento.info
                var getMyInfo = $.get("cal_me.php", {
                    'key' : key,
                    'uid' : Memento.info.uid
                }, function(data) {
                    data = $.parseJSON(data);
                    Memento.info.uname = data["name"];
                    Memento.info.uimg = data["tinyurl"];
                });

                //autocomplete
                $("#target").autocomplete("cal_friend_auto.php", {
                    delay : 400,
                    width : 150,
                    dataType : 'json',
                    parse : function(data) {
                        var parsed = [];
                        for (var i = 0; i < data.length; i++) {
                            parsed[parsed.length] = {
                                data : data[i],
                                value : data[i].name,
                                result : data[i].name
                            };
                        }
                        return parsed;
                    },
                    formatItem : function(item) {
                        return "<img src='" + item["tinyurl"] + "' />" + "<span>" + item["name"] + "</span>";
                    },
                    selectFirst : true
                });
                //请求数据
                $("#target_confirm").bind("click", function() {
                    $.when(getMyInfo, getFriendInfo).then(
                        getMemento, 
                        function(){
                            alert('用户信息异常');
                        }
                    );
                    
                    var target = $("#target").val();
                    //根据用户输入获取目标好友信息
                    var getFriendInfo = $.get("cal_friend.php", {
                        'key' : key,
                        'target' : target
                    }, function(data) {
                        data = $.parseJSON(data);
                        alert("查找 " + data["friends"][0]["name"] + "，请耐心等候");

                        //生成加载提示
                        $("#jTemplatesTest").append("<div class='loading'>加载中<a></a></div>");

                        //将得到的数据存在Memento.info中
                        Memento.info.targetid = data["friends"][0]["id"];
                        Memento.info.targetname = data["friends"][0]["name"];
                        Memento.info.targetimg = data["friends"][0]["tinyurl"];
                    });
                    
                    //请求并处理时间线数据
                    var getMemento = $.get("cal_memento.php", {
                        'key' : key,
                        'uid' : Memento.info.uid,
                        'uname' : Memento.info.uname,
                        'targetid' : Memento.info.targetid,
                        'targetname' : Memento.info.targetname
                    }, function(data) {
                        var index = data.indexOf('[{"uid":');
                        if (index < 0) {
                            alert("网络状况不佳，请重试");
                            //隐藏加载提示
                            $("#jTemplatesTest").html("");
                        } else {
                            data = data.slice(index);
                            data = $.parseJSON(data);
                            $("#jTemplatesTest").setTemplateElement("template");
                            $("#jTemplatesTest").processTemplate(data);
                            //设置iframe高度
                            XN_RequireFeatures(["Connect", "CanvasUtil"], function() {
                                //这里要自己填两个参数：api_key和跨域文件xd_receiver.html的路径
                                XN.Main.init("3ada89292ed94a61be1ac634b3291750", "xd_receiver.html");
                                //这里要填需要自定义的高度如"800px"，注意应该有'px'单位
                                var height_frame = document.getElementById("container").scrollHeight + 100;
                                XN.CanvasClient.setCanvasHeight(height_frame + "px");
                            });
                            //生成浮动层
                            $("<div id='floatblock'><ul><li><img src='" + Memento.info.uimg + "' /></li><li>" + Memento.info.uname + "</li><li class='light'>|</li><li>" + Memento.info.targetname + "</li><li><img src='" + Memento.info.targetimg + "' /></li></ul></div>").appendTo("#container");
                            //隐藏输入框
                            $(".input_area").hide();
                            //显示“生成时间线”按钮
                            $("#tools").show();
                        }
                    });
                });
                //绑定生成时间线按钮
                $("#MakeLine").bind("click", function() {
                    $("#TipLayer .tip_text").html("<div class='loading'>生成中<a></a></div>");
                    layerShow("TipLayer");
                    var content = $("#container").html();
                    $.post("factory.php", {
                        'content' : content,
                        'uid' : Memento.info.uid,
                        'uname' : Memento.info.uname,
                        'targetid' : Memento.info.targetid,
                        'targetname' : Memento.info.targetname,
                        'key' : key
                    }, function(data) {
                        if (data == "success") {
                            $("#TipLayer .tip_text").html("生成成功 <a href='userlines/" + Memento.info.uid + "&" + Memento.info.targetid + ".htm' target='_blank'>查看</a>");
                        } else {
                            alert("生成失败，请稍后再试。");
                            layerHide("TipLayer");
                        }
                    });
                });
                //绑定重新查找按钮
                $("#TryAgain").bind("click", function() {
                    if ($("#CheckFeedInput").attr("checked") == "checked") {
                        $.get("send_feed.php", {
                            'key' : key
                        }, function(data) {
                            data["post_id"] > 0 ? alert("新鲜事发送成功") : alert("新鲜事发送失败");
                        });
                    }
                    //显示输入框
                    $(".input_area").show();
                    //隐藏时间线
                    $("#container").hide();
                    //隐藏“生成时间线”按钮
                    $("#tools").hide();
                    //定位到页面顶部
                    XN.CanvasClient.setCanvasHeight(500 + "px");
                });

            });

            function layerShow(givenId) {
                var A = document.getElementById(givenId);
                var B = document.getElementById("hide");
                A.style.display = "block";
                B.style.display = "block";
            }

            function layerHide(givenId) {
                var A = document.getElementById(givenId);
                var B = document.getElementById("hide");
                A.style.display = "none";
                B.style.display = "none";
            }

        </script>
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
            <div id="TipLayer" class="upLayer">
                <div class="closeButton">
                    <input type="button" value="关闭" href="javascript:void(0)" onclick="layerHide('TipLayer')" />
                </div>
                <div class="tip_text"></div>
            </div>
        </div>
    </body>
</html>