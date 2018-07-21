<?php  
include "session.php";
include "function.php";

// SET TIMEZONE 
date_default_timezone_set('Asia/Jakarta');

$settings['title'] = 'FB Tools';
$settings['desc'] = 'Tools Lite Facebook';
$settings['author'] = 'Irfaan Programmer';
$baseurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Title Declaration
switch (@$_GET['module']) {

	case 'massdeletestatus':
	$title = "Mass Delete Status";
	break;

	case 'bomlike':
	$title = "Bom Like";
	break;

	case 'addfriend':
	$title = "Add Friend";
	break;

	case 'massunfriend':
	$title = "Mass Unfriend";
	break;

	case 'friendrequest':
	$title = "Friend Request";
	break;

	case 'joingroup':
	$title = "Join Grup";
	break;

	case 'massleavegroup':
	$title = "Mass Leave Group";
	break;

	case 'scrapeuid':
	$title = "Scrape UID";
	break;

	case 'profileguard':
	$title = "Profile Guard";
	break;

	case 'botreaction':
	$title = "Bot Reaction";
	break;
	case 'botreactionmemperbarui':
	$title = "Memperbarui Bot Reaction";
	break;

	case 'botpostgroup':
	$title = "Bot Post Group";
	break;

	case 'laporan':
	$title = "Laporan";
	break;

	case 'masuk':
	$title = "Masuk";
	break;
	default:
	if (!empty($_SESSION['masuk'])) {
		$title = "Dashboard";
	}else {
		$title = $settings['title'];
	}
	break;
}
?>