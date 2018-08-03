<?php 
include "config/settings.php";
?>
<!DOCTYPE html>
<html>
<head>

	<?php include "template/title.php" ?>
	<?php include "template/meta.php" ?>
	
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/hexo-theme-material-indigo@1.7.2/css/style.css"/>

	<!-- dataTables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

	<link rel="stylesheet" href="assets/css/main.css"/>

	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	<script>window.lazyScripts=[]</script>

	<!-- custom head -->
</head>
<body itemscope='itemscope' itemtype='http://schema.org/WebPage'>
	<meta itemprop="accessibilityControl" content="fullKeyboardControl"/>
	<meta itemprop="accessibilityControl" content="fullMouseControl"/>
	<div id="loading"></div>

	<aside id="menu"  >
		<div class="inner flex-row-vertical">
			<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="menu-off">
				<i class="icon icon-lg icon-close"></i>
			</a>
			<!-- header -->
			<div class="brand-wrap" style="background-image:url(https://lh3.googleusercontent.com/-SatEkQZFds0/W0M0muGGxJI/AAAAAAAAAj4/Wy1DYvDmc6cs1v_asXcf61Qc-LrSGPMNgCLcBGAs/s1600/bg1.jpg)">
				<div class="brand">
					<a href='javascript:;' class="avatar waves-effect waves-circle waves-light">
						<?php if (!empty($_SESSION['masuk'])): ?>
							<img width="100" src="<?= $_SESSION['picture'] ?>"/>	
						<?php else: ?>
							<img src="https://2.bp.blogspot.com/-SxG8ABgNBwo/W0H9c9EMtOI/AAAAAAAAAjU/SaP08rKponcLyVnsCQwb8p49x54DhmlvwCPcBGAYYCw/s1600/default-user-image.png"/>
						<?php endif ?>
					</a>
					<hgroup class="introduce">
						<?php if (!empty($_SESSION['masuk'])): ?>
							<h5 class="nickname"><?= $_SESSION['name'] ?></h5>
							<a href="https://fb.com/<?= $_SESSION['id'] ?>" class="mail"><?= $_SESSION['id'] ?></a>
						<?php else: ?>
							<h5 class="nickname"><?= $settings['title']; ?></h5>
							<a target="_blank" href="javascript:;" class="mail"><?= $settings['desc'] ?></a>
						<?php endif ?>
					</hgroup>
				</div>
			</div>
			<div class="scroll-wrap flex-col">

				<!-- nav#blogger -->
				<ul class="nav">
					<?php include "template/nav.php" ?>
				</ul>

			</div>
		</div>
	</aside>

	<main id="main">
		<header class="top-header" id="header">
			<div class="flex-row">
				<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light on" id="menu-toggle">
					<i class="icon icon-lg icon-navicon"></i>
				</a>
				<div class="flex-col header-title ellipsis">
					<?= $title ?>
				</div>

				<div class="search-wrap" id="search-wrap">
					<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="back">
						<i class="icon icon-lg icon-chevron-left"></i>
					</a>
					<!-- blogger#search -->					
				</div>
				<a data-toggle="modal" data-target="#modalauthor" href="javascript:;" class="header-icon waves-effect waves-circle waves-light"><i class="icon icon-lg icon-question-circle"></i></a>
				<a href="javascript:;" class="hidden header-icon waves-effect waves-circle waves-light" id="menuShare"></a>
			</div>
		</header>
		<header class="content-header post-header">

			<div class="container fade-scale">

				<!-- blogger#header -->
				<h1 class="title">
					<?= $title ?>
				</h1>
				<h5 class="subtitle"></h5>
			</div>
			<!-- blogger#menu navigasi -->
		</header>

		<div class="container body-wrap">

			<!-- blogger#content -->
			<article class="post-article article-type-post">
				<div class="post-card" style="min-height: 500px">
					<h1 class="post-card-title">
						<?= $title ?>
					</h1>
					<div class="post-meta">
						<span id='busuanzi_container_page_pv' style='display:none'>
							<i class='icon icon-eye icon-pr'></i><span id='busuanzi_value_page_pv'></span>
						</span>
					</div>
					<div class="post-content">
						<?php include "template/nav.process.php" ?>
					</div>
				</div>
			</article>

		</div>

		<footer class="footer">
			<div class="top">

				<p>
					<span id="busuanzi_container_site_uv" style='display:none'>
						Pengunjung Situs：<span id="busuanzi_value_site_uv"></span>
					</span>
					<span id="busuanzi_container_site_pv" style='display:none'>
						Lalu Lintas：<span id="busuanzi_value_site_pv"></span>
					</span>
				</p>

			</div>
			<div class="bottom">
				<p>
					<span><?= $settings['title']; ?> &#169; 2018</span>
				</p>
			</div>
		</footer>
	</main>

	<div class="mask" id="mask"></div>
	<a href="javascript:;" id="gotop" class="waves-effect waves-circle waves-light"><span class="icon icon-lg icon-chevron-up"></span></a>

	<div class="global-share" id="globalShare">
		<ul class="reset share-icons">
			<li><a class="facebook share-sns" target="_blank" href='https://www.facebook.com/sharer/sharer.php?u=<?= $baseurl ?>' data-title=" Facebook"><i class="icon icon-facebook"></i></a></li>
			<li><a class="twitter share-sns" target="_blank" href='http://twitter.com/share?url=<?= $baseurl ?>' data-title=" Twitter"><i class="icon icon-twitter"></i></a></li>
			<li><a class="google share-sns" target="_blank" href='http://plus.google.com/share?url=<?= $baseurl ?>' data-title=" Google+"><i class="icon icon-google-plus"></i></a></li>
		</ul>
	</div>
	<div class="page-modal wx-share" id="wxShare">
	</div>

	<script src="//cdn.bootcss.com/node-waves/0.7.4/waves.min.js"></script>

	<script async src="//dn-lbstatics.qbox.me/busuanzi/2.3/busuanzi.pure.mini.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<!-- dataTables -->
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/highlight.min.js'></script>
	<script type='text/javascript'>hljs.initHighlightingOnLoad();</script>

	<script>
		var BLOG = { ROOT: '/', SHARE: true, REWARD: false };
	</script>
	<script src="https://cdn.jsdelivr.net/npm/hexo-theme-material-indigo@1.7.2/js/main.min.js"></script>
	<script async src="assets/js/main.js"></script>
	<script async src="assets/js/smooth.js"></script>

	<?php  
	if (!empty($_SESSION['execute'])) {
		echo $_SESSION['execute'];
		unset($_SESSION['execute']);
	}
	
	include "template/author.php";
	?>

</body>
</html>