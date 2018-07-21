<h3 class="post-title">
	Bot Post Group
</h3>
<div class="post-meta">
	<span>
		Tools ini berfungsi untuk posting di group secara otomatis, minimal 1x sehari
	</span>            
</div>

<div class="post-content">

	<!-- content -->
	<form class='formtablecheckbox' method="post">
		<br/><label>Status Aktif : </label><br/>
		<label class="switch">
			<input type="checkbox" name="status" value="Aktif">
			<span class="slider round"></span>
		</label>
		<br/><br/>
		<label><b>Status yang ingin dibagikan : </b></label><br/>
		<textarea name="postmessage" rows="5" cols="50" placeholder="Insert Message" required="">{hai|hallo|hei hei|ok} {semuanya|kawan-kawan|anggota group} {bagaimana kabarnya|bagaimana keadaanmu sekarang|apakah kalian sehat} ?</textarea>

		<label><b>Pilih Waktu Posting : </b></label><br/>
		<select name="jam" class="chosen" style="min-width:200px">
			<?php
			for ($i=1; $i <= 24 ; $i++) { 
				echo "<option value='{$i}'>".date('H A', mktime($i,0,0))."</option>";
			}					
			?>
		</select>

		<br/><br/><label><b>Pilih Group dengan mengklik gambarnya : </b></label>
		<!-- content -->
		<table class="tablecheckbox">
			<thead>
				<tr>
					<th></th>
					<th>Nama Group</th>
					<th>Jumlah Anggota</th>
					<th>URL</th>
				</tr>
			</thead>
			<tbody>
				<?php  
				$url = "https://graph.facebook.com/me/groups?fields=name,members.limit(0).summary(true)&access_token={$_SESSION['token']}";

				$curl = file_get_contents_curl($url);
				$result = json_decode($curl);
				?>
				<?php
				foreach ($result->data as $row) {		
					echo "
					<tr>
						<td style='width:5%'>".$row->id."</td>
						<td>".$row->name."</td>
						<td>".number_format($row->members->summary->total_count)."</td>
						<td><a target='_blank' href='https://fb.com/".$row->id."'><button type='button'>Kunjungi</button></a></td>
					</tr>
					";
				}
				?>
			</tbody>
		</table>
		<input id="botpostgroup" name="botpostgroup" type="submit" value="Simpan">
	</form>

</div>

<?php  
include "execute.php";
?>