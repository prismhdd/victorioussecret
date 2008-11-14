<?php session_start();
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$s_user_artist = Doctrine_Query::create()
  				 ->select('ua.user_id, artist.name')
			     ->from('UserArtist ua')
			     ->innerJoin('ua.Artist artist')
			     ->where('ua.user_id=?', $_SESSION['user']['user_id'])
			     ->orderBy('artist.name ASC')
			     ->execute();
			     
$s_user_album = Doctrine_Query::create()
				 ->select('ua.user_id, album.name, artist.name')
			     ->from('UserAlbum ua')
			     ->innerJoin('ua.Album album')
			     ->innerJoin('album.Artist artist')
			     ->where('ua.user_id=?', $_SESSION['user']['user_id'])
			     ->orderBy('artist.name ASC, album.name ASC')
			     ->execute();

$user_lib = array();

if ($s_user_artist && $s_user_album) {
	foreach($s_user_album as $user_album) {
	$artist = $user_album['Album']['Artist']['name'];
	$user_lib[$artist][] = $user_album['Album']['name'];
	}

	foreach($s_user_artist as $user_artist) {
		$artist = $user_artist['Artist']['name'];
		if (!array_key_exists($artist, $user_lib)) {
			$user_lib[$artist] = array();
		}
	}
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
					$artists = array();
					
					// function to handle the start tags 
					echo "<br>";
					function start_element_handler($parser, $name, $attributes){
					    global $current_tag;
					    global $current_data;
					    global $current_artist;
					    $current_tag = $name;
					    if ($name == 'ALBUMS')
						   {
						    	$current_artist = $current_data;
						    	$current_data = '';
						   }
					}
					
					// function to handle the end tags 
					function end_element_handler($parser, $name){
						global $current_artist;
						global $current_tag;
						global $current_data;
						global $artists;
						    if ($current_tag == 'ALBUM') {
						  		$artists[$current_artist][] = $current_data;
							}
						$current_tag = '';
						$current_data = '';
					}
								
					// function to handle the data between the tags 
					function character_data_handler($parser, $data){
					    global $current_data;
						$current_data .= $data;
					}
					
					if (!($fp = fopen($file, "r"))) {
					    die("could not open XML input");
					}
					
					$data = fread($fp, filesize($file));
					
					$xml_parser = xml_parser_create();
					//xml_set_object($xml_parser, $file);
					xml_set_element_handler($xml_parser, "start_element_handler", "end_element_handler");
					xml_set_character_data_handler($xml_parser, "character_data_handler");
					
					// print out
					if(!(xml_parse($xml_parser, $data))){
					    die("Error on line " . xml_get_current_line_number($xml_parser));
					}
					else {
						foreach ($artists as $artist => $albums) {
							$db_artist = Doctrine_Query::create()
						        ->from('Artist a')
						        ->where('a.name=?', array(trim($artist)))
						        ->fetchOne();
						     if (!$db_artist) {
						     	//If we don't have it add it to the database'
								$db_artist = new Artist();
								$db_artist['name'] = trim($artist);
								$db_artist['added_by_user_id'] = $_SESSION['user']['user_id'];
								$db_artist->save();
						    }
						    $userartist = Doctrine_Query::create()
						        ->from('UserArtist a')
						        ->where('a.user_id=? and a.artist_id=?', array($_SESSION['user']['user_id'],$db_artist['artist_id']))
						        ->fetchOne();
					        if (!$userartist) {
					        	$userartist = new UserArtist();
					    		$userartist['user_id'] = $_SESSION['user']['user_id'];
					    		$userartist['artist_id'] = $db_artist['artist_id'];
					    		$userartist->save();
					        }
						    // test
							//echo "Artist: $artist<br>";
							foreach ($albums as $album) {
								$db_album = Doctrine_Query::create()
							        ->from('Album a')
							        ->where('a.name=? and a.artist_id=?', array(trim($album), $db_artist['artist_id']))
							        ->fetchOne(); 
							     if (!$db_album) {
							     	//If we don't we have to add it to the database'
									$db_album = new Album();
									$db_album['name'] = trim($album);
									$db_album['Artist'] = $db_artist;
									$db_album['added_by_user_id'] = $_SESSION['user']['user_id'];
									$db_album->save();
							    }
							    $useralbum = Doctrine_Query::create()
							        ->from('UserAlbum a')
							        ->where('a.user_id=? and a.album_id=?', array($_SESSION['user']['user_id'], $db_album['album_id']))
							        ->fetchOne();
							    if (!$useralbum) {
							    	$useralbum = new UserAlbum();
								    $useralbum['user_id'] = $_SESSION['user']['user_id'];
								    $useralbum['album_id'] = $db_album['album_id'];
								    $useralbum->save();
							    }
								//echo "&nbsp;&nbsp;&nbsp;Album: $album<br />\n";
							}
						}
					}
					xml_parser_free($xml_parser);
					fclose($fp);
				}
			?>
			</form>
			<br>
			<table border = "1" width = "100%">
				<tr>
					<td align = "center" width = "40%"><b> Artists </b></td>
					<td align = "center" width = "60%"><b> Albums </b></td>
				</tr>
				<?php foreach($user_lib as $key => $value) { ?>
				<tr>	
					<td valign="top">
						<?php print $key; ?>
					</td>
					<td>
						<ul>
							<?php foreach($value as $alb) { ?>
								<li type="disc"><?php print $alb; ?> </li>
							<?php }?>
						</ul>
					</td>
				</tr>
			<?php }?>	
			</table>
		</div>
	</div>
</div>
<?php require_once('footer.php'); ?>
</body></html>