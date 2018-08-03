
<?php if (empty($_SESSION['masuk'])): ?>
	<p>Fb Tools ini ditujukan untuk mempermudah pengguna facebook untuk melakukan sesuatu secara sekaligus, misalnya menghapus pertemanan, keluar dari grup, dan lain sebagainya :</p>

	<h3>Tools yang tersedia :</h3>
	<ol>
		<li>Bom Like</li>
		<li>Add Friend From Group</li>
		<li>Mass Unfriend / Menghapus Teman Secara Masal</li>
		<li>Join Group / Masuk Grup Berdasarakan Pencarian</li>
		<li>Mass Leave Group / Keluar Group Sesuai yang dipilih</li>
		<li>Profile Guard / Melindungi Foto Profile</li>
		<li>Bot Reaction / Robot untuk melakukan reaction terhadap post</li>
		<li>Bot Post Group / Melakukan Posting ke group yang dipilih (min 1x sehari)</li>
	</ol>

	<p>
		Untuk tools lainnya akan diupdate pada versi selanjutnya, Irfaan Programmer.
	</p>
	<a class="btn btn-primary" href="?module=masuk">Masuk Untuk Menggunakan Tools</a>
<?php else: ?>
<style type="text/css">.btn:not(.btn-block) { margin-bottom:10px; }</style>

<div class="row">
	<div class="col-md-4">	
		<a href="/" class="btn btn-primary btn-lg col-md-12" role="button"><span class="icon icon-star"></span> <br/>Next Soon</a>
	</div>
	<div class="col-md-4">	
		<a href="/" class="btn btn-warning btn-lg col-md-12" role="button"><span class="icon icon-star"></span> <br/>Next Soon</a>
	</div>
	<div class="col-md-4">	
		<a href="/" class="btn btn-danger btn-lg col-md-12" role="button"><span class="icon icon-star"></span> <br/>Next Soon</a>
	</div>
</div>
<?php endif ?>