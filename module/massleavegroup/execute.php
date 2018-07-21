<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$userid = @$_SESSION['id'];
$token = @$_SESSION['token'];
$target = @$_POST['target'];
$delayprocess = @$_POST['delayprocess'];

$success = 0;
$error = 0;
foreach ($target as $key => $groupid) {
	$nomor = $key + 1;		

	$jsonresult = array('process' => "Sedang Memproses Keluar Group dengan id".' : '. $groupid . " <img src='data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7'/>");
	echo json_encode($jsonresult);	
	sleep($delayprocess);	

	$url = "https://graph.facebook.com/{$groupid}/members?member={$userid}&method=DELETE&access_token={$token}";
	$curl = file_get_contents_curl($url);
	$result = json_decode($curl);

	if ($result == 'true') {
		$success = $success + 1;
	}else {
		$error = $error + 1;
	}

	sleep(1);
	$jsonresult = array('process' => "Selesai Memproses Keluar Group dengan id".' : '. $groupid . " <img src='data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7'/>");
	echo json_encode($jsonresult);	

}

sleep(1);
$jsonresult = array('process' => "<script>sweetAlert('Berhasil Memproses Permintaan!', 'Success : ".$success." | Error : ".$error."', 'success').then(function() {window.location = './?module=massleavegroup'; })</script>");
echo json_encode($jsonresult);
?>