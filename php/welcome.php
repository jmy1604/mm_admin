<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>欢迎登录界面</title>
</head>
<body>
 
<?php

session_start ();
$login_state = $_SESSION['login_state'];
if ($login_state == null || $login_state <= 0) {
?>
	<a href="exit.php">退出登录</a>
	<script type="text/javascript">
		alert("退出登录");
		window.location.href="exit.php";
	</script>
	<br>
<?php
	echo("错误信息: 没有登陆");
    return;
}
?>
欢迎登录
<?php
    //显示登录用户名
	echo "${_SESSSION['user_name']}";
?><br>
您的ip：
<?php
    //显示ip
	echo "${_SERVER['REMOTE_ADDR']}";
?>
<br>
您的语言：
<?php
    //使用的语言
	echo "${_SERVER['HTTP_ACCEPT_LANGUAGE']}";
?>
<br>
浏览器版本：
<?php
    //浏览器版本信息
	echo "${_SERVER['HTTP_USER_AGENT']}";
?>
	<a href="alter_password.html">修改密码</a>
	<script type="text/javascript">
		window.location.href="../gm.html";
	</script>
</body>
</html>
