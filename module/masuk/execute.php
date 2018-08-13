<?php  
if (@$_POST['byaccount']) {

	// Declaration Variable
	$username = $_POST['username'];
	$password = $_POST['password'];

	// GET TOKEN IPHONE
	$data = array(
		"api_key" => "3e7c78e35a76a9299309885393b02d97",
		"email" => @$username,
		"format" => "JSON",
		//"generate_machine_id" => "1",
		//"generate_session_cookies" => "1",
		"locale" => "en_US",
		"method" => "auth.login",
		"password" => @$password,
		"return_ssl_resources" => "0",
		"v" => "1.0"
		);
	sign_creator($data);
	$response = cURL('GET', false, $data);
	$message = json_decode($response);

	if (@$message->error_msg) {
		sweetalert($message->error_msg,'error');
		header("Location: ./?module=masuk");
		exit;
	}else {
		
		// CURL 
		$api = file_get_contents_curl("https://graph.facebook.com/me?fields=name,picture&access_token={$message->access_token}");
		$result = json_decode($api);

		$id = $result->id;
		$name = $result->name;
		$token = $message->access_token;

		// IF SUCCESS CREATE SESSION
		$_SESSION['masuk'] = true;
		$_SESSION['id'] = $result->id;
		$_SESSION['name'] = $result->name;
		$_SESSION['picture'] = $result->picture;
		$_SESSION['token'] = $message->access_token;

		if (file_exists('files/database.json')) {
			//open the json file for checking
			$data = file_get_contents('files/database.json');
			$data = json_decode($data);

			$check = 'no';
			foreach ($data as $key => $value) {
				if ($result->id == @$data[$key]->id) {
					//JIKA CHECK DITEMUKAN MAKA UPDATE
					$check = 'yes';

					// JIKA CHECK DITEMUKAN DATA TIDAK DARI ULANG
					inputjson(
						$data[$key]->id,
						$name,
						$token,
						$data[$key]->botreaction,
						$data[$key]->botpostgroup,
						$key
						);	

					sweetalert('Berhasil Disimpan! Memperbarui Data','success');		
				}
			}

			// JIKA CHECK TIDAK DITEMUKAN MAKA BUAT BARU
			if ($check == 'no') {
				inputjson(
					$id,
					$name,
					$token
					);
				sweetalert('Berhasil Disimpan! Anggota Baru #2','success');		
			}
		}else {		
			inputjson(
				$id,
				$name,
				$token
				);
			sweetalert('Berhasil Disimpan! Anggota Baru #1','success');		
		}

		header("Location: ./");
		exit;

	}

}elseif (@$_POST['token']) {

	// Declaration Variable
	$token = $_POST['token'];

	// CURL VALIDATION IPHONE TOKEN
	$api = file_get_contents_curl("https://graph.facebook.com/app?access_token={$token}");
	$result = json_decode($api);
	$checkiphone = @$result->id;

	// CHECK TOKEN VALIDATION
	if (@$result->error->code == "190") {
		sweetalert($result->error->message,'error');		
		header("Location: ./?module=masuk");
		exit;
	}else {	
		if ($checkiphone == '6628568379') {
			// CURL
			$api = file_get_contents_curl("https://graph.facebook.com/me?fields=name,picture&access_token={$token}");
			$result = json_decode($api);

			$id = $result->id;
			$name = $result->name;

			// IF SUCCESS CREATE SESSION
			$_SESSION['masuk'] = true;
			$_SESSION['id'] = $result->id;
			$_SESSION['name'] = $result->name;
			$_SESSION['picture'] = $result->picture;
			$_SESSION['token'] = $token;

			if (file_exists('files/database.json')) {
				//open the json file for checking
				$data = file_get_contents('files/database.json');
				$data = json_decode($data);

				$check = 'no';
				foreach ($data as $key => $row) {
					if ($result->id == @$data[$key]->id) {
						//JIKA CHECK DITEMUKAN MAKA UPDATE
						$check = 'yes';

						// JIKA CHECK DITEMUKAN DATA TIDAK DARI ULANG
						inputjson(
							$data[$key]->id,
							$data[$key]->name,
							$token,
							$data[$key]->botreaction,
							$data[$key]->botpostgroup,
							$key
							);	
						sweetalert('Berhasil Disimpan! Memperbarui Data','success');		
					}
				}

				// JIKA CHECK TIDAK DITEMUKAN MAKA BUAT BARU
				if ($check == 'no') {
					inputjson(
						$id,
						$name,
						$token
						);
					sweetalert('Berhasil Disimpan! Anggota Baru #2','success');		
				}
			}else {		
				inputjson(
					$id,
					$name,
					$token
					);
				sweetalert('Berhasil Disimpan! Anggota Baru #1','success');		
			}

			header("Location: ./");
			exit;

		}else {
			sweetalert('Bukan Token Iphone Nih!','error');	
			header("Location: ./?module=masuk");
			exit;
		}
	}

}
?>