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
        $username=$_REQUEST["username"];
        //获取html中的密码（通过post请求）
		$password=$_REQUEST["password"];
 
        //连接mysql 数据库，账户名root ，密码root
		//$con = mysqli_connect("localhost", "root", "", "ih_admin");
		$c = get_config();
		if ($c == null) {
			die("配置找不到");
		}
		$dbc= new mysqli($c->DBIP, $c->DBUser, $c->DBPassword, $c->DBName);
    	if(!$dbc)  {
      		die("数据库链接错误". mysqli_error($dbc));
    	}
        //use user_info数据库；
		//mysqli_select_db("user_info",$con);
		$dbusername=null;
		$dbpassword=null;
		$permission=0;
        //查出对应用户名的信息，isdelete表示在数据库已被删除的内容
		$result=mysqli_query($dbc, "select * from accounts where username ='$username';");
        //while循环将$result中的结果找出来
		while ($row=mysqli_fetch_array($result)) {
			$dbusername=$row["username"];
			$dbpassword=$row["password"];
			$permission=$row["permission"];
        }
        //用户名在数据库中不存在时跳回index.html界面
		if (is_null($dbusername)) {
	?>
	<script type="text/javascript">
			alert("用户名不存在");
			window.location.href="../login.html";
	</script>
	<?php 
		}
		else {
            //当对应密码不对时跳回index.html界面
			if ($dbpassword!=$password){
	?>
	<script type="text/javascript">
				alert("密码错误");
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
    //关闭数据库连接，如不关闭，下次连接时会出错
		mysqli_close($con);
	?>
</body>
</html>