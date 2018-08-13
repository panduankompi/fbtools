<form class='formmasscomment' method="post">
	<div class="form-group">
		<label>URL Postingan : </label>
		<input class="form-control" placeholder="https://" type="text" name="postid" required="">
	</div>		
	<div class="form-group">
		<label>Pesan Komentar : (massup|massnumb)</label>
		<textarea class="form-control" name="postmessage" rows="5" cols="50" placeholder="Insert Message" required="">{Up|Recomended|Tertarik !|Jejak Dulu}</textarea>
	</div>
	<div class="form-group">
		<label>URL Gambar : (Komentar dengan gambar pisah dengan || untuk acak)</label>
		<textarea class="form-control" name="postimages" rows="5" cols="50" placeholder="https://"></textarea>
	</div>
	<?php include "module/_form/delay.php" ?>
	<div class="form-group">
		<label>Maksimal Proses : </label>
		<input onclick="this.select();" class="form-control" placeholder="1" type="number" name="max" required="">
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
		$(".formmasscomment").on('submit', function(e){
			e.preventDefault();
			var btn = $("input[type='submit']");
			var hidden = $("input[type='hidden']");
			var progressbar = $('.progress');

			var form=this,rows_selected=table_asc.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){
				$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))
			});

			btn.prop('disabled',true);
			btn.val('On Progress...');

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'masscomment',
				data : $(".formmasscomment").serialize(),
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