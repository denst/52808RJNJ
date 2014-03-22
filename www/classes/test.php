<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $file = fopen($_SERVER['DOCUMENT_ROOT']."/data/".'advertisements_portal.txt',"w+");
    fwrite($file,'test');
    fclose($file);
?>
