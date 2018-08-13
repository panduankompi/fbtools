<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$token = @$_SESSION['token'];
$people = @$_POST['people'];
$max = @$_POST['max'];
$count_kali = 100 / $max;
$delay = @$_POST['delay'];

$curl = file_get_contents_curl("https://graph.facebook.com/{$people}/feed?fields=id,permalink_url,object_id&limit={$max}&access_token={$token}");
$result = json_decode($curl);

sleep(1);
$response = array('message' => 'Sedang Mengambil Status...', 'progress' => 100);
echo json_encode($response);

$success = 0;
$error = 0;
$nomor = 0;
foreach ($result->data as $key => $row) {
	$new_link = str_replace('fb.me', 'fb.com', urldecode($row->permalink_url));
	$short_link = substr($new_link, 0,80);

	$url = "https://graph.facebook.com/{$row->id}/likes?method=post&access_token={$token}";
	$curl = file_get_contents_curl($url);
	$result = json_decode($curl);

	if (@$result->error) {
		$error = $error + 1;
	}else {
		$success = $success + 1;
	}

	sleep($delay);	
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. execute post id : ' . $row->id, 'progress' => $processed);
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