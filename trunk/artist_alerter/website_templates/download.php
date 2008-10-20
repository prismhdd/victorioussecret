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
				<li class="active"><a href="download.php">Download</a></li>
				<li><a href="library.php">Library</a></li>
				<li><a href="about.php">About Us</a></li>
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
			<h2 class="title">Download</h2><a href="offline.exe">Uploading Application</a>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>