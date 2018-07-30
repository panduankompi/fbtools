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