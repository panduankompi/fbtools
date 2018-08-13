<form class='formtablecheckbox' method="post">
	<div class="form-group">
		<label>Pilih Status : </label>
		<table class="tablecheckbox_desc">
			<thead>
				<tr>
					<th></th>
					<th>Tanggal Publish</th>
					<th>Isi Status</th>
					<th>URL</th>
				</tr>
			</thead>
			<tbody>
				<?php  
				// https://graph.facebook.com/me/statuses
				// for statuses <td style='width:5%'>".$_SESSION['id']."_".$row->id."</td>
				$url = "https://graph.facebook.com/me/posts?access_token={$_SESSION['token']}";

				$curl = file_get_contents_curl($url);
				$result = json_decode($curl);
				?>
				<?php
				foreach ($result->data as $row) {		
					$message = !empty($row->message) ? $row->message : 'Photo or Share Link';
					echo "
					<tr>
						<td style='width:5%'>".$row->id."</td>
						<td>".date('Y-m-d H:i:s', strtotime($row->updated_time))."</td>
						<td>".strip_tags(truncate($message,50))."</td>
						<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$row->id."'>Kunjungi</a></td>
					</tr>
					";
				}
				?>
			</tbody>
		</table>
	</div>
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


			var form=this,rows_selected=table_desc.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){
				$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))
			});

			btn.prop('disabled',true);
			btn.val('On Progress...');

			var lastResponseLength = false;
			$.ajax({
				type: 'post',
				url : 'massdeletestatus',
				data : $(".formtablecheckbox").serialize(),
				dataType: 'json',
				processData: false,
				xhrFields: {
					onprogress: function(e)
					{
						progressbar.fadeIn();
						var response = event.currentTarget.response;
						if(lastResponseLength == false && response.length == 1)
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