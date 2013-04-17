<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"l>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>welcome</title>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready( function() {
			$("#enter").bind("click", function() {
				top.location='https://graph.renren.com/oauth/authorize?client_id=3ada89292ed94a61be1ac634b3291750&response_type=code&scope=read_user_status+publish_feed&display=page&redirect_uri=http://apps.renren.com/memento/home.php';
			});
		});
	</script>
	<style type="text/css">
		/*--公用--*/
		* {
			font-size:12px;
		}
		/*--本页--*/
		#slogan {
			width:600px;
			text-align:center;
			margin:100px auto 50px auto;
			font-size:25px;
			font-family: "Microsoft Yahei",Tahoma,Arial,Helvetica,STHeiti;
		}
		#slogan span {
			font-size:15px;
			font-family: "Microsoft Yahei",Tahoma,Arial,Helvetica,STHeiti;
		}
		#enter {
			margin:0 auto;
			text-align: center;
			width:100px;
			height:25px;
			display: block;
			font-size:20px;
			color:#ffffff;
			text-decoration:none;
			line-height:25px;
			background:#FF6600;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<div id="slogan">
			寻找遗失的美好。
			<span>——Memento</span></p>
	</div>
	<a id="enter" href="#">开始</a>
		
</body>
</html>