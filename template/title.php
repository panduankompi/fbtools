<?php  
// Title Declaration
switch (@$_GET['module']) {

	case 'massdeletestatus':
	$title = "Mass Delete Status";
	break;

	case 'bomlike':
	$title = "Bom Like";
	break;

	case 'addfriend':
	$title = "Add Friend ". $groupname = !empty($_GET['groupname']) ? "From Group <b>".$_GET['groupname']."</b>" : '';
	break;

	case 'massunfriend':
	$title = "Mass Unfriend";
	break;

	case 'friendrequest':
	$title = "Friend Request";
	break;

	case 'joingroup':
	$title = "Join Grup". $q = !empty($_GET['q']) ? " Hasil Query : <b>".$_GET['q']."</b>" : 'From Search Result';
	break;

	case 'massleavegroup':
	$title = "Mass Leave Group";
	break;

	case 'massdeletepostgroup':
	$title = "Mass Delete Post Group ". $groupname = !empty($_GET['groupname']) ? "<b>".$_GET['groupname']."</b>" : '';;
	break;

	case 'masscomment':
	$title = "Mass Comment";
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
<title><?= $title ?></title>   