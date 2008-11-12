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
			// database part need to be added
				if($_POST[upload] == "1")
				{
					$file = $_FILES['file']['tmp_name'];
					
					//function starts					
					$current_tag = '';
					$current_data = '';
					$current_artist = '';
					//bug for data handler
					//keep counts will help to match start_handle = char_handle
					$s_count = 0;
					$d_count = 0;
					$artists = array();
					
					// function to handle the start tags 
					echo "<br>";
					function start_element_handler($parser, $name, $attributes){
					    global $current_tag;
					    global $current_data;
						global $current_artist;
						global $artists;
						global $s_count;
						global $d_count;
					    
					    $s_count += 1;
					    $current_tag = $name;
					}
					
					// function to handle the end tags 
					function end_element_handler($parser, $name){
					}
								
					// function to handle the data between the tags 
					function character_data_handler($parser, $data){
						global $current_tag;
					    global $current_data;
						global $current_artist;
						global $artists;
						global $s_count;
						global $d_count;
						
						$d_count += 1;
//						echo "s_count : " . $s_count . "<br>";
//						echo "d_count : " . $d_count . "<br>";
						if ($s_count == $d_count) {
							//echo "data : " . $data . "<br>";
						    //$current_data = $data;
							if ($current_tag == 'ARTIST')
						    {
						    	$current_artist = $data;
						    	//echo "current artist : " . $current_artist . "<br>";
						    }
						    if ($current_tag == 'ALBUM') {
						    	$current_data = $data;
						    	//echo "current artist : " . $current_artist . "<br>";
						    	//echo "current data : "	. $current_data . "<br>";				    	
						    	if (!array_key_exists($current_artist, $artists)) {
									$artists[$current_artist] = array ();
								}
								//echo $current_data . " added to " . $current_artist . " key<br>"; 
								array_push($artists[$current_artist], $current_data);
							}
						}
						else {
							$d_count -= 1;
						}
					}
					
					if (!($fp = fopen($file, "r"))) {
					    die("could not open XML input");
					}
					
					$data = fread($fp, filesize($file));
					
					$xml_parser = xml_parser_create();
					xml_set_object($xml_parser, $file);
					xml_set_element_handler($xml_parser, "start_element_handler", "end_element_handler");
					xml_set_character_data_handler($xml_parser, "character_data_handler");
					
					// print out
					if(!(xml_parse($xml_parser, $data))){
					    die("Error on line " . xml_get_current_line_number($xml_parser));
					}
					else {
						foreach ($artists as $artist => $albums) {
							echo "Artist: $artist<br>";
							foreach ($albums as $album) {
								echo "&nbsp;&nbsp;&nbsp;Album: $album<br />\n";
							}
						}
					}
					xml_parser_free($xml_parser);
					fclose($fp);
				}
			?>
			
			</form>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>


</body></html>