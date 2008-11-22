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
			If you are unsure whether you already have Java or need the latest version, please visit 
			<a href="http://java.com/en/download/installed.jsp?detect=jre&try=1">here.</a><br><br><br>
			
			<a href="OfflineApplication.jar">Click here to download</a>
			
			<p>
				If you double click on the .jar file it should start up automatically, if not go to the console and run 
				<span style="font-familiy:monspace;">java -jar OfflineApplication.jar</span>
			</p>
			
			<h2>Read Me</h2>
			<div>
			<pre>                                    
Artist Alerter v0.1

INSTALLATION INSTRUCTIONS:
	-Go to Download page on website
	-Click 'Click here to download'
	-Doubleclick on .jar file, the program should start automatically
		-If the program doesn't start, go into the console and run 
		'java -jar OfflineApplication.jar'

OPERATING INSTRUCTIONS:
	-To select files to upload, click the 'Choose Directory' button 
	-Navigate to the desired directory to upload and click upload
		-You can change the selected directory by clicking 'Choose Directory' again
	-When the desired directory has been selected, click the 'Scan' button to scan  your library
	-A progress bar will come up to inform you of the progress of the scan
	-Another window will pop-up, displaying the results of the scan
	-You can view the albums found, broken up by artist
	-To cancel the exporting of these files, click the 'Exit' button
	-To export these files, click the 'Export' button
		-Save the file as 'export.xml' in a desired directory	
		-Log into the Websitre and navigate to the Library page
		-Select 'Browse' and selec the export.xml file you saved
		-Select 'Upload'
		-You have just uploaded your library onto Artist Alerter

KNOWN BUGS:
	To report a bug, please email us at teamvictorioussecret@googlegroups.com

	-Artist Alerter cannot overwrite an existing 'export.xml' file

TROUBLESHOOTING:

	The offline application won't run!
		-In order for the .jar file to execute properly, 
		 you need to have java installed on your computer.
		-Please visit http://java.sun.com/ to download this

	I clicked 'Export', but my file won't save!
		-You already have a file called 'export.xml' saved in that directory
		-Delete or rename the file and try again

	My MP3 files won't scan!
		-You're files don't have valid id tags
		-Update your id tags and try again

CHANGELOG:

Artist Alerter was created by team Victorious Secret
	Charles Bailey
	Anthony Waters
	Woojoon Choi
	William DeRoberts

http://sdd.parkviewpropertiesllc.com/website_templates/index.php
			</pre>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>