<?php
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$artists = Doctrine_Query::create()
			        ->from('Artist a')
			        ->leftJoin('a.Albums albums')
			        ->execute();
			        
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<?php require_once('sidebar.php') ?>
	<div id="main">
		<div>
			<?php foreach($artists as $artist) { ?>
				<p>
					<?php print $artist['name']; ?>
				</p>
				<ul>
					<?php foreach($artist['Albums'] as $album) { ?>
						<li><?php print $album['name'] ?> </li>
					<?php }?>
				</ul>
			<?php }?>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>


