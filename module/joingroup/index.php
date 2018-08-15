<form class='formtablecheckbox' method="post">
	<?php if (!empty($_GET['q'])): ?>
		<div class="form-group">
			<label><b>Pilih Anggota yang ingin anda tambahkan pertemanan</b></label>
			<table class="tablecheckbox_asc">
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
			<input class="btn btn-primary" type="submit" value="Submit">
		</div>
	<?php else: ?>
		<div class="form-row">
			<div class="form-group col-md-10">
				<input class="form-control" type="text" name="query" placeholder="Input Query">
			</div>
			<div class="form-group col-md-2">
				<button type="button" class="getquery btn btn-primary">Search</button>
			</div>
		</div>
	<?php endif ?>
</form>

<div class="progress" style="display: none;">
	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0;background-color: #3f51b5!important">
		<span id="fullResponse"></span>
	</div>
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
			var hidden = $("input[type='hidden']");
			var progressbar = $('.progress');
			hidden.remove();

			var form=this,rows_selected=table_asc.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){
				$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))
			});

			btn.prop('disabled',true);
			btn.val('On Progress...');

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
						progressbar.fadeIn();
						var response = e.currentTarget.response;
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