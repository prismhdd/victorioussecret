<?php
require_once('../database/config.php');

	
$conn = Doctrine_Manager :: connection(DSN);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$_POST['createprofile']) {
	$email_address = $_POST['emailAddress'];
	$password = $_POST['password'];
	$user = Doctrine_Query::create()
		          ->from('User u')
		          ->where('u.email_address=? AND u.password=?', array($email_address, $password))
		          ->fetchOne();
	if ($user) {		
		session_start();
		$_SESSION['user'] = array('first_name' => $user['first_name'], 'user_id' => $user['user_id']);
		print '<META HTTP-EQUIV=REFRESH CONTENT="2; URL='. $_GET['lastpage'].'"> Redirecting to ' . $_GET['lastpage'];
		session_write_close();
	} else {
		$error = 'Invalid Credentials';
		header('Location: '. $_GET['lastpage'] . '?error=' . $error . '&username=' . $email_address );
	}
}
?>
<?php if (!isset($_SESSION['user']) || !$_SESSION['user']) {
	print $_GET['error']; ?>
<form method="post" action="login.php?lastpage=<?php print $_SERVER['PHP_SELF'] ?>">
		<fieldset>
		<label for="inputtext1">User Name:</label>
		<input id="inputtext1" name="emailAddress" type="text" value="<?php print $_GET['username'] ?>">
		<label for="inputtext2">Password:</label>
		<input id="inputtext2" name="password" type="password">
		<input id="inputsubmit1" name="inputsubmit1" value="Sign In" type="submit"><br/>
		<a href="register.php">Need an account?</a>
		<p>
		</p></fieldset>
</form>
<?php } else { ?>
	
	<!-- stuff for when the user is logged in -->
	Welcome <?php
		$user = $_SESSION['user'];
		print $user['first_name']; 
	 ?>
	
	
<?php } ?>
