<?php
include "config.php";

session_start();
$login_state = $_SESSION['login_state'];
if ($login_state <= 0) {
    echo("错误信息: 没有登陆");
    header('Location: ../login.html');
} else {
    $permission = $_SESSION['permission'];
    if ($permission < 2) {
        echo("权限不够");
        return;
    }
    echo
    '<h1>History</h1>
    <label>GM账号</label>';
    $c = get_config();
	if ($c == null) {
		die("配置找不到");
	}
	$dbc = new mysqli($c->DBIP, $c->DBUser, $c->DBPassword, $c->DBName);
   	if(!$dbc)  {
     	die("数据库链接错误". mysqli_error($dbc));
    }
    $result = mysqli_query($dbc, "select distinct act_account from history;");
    //while循环将$result中的结果找出来
    echo '<table border="1"><tr>' ;
    echo '</tr>';

    $cnt = 0;
	while ($row = mysqli_fetch_array($result)) {
        $act_account = $row["act_account"];
        echo '<tr><td>' . $act_account . '</td><td><input type="button" id="submit" value="查看" onclick="SeeHistory(\'' . $act_account . '\', 0);"></td></tr>';
        $cnt += 1;
    }

    if ($cnt > 1) {
        echo '<tr><td>所有账号</td><td><input type="button" id="submit" value="查看" onclick="SeeHistory(\'\', 0);"></td></tr>';
    }
}
?>