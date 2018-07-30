<form method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Status Aktif : </label>
				<label class="switch">
					<input type="checkbox" name="status" value="Aktif">
					<span class="slider round"></span>
				</label>
			</div>
			<div class="form-group">
				<label>Maksimal Proses : </label>
				<select name="maxprocess" class="form-control" required>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select>
			</div>
			<label>Tipe Reaction : </label>
			<div class="form-group">
				<select class="form-control" name="reaction" required>
					<option value='LIKE'>LIKE</option>
					<option value='LOVE'>LOVE</option>
					<option value='WOW'>WOW</option>
					<option value='HAHA'>HAHA</option>
					<option value='SAD'>SAD</option>
					<option value='ANGRY'>ANGRY</option>
				</select>
			</div>
			<div>
				<input class="btn btn-primary" name="saveaccount" type="submit" value="Simpan">
			</div>	
		</div>
	</div>
</form>

<?php  
include "execute.php";
?>