<html><head>
<title>Artist Alert - SD&D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
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
			<h2 class="title">About <i>Victorious Secret</i></h2>*Insert BIOGRAPHY here* 
			
		</div>
		
		
	</div>
</div>

<?php require_once('footer.php'); ?>


</body></html>