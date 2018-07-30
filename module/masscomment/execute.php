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
$postimages =  @$_POST['postimages'];
$postimagesX = explode("||", $postimages);

$success = 0;
$error = 0;
for ($i=1; $i <= $max; $i++) { 
	
	$postmessage = (@$_POST['postmessage'] == 'massup' ? urlencode("up ".base64_encode(rand(000,999))) : @$_POST['postmessage'] == 'massnumb' ? rand(000000000,999999999) : spin(@$_POST['postmessage']));

	sleep($delay);	
	$jsonresult = array('process' => "Sedang Mengirim Komentar dengan pesan ".' : '. $postmessage . " <img src='data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7'/>");
	echo json_encode($jsonresult);	

	
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

	sleep(1);
	$jsonresult = array('result' => $result_progress, 'process' => "Selesai Mengirim dengan pesan ".' : '. $postmessage . " <img src='data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7'/>");
	echo json_encode($jsonresult);	
}

sleep(1);
$jsonresult = array('process' => "<script>sweetAlert('Berhasil Memproses Permintaan!', 'Success : ".$success." | Error : ".$error."', 'success')</script>");
echo json_encode($jsonresult);
?>