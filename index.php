<?php 
include "config/settings.php";
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset='utf-8'/>
	<meta content='IE=edge' http-equiv='X-UA-Compatible'/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

	<title><?= $title ?></title>   

	<meta name="description" content="<?= $settings['desc'] ?>"/>
	<meta name="author" content="<?= $settings['author'] ?>"/>
	<link rel="base" href="<?= $baseurl ?>"/>
	<link rel="canonical" href="<?= $baseurl ?>"/>
	<!-- <meta rel="sitemap" type="application/xml" content="http://meusite.com.br/sitemap.xml"/> -->
	<meta name="robots" content="index/follow"/>
	<meta name="googlebot" content="index/follow"/>
	<meta name="theme-color" content="#FF4455"/>
	<meta name="msapplication-navbutton-color" content="#FF4455"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="#FF4455"/>
	<!-- Schema.org markup for Google+ -->
	<meta itemprop="name" content="<?= $title ?>"/>
	<meta itemprop="description" content="<?= $settings['desc'] ?>"/>
	<meta itemprop="image" content="<?= $baseurl ?>assets/img/fb-tools.png"/>
	<!-- markup for facebook -->
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="<?= $title ?>"/>
	<meta property="og:url" content="<?= $baseurl ?>"/>
	<meta property="og:site_name" content="<?= $settings['title'] ?>"/>
	<meta property="og:image" content="<?= $baseurl ?>assets/img/fb-tools.png"/>
	<meta property="og:description" content="<?= $settings['desc'] ?>"/>
	<meta property="og:locale" content="en_US"/>
	<!-- <meta property="fb:app_id" content="5349"/>
	<meta property="fb:admins" content="123456789"/> -->
	<!-- markup for twitter -->
	<meta name="twitter:card" content="summary"/>
	<meta name="twitter:title" content="<?= $title ?>"/>
	<meta name="twitter:description" content="<?= $settings['desc'] ?>"/>
	<meta name="twitter:creator" content="<?= $settings['author'] ?>"/>
	<meta name="twitter:image" content="<?= $baseurl ?>assets/img/fb-tools.png"/>
	<!-- JSON-LD - structured data markup Google Search -->
	<script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "WebSite",
		"name": "<?= $settings['title'] ?>",
		"alternateName": "<?= $settings['title'] ?>",
		"url": "<?= $baseurl ?>"}
	</script>

	<link rel="stylesheet" href="//unpkg.com/hexo-theme-material-indigo@latest/css/style.css"/>
	<link rel="stylesheet" href="assets/css/main.css"/>

	<!-- dataTables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
	<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
							<a href="javascript:;" class="mail"><?= $_SESSION['id'] ?></a>
						<?php else: ?>
							<h5 class="nickname"><?= $settings['title']; ?></h5>
							<a href="javascript:;" class="mail"><?= $settings['desc'] ?></a>
						<?php endif ?>
					</hgroup>
				</div>
			</div>
			<div class="scroll-wrap flex-col">

				<!-- nav#blogger -->
				<ul class="nav">

					<?php if (!empty($_SESSION['masuk'])): ?>
						<li class="waves-block waves-effect">
							<a href="./">
								<i class="icon icon-lg icon-cog"></i>
								Dashboard
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=massdeletestatus">
								<i class="icon icon-lg icon-plus"></i>
								Mass Delete Status
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=bomlike">
								<i class="icon icon-lg icon-plus"></i>
								Bom Like
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=addfriend">
								<i class="icon icon-lg icon-plus"></i>
								Add Friend
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=massunfriend">
								<i class="icon icon-lg icon-plus"></i>
								Mass Unfriend
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=friendrequest">
								<i class="icon icon-lg icon-plus"></i>
								Friend Request
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=joingroup">
								<i class="icon icon-lg icon-plus"></i>
								Join Group
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=massleavegroup">
								<i class="icon icon-lg icon-plus"></i>
								Mass Leave Group
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=massdeletepostgroup">
								<i class="icon icon-lg icon-plus"></i>
								Mass Delete Post Group
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=masscomment">
								<i class="icon icon-lg icon-plus"></i>
								Mass Comment
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=profileguard">
								<i class="icon icon-lg icon-plus"></i>
								Profile Guard
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=botreaction">
								<i class="icon icon-lg icon-plus"></i>
								Bot Reaction
							</a>
						</li> 	
						<!-- <li class="waves-block waves-effect">
							<a href="?module=botpostgroup">
								<i class="icon icon-lg icon-plus"></i>
								Bot Post Group
							</a>
						</li> 			 -->		
					<?php else: ?>
						<li class="waves-block waves-effect">
							<a href="./">
								<i class="icon icon-lg icon-user"></i>
								Dashboard
							</a>
						</li> 
						<li class="waves-block waves-effect">
							<a href="?module=masuk">
								<i class="icon icon-lg icon-user"></i>
								Masuk
							</a>
						</li> 
					<?php endif ?>

					<li class="waves-block waves-effect">
						<a href="?module=laporan">
							<i class="icon icon-lg icon-clock-o"></i>
							Laporan Cron
						</a>
					</li>

					<?php if (!empty($_SESSION['masuk'])): ?>
						<li class="waves-block waves-effect">
							<a href="keluar">
								<i class="icon icon-lg icon-sign-out"></i>
								Keluar
							</a>
						</li> 
					<?php endif ?>

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
				<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="menuShare"><i class="icon icon-lg icon-share-alt"></i></a>
			</div>
		</header>
		<header class="content-header index-header">

			<div class="container fade-scale">

				<!-- blogger#header -->
				<h1 class="title">
					<?= $title ?>
				</h1>
				<h5 class="subtitle"></h5>
			</div>
			<!-- blogger#menu navigasi -->
		</header>

		<div class="container body-wrap fade-scale">

			<!-- blogger#content -->
			<article class="article-card article-type-post" style="min-height: 500px">

				<?php  
				if (empty($_SESSION['masuk']) AND @$_GET['module']) {
					if ($_GET['module'] == 'laporan') {
						include "module/laporan/index.php";
					}elseif ($_GET['module'] == 'masuk') {
						include "module/masuk/index.php";
					}
					else {
						$_SESSION['execute'] = "<script> sweetAlert('Ehmm!', 'By Passed Detected!', 'error').then(function() {window.location = './?module=masuk'; }); </script>";
					}
				}else {
					switch (@$_GET['module']) {

						case 'massdeletestatus':
						include "module/massdeletestatus/index.php";
						break;

						case 'bomlike':
						include "module/bomlike/index.php";
						break;

						case 'addfriend':
						include "module/addfriend/index.php";
						break;

						case 'massunfriend':
						include "module/massunfriend/index.php";
						break;

						case 'friendrequest':
						include "module/friendrequest/index.php";
						break;

						case 'joingroup':
						include "module/joingroup/index.php";
						break;

						case 'massleavegroup':
						include "module/massleavegroup/index.php";
						break;

						case 'massdeletepostgroup':
						include "module/massdeletepostgroup/index.php";
						break;

						case 'masscomment':
						include "module/masscomment/index.php";
						break;

						case 'profileguard':
						include "module/profileguard/index.php";
						break;

						case 'botreaction':
						include "module/botreaction/index.php";
						break;
						case 'botreactionmemperbarui':
						include "module/botreaction/memperbarui/index.php";
						break;

						case 'botpostgroup':
						include "module/botpostgroup/index.php";
						break;

						case 'laporan':
						include "module/laporan/index.php";
						break;

						case 'masuk':
						include "module/masuk/index.php";
						break;

						case 'keluar':
						include "module/keluar/index.php";
						break;

						default:
						include "module/dashboard/index.php";
						break;
					}
				}
				?>

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
					<span>
						Made Use <a href="http://hexo.io/" target="_blank">Hexo</a> Theme <a href="https://github.com/yscoder/hexo-theme-indigo" target="_blank">indigo</a>
					</span>
					<!-- Jangan dihapus Jika tidak ingin redirect ke pembuatnya ! -->
					<span id="kurteyki">Created By <a id="credit" rel='nofollow' href="https://fb.com/he.irfaandemmy" title="Kurteyki Team">Irfaan</a></span>
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
	<script>
		var BLOG = { ROOT: '/', SHARE: true, REWARD: false };
	</script>

	<script src="//unpkg.com/hexo-theme-material-indigo@latest/js/main.min.js"></script>

	<script async src="//dn-lbstatics.qbox.me/busuanzi/2.3/busuanzi.pure.mini.js"></script>

	<!-- dataTables -->
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script async src="assets/js/main.js"></script>
	<script async src="assets/js/smooth.js"></script>

	<?php  
	if (!empty($_SESSION['execute'])) {
		echo $_SESSION['execute'];
		unset($_SESSION['execute']);
	}
	?>

</body>
</html>