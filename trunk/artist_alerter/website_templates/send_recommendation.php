<?php
session_start();
/*
 * For sending recommendations to users
 */
 
 if (!$_SESSION['user']) {
 	die('You need to login to send recommendations');
 }
 
require_once('../database/config.php');
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
	$send = true;
}else if (isset($_GET['search_username'])) {
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<?php require_once('sidebar.php') ?>
	<div id="main">
		<h2 class="title">Send Recommendations</h2>
		<div>
			<?php if (!isset($send)) {?>
				<?php if ($user_albums->count() > 0 ) { ?>
					<!-- if the logged in user has albums to recommend allow them to continue -->
					<?php if (!isset($_GET['to_user_id'])) { ?>
							<p>Please search for the user that you want to send the recommendation to</p>
							<form method="get">
								<input type="text" name="search_username" value="<?php print $_GET['search_username']?>"/>
								<input type="submit" value="Search For User" />
							</form>
							<?php if (isset($users)) { 
								if ($users->count() == 0) {?>
									<p>No users found</p>
								<?php } else { ?>
									<p>Click on one of the user's below to send them a recommendation</p>
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
							<form method="post">
								<input type="hidden" name="to_user_id" value="<?php print $_GET['to_user_id'] ?>" ?>
								<table>
									<tr>
										<td>To:</td>
										<td><?php print $_GET['username'] ?> ( <a href="send_recommendation.php">search for a different user</a> )</td>
									</tr>
									<tr>
										<td>From:</td>
										<td><?php print $_SESSION['user']['first_name'] ?></td>
									</tr>
									<tr>
										<td>Message:</td>
										<td><textarea name="message" rows="5" cols="30"></textarea></td>
									</tr>
									<tr>
										<td>Album:</td>
										<td>
										<?php if ($user_albums->count() > 0) {?>
											<!-- if the user has some albums to recommend then list them -->
											<select name="album_id">
												<?php foreach($user_albums as $user_album) {?>
													<option value="<?php print $user_album['Album']['album_id'] ?>"><?php print $user_album['Album']['Artist']['name'] ?> - <?php print $user_album['Album']['name'] ?></option>
												<?php } ?>	
											</select>
										<?php } ?>
										</td>
									</tr>							
								</table> 
								<input type="submit" value="Send Recommendation"/>
							</form>
							<?php } 
					} else { ?>
						<!-- User has not albums so don't let them send recommendations -->
						<p>You don't have any albums to recommend please add them through your
						<a href="library.php">Library<a>.</p>
					<?php } 
			} else { ?>
				<p>Your recommendation was sent successfully</p>
			<?php } ?>
			</div>
	</div>

<?php require_once('footer.php'); ?>

</body></html>

		