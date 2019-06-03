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

$player_id = $_POST["player_id"];
$order_id = $_POST['order_id'];

$c = get_config();
if ($c == null) {
    echo("错误信息: 配置找不到");
    return;
}

$dbc = new mysqli($c->DBIP, $c->DBUser, $c->DBPassword, $c->DBName);
if (!$dbc)  {
    echo("错误信息: 数据库链接错误". mysqli_error($dbc));
    return;
}

echo("请求完成");

define("PAY_TABLE_ORDER_ID", "订单ID");
define("PAY_TABLE_BUNDLE_ID", "BundleID");
define("PAY_TABLE_ACCOUNT", "玩家账号");
define("PAY_TABLE_PLAYER_ID", "玩家ID");
define("PAY_TABLE_TIME", "购买时间");
$tab_headers = array(PAY_TABLE_ORDER_ID=>'OrderId', PAY_TABLE_BUNDLE_ID=>'BundleId', PAY_TABLE_ACCOUNT=>'Account', PAY_TABLE_PLAYER_ID=>'PlayerId', PAY_TABLE_TIME=>'PayTimeStr');

echo '<table border="1"><tr>' ;
foreach ($tab_headers as $k=>$v) {
    echo '<th>'. $k . '</th>';
}
echo '</tr>';

function get_pay_list($dbc, $table_name, $player_id, $order_id, $tab_headers) {
    $result;
    if ($player_id != "") {
        $result=mysqli_query($dbc, "select * from $table_name where PlayerId=".$player_id.";");
    } else {
        $result=mysqli_query($dbc, "select * from $table_name where OrderId=".$order_id.";");
    }
    while ($row=mysqli_fetch_array($result)) {
        $order_id = $row[$tab_headers[PAY_TABLE_ORDER_ID]];
        $bundle_id = $row[$tab_headers[PAY_TABLE_BUNDLE_ID]];
        $account = $row[$tab_headers[PAY_TABLE_ACCOUNT]];
        $player_id = $row[$tab_headers[PAY_TABLE_PLAYER_ID]];
        $start_time = $row[$tab_headers[PAY_TABLE_TIME]];
        echo '<tr><td>' . $order_id . '</td><td>' . $bundle_id . '</td><td>' . $account . '</td><td>' . $player_id . '</td><td>' . $start_time . '</td></tr>';
    }
}

get_pay_list($dbc, 'ApplePays', $player_id, $order_id, $tab_headers);
get_pay_list($dbc, 'GooglePays', $player_id, $order_id, $tab_headers);

mysqli_close($dbc);

echo '</table>';

save_act("history", ACT_PLAYER_CHARGE_INFO, "player_charge_info", 1, $_SESSION["user_name"], "player_id($player_id) order_id($order_id)");

?>