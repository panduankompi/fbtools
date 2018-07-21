<h3 class="post-title">
	Mass Delete Status
</h3>
<div class="post-meta">
	<span>
		Pilih Status yang ingin dihapus
	</span>            
</div>

<div class="post-content">

	<!-- content -->
	<form class='formtablecheckbox' method="post">
		<br/><label>Pilih Status : </label><br/>
		<table class="tablecheckboxdesc">
			<thead>
				<tr>
					<th></th>
					<th>Tanggal Publish</th>
					<th>Isi Status</th>
					<th>Type</th>
					<th>URL</th>
				</tr>
			</thead>
			<tbody>
				<?php  
				$url = "https://graph.facebook.com/me/feed?fields=type,created_time,name,message&access_token={$_SESSION['token']}";

				$curl = file_get_contents_curl($url);
				$result = json_decode($curl);
				?>
				<?php
				foreach ($result->data as $row) {		
					$messagex = !empty($row->name) ? $row->name : 'Tidak Diketahui';
					$message = !empty($row->message) ? $row->message : $messagex;
					echo "
					<tr>
						<td style='width:5%'>".$row->id."</td>
						<td>".date('Y-m-d H:i:s', strtotime($row->created_time))."</td>
						<td>".strip_tags(truncate($message,50))."</td>
						<td>".$row->type."</td>
						<td><a target='_blank' href='https://fb.com/".$row->id."'><button type='button'>Kunjungi</button></a></td>
					</tr>
					";
				}
				?>
			</tbody>
		</table>
		<br><br><label>Delay Proses : </label><br/>
		<select name="delayprocess" class="chosen" style="min-width:300px">
			<option value="1">1 detik</option>	
			<option value="5">5 detik</option>	
		</select><br/><br/>
		<input type="submit" value="Submit">
	</form>

	<table>
		<tbody id="tloader"></tbody>
	</table>


</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.formtablecheckbox').on('submit', function(e){
			e.preventDefault();
			var btn = $("input[type='submit']");
			var tloader = $('#tloader');
			btn.prop('disabled',true);
			btn.val('in Progress....');

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'massdeletestatus',
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