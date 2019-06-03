<?php
    session_start();
    $login_state = $_SESSION['login_state'];
    if ($login_state <= 0) {
        echo("错误信息: 没有登陆");
        header('Location: ../login.html');
    } else {
        echo '<h1>MM Admin</h1>
    <a href="test.html">测试</a><br>
    <a href="anounce.html">系统公告</a></br>
    <a href="mail.html">邮件</a></br>
    <a href="player_info.html">玩家信息</a><br>
    <a href="online_player_num.html">在线玩家人数</a><br>
    <a href="month_card_send.html">月卡发放</a><br>
    <a href="ban_player.html">封号</a><br>
    <a href="player_charge_info.html">玩家充值信息</a><br>';
        $permission = $_SESSION['permission'];
        if ($permission > 1) {
            echo '<a href="history.html">历史</a><br><br>';
        }
    }
?>