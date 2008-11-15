<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D </title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>
<?php require_once('../lastfmapi/lastfmapi.php'); ?>

<div id="content">
	<?php require_once('sidebar.php') ?>
	<div id="main">
		<div id="welcome">
			<h2 class="title">Library Update</h2>
			<form method="POST">
				<table id="info_fields">
					<tr>
						<th align="left"><label for="artist">Artist:</label></th>
                        <td><input id="artist" type="text" name="artist" value="<?php print $_POST['artist']?>"/></td>
                    </tr>
                    <tr>
						<th align="left"><label for="album">Album:</label></th>
						<td><input id="album" type="text" name="album" value="<?php print $_POST['album']?>"/></td>
					</tr>
					<tr>
						<td><input type="submit" id="manual_add" name="manual_add" value="Update Library"/></td>
					</tr>
				</table>
				<?php
					if($_POST['manual_add']){
						$artist = $_POST['artist'];
					    $album = $_POST['album'];
					    $error = 0;					  
					    
					    $authVars['apiKey'] = 'de18f1962a7933c63b59d67a6c350237';
					    //Pass the apiKey to the auth class to get a none fullAuth auth class
					    $auth = new lastfmApiAuth('setsession', $authVars);
					    
					    $apiClass = new lastfmAPI();
					    
					    echo "<br>";
					    //Check for empty data fields
					    if(!$artist) {
					      $error ++;
					      echo $error . ". You didn't enter an artist!<br>";
					    }
					  	if(!$album) {
					      $error ++;
					      echo $error . ". You didn't enter an album title!<br>";
					    }
					    
					    //Provides the input artist as a paramater
					    $methodVars = array(
							'artist' => $artist
						);						
						
						//Calls the getInfo function on the given artist
						$searchArtists = $apiClass->getPackage($auth, 'artist');
					    $searchResults=$searchArtists->getInfo($methodVars);
					    
					    if ($searchResults) {
							//If the search results are valid add the artist
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
						    //Link the artist to the album
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
					        //add the album
								$db_album = Doctrine_Query::create()
							        ->from('Album a')
							        ->where('a.name=? and a.artist_id=?', array(trim($album), $db_artist['artist_id']))
							        ->fetchOne(); 
							     if (!$db_album) {
									$db_album = new Album();
									$db_album['name'] = trim($album);
									$db_album['Artist'] = $db_artist;
									$db_album['added_by_user_id'] = $_SESSION['user']['user_id'];
									$db_album->save();
							    }
							    //Add the link from the album to the user
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
							    echo "Artist/Album added <a href='library.php'>Back to Library</a>";
					    } else {
					    	echo "Invalid artist!";
					    }
					}
				?>
            </form>		
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>