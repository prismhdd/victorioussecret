<?php
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$artists = Doctrine_Query::create()
			        ->from('Artist a')
			        ->leftJoin('a.Albums albums')
			        ->execute();
			        
?>

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
