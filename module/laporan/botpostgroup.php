<h3 class="post-title">
	Laporan Bot Post Group
</h3>
<div class="post-meta">
	<span>dibawah ini adalah data user yang menggunakan aplikasi bot post group</span>            
</div>

<div class="post-content">
	
	<!-- content -->
	<table class="tableUser">
		<thead>
			<tr>
				<th>Nama</th>
				<th>Last Run</th>
				<th>Post Jam</th>
				<th>Post Mesage</th>
				<th>Pesan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (file_exists('files/database.json')) {

				$data = file_get_contents('files/database.json');
				$data = json_decode($data);

				foreach($data as $row){
					if ($row->botpostgroup->status == 'Aktif') {
						$lastrun = !empty($row->botreaction->lastrun) ? dateid($row->botreaction_lastrun) : '';

						echo "
						<tr>
							<td>".$row->name."</td>
							<td>".$lastrun."</td>
							<td>".$row->botpostgroup->jam."</td>
							<td>".truncate($row->botpostgroup->postmessage, 25)."</td>
							<td>".$row->botpostgroup->pesan."</td>
						</tr>
						";
					}				

				}
			}
			?>
		</tbody>
	</table>

</div>