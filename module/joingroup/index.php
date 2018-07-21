<h3 class="post-title">
	Join Group <?php $q = !empty($_GET['q']) ? "Hasil Query : <b>".$_GET['q']."</b>" : 'From Search Result'; echo $q  ?>
</h3>
<div class="post-meta">
	<span>
		Cari Nama Grup dan Bergabung
	</span>            
</div>

<div class="post-content">

	<!-- content -->
	<form class='formtablecheckbox' method="post">
		<?php if (!empty($_GET['q'])): ?>
			<br/><label><b>Pilih Anggota yang ingin anda tambahkan pertemanan</b></label>
			<table class="tablecheckbox">
				<thead>
					<tr>
						<th></th>
						<th>Nama</th>
						<th>Privasi</th>
						<th>Anggota</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php  					
					$q = urlencode($_GET['q']);
					$url = "https://graph.facebook.com/search?q={$q}&fields=members.limit(0).summary(true),name,privacy&type=group&access_token={$_SESSION['token']}";
					$curl = file_get_contents_curl($url);
					$result = json_decode($curl);
					?>
					<?php
					foreach ($result->data as $row) {		
						echo "
						<tr>
							<td style='width:5%'>".$row->id."</td>
							<td title='".$row->name."'>".truncate($row->name,50)."</td>
							<td>".$row->privacy."</td>
							<td>".number_format($row->members->summary->total_count)."</td>
							<td><a target='_blank' href='https://fb.com/".$row->id."'><button type='button'>Kunjungi</button></a></td>
						</tr>
						";
					}
					?>
				</tbody>
			</table>	
			<br/><label>Delay Proses : </label><br/>
			<select name="delayprocess" class="chosen" style="min-width:200px">
				<option value="1">1 detik</option>
				<option value="5">5 detik</option>
				<option value="15">15 detik</option>
				<option value="30">30 detik</option>
				<option value="60">1 menit</option>
				<option value="180">3 menit</option>		
				<option value="300">5 menit</option>		
			</select><br/><br/>
			<input type="submit" value="Submit">
		<?php else: ?>
			<input type="text" name="query" placeholder="Input Query">
			<button type="button" class="getquery">Search</button>
		<?php endif ?>
	</form>

	<table>
		<tbody id="tloader"></tbody>
	</table>

</div>

<script type="text/javascript">
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			var query = $("input[name='query']").val();
			if (query == '') {
				$("input[name='query']").focus();
				return false;
			}else {			
				location.href = '?module=joingroup&q=' + query;
			}
			event.preventDefault();
		}
	});

	$('.getquery').on("click",function(){
		var query = $("input[name='query']").val();
		if (query == '') {
			$("input[name='query']").focus();
		}else {			
			location.href = '?module=joingroup&q=' + query;
		}
	})

	$(document).ready(function(){
		$('.formtablecheckbox').on('submit', function(e){
			e.preventDefault();
			var btn = $("input[type='submit']");
			var tloader = $('#tloader');
			btn.prop('disabled',true);
			btn.val('in Progress....');

			tloader.html('<tr><td>Loading <img src="data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7"/></td></tr>').fadeIn();

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'joingroup',
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