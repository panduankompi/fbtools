<form class='formtablecheckbox' method="post">
	<?php if (!empty($_GET['groupid'])): ?>
		<label>Pilih Anggota yang ingin anda tambahkan pertemanan :</label>
		<table class="tablecheckbox">
			<thead>
				<tr>	<?php include "template/meta.php" ?>
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
		<?php include "module/_form/delay.php" ?>
		<div class="form-group">
			<input class="btn btn-primary" type="submit" value="Submit">
		</div>
	<?php else: ?>		
		<div class="form-group">
			<label>Limit Anggota : </label>
			<input class="form-control" type="text" name="limit" value="10">
		</div>
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
	<?php endif ?>
</form>

<table>
	<tbody id="tloader"></tbody>
</table>

<script type="text/javascript">
	function getgroup(groupname,groupid){	
		var limit = $("input[name='limit']").val();		
		location.href = '?module=addfriend&groupname=' + groupname + '&groupid=' + groupid + '&limit=' + limit;
	}

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
				url : 'addfriend',
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