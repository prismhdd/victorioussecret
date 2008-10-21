<?php
session_start(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<div id="sidebar">
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="download.php">Download</a></li>
				<li><a href="library.php">Library</a></li>
				<li class="active"><a href="about.php">About Us</a></li>
			</ul>
		</div>
		<div id="login" class="boxed">
			<h2 class="title">MyLibrary</h2>
			<div class="content">
				<?php require_once('login.php'); ?>
			</div>
		</div>
			
		<?php require_once('updates.php'); ?>
		
	</div>
	<div id="main">
		<div id="welcome" class="post">
			<h2 class="title">About <i>Victorious Secret</i></h2><i>Victorious Secret</i> was formed in August 2008 
			for the <b>Software Design and Documentation</b> course. <i>Victorious Secret</i> is comprised of 
			<ul>
				<li>Charles Bailey</li>
				<li>Anthony Waters</li>
				<li>Willy DeRoberts</li>
				<li>Woojoon Choi</li>
			</ul>			
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>