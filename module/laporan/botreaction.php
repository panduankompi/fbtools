<h3 class="post-title">
	Laporan Bot Reaction
</h3>
<div class="post-meta">
	<span>dibawah ini adalah data user yang menggunakan aplikasi bot reaction</span>            
</div>

<div class="post-content">
	
	<!-- content -->
	<table class="tableUser">
		<thead>
			<tr>
				<th>Nama</th>
				<th>Last Run</th>
				<th>Max</th>
				<th>Reaction</th>
				<th>Pesan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (file_exists('files/database.json')) {

				$data = file_get_contents('files/database.json');
				$data = json_decode($data);

				foreach($data as $row){
					if (@$row->botreaction->status == 'Aktif') {
						$lastrun = !empty($row->botreaction->lastrun) ? dateid($row->botreaction->lastrun) : '';
						echo "
						<tr>
							<td>".$row->name."</td>
							<td>".$lastrun."</td>
							<td>".$row->botreaction->maxprocess."</td>
							<td>".$row->botreaction->reaction."</td>
							<td>".$row->botreaction->pesan."</td>
						</tr>
						";
					}

				}
			}
			?>
		</tbody>
	</table>

</div>