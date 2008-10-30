<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<div id="sidebar">
		<div id="menu">
			<ul>
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="download.php">Download</a></li>
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
		<form action="upload_file.php" method="post" enctype="multipart/form-data">
			<label for="file">Filename:</label>
			<input type="file" name="file" id="file" /> 
			<br/>
			<input type="submit" name="submit" value="Submit" />
		</form>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>