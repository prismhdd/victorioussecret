<?php
session_start();
/*
 * For sending recommendations to users
 */
 
 /*if (!$_SESSION['user']) {
 	die('You need to login to send recommendations');
 }*/
 
require_once('../../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$current_user_id = $_SESSION['user']['user_id'];

//Get all of the albums we can recommend
$user_albums = Doctrine_Query::create()
		          ->from('UserAlbum ua')
		         ->where('ua.user_id=?', $current_user_id)
		          ->execute();
		          
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$recommendation = new Recommendation();
	$recommendation['note'] = $_POST['message'];
	$recommendation['from_user_id'] = $_SESSION['user']['user_id'];
	$recommendation['to_user_id'] = $_POST['to_user_id'];
	$recommendation['album_id'] = $_POST['album_id'];
	$recommendation->save();
}

if (isset($_GET['search_username'])) {
	//Search for all the usernames that match the criteria
	$search = Doctrine::getTable('User')
	               ->getTemplate('Doctrine_Template_Searchable')
	               ->getPlugin();
		
		$results = $search->search($_GET['search_username']);
		foreach($results as $result) {
			$user_ids[] = (int) $result['user_id'];
		}
		
		if (count($user_ids) > 0) {
			$users = Doctrine_Query::create()
			          ->from('User u')
			          ->whereIn('u.user_id', $user_ids)
			          ->execute();
		}
}
?>

<div>
	<p>Send recommendation <a href="send_recommendation.php">Reset Form</a></p>
	<?php if (!isset($_GET['to_user_id'])) { ?>
			<p>Please search for the user that you want to send the recommendation to</p>
			<form method="get">
				<input type="text" name="search_username" />
				<input type="submit" />
			</form>
			<?php if (isset($users)) { 
				if ($users->count() == 0) {?>
					<p>No users found</p>
				<?php } else { ?>
					<ul>
						<?php
						foreach($users as $user) { ?>
							<li><a href="send_recommendation.php?to_user_id=<?php print $user['user_id'] ?>&username=<?php print $user['username'] ?>"><?php print $user['username'] ?></a></li>
						<?php } ?>
					</ul>
				<?php }
			}
			if (!isset($users) && isset($_GET['search_username'])) { ?>
				<p>No users found, try again</p>
			<?php
			}
	}
		?>
		
		<?php if (isset($_GET['to_user_id'])) { ?>
			to <?php print $_GET['username'] ?>
	<form method="post">
		from <?php print $_SESSION['user']['first_name'] ?>
		
		message
		<input type="text" name="message" />
		
		for album
		<select name="album_id">
			<?php foreach($user_albums as $user_album) {?>
				
				<option value="<?php print $user_album['Album']['album_id'] ?>"><?php print $user_album['Album']['name'] ?></option>
			<?php } ?>			
		</select>
		
		<input type="submit" />
	</form>
	
	<?php } ?>
</div>