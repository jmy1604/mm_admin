<?php

define("ACT_ANOUNCEMENT", 1);
define("ACT_ADD_ITEMS", 2);
define("ACT_SYS_MAIL", 3);
define("ACT_PLAYER_INFO", 4);
define("ACT_ONLINE_PLAYER_NUM", 5);
define("ACT_MONTH_CARD_SEND", 6);
define("ACT_BAN_PLAYER", 7);
define("ACT_BAN_LIST", 8);
define("ACT_GUILD_INFO", 9);
define("ACT_GUILD_LIST", 10);
define("ACT_PLAYER_CHARGE_INFO", 11);

function save_act($table_name, $act_id, $act_name, $act_result, $act_account, $detail) {
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

    $sql = "insert into $table_name (act_id, act_name, act_result, act_account, detail) values ($act_id, '$act_name', $act_result, '$act_account', '$detail');";
    //echo "save act sql: " . $sql;
    $result = mysqli_query($dbc, $sql); 
    if(!$result){
        echo "ERROR:". mysqli_error($dbc);
        return;    
    }
    mysqli_close($dbc);
}

?>