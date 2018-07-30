<?php  
if (empty($_SESSION['masuk']) AND @$_GET['module']) {
	if ($_GET['module'] == 'laporan') {
		include "module/laporan/index.php";
	}elseif ($_GET['module'] == 'masuk') {
		include "module/masuk/index.php";
	}
	else {
		$_SESSION['execute'] = "<script> sweetAlert('Ehmm!', 'By Passed Detected!', 'error').then(function() {window.location = './?module=masuk'; }); </script>";
	}
}else {
	switch (@$_GET['module']) {

		case 'massdeletestatus':
		include "module/massdeletestatus/index.php";
		break;

		case 'bomlike':
		include "module/bomlike/index.php";
		break;

		case 'addfriend':
		include "module/addfriend/index.php";
		break;

		case 'massunfriend':
		include "module/massunfriend/index.php";
		break;

		case 'friendrequest':
		include "module/friendrequest/index.php";
		break;

		case 'joingroup':
		include "module/joingroup/index.php";
		break;

		case 'massleavegroup':
		include "module/massleavegroup/index.php";
		break;

		case 'massdeletepostgroup':
		include "module/massdeletepostgroup/index.php";
		break;

		case 'masscomment':
		include "module/masscomment/index.php";
		break;

		case 'profileguard':
		include "module/profileguard/index.php";
		break;

		case 'botreaction':
		include "module/botreaction/index.php";
		break;
		case 'botreactionmemperbarui':
		include "module/botreaction/memperbarui/index.php";
		break;

		case 'botpostgroup':
		include "module/botpostgroup/index.php";
		break;

		case 'laporan':
		include "module/laporan/index.php";
		break;

		case 'masuk':
		include "module/masuk/index.php";
		break;

		case 'keluar':
		include "module/keluar/index.php";
		break;

		default:
		include "module/dashboard/index.php";
		break;
	}
}
?>