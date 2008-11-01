<?php
session_start();
/*
 * For viewing all of the logged in user's receives recommendations'
 */
 
 if (!$_SESSION['user']) {
 	die('You need to login to view recommendations');
 }
 
require_once('../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$current_user_id = $_SESSION['user']['user_id'];
//Get all of the recommendations
$recommendations = Doctrine_Query::create()
		          ->from('Recommendation r')
		          ->where('r.to_user_id=?', $current_user_id)
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
		<h2 class="title">Viewing Recommendations</h2>
		<div>
			 (<?php print $recommendations->count()?> Recommendations Found)
			<ul>
				<?php foreach($recommendations as $recommendation) { ?>
						<li>(<?php print $recommendation['date_added'] ?>) Recomendation from <?php print $recommendation['FromUser']['first_name']?> for
						<?php print $recommendation['Album']['name'] ?> </li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>

