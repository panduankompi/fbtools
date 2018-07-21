<?php  
include "execute.php";
?>

<h3 class="post-title">
	Masuk dengan Facebook
</h3>
<div class="post-meta">
	<span>Masuk untuk mendapatkan token iphone, sistem tidak menyimpan password anda</span>            
</div>

<div class="post-content">
	
	<!-- content -->
	<form method="post">
		<input type="text" placeholder="Username" name="username" required style='width: 250px;'><br/><br/>
		<input type="password" placeholder="Password" name="password" required style='width: 250px;'><br/><br/>
		<input name="byaccount" type="submit" value="Submit">
	</form>

</div>

<h3 class="post-title">
	Masuk dengan Token Facebook
</h3>
<div class="post-meta">
	<span>Masukan Token Facebook anda</span>            
</div>

<div class="post-content">
	
	<!-- content -->
	<form method="post">
		<div class="form-group">
			<textarea name="token" rows="10" cols="100" placeholder="EAXXX..." required></textarea>
		</div>

		<input name="bytoken" type="submit" value="Submit">

	</form>

</div>