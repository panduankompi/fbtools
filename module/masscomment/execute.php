<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$posturl = @$_POST['postid'];
$postidsearch =  preg_match('/[^\/|\.!=][0-9]{7,}(?!.*[0-9]{7,})\d+/',$posturl,$matches);
$postid = $matches[0];
$token = @$_SESSION['token'];
$delay = @$_POST['delay'];
$max = @$_POST['max'];
$count_kali = 100 / $max;
$postimages =  @$_POST['postimages'];
$postimagesX = explode("||", $postimages);

$success = 0;
$error = 0;
$nomor = 0;
for ($i=1; $i <= $max; $i++) { 
	
	if ($postmessage !== 'massup' or $postmessage !== 'massnumb') {
		$postmessage = spin(@$_POST['postmessage']);
	}else {		
		$postmessage = (@$_POST['postmessage'] == 'massup' ? urlencode("up ".base64_encode(rand(000,999))) : rand(000000000,999999999));
	}
	
	if (!empty($postimages)) {
		$rand = array_rand($postimagesX);
		$postimagesrand = $postimagesX[$rand];
		$url = "https://graph.facebook.com/{$postid}/comments?method=POST&attachment_url={$postimagesrand}&message={$postmessage}&access_token={$token}";
	}else {
		$url = "https://graph.facebook.com/{$postid}/comments?method=POST&message={$postmessage}&access_token={$token}";
	}
	$curl = file_get_contents_curl($url);
	$result = json_decode($curl);

	if ($result->id) {
		$success = $success + 1;
	}else {
		$error = $error + 1;
	}

	sleep($delay);	
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. Selesai Mengirim dengan pesan : '. $postmessage, 'progress' => $processed);
	echo json_encode($response);	
	flush();

	if ($max === 1) {
		sleep(1);
	}

	$nomor++;
}

sleep(1);
$response = array('message' => 'Complete', 'progress' => 100, 'success' => $success, 'error' => $error);
echo json_encode($response);
?>