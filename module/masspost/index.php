<form class='formtablecheckbox' method="post">
	<div class="alert alert-warning alert-dismissible" role="alert">
		<strong>Perhatian !</strong> Jangan terlalu banyak melakukan post dalam waktu singkat atau facebook anda akan kena kunci ! <br>beri jeda waktu untuk mengirimnya.
	</div>
	<?php if (@isset($_GET['type'])): ?>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Pesan Komentar : Gunakan {kalimat1|kalimat2} untuk acak</label>
					<textarea onclick="this.select();" class="form-control" name="postmessage" rows="5" cols="50" required="">{kalimat1|kalimat2|kalimat3}</textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Type :</label>
					<input readonly="" value="<?= $_GET['type'] ?>" class="form-control" type="text" name="type">
				</div>
				<!-- <div class="form-group">
					<label>Atur Jadwal :</label>
					<input placeholder="Click to Pick Date" class="form-control" id="datetimepicker" type="postdate">
				</div> -->
				<div class="form-group">
					<label>Link : (optional)</label>
					<input onclick="this.select();" placeholder="https://example.com" class="form-control" type="url" name="postlink">
				</div>
			</div>
		</div>
	<?php endif ?>
	<?php if (@$_GET['type'] == 'profile'): ?>
		<div class="form-group">
			<label>Pilih User untuk mengirim post anda :</label>
			<table class="tablecheckbox_asc">
				<thead>
					<tr>
						<th></th>
						<th>Nama</th>
						<th>JK</th>
						<th>Location</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php  
					$url = "https://graph.facebook.com/me/friends?fields=location,gender,updated_time,name,picture&access_token={$_SESSION['token']}";

					$curl = file_get_contents_curl($url);
					$result = json_decode($curl);
					?>
					<?php
					foreach ($result->data as $row) {		
						$gender = !empty($row->gender) ? $row->gender : 'Tidak Diketahui';
						if ($gender == 'male') {$gender = 'Laki-Laki'; }else {$gender = 'Perempuan'; } 
						$location = !empty($row->location->name) ? $row->location->name : 'Tidak Diketahui';
						echo "
						<tr>
							<td style='width:5%'>".$row->id."</td>
							<td><img src='".$row->picture."' title='".$row->name."'/> ".truncate($row->name, 15)."</td>
							<td>".$gender."</td>
							<td>".dateid($row->updated_time, 'l, j F Y', '')."</td>
							<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$row->id."'>Kunjungi</a></td>
						</tr>
						";
					}
					?>
				</tbody>
			</table>
		</div>
	<?php elseif (@$_GET['type'] == 'group'): ?>
		<div class="form-group">
			<label>Pilih Grup untuk mengirim post anda :</label>
			<table class="tablecheckbox_asc">
				<thead>
					<tr>
						<th></th>
						<th>Nama Group</th>
						<th>Anggota</th>
						<th>Update Terakhir</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php  
					$url = "https://graph.facebook.com/me/groups?fields=updated_time,name,members.limit(0).summary(true)&access_token={$_SESSION['token']}";

					$curl = file_get_contents_curl($url);
					$result = json_decode($curl);
					?>
					<?php
					foreach ($result->data as $row) {		
						echo "
						<tr>
							<td style='width:5%'>".$row->id."</td>
							<td title='".$row->name."'>".truncate($row->name, 50)."</td>
							<td>".number_format($row->members->summary->total_count)."</td>
							<td>".dateid($row->updated_time, 'l, j F Y', '')."</td>	
							<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$row->id."'>Kunjungi</a></td>
						</tr>
						";
					}
					?>
				</tbody>
			</table>
		</div>
	<?php elseif (@$_GET['type'] == 'page'): ?>
		<div class="form-group">
			<label>Pilih Halaman untuk mengirim post anda :</label>
			<table class="tablecheckbox_asc">
				<thead>
					<tr>
						<th></th>
						<th>Nama Halaman</th>
						<th>Jumlah Like</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php  
					$url = "https://graph.facebook.com/v2.6/me/likes?fields=name,fan_count&access_token={$_SESSION['token']}";

					$curl = file_get_contents_curl($url);
					$result = json_decode($curl);
					?>
					<?php
					foreach ($result->data as $row) {		
						echo "
						<tr>
							<td style='width:5%'>".$row->id."</td>
							<td title='".$row->name."'>".truncate($row->name, 50)."</td>
							<td>".number_format($row->fan_count)."</td>
							<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$row->id."'>Kunjungi</a></td>
						</tr>
						";
					}
					?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<style type="text/css">.btn:not(.btn-block) { margin-bottom:10px; }</style>

		<div class="row">
			<div class="col-md-4">	
				<a href="?module=masspost&type=profile" class="btn btn-primary btn-lg col-md-12" role="button"><span class="icon icon-user"></span> <br/>Profile</a>
			</div>
			<div class="col-md-4">	
				<a href="?module=masspost&type=group" class="btn btn-warning btn-lg col-md-12" role="button"><span class="icon icon-group"></span> <br/>Group</a>
			</div>
			<div class="col-md-4">	
				<a href="?module=masspost&type=page" class="btn btn-danger btn-lg col-md-12" role="button"><span class="icon icon-star"></span> <br/>Page</a>
			</div>
		</div>
	<?php endif ?>
	<?php if (@isset($_GET['type'])): ?>
		<?php include "module/_form/delay.php" ?>
		<div class="form-group">
			<input class="btn btn-primary" type="submit" value="Submit">
		</div>
	<?php endif ?>
</form>

<div class="progress" style="display: none;">
	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0;background-color: #3f51b5!important">
		<span id="fullResponse"></span>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.formtablecheckbox').on('submit', function(e){
			e.preventDefault();
			var btn = $("input[type='submit']");
			var hidden = $("input[type='hidden']");
			var progressbar = $('.progress');
			hidden.remove();

			var form=this,rows_selected=table_asc.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){
				$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))
			});

			btn.prop('disabled',true);
			btn.val('On Progress...');

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'masspost',
				data : $(".formtablecheckbox").serialize(),
				dataType: 'json',
				processData: false,
				xhrFields: {
					onprogress: function(e)
					{
						progressbar.fadeIn();
						var response = e.currentTarget.response;
						if(lastResponseLength == false)
						{
							progressResponse = response;
							lastResponseLength = response.length;
						}
						else
						{
							progressResponse = response.substring(lastResponseLength);
							lastResponseLength = response.length;
						}
						var parsedResponse = JSON.parse(progressResponse);
						if (parsedResponse.message == 'error') {
							$('#fullResponse').text(parsedResponse.message);
							sweetAlert('Ehmm', parsedResponse.code , 'error');
							btn.prop('disabled',false);
							btn.val('Submit');
						}else if (parsedResponse.message == 'Complete') {
							$('#fullResponse').text(parsedResponse.message);
							sweetAlert('Berhasil Memproses Permintaan!', 'Sukses : ' + parsedResponse.success + ' | Gagal : ' + parsedResponse.error , 'success');
							btn.prop('disabled',false);
							btn.val('Submit');
						}else{							
							$('#fullResponse').text(parsedResponse.message);
						}
						$('.progress-bar').css('width', parsedResponse.progress + '%');
					}
				}
			});
		})
	})
</script>