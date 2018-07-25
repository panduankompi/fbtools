<?php  
$posturl = "https://www.facebook.com/groups/sharinggilsblog.org/permalink/1846062745474588";
$postid =  preg_match('/[^\/|\.!=][0-9]{7,}(?!.*[0-9]{7,})\d+/',$posturl,$matches);
echo $matches[0];
	?>