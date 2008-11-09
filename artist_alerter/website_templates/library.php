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
			<h2 class="title">MyLibrary</h2>
			<form method="POST" enctype="multipart/form-data">
			<input type="hidden" name="upload" value="1">
			<input type="file" name="file">
			<input type="submit" value="Upload">
			<?php
				if($_POST[upload] == "1")
				{
					$file = $_FILES['file']['tmp_name'];
					
					// function to handle the start tags 
					function startTag($parser, $data){
					    //echo "<p>";
					}
					
					// function to handle the data between the tags 
					function contents($parser, $data){
					    //echo $data;
					}
					
					// function to handle the end tags 
					function endTag($parser, $data){
					    //echo "</p><br>";
					}
					
					$xml_parser = xml_parser_create();
					
					xml_set_element_handler($xml_parser, "startTag", "endTag");
					
					xml_set_character_data_handler($xml_parser, "contents");
					
					if (!($fp = fopen($file, "r"))) {
					    die("could not open XML input");
					}
					
					$data = fread($fp, filesize($file));
					
					if(!(xml_parse($xml_parser, $data))){
					    die("Error on line " . xml_get_current_line_number($xml_parser));
					}
					
					xml_parser_free($xml_parser);
					
					fclose($fp);
					
					echo "<br>" . $data;
					
					/*
					$data = fread($fp, filesize($file));
					fclose($fp);
					xml_parse_into_struct($xml_parser, $data, $vals, $index);
					xml_parser_free($xml_parser);
					*/
				}
			?>
			
			</form>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>


</body></html>