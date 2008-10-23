<?php
session_start();
/*
 * For sending recommendations to users
 */
 
 if (!$_SESSION['user']) {
 	die('You need to login to send recommendations');
 }
 
require_once('../../database/config.php');
$conn = Doctrine_Manager :: connection(DSN);
$current_user_id = $_SESSION['user']['user_id'];
//Get all of the users we can send recommendations to
$users = Doctrine_Query::create()
		          ->from('User u')
		          // ->where('u.user_id!=?', $current_user_id); //when enabled this will not include the logged in user
		          ->execute();

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
?>

<div>
	Send recommendation
	<form method="post">
		to user
		<select name="to_user_id">
			<?php foreach($users as $user) { ?>
				<option value="<?php print $user['user_id'] ?>"><?php print $user['email_address'] ?></option>
			<?php } ?>			
		</select>
		from <?php print $_SESSION['user']['first_name'] ?>
		
		message
		<input type="text" name="message" />
		
		for album
		<select name="album_id">
			<?php foreach($user_albums as $user_album) { ?>
				<option value="<?php print $user_album['Album']['album_id'] ?>"><?php print $user_album['Album']['name'] ?></option>
			<?php } ?>			
		</select>
		
		<input type="submit" />
	</form>
</div>