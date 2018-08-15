<hr>
<h3>
	Bot Post Group
</h3>
<table class="tabledefault">
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
				if (@$row->botpostgroup->status == 'Aktif') {
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