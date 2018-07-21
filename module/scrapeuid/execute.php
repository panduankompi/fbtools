<?php  

ob_implicit_flush(true);
ob_end_flush();
error_reporting(0);

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
set_time_limit(0);

session_start();

include "../../config/function.php";

$token = $_SESSION['token'];
$postid = "231459584130583";

$url = "https://graph.facebook.com/{$postid}?fields=reactions.summary(true).limit(100)&access_token={$token}";

$curl = file_get_contents_curl($url);
$result = json_decode($curl);

// if (!empty($result->error)) {
// 	$error = $result->error->message;
// 	$result_progress = $error;
// 	$jsonresult = array('result' => $result_progress, 'process' => '');
// 	echo json_encode($jsonresult);
// 	exit;	
// }else {		

	echo "<textarea>";
foreach ($result->reactions->data as $row) {		
	
	sleep(1);
	$jsonresult = array('result' => $row->id, 'process' => "HAHAHAHAHA".' : '. $row->id);
	echo json_encode($jsonresult);	

}
	echo "</textarea>";

// }

// sleep(1);
// $jsonresult = array('result' => '', 'process' => "HAHAHAHAHA");
// echo json_encode($jsonresult);
?>