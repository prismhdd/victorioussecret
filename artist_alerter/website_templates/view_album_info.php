<?php session_start();
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
//Loads the information for a certain album
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$album = Doctrine_Query::create()
					->from('Album a')
					->innerJoin('a.Artist aa')
					->where('a.album_id=?', $_GET['id'])
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
			<h2 class="title">Album Info</h2>
			<img src="<?php print $album['preview_image']?>"/>
			<?php if (isset($album) && $album) { ?>
				<table>
					<tr>
						<td><b>Album Name:</b></td>
						<td><?php print $album['name'] ?></td>
					</tr>
					<tr>
						<td><b>Artist Name:</b></td>
						<td><a href="view_artist_info.php?id=<?php print $album['Artist']['artist_id']?>"><?php print $album['Artist']['name'] ?></a></td>
					</tr>
					<tr>
						<td><b>Release Date:</b></td>
						<td><?php print $album['release_date'] ?></td>
					</tr>
				</table>
				<?php if ($album['url'] != '')  { ?> 
					<p> For more information please click <a href="<?php print $album['url']?>">here</a>, all information courtesy of iTunes</p>
				<?php } ?>
			<?php } else { ?>
				<p>Album not found</p>
			<?php } ?>
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>