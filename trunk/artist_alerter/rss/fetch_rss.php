<?php


//Fetches an rss feed from a remote source
require_once ('ITunesRssFeed.php');
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$feed = new ITunesRssFeed('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/newreleases/sf=143441/limit=50/rss.xml');
$artists = $feed->getArtists();
//loads the system user for adding artists/albums
$system_user = Doctrine_Query::create()
						->from('User u')
						->where('u.username=?','SYSTEM')
						->fetchOne();
?>

<?php
//For each artist that we have found in the RSS feed  
foreach($artists as $artist => $albums) {
				//1.check if we already have it saved
				$db_artist = Doctrine_Query::create()
			        ->from('Artist a')
			        ->where('a.name=?', array(trim($artist)))
			        ->fetchOne();
			     if (!$db_artist) {
			     	//If we don't have it add it to the database'
					$db_artist = new Artist();
					$db_artist['name'] = trim($artist);
					$db_artist['added_by_user_id'] = $system_user['user_id'];
					$db_artist->save();
			    }
	?>
	<div>
		<p><?php print $artist ?></p>
		<ul>
			
			<?php
				//Now for each album that this artist has in the rss feed 
					foreach($albums as $album) {
						//First check if we have the album already
							$album_name = $album['album'];
							$album_url = $album['albumlink'];
							$album_preview_image = $album['coverart'];
							$db_album = Doctrine_Query::create()
						        ->from('Album a')
						        ->where('a.name=? and a.artist_id=?', array(trim($album_name), $db_artist['artist_id']))
						        ->fetchOne(); 
						     if (!$db_album) {
						     	//If we don't we have to add it to the database'
								$db_album = new Album();
								$db_album['name'] = trim($album_name);
								$db_album['Artist'] = $db_artist;
								$db_album['url'] = $album_url;
								$db_album['preview_image'] = $album_preview_image;
								$db_album['release_date'] = $album['releasedate'];
								$db_album['added_by_user_id'] = $system_user['user_id'];
								$db_album->save();
						     }
				?>
				<li><?php print $album ?></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>