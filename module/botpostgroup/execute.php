<?php  
if (@$_POST['botpostgroup']) {

	if (empty($_POST['target']) AND !empty($_POST['status'])) {
		sweetalert('Grup belum dipilih!','error');		
		header("Location: ./?module=botpostgroup");
		exit;		
	}else {

		$id = $_SESSION['id'];
		$name = $_SESSION['name'];
		$token = $_SESSION['token'];
		$status = !empty($_POST['status']) ? $_POST['status'] : 'Tidak Aktif';
		$postmessage = $_POST['postmessage'];
		$group = $_POST['target'];
		$jam = date('H',mktime($_POST['jam'],00,00));

		if (file_exists('files/database.json')) {

			$data = file_get_contents('files/database.json');
			$data = json_decode($data);

			foreach ($data as $key => $value) {
				if ($id == @$data[$key]->id) {

					$pesan = !empty($data[$key]->botpostgroup->pesan) ? $data[$key]->botpostgroup->pesan: 'Baru Dibuat';
					$lastrun = !empty($data[$key]->botpostgroup->lastrun) ? $data[$key]->botpostgroup->lastrun: '';

					$botpostgroup = array(
						'status' => $status,
						'postmessage' => $postmessage,
						'group' => $group,
						'jam'  => $jam,
						'pesan' => $pesan,
						'lastrun' => $lastrun
						);

					inputjson(
						$id,
						$name,
						$token,
						$data[$key]->botreaction,
						$botpostgroup,
						$key
						);	

					sweetalert('Berhasil Disimpan! Memperbarui Data','success');	
					header("Location: ./?module=laporan");
					exit;						
				}
			}
		}
		
	}

}
?>