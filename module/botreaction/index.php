<h3 class="post-title">
	Pengaturan Bot Reaction
</h3>
<div class="post-meta">
	<span>Silahkan atur settingan reaction anda, kemudian simpan</span>            
</div>

<div class="post-content">
	
	<!-- content -->
	<form method="post">
		<br/><label>Status Aktif : </label><br/>
		<label class="switch">
			<input type="checkbox" name="status" value="Aktif">
			<span class="slider round"></span>
		</label><br/><br/>
		<label>Maksimal Proses : </label>
		<div>
			<select name="maxprocess" style="min-width: 250px" required>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
		</div>
		<br/><label>Tipe Reaction : </label>
		<div>
			<select name="reaction" style="min-width: 250px" required>
				<!-- <option value='NONE'>NONE</option> -->
				<option value='LIKE'>LIKE</option>
				<option value='LOVE'>LOVE</option>
				<option value='WOW'>WOW</option>
				<option value='HAHA'>HAHA</option>
				<option value='SAD'>SAD</option>
				<option value='ANGRY'>ANGRY</option>
				<!-- <option value='THANKFUL'>THANKFUL</option>
				<option value='PRIDE'>PRIDE</option> -->
			</select>
		</div>
		<div>
			<br/><input name="saveaccount" type="submit" value="Simpan">
		</div>
	</form>

</div>

<?php  
include "execute.php";
?>