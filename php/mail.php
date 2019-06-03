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

$permission = $_SESSION['permission'];
if ($permission < 1) {
    echo("权限不够");
    return;
}

$MailID = $_POST["MailID"];
$ItemList = $_POST["ItemList"];
$PlayerId = $_POST["PlayerId"];

$items = explode(',', $ItemList);
if ($items == null) {
    echo("错误信息: 物品数组列表为空或者格式错误");
    return;
}

$item_list = array();
$item_num = count($items);
for ($i=0; $i<$item_num; $i++) {
    $item_list[$i] = intval($items[$i]);
}
$cmd = array('PlayerId'=>intval($PlayerId), 'MailTableID'=>intval($MailID), 'AttachItems'=>$item_list);
$jd = json_encode($cmd);
$bd = base64_encode($jd);
$data = format_gmcmd(3, $bd, "sys_mail");
$cfg = get_config();
if ($cfg == null) {
    echo("错误信息: get cfg failed");
    return;
}

$result = RequestsPost(get_gm_url(), $data);
if ($result->status_code != 200) {
    echo("错误信息: Http请求失败");
    return;
}

$jsd = json_decode($result->body);
if ($jsd == null) {
    echo("错误信息: 返回结果json解码失败");
    return;
}

$res = $jsd->{'Res'};
if ($res < 0) {
    echo("错误信息: " . $res);
} else {
    echo("操作成功");
}

save_act("history", ACT_SYS_MAIL, "sys_mail", $res, $_SESSION["user_name"], "player_id($PlayerId) mail_id($MailID) item_list($ItemList)");

?>