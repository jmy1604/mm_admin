<?php

include "config.php";

session_start();
$login_state = $_SESSION['login_state'];
if ($login_state <= 0) {
    echo("错误信息: 没有登陆");
    header('Location: ../login.html');
    return;
}

$permission = $_SESSION['permission'];
if ($permission < 2) {
    echo("权限不够");
    return;
}

$account=$_POST["account"];
$page;
if (!isset($_POST["page"])) {
    $page = 0;
} else {
    $page = $_POST["page"];
}

$c = get_config();
if ($c == null) {
	die("配置找不到");
}
$dbc = new mysqli($c->DBIP, $c->DBUser, $c->DBPassword, $c->DBName);
if(!$dbc)  {
  	die("数据库链接错误". mysqli_error($dbc));
}

$tab_headers = array(1=>'Account', 2=>'Id', 3=>'ActId', 4=>'ActName', 5=>'ActResult', 6=>'ActTime', 7=>'Detail');

echo '<table border="1"><tr>' ;
foreach ($tab_headers as $k=>$v) {
    echo '<th>'. $v . '</th>';
}
echo '</tr>';

$need_fetch = 30;
$offset = $page * $need_fetch;
$real_fetch = $need_fetch+1;
$result;
$row_num_res;
if ($account == '') {
    $result = mysqli_query($dbc, "select * from history order by act_time desc limit $offset, $real_fetch;");
    $row_num_res = mysqli_query($dbc, "select count(*) from history;");
} else {
    $result = mysqli_query($dbc, "select * from history where act_account='$account' order by act_time desc limit $offset, $real_fetch;");
    $row_num_res = mysqli_query($dbc, "select count(*) from history where act_account='$account';");
}

if ($account == "") {
    echo '<label>当前账号: 所有</label><br>';
} else {
    echo '<label>当前账号: ' . $account . '</label><br>';
}

$row = mysqli_fetch_row($row_num_res);
$row_num = $row[0];
$total_page = ceil($row_num/$need_fetch);

$display_page = $page + 1;
echo '<label>当前页: ' . $display_page . '/' . $total_page . '</label><br>';

$cnt = 0;
while ($row = mysqli_fetch_array($result)) {
    if ($cnt > $need_fetch) {
        break;
    }
    $act_account = $row["act_account"];
    $id = $row["id"];
    $act_id = $row["act_id"];
    $act_name = $row["act_name"];
    $act_result = $row["act_result"];
    $act_time = $row["act_time"];
    $detail = $row["detail"];
    echo '<tr><td>' . $act_account . '</td><td>' . $id . '</td><td>' . $act_id . '</td><td>' . $act_name . '</td><td>' . $act_result . '</td><td>' . $act_time . '</td><td>' . $detail . '</td></tr>';
    $cnt += 1;
}

if ($page > 0) {
    $prev_page = $page -1;
    echo '<a href="javascript:SeeHistory(\'' . $account . '\', ' . $prev_page . ')"> 上一页 </a>';
}

if ($cnt > $need_fetch) {
    $next_page = $page + 1;
    echo '<a href="javascript:SeeHistory(\'' . $account . '\', ' . $next_page . ')"> 下一页 </a>';
}

?>