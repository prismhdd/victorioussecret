<?php session_start() ?>
<?php
if (isset($_GET['logout'])) {
	session_destroy();
	header('Location: index.php');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<?php require_once('sidebar.php') ?>
	<div id="main">
		<div id="welcome" class="post">
			<h2 class="title">Your Music Source</h2>			
				The <b>Artist Alert</b> idea spawned from mounting frustrations over staying up-to-date with favorite artists.  
				As your music collection grows and the number of artists increases, so does the amount of time you need to 
				spend on keeping track of new releases. 
				<br/><br/>
				<b>Artist Alert</b> significantly reduces the time and effort required 
				on the part of fans so they can spend more time enjoying their music.  Once <b>Artist Alert</b> discovers 
				your music collection, you will automatically be notified of any new albums that may interest you. 
				<br/><br/>
				<a href=intro.php>New to Artist Alert? Click here</a>
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>