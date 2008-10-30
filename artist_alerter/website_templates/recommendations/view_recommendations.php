<?php
session_start();
/*
 * For viewing all of the logged in user's receives recommendations'
 */
 
 if (!$_SESSION['user']) {
 	die('You need to login to view recommendations');
 }
 
require_once('../../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$current_user_id = $_SESSION['user']['user_id'];
//Get all of the recommendations
$recommendations = Doctrine_Query::create()
		          ->from('Recommendation r')
		          ->where('r.to_user_id=?', $current_user_id)
		          ->execute();
?>

<div>
	Viewing Recommendations
	<ul>
		<?php foreach($recommendations as $recommendation) { ?>
				<li>(<?php print $recommendation['date_added'] ?>) Recomendation from <?php print $recommendation['FromUser']['first_name']?> for
				<?php print $recommendation['Album']['name'] ?> </li>
		<?php } ?>
	</ul>
</div>