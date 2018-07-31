<?php  
include "session.php";
include "function.php";
include "timezone.php";

$settings['title'] = 'FB Tools';
$settings['desc'] = 'Tools Lite Facebook';
$settings['author'] = 'Irfaan Programmer';
$baseurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>