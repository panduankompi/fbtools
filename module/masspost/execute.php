<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$token = @$_SESSION['token'];
$type =  @$_POST['type'];
$postlink = $_POST['postlink'];
$delay = @$_POST['delay'];
$target = @$_POST['target'];
$target_count = count($target);
$count_kali = 100 / $target_count;
$postdate = strtotime($_POST['postdate']);

if ($target == 0) {
	$response = array('message' => 'error', 'progress' => 100, 'code' => 'Silahkan Pilih Target Untuk Di proses !');
	echo json_encode($response);
	exit;
}

$success = 0;
$error = 0;
$nomor = 0;
foreach ($target as $targetid) {	

	$postmessage = spin(@$_POST['postmessage']);

	if (!empty($postlink)) {
		$data = array(
			'message' => $postmessage, 			
			'link' => $postlink,
			'access_token' => $token, 
			);
	}else {
		$data = array(
			'message' => $postmessage, 
			'access_token' => $token, 
			);
	}
	$url = "https://graph.facebook.com/{$targetid}/feed";
	$curl = file_get_contents_curl($url,$data);
	$result = json_decode($curl);

	if ($result->id == true) {
		$success = $success + 1;
	}else {
		$error = $error + 1;
	}

	sleep($delay);	
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. execute post with message : ' . $targetid, 'progress' => $processed);
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