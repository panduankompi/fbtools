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

<table>
	<tbody id="tloader"></tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '#bomlike', function(e){
			e.preventDefault();
			var btn = $(this);
			var tloader = $('#tloader');
			btn.prop('disabled',true);
			btn.val('in Progress....');

			tloader.html('<tr><td>Loading <img src="data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7"/></td></tr>').fadeIn();

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'bomlike',
				data : $("#formbomlike").serialize(),
				dataType: 'json',
				processData: false,
				xhrFields: {
					onprogress: function(e)
					{
						var progressResponse;
						var response = e.currentTarget.response;
						if(lastResponseLength === false)
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
						tloader.fadeIn().html('<tr><td>'+parsedResponse.process+'</td></tr>');
					}
				}
			});

			ajaxRequest.done(function(data)
			{
				btn.prop('disabled',false);
				btn.val('Submit');
				tloader.fadeOut();
			});

			ajaxRequest.fail(function(error){
				var result = JSON.stringify(error, null, 4);
				btn.prop('disabled',false);
				btn.val('Submit');
				tloader.fadeOut();
			});


		})
	})
</script>