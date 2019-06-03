<?php

function get_config() {
    global $config;
    if ($config == null) {
       $jd = file_get_contents("../config.json");
       if ($jd == null) {
            echo "not found config.json";
            return null;
       }
       $config= json_decode($jd);
    }
    return $config;
}

function get_gm_url() {
    $c = get_config();
    if ($c == null) {
        return "";
    }
    $gm_server_ip = $c->GMServerIP;
    return "http://" . $gm_server_ip . "/gm";
}

?>