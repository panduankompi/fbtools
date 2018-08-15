<?php  
if (@$_POST['saveaccount']) {

	$id = $_SESSION['id'];
	$name = $_SESSION['name'];
	$token = $_SESSION['token'];
	$status = !empty($_POST['status']) ? $_POST['status'] : 'Tidak Aktif';
	$reaction = $_POST['reaction'];
	$maxprocess = $_POST['maxprocess'];

	if (file_exists('files/database.json')) {

		$data = file_get_contents('files/database.json');
		$data = json_decode($data);

		foreach ($data as $key => $value) {
			if ($id == @$data[$key]->id) {

				$pesan = !empty($data[$key]->botreaction->pesan) ? $data[$key]->botreaction->pesan: 'Baru Dibuat';
				$lastrun = !empty($data[$key]->botreaction->lastrun) ? $data[$key]->botreaction->lastrun: '';

				$botreaction = array(
					'status' => $status,
					'reaction' => $reaction,
					'maxprocess' => $maxprocess,
					'pesan'  => $pesan,
					'lastrun' => $lastrun
					);

				inputjson(
					$id,
					$name,
					$token,
					$botreaction,
					$data[$key]->botpostgroup,
					$key
					);	


				sweetalert('Berhasil Disimpan! Memperbarui Data','success');
				header("Location: ./?module=laporan");
				exit;
			}
		}
	}
}
?>