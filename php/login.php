<?php
	include 'config.php';
	//登录系统开启一个session内容
	session_start();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>登录系统的后台执行过程</title>
</head>
<body>
	<?php 
        //获取html中的用户名（通过post请求）
        $username=$_POST["username"];
        //获取html中的密码（通过post请求）
		$password=$_POST["password"];
 
        //连接mysql 数据库，账户名root ，密码root
		//$con = mysqli_connect("localhost", "root", "", "ih_admin");
		$c = get_config();
		if ($c == null) {
			die("配置找不到");
		}
		$dbc= new mysqli($c->DBIP, $c->DBUser, $c->DBPassword, $c->DBName);
    	if($dbc->connect_errno)  {
      		die("数据库链接错误". $dbc->connect_errno);
		}
		echo("db_ip: " . $c->DBIP . ", db_user: " . $c->DBUser . ", db_password: " . $c->DBPassword . ", db_name: " . $c->DBName);
        //use user_info数据库；
		//mysqli_select_db("user_info",$con);

        //查出对应用户名的信息，isdelete表示在数据库已被删除的内容
		$result=mysqli_query($dbc, "select password, permission from accounts where username='$username'");
		if (is_null($result)) {
			die("数据库缺少数据");
		}
        //while循环将$result中的结果找出来
		$row=mysqli_fetch_array($result);
		$dbpassword=$row["password"];
		$permission=$row["permission"];

        //用户名在数据库中不存在时跳回index.html界面
		if (is_null($dbpassword)) {
	?>
	<script type="text/javascript">
			var user_name = '<?php echo $username?>';
			alert("用户名" + user_name + "不存在");
			window.location.href="../login.html";
	</script>
	<?php 
		}
		else {
            //当对应密码不对时跳回index.html界面
			if ($dbpassword!=$password){
	?>
	<script type="text/javascript">
				var user = '<?php echo $username?>';
				var pw = '<?php echo $dbpassword?>';
				alert("用户(" + user + ")密码(" + pw + ")错误");
				window.location.href="../login.html";
	</script>
	<?php 
			}
			else {
				$_SESSION['login_state'] = 1;
				$_SESSION['user_name'] = $username;
				$_SESSION['permission'] = $permission;
	?>
	<script type="text/javascript">
		window.location.href="welcome.php";
	</script>
	<?php 
			}
		}
		mysqli_free_result($result);
    //关闭数据库连接，如不关闭，下次连接时会出错
		mysqli_close($con);
	?>
</body>
</html>