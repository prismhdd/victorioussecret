<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<?php require_once('sidebar.php') ?>
	<div id="main">
		<div id="welcome" class="post">
			<h2 class="title">Download</h2>
			In order to run this application, you will need to have Java installed on your computer. 
			If you are unsure whether you already have Java, please visit 
			<a href="http://java.com/en/download/installed.jsp?detect=jre&try=1">here.</a><br><br><br>
			
			<a href="OfflineApplication.jar">Click here to download</a>
			
			<p>
				If you double click on the .jar file it should start up automatically, if not go to the console and run 
				<span style="font-familiy:monspace;">java -jar OfflineApplication.jar</span>
			</p>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>