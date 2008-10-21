<?php


//Fetches an rss feed from a remote source
require_once ('ITunesRssFeed.php');
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$feed = new ITunesRssFeed('http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/newreleases/sf=143441/limit=100/rss.xml');
$artists = $feed->getArtists();
?>

<?php foreach($artists as $artist => $albums) {
				$db_artist = Doctrine_Query::create()
			        ->from('Artist a')
			        ->where('a.name=?', array(trim($artist)))
			        ->fetchOne();
			     if (!$db_artist) {
					$db_artist = new Artist();
					$db_artist['name'] = trim($artist);
					$db_artist->save();
			    }
	?>
	<div>
		<p><?php print $artist ?></p>
		<ul>
			<?php foreach($albums as $album) {
							$db_album = Doctrine_Query::create()
						        ->from('Album a')
						        ->where('a.name=? and a.artist_id=?', array(trim($album), $db_artist['artist_id']))
						        ->fetchOne(); 
						     if (!$db_album) {
								$db_album = new Album();
								$db_album['name'] = trim($album);
								$db_album['Artist'] = $db_artist;
								$db_album->save();
						     }
				?>
				<li><?php print $album ?></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>