<?php
include 'http_send.php';
include 'format_gm_cmd.php';
include 'config.php';
include 'act.php';

session_start();
$login_state = $_SESSION['login_state'];
if ($login_state <= 0) {
    echo("错误信息: 没有登陆");
    header('Location: ../login.html');
    return;
}

$c = get_config();
if ($c == null) {
    echo("错误信息: 配置找不到");
    return;
}

$dbc= new mysqli($c->DBIP, $c->DBUser, $c->DBPassword, $c->DBNameLogin);
if(!$dbc)  {
    echo("错误信息: 数据库链接错误".$mysql_error());
    return;
}

$result=mysqli_query($dbc, "select * from BanPlayers;");

define("BAN_LIST_TABLE_UNIQUE_ID", "玩家唯一ID");
define("BAN_LIST_TABLE_ACCOUNT", "玩家账号");
define("BAN_LIST_TABLE_PLAYER_ID", "玩家ID");
define("BAN_LIST_TABLE_TIME", "封号时间");
$tab_headers = array(BAN_LIST_TABLE_UNIQUE_ID=>'UniqueId', BAN_LIST_TABLE_ACCOUNT=>'Account', BAN_LIST_TABLE_PLAYER_ID=>'PlayerId', BAN_LIST_TABLE_TIME=>'StartTimeStr');

$tab_str = '<table border="1" style="margin: auto;">';
$tab_str = $tab_str . '<tr>';
foreach ($tab_headers as $k=>$v) {
    $tab_str = $tab_str . '<th>'. $k . '</th>';
}
$tab_str = $tab_str . '</tr>';

$uniqueId; $account; $player_id; $start_time;
while ($row=mysqli_fetch_array($result)) {
	$unique_id = $row[$tab_headers[BAN_LIST_TABLE_UNIQUE_ID]];
    $account = $row[$tab_headers[BAN_LIST_TABLE_ACCOUNT]];
    $player_id = $row[$tab_headers[BAN_LIST_TABLE_PLAYER_ID]];
    $start_time = $row[$tab_headers[BAN_LIST_TABLE_TIME]];
    $tab_str = $tab_str . '<tr><td>' . $unique_id . '</td>';
    $tab_str = $tab_str . '<td>' . $account . '</td>';
    $tab_str = $tab_str . '<td>' . $player_id . '</td>';
    $tab_str = $tab_str . '<td>' . $start_time . '</td></tr>';
}
$tab_str = $tab_str . '</table>';

echo $tab_str;
echo("请求完成");

save_act("history", ACT_BAN_LIST, "ban_list", 1, $_SESSION["user_name"], "");

?>