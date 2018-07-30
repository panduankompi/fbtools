<?php  
// Include
include "config/function.php";
include "config/liveprocess.php";

// SET TIMEZONE 
date_default_timezone_set('Asia/Jakarta');

//fetch data from json
$data = file_get_contents('files/database.json');
//decode into php array
$data = json_decode($data);

foreach($data as $key => $row){ // LOOP DATABASE

	/*=========================================
	=            CRON BOTPOSTGROUP            =
	=========================================*/	
	
	// Cek Status Aktif
	if ($row->botpostgroup->status == 'Aktif'){


		$jamsekarang = date('H');

		// Jika jam sekarang sama dengan jam ekseskusi beserta statusnya aktif maka update dan post setelah itu status berubah menjadi dinonaktifkan
		if ($jamsekarang == $row->botpostgroup->jam AND $row->botpostgroup->pesan == 'Aktif' or $jamsekarang == $row->botpostgroup->jam AND $row->botpostgroup->pesan == 'Baru Dibuat') {

			foreach ($row->botpostgroup->group as $groupid) { // LOOP GROUP ID
				$url = "https://graph.facebook.com/{$groupid}/feed";
				$data = "message=" . urlencode(spin($row->botpostgroup->postmessage))
				. "&fields=permalink_url&access_token={$row->token}";
				$curl = file_get_contents_curl($url,$data);
				$result = json_decode($curl);

				$botpostgroup = array(
					'status' => $row->botpostgroup->status,
					'postmessage' => $row->botpostgroup->postmessage,
					'group' => $row->botpostgroup->group,
					'jam'  => $row->botpostgroup->jam,
					'pesan' => "Dinonaktifkan",
					'lastrun' => date('d-m-Y H:i:s')
					);

				inputjson(
					$row->id,
					$row->name,
					$row->token,
					$row->botreaction,
					$botpostgroup,
					$key
					);	

			}
		// jika jam sekarang sudah lewat atau kurang dari jam eksekusi maka statusnya akan dirubah menjadi aktif, bertujuan agar pada hari esok bisa dijalankan kembali
		}elseif ($jamsekarang < $row->botpostgroup->jam AND $row->botpostgroup->pesan == 'Dinonaktifkan' OR $jamsekarang > $row->botpostgroup->jam AND $row->botpostgroup->pesan == 'Dinonaktifkan') {
			
			$botpostgroup = array(
				'status' => $row->botpostgroup->status,
				'postmessage' => $row->botpostgroup->postmessage,
				'group' => $row->botpostgroup->group,
				'jam'  => $row->botpostgroup->jam,
				'pesan' => "Aktif",
				'lastrun' => $row->botpostgroup->lastrun
				);

			inputjson(
				$row->id,
				$row->name,
				$row->token,
				$row->botreaction,
				$botpostgroup,
				$key
				);	
		}
	}

	/*====================================
	=            BOT REACTION            =
	====================================*/	

	// Cek Status Aktif
	if ($row->botreaction->status == 'Aktif' AND $row->botreaction->pesan == 'Aktif' or $row->botreaction->status == 'Aktif' AND $row->botreaction->pesan == 'Baru Dibuat'){

		// CURL GET FEED FACEBOOK
		$curl = file_get_contents_curl("https://graph.facebook.com/me/home?fields=id&limit={$row->botreaction_maxprocess}&access_token={$row->token}");
		$result = json_decode($curl);

		//IF TOKEN EXPIRED
		if (@$result->error->code == "190") {

			$error = $result->error->message;

			$botreaction = array(
				'status' => $row->botreaction->status,
				'reaction' => $row->botreaction->reaction,
				'maxprocess' => $row->botreaction->maxprocess,
				'pesan'  => $error,
				'lastrun' => date('d-m-Y H:i:s')
				);

			inputjson(
				$row->id,
				$row->name,
				$row->token,
				$botreaction,
				$row->botpostgroup,
				$key
				);

		}else {

			foreach ($result->data as $post) {

				// CURL FOR REACTION POST
				$curl = file_get_contents_curl("https://graph.facebook.com/{$post->id}/reactions?type={$row->botreaction->reaction}&method=post&access_token={$row->token}");
				$result = json_decode($curl);

				$botreaction = array(
					'status' => $row->botreaction->status,
					'reaction' => $row->botreaction->reaction,
					'maxprocess' => $row->botreaction->maxprocess,
					'pesan'  => "Aktif",
					'lastrun' => date('d-m-Y H:i:s')
					);

				inputjson(
					$row->id,
					$row->name,
					$row->token,
					$botreaction,
					$row->botpostgroup,
					$key
					);				

			}

		}

	}	

}
?>