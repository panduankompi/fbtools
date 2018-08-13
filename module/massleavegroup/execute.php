<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$userid = @$_SESSION['id'];
$token = @$_SESSION['token'];
$target = @$_POST['target'];
$target_count = count($target);
$count_kali = 100 / $target_count;
$delay = @$_POST['delay'];

if ($target == 0) {
	$response = array('message' => 'error', 'progress' => 100, 'code' => 'Silahkan Pilih Data Untuk Di proses !');
	echo json_encode($response);
	exit;
}

$success = 0;
$error = 0;
$nomor = 0;
foreach ($target as $key => $groupid) {	

	$url = "https://graph.facebook.com/{$groupid}/members?member={$userid}&method=DELETE&access_token={$token}";
	$curl = file_get_contents_curl($url);
	$result = json_decode($curl);

	if ($result == 'true') {
		$success = $success + 1;
	}else {
		$error = $error + 1;
	}

	sleep($delay);	
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. execute group id : ' . $groupid, 'progress' => $processed);
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