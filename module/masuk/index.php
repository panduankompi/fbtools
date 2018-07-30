<div class="row">
	<div class="col-md-6">
		<form method="post">
			<h3>Masuk Dengan Facebook</h3>
			<div class="form-group">
				<input class='form-control' type="text" placeholder="Username" name="username" required/>
			</div>
			<div class="form-group">
				<input class='form-control' type="password" placeholder="Password" name="password" required/>
			</div>
			<div class="form-group">
				<input class='btn btn-primary' name="byaccount" type="submit" value="Submit"/>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<form method="post">
			<h3>Masuk Dengan Token iPhone</h3>
			<div class="form-group">
			<textarea class="form-control" name="token" rows="4" placeholder="EAXXX..." required></textarea>
			</div>
			<div class="form-group">
				<input class='btn btn-primary' type="submit" value="Submit"/>
			</div>
		</form>
	</div>
</div>

<?php  
include "execute.php";
?>