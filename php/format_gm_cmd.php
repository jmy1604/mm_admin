<?php

function format_gmcmd($msg_id, $msg_data, $msg_str) {
    $a = array('Id'=>$msg_id, 'Data'=>$msg_data, 'String'=>$msg_str);
    return json_encode($a);
}

?>