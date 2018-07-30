<form class='formtablecheckbox' method="post">
	<div class="form-group">
		<label>Pilih Profile : </label>
		<table class="tablecheckbox">
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
		<input class="btn btn-primary" id="bomlike" name="bomlike" type="submit" value="Submit">
	</div>
</form>

<table>
	<tbody id="tloader"></tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$('.formtablecheckbox').on('submit', function(e){
			e.preventDefault();
			var btn = $("input[type='submit']");
			var tloader = $('#tloader');
			btn.prop('disabled',true);

			var form=this,rows_selected=table.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))});
			
			btn.val('in Progress Execute : ' + $('input[type="hidden"]').length + ' Process');
			tloader.html('<tr><td>Loading <img src="data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7"/></td></tr>').fadeIn();

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'massunfriend',
				data : $(".formtablecheckbox").serialize(),
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
				$("input[type='hidden']").remove();
				tloader.fadeOut();
			});

			ajaxRequest.fail(function(error){
				var result = JSON.stringify(error, null, 4);
				btn.prop('disabled',false);
				btn.val('Submit');
				$("input[type='hidden']").remove();
				tloader.fadeOut();
			});


		})
	})
</script>