<?php
include 'http_send.php';
include 'format_gm_cmd.php';
include 'config.php';

session_start();
$login_state = $_SESSION['login_state'];
if ($login_state <= 0) {
    echo("错误信息: 没有登陆");
    header('Location: ../login.html');
    return;
}

$guild_id=$_POST["guild_id"];
$cmd = array('GuildId'=>intval($guild_id));
$jd = json_encode($cmd);
$bd = base64_encode($jd);
$data = format_gmcmd(9, $bd, "guild_info");
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
    echo("返回错误码: " . $res);
} else {
    $guild_info = base64_decode($jsd->{'Data'});
    echo $guild_info;
}

save_act("history", ACT_GUILD_INFO, "guild_info", $res, $_SESSION["user_name"], "guild_id($guild_id)");

?>