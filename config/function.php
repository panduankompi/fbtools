<?php  
function inputjson($id = "", $name = "", $token = "", $botreaction = "", $botpostgroup = "", $key = "kosong"){
	
	$data = file_get_contents('files/database.json');
	$data = json_decode($data);
	
	$input = array(
		"id" => $id,
		"name" => $name,
		"token" => $token,
		"botreaction" => $botreaction,
		"botpostgroup" => $botpostgroup ,
		);


	if ($key !== 'kosong') {
		$data[$key] = $input;
	}else {
		$data[] = $input;
	}
	$data = json_encode($data, JSON_PRETTY_PRINT);
	file_put_contents('files/database.json', $data);

}

function sweetalert($message,$type,$redirect = false){

	if ($redirect !== false) {
		return $_SESSION['execute'] = "
		<script> 
			sweetAlert('Message !', '".$message."', '".$type."').then(function() {window.location = './".$redirect."'; });
		</script>";
	}else {
		return $_SESSION['execute'] = "
		<script> 
			sweetAlert('Message !', '".$message."', '".$type."');
		</script>";
	}

}

function spin($pass){
	$mytext = $pass;
	while(inStr("}",$mytext)){
		$rbracket = strpos($mytext,"}",0);
		$tString = substr($mytext,0,$rbracket);
		$tStringToken = explode("{",$tString);
		$tStringCount = count($tStringToken) - 1;
		$tString = $tStringToken[$tStringCount];
		$tStringToken = explode("|",$tString);
		$tStringCount = count($tStringToken) - 1;
		$i = rand(0,$tStringCount);
		$replace = $tStringToken[$i];
		$tString = "{".$tString."}";
		$mytext = str_replaceFirst($tString,$replace,$mytext);
	}
	return $mytext;
}
function str_replaceFirst($s,$r,$str){
	$l = strlen($str);
	$a = strpos($str,$s);
	$b = $a + strlen($s);
	$temp = substr($str,0,$a) . $r . substr($str,$b,($l-$b));
	return $temp;
}
function inStr($needle, $haystack){
	return @strpos($haystack, $needle) !== false;
}

function truncate($string, $limit) {
	if(strlen($string) > $limit) 
	{
		return substr($string, 0, $limit) . "..."; 
	}
	else 
	{
		return $string;
	}
}

function file_get_contents_curl($url, $post=null, $req=null) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	if ($req != null) {
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $req);
	}
	if($post != null) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function sign_creator(&$data){
	$sig = "";
	foreach($data as $key => $value){
		$sig .= "$key=$value";
	}
	$sig .= 'c1e620fa708a1d5696fb991c1bde5662';
	$sig = md5($sig);
	return $data['sig'] = $sig;
}

function cURL($method = 'GET', $url = false, $data){
	$c = curl_init();
	$user_agents = array(
		"Mozilla/5.0 (iPhone; CPU iPhone OS 9_2_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Mobile/13D15 Safari Line/5.9.5",
		"Mozilla/5.0 (iPhone; CPU iPhone OS 9_0_2 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Mobile/13A452 Safari/601.1.46 Sleipnir/4.2.2m","Mozilla/5.0 (iPhone; CPU iPhone OS 9_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13E199 Safari/601.1","Mozilla/5.0 (iPod; CPU iPhone OS 9_2_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/45.0.2454.89 Mobile/13D15 Safari/600.1.4","Mozilla/5.0 (iPhone; CPU iPhone OS 9_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13E198 Safari/601.1"
		);
	$useragent = $user_agents[array_rand($user_agents)];
	$opts = array(
		CURLOPT_URL => ($url ? $url : 'https://api.facebook.com/restserver.php').($method == 'GET' ? '?'.http_build_query($data) : ''),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_USERAGENT => $useragent
		);
	if($method == 'POST'){
		$opts[CURLOPT_POST] = true;
		$opts[CURLOPT_POSTFIELDS] = $data;
	}
	curl_setopt_array($c, $opts);
	$d = curl_exec($c);
	curl_close($c);
	return $d;
}

function dateid ($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
	if (trim ($timestamp) == '')
	{
		$timestamp = time ();
	}
	elseif (!ctype_digit ($timestamp))
	{
		$timestamp = strtotime ($timestamp);
	}
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace ("/S/", "", $date_format);
	$pattern = array (
		'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		'/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		'/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		'/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		'/April/','/June/','/July/','/August/','/September/','/October/',
		'/November/','/December/',
		);
	$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
		'Oktober','November','Desember',
		);
	$date = date ($date_format, $timestamp);
	$date = preg_replace ($pattern, $replace, $date);
	$date = "{$date} {$suffix}";
	return $date;
} 
?>