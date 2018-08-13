<form class='formtablecheckbox' method="post">
	<div class="form-group">
		<label>Pilih Orang : </label>
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
				$url = "https://graph.facebook.com/{$_SESSION['id']}/friendrequests?limit=0&access_token={$_SESSION['token']}";
				$curl = file_get_contents_curl($url);
				$result = json_decode($curl);
				?>
				<?php
				foreach ($result->data as $row) {		
					$url = "https://graph.facebook.com/{$row->from->id}/?fields=location,gender,updated_time,name,picture&access_token={$_SESSION['token']}";
					$curl = file_get_contents_curl($url);
					$resultdetail = json_decode($curl);
					$gender = !empty($resultdetail->gender) ? $resultdetail->gender : 'Tidak Diketahui';
					if ($gender == 'male') {$gender = 'Laki-Laki'; }else {$gender = 'Perempuan'; } 
					$location = !empty($resultdetail->location->name) ? $resultdetail->location->name : 'Tidak Diketahui';
					echo "
					<tr>
						<td style='width:5%'>".$resultdetail->id."</td>
						<td><img src='".$resultdetail->picture."' title='".$resultdetail->name."'/> ".truncate($resultdetail->name, 15)."</td>
						<td>".$gender."</td>
						<td>".truncate($location, 25)."</td>
						<td>".dateid($resultdetail->updated_time, 'l, j F Y', '')."</td>
						<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$resultdetail->id."'>Kunjungi</a></td>
					</tr>
					";
				}
				?>
			</tbody>
		</table>			
	</div>
	<div class="form-group">
		<label>Proses yang dilakukan : </label>
		<select name="action" class="form-control">
			<option value="accept">Accept All Selected</option>	
			<option value="reject">Reject All Selected</option>	
		</select>
	</div>
	<?php include "module/_form/delay.php" ?>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Submit">
	</div>
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

			var form=this,rows_selected=table_asc.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){
				$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))
			});

			btn.prop('disabled',true);
			btn.val('On Progress...');
			
			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'friendrequest',
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
							sweetAlert('Berhasil Memproses Permintaan!', 'Sukses : ' + parsedResponse.success + ' | Gagal : ' + parsedResponse.error , 'success').then(function()  {window.location = './?module=<?= $_GET['module'] ?>'; });
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