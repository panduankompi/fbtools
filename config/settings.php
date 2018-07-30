<?php  
include "session.php";
include "function.php";

// SET TIMEZONE 
date_default_timezone_set('Asia/Jakarta');

$settings['title'] = 'FB Tools';
$settings['desc'] = 'Tools Lite Facebook';
$settings['author'] = 'Irfaan Programmer';
$baseurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>