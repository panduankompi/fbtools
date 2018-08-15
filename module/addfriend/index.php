<form class='formtablecheckbox' method="post">
	<?php if (!empty($_GET['groupid'])): ?>
		<div class="form-group">
			<label>Pilih Anggota yang ingin anda tambahkan pertemanan :</label>
			<table class="tablecheckbox_asc">
				<thead>
					<tr>
						<th></th>
						<th>Nama</th>
						<th>JK</th>
						<th>Location</th>
						<th>Update Terakhir</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php  					
					$url = "https://graph.facebook.com/{$_GET['groupid']}/members?limit={$_GET['limit']}&fields=location,gender,updated_time,name,picture&access_token={$_SESSION['token']}";

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
							<td>".truncate($location, 25)."</td>
							<td>".dateid($row->updated_time, 'l, j F Y', '')."</td>
							<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$row->id."'>Kunjungi</a></td>
						</tr>
						";
					}
					?>
				</tbody>
			</table>	
		</div>
		<?php include "module/_form/delay.php" ?>
		<div class="form-group">
			<input class="btn btn-primary" type="submit" value="Submit">
		</div>
	<?php else: ?>		
		<div class="form-group">
			<label>Limit Anggota : </label>
			<input onclick="this.select();" class="form-control" type="text" name="limit" value="10">
		</div>
		<div class="form-group">
			<label>Pilih Grup yang anda miliki untuk mengambil data anggotanya :</label>
			<table class="tabledefault">
				<thead>
					<tr>
						<th>Nama Group</th>
						<th>Jumlah Anggota</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php  
					$limit = 10;
					$url = "https://graph.facebook.com/me/groups?fields=name,members.limit(0).summary(true)&access_token={$_SESSION['token']}";

					$curl = file_get_contents_curl($url);
					$result = json_decode($curl);
					?>
					<?php
					foreach ($result->data as $row) {		
						echo "
						<tr>
							<td>".$row->name."</td>
							<td>".number_format($row->members->summary->total_count)."</td>
							<td><button class='btn btn-success waves-effect btn-sm' onclick='getgroup(\"".$row->name."\",\"".$row->id."\")' type='button'>Pilih</button></td>
						</tr>
						";
					}
					?>
				</tbody>
			</table>	
		</div>
	<?php endif ?>
</form>

<div class="progress" style="display: none;">
	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0;background-color: #3f51b5!important">
		<span id="fullResponse"></span>
	</div>
</div>

<script type="text/javascript">
	function getgroup(groupname,groupid){	
		var limit = $("input[name='limit']").val();		
		location.href = '?module=addfriend&groupname=' + groupname + '&groupid=' + groupid + '&limit=' + limit;
	}

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
				url : 'addfriend',
				data : $(".formtablecheckbox").serialize(),
				dataType: 'json',
				processData: false,
				xhrFields: {
					onprogress: function(e)
					{
						progressbar.fadeIn();
						var response = event.currentTarget.response;
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