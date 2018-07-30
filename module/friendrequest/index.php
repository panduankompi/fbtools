<form class='formtablecheckbox' method="post">
	<div class="form-group">
		<label>Pilih Orang : </label>
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

<table>
	<tfoot id="tloader"></tfoot>
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