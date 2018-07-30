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
      <input class="form-control" placeholder="1" type="number" name="max" required="">
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
      $(".formmasscomment").on('submit', function(e){
        e.preventDefault();
        var btn = $("input[type='submit']");
        var tloader = $('#tloader');
        btn.prop('disabled',true);
        btn.val('in Progress....');

        tloader.html('<tr><td>Loading <img src="data:image/gif;base64,R0lGODlhKwALAPAAAKrD2AAAACH5BAEKAAEAIf4VTWFkZSBieSBBamF4TG9hZC5pbmZvACH/C05FVFNDQVBFMi4wAwEAAAAsAAAAACsACwAAAjIMjhjLltnYg/PFChveVvPLheA2hlhZoWYnfd6avqcMZy1J14fKLvrEs/k+uCAgMkwVAAAh+QQBCgACACwAAAAAKwALAIFPg6+qw9gAAAAAAAACPRSOKMsSD2FjsZqEwax885hh3veMZJiYn8qhSkNKcBy4B2vNsa3pJA6yAWUUGm9Y8n2Oyk7T4posYlLHrwAAIfkEAQoAAgAsAAAAACsACwCBT4OvqsPYAAAAAAAAAj1UjijLAg9hY6maalvcb+IPBhO3eeF5jKTUoKi6AqYLwutMYzaJ58nO6flSmpisNcwwjEfK6fKZLGJSqK4AACH5BAEKAAIALAAAAAArAAsAgU+Dr6rD2AAAAAAAAAJAVI4oy5bZGJiUugcbfrH6uWVMqDSfRx5RGnQnxa6p+wKxNpu1nY/9suORZENd7eYrSnbIRVMQvGAizhAV+hIUAAA7"/></td></tr>').fadeIn();

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