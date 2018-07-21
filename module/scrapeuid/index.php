<h3 class="post-title">
	Scrape UID Dari Postingan yang dilike
</h3>
<div class="post-meta">
	<span>Scrape Uid ini akan mengambil id profil dari post yang di like</span>            
</div>

<div class="post-content">
	
	<!-- content -->
	<form id='formuidfrompost' method="post">
		<br/><label>URL Postingan : </label><br/>
		<input placeholder="https://facebook.com/" type="text" name="url">
		<br/><label>Hasil Scrape : </label><br/>
		<textarea readonly="" id="result" placeholder="Hasil Scrape" rows="10" cols="50" name="result"></textarea>
		<input id="uidfrompost" name="uidfrompost" type="submit" value="Submit">
	</form>


	<table class="table table-bordered">
		<tfoot id="loader" class="text-center"></tfoot>
	</table>

</div>

<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '#uidfrompost', function(e){
			e.preventDefault();
			var btn = $(this);
			var loader = $('#loader');
			var result = $('#result');
			btn.prop('disabled',true);
			btn.val('in Progress....');

			result.val('');
			loader.html('<tr><td colspan="3"><i class="fa fa-cog fa-5x fa-spin" aria-hidden="true"></i></td></tr>').fadeIn();

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'module/scrapeuid/execute.php',
				data : $("#formuidfrompost").serialize(),
				dataType: 'json',
				processData: false,
				xhrFields: {
           				// Getting on progress streaming response
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
           					if (parsedResponse.result !== '') {
           						if (result.val() === '') {
           							var dataresult = parsedResponse.result;
           						}else {           							
           							var dataresult = parsedResponse.result+"\n"+result.val();
           						}
           						result.val(dataresult);
           					}
           					loader.fadeIn().html('<tr><td colspan="3"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> '+parsedResponse.process+'</td></tr>');
           				}
           			}
           		});

    			// On completed
    			ajaxRequest.done(function(data)
    			{
    				btn.prop('disabled',false);
    				btn.val('Submit');	
    			});

    			// On failed
    			ajaxRequest.fail(function(error){
    				var result = JSON.stringify(error, null, 4);
    				btn.prop('disabled',false);
    				btn.val('Submit');
    			});

    		})
	})
</script>