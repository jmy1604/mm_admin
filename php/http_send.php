<?php

require_once 'third_party/Requests/library/Requests.php';

Requests::register_autoloader();

function RequestsPost($url, $query)
{
    $header = array('Content-type'=>'application/x-www-form-urlencoded');
    $result = Requests::post($url, $header, $query);
    return $result;
}

function RequestsGet($url, $query)
{
    $header = array('Content-type'=>'application/x-www-form-urlencoded');
    $result = Requests::get($url, $header);
    return $result;
}

function sock_post($url, $query) 
{ 
    $info = parse_url($url); 
    $fp = fsockopen($info['host'], $info["port"], $errno, $errstr, 3); 
    $head = "POST ".$info['path']." HTTP/1.0\r\n"; 
    $head .= "Host: ".$info['host']."\r\n"; 
    $head .= "Referer: http://".$info['host'].$info['path']."\r\n"; 
    $head .= "Content-type: application/x-www-form-urlencoded\r\n"; 
    $head .= "Content-Length: ".strlen(trim($query))."\r\n"; 
    $head .= "\r\n"; 
    $head .= trim($query);
    $write = fputs($fp, $head); 
    //print_r(fgets($fp));
    while (!feof($fp)) 
    { 
        $line = fgets($fp); 
        echo $line."<br>"; 
    } 
} 

?>