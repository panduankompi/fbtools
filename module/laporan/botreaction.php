<h3>Bot Reaction</h3>
<table class="tabledefault">
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