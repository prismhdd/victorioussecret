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
				<form>
					<fieldset>
					<label for="inputtext1">User Name:</label>
					<input id="inputtext1" name="inputtext1" type="text">
					<label for="inputtext2">Password:</label>
					<input id="inputtext2" name="inputtext2" type="password">
					<input id="inputsubmit1" name="inputsubmit1" value="Sign In" type="submit"><br/>
					<a href="register.php">Need an account?</a>
					<p>
					</p></fieldset>
				</form>
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