<?php session_start();
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$album = Doctrine_Query::create()
					->from('Album a')
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
			<?php if (isset($album) && $album) { ?>
				<table>
					<tr>
						<td>Album Name</td>
						<td><?php print $album['name'] ?></td>
					</tr>
					<tr>
						<td>Artist Name</td>
						<td><?php print $album['Artist']['name'] ?></td>
					</tr>
				</table>
			<?php } else { ?>
				<p>Album not found</p>
			<?php } ?>
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>