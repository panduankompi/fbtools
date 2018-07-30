<form class='formtablecheckbox' method="post">
	<div class="form-group">
		<label>Pilih Status : </label>
		<table class="tablecheckbox">
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
				$url = "https://graph.facebook.com/me/statuses?access_token={$_SESSION['token']}";

				$curl = file_get_contents_curl($url);
				$result = json_decode($curl);
				?>
				<?php
				foreach ($result->data as $row) {		
					if (@$row->message != '') {
						$message = !empty($row->message) ? $row->message : '';
						echo "
						<tr>
							<td style='width:5%'>".$_SESSION['id']."_".$row->id."</td>
							<td>".date('Y-m-d H:i:s', strtotime($row->updated_time))."</td>
							<td>".strip_tags(truncate($message,50))."</td>
							<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://fb.com/".$row->id."'>Kunjungi</a></td>
						</tr>
						";
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Submit">
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