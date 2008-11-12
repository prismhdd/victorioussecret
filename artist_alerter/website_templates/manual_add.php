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
                        <td><input id="artist" type="text" name="artist"/></td>
                    </tr>
                    <tr>
						<th align="left"><label for="album">Album:</label></th>
						<td><input id="album" type="text" name="album"/></td>
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
					    // Pass the apiKey to the auth class to get a none fullAuth auth class
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
						
						//Calls the search function on the given artist
						$searchArtists = $apiClass->getPackage($auth, 'artist');
					    $searchResults=$searchArtists->search($methodVars);
					    
					    //A return of 0 means the artist is not in the last.fm database, potentially invalid
					    if ($searchResults['totalResults']==0)
					    	echo "Invalid artist!";
					    else	//If the artist is valid, add to the database
					    	echo $searchResults['totalResults'] . " results found";
					}
				?>
            </form>		
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>