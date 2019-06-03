<?php
include 'http_send.php';
include 'format_gm_cmd.php';
include 'config.php';
include "act.php";

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

$content=$_POST["Content"];
$duration=$_POST["Duration"];
$cmd = array('Content'=>base64_encode($content), 'RemainSeconds'=>intval($duration));
$jd = json_encode($cmd);
$bd = base64_encode($jd);
$data = format_gmcmd(1, $bd, "anounce");
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
    echo("错误信息". $res);
} else {
    echo("操作成功");
}

$qian=array(" ", "  ", "\n","\r");
$content = str_replace($qian, '', $content);
save_act("history", ACT_ANOUNCEMENT, "anouncement", $res, $_SESSION["user_name"], "content($content) duration($duration)");

?>