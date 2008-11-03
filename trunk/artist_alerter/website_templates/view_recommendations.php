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
if (isset($_GET['id']) && isset($_GET['action']) && is_numeric($_GET['id'])) {
	if ($_GET['action'] == 'remove')  {
		Doctrine_Query::create()->delete()
		          ->from('Recommendation r')
		          ->where('r.from_user_id=? and r.recommendation_id=?', array($current_user_id, $_GET['id']))
		          ->execute();
	}
}
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
						<li><span style="font-weight:bold;">(<?php print $recommendation['date_added'] ?>)</span> Recommendation from 
						<span style="font-weight:bold"><a href="view_user_info.php?id=
						<?php print $recommendation['FromUser']['user_id'] ?>">
						<?php print $recommendation['FromUser']['first_name']?></a></span> for
						<span style="font-weight:bold"><a href="view_album_info.php?id=
						<?php print $recommendation['Album']['album_id'] ?>">
						<?php print $recommendation['Album']['name'] ?></a></span>
						<a href="view_recommendations.php?id=<?php print $recommendation['recommendation_id']?>&
						action=remove">(remove)</a> 
						<br/>
							<span>Message: <?php print $recommendation['note']?>
							</span>
						</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>

