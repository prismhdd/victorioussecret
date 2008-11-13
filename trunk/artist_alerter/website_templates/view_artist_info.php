<?php session_start();
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$artist = Doctrine_Query::create()
					->from('Artist a')
					->innerJoin('a.Albums aa')
					->where('a.artist_id=?', $_GET['id'])
					->fetchOne();
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
			<h2 class="title">Artist Info</h2>
			<?php if (isset($artist) && $artist) { ?> 
			<b>Artist Name:</b> <?php print $artist['name'] ?>
			<p>
				<b>Albums:</b>
				<ul>
					<?php foreach($artist['Albums'] as $album) { ?>
						<li><a href="view_album_info.php?id=<?php print $album['album_id']?>"><?php print $album['name'] ?></a></li>
					<?php } ?>
				</ul>
			</p>
			<?php } else { ?>
				<p>Artist not found</p>
			<?php } ?>
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>