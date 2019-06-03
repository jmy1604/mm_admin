<?php 

function generate_result_html($find, $replace, $source_file, $dest_file) {
    $fp = fopen($source_file, "r"); 
    if ($fp != null) {
        $content = fread($fp, filesize($source_file)); 
        for ($i=0; $i<count($find); $i++) {
            $content = str_replace($find[$i], $replace[$i], $content); 
        }
        $handle = fopen($dest_file, "w"); //打开文件指针，创建文件 
        if (!is_writable($dest_file)) { 
            echo("文件：".$dest_file."不可写，请检查其属性后重试！");
            return false;
        } 
        if (!fwrite($handle, $content)) { //将信息写入文件 
            echo("生成文件".$dest_file."失败！"); 
            return false;
        } 
        fclose($handle); //关闭指针
        echo("创建文件".$dest_file."成功！"); 
    }
    return true;
}

function check_and_generate_result_html($find, $replace, $source_file, $dest_file) {
    if (!file_exists($dest_file)) {
        if (!generate_result_html($find, $replace, $source_file, $dest_file)) {
            return false;
        }
    }
    return true;
}

?> 