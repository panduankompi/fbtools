<h3 class="post-title">
	Selamat Datang di <?= $settings['title'] ?>
</h3>
<div class="post-meta">
	<span><?= $settings['desc'] ?></span>            
</div>

<div class="post-content">

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

	<?php if (empty($_SESSION['masuk'])): ?>
		<a href="?module=masuk"><button>Masuk Untuk Menggunakan Tools</button></a>
	<?php endif ?>

</div>