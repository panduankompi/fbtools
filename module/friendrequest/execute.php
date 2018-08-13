<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$userid = @$_SESSION['id'];
$token = @$_SESSION['token'];
$target = @$_POST['target'];
$target_count = count($target);
$count_kali = 100 / $target_count;
$action = @$_POST['action'];
$delay = @$_POST['delay'];

if ($target == 0) {
	$response = array('message' => 'error', 'progress' => 100, 'code' => 'Silahkan Pilih Data Untuk Di proses !');
	echo json_encode($response);
	exit;
}

$success = 0;
$error = 0;
$nomor = 0;
foreach ($target as $key => $userid) {

	if ($action == 'reject') {		
		$url = "https://graph.facebook.com/me/friends/{$userid}?method=POST&access_token={$token}";
		$curl = file_get_contents_curl($url);

		$url = "https://graph.facebook.com/me/friends/{$userid}?method=DELETE&access_token={$token}";
		$curl = file_get_contents_curl($url);
		$result = json_decode($curl);
	}elseif ($action == 'accept') {
		$url = "https://graph.facebook.com/me/friends/{$userid}?method=POST&access_token={$token}";
		$curl = file_get_contents_curl($url);
		$result = json_decode($curl);
	}

	if ($result == 'true') {
		$success = $success + 1;
	}else {
		$error = $error + 1;
	}

	sleep($delay);
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. execute user id : ' . $userid, 'progress' => $processed);
	echo json_encode($response);	
	flush();

	if ($target_count === 1) {
		sleep(1);
	}

	$nomor++;

}

sleep(1);
$response = array('message' => 'Complete', 'progress' => 100, 'success' => $success, 'error' => $error);
echo json_encode($response);
?>