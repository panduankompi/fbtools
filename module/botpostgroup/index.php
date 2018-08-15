<form class='formtablecheckbox' method="post">
	<div class="row">
		<div class="col-md-6">

			<div class="form-group">
				<label>Status Aktif : </label>
				<label class="switch">
					<input type="checkbox" name="status" value="Aktif">
					<span class="slider round"></span>
				</label>
			</div>

			<div class="form-group">
				<label><b>Status yang ingin dibagikan : </b></label>
				<textarea class="form-control" name="postmessage" rows="5" cols="50" placeholder="Insert Message" required="">{hai|hallo|hei hei|ok} {semuanya|kawan-kawan|anggota group} {bagaimana kabarnya|bagaimana keadaanmu sekarang|apakah kalian sehat} ?</textarea>
			</div>

			<div class="form-group">
				<label><b>Pilih Waktu Posting : </b></label>
				<select class="form-control" name="jam" class="chosen">
					<?php
					for ($i=1; $i <= 24 ; $i++) { 
						echo "<option value='{$i}'>".date('H A', mktime($i,0,0))."</option>";
					}					
					?>
				</select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label><b>Pilih Group dengan mengklik gambarnya : </b></label>
				<table class="tablecheckbox_asc">
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
								<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$row->id."'>Kunjungi</a></td>
							</tr>
							";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="form-group">
		<input class="btn btn-primary" name="botpostgroup" type="submit" value="Submit">
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$('.formtablecheckbox').on('submit', function(e){
			var form=this,rows_selected=table_asc.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){
				$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))
			});
		})
	})
</script>
<?php  
include "execute.php";
?>