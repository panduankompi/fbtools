<form id='formbomlike' method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Pilih Profile : </label>
				<select name="people" class="form-control chosen">
					<?php  
					$url = "https://graph.fb.me/me/friends?access_token={$_SESSION['token']}";

					$curl = file_get_contents_curl($url);
					$result = json_decode($curl);
					?>
					<?php
					foreach ($result->data as $row) {							
						echo "<option value='{$row->id}'>{$row->name}</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label>Maksimal Proses : </label>
				<select name="max" class="form-control">
					<option value="1">1</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="50">50</option>		
				</select>
			</div>
			<?php include "module/_form/delay.php" ?>
			<div class="form-group">
				<input class="btn btn-primary" id="bomlike" name="bomlike" type="submit" value="Submit">
			</div>
		</div>
	</div>
</form>

<div class="progress" style="display: none;">
	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0;background-color: #3f51b5!important">
		<span id="fullResponse"></span>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '#bomlike', function(e){
			e.preventDefault();
			var btn = $("input[type='submit']");
			var hidden = $("input[type='hidden']");
			var progressbar = $('.progress');

			btn.prop('disabled',true);
			btn.val('On Progress...');

			var lastResponseLength = false;
			$.ajax({
				type: 'post',
				url : 'bomlike',
				data : $("#formbomlike").serialize(),
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
							btn.prop('disabled',false);
							btn.val('Submit');
							progressbar.fadeOut();
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