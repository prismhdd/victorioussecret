<?php
require_once('../database/config.php');

	
$conn = Doctrine_Manager :: connection(DSN);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email_address = $_POST['emailAddress'];
	$password = $_POST['password'];
	$user = Doctrine_Query::create()
		          ->from('User u')
		          ->where('u.email_address=? AND u.password=?', array($email_address, $password))
		          ->fetchOne();
	if ($user) {
		$_SESSION['user'] = $user;
		header('Location: '. $_GET['lastpage'] );
	} else {
		unset($_SESSION['user']);
		$error = 'Invalid Credentials';
		header('Location: '. $_GET['lastpage'] . '?error=' . $error . '&username=' . $email_address );
	}
	//After verfying credentials we just send them to the page they click Sign In on
	
}
?>
<?php if (!isset($_SESSION['user'])) {
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
	Welcome <?php print $_SESSION['user']['first_name']; ?>
	
	
<?php } ?>
