<?php
include 'http_send.php';
include 'format_gm_cmd.php';
include 'config.php';

session_start();
$login_state = $_SESSION["login_state"];
if ($login_state <= 0) {
    echo("错误信息: 没有登陆");
    header('Location: ../login.html');
    return;
}

$num=$_POST["Num"];
$string=$_POST["String"];

$cmd = array('StringValue'=>$string, 'NumValue'=>intval($num));
$jd = json_encode($cmd);
$bd = base64_encode($jd);
$data = format_gmcmd(0, $bd, "test");
$result = RequestsPost(get_gm_url(), $data);
if ($result->status_code != 200) {
    echo("错误信息: http请求失败");
    return;
}

echo("操作完成");

?>