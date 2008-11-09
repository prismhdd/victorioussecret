<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D</title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<?php require_once('sidebar.php') ?>
	<div id="main">
		<div id="welcome" class="post">
			<h2 class="title">User Info</h2>
			<form method="POST">	      
                <table id="signupfields">
                    <tr>
                        <th align="left"><label for="firstname">First Name:</label></th>
                        <td><input id="firstname" type="text" name="firstname" value="<?php print $user['first_name'] ?>"/></td>
                    </tr>
					<tr>
                        <th align="left"><label for="lastname">Last Name:</label></th>
                        <td><input id="lastname" type="text" name="lastname" value="<?php print $user['last_name'] ?>"/></td>
                    </tr>
                    <tr>
                        <th align="left"><label for="email" dir="ltr">Email:</label></th>
                        <td><input type="text" name="email" id="email" value="<?php print $user['email_address'] ?>"/></td>
                    </tr>
                    <tr>
                        <th align="left"><label for="opword">Your Password:</label></th>
                        <td><input  type="password" name="opword" id="pword"/></td>
                    </tr>
                    <tr>
                        <th align="left"><label for="npword">New Password:</label></th>
                        <td><input  type="password" name="npword" id="pword"/></td>
                    </tr>					
                    <tr>
                        <th align="left"><label for="confirmpw">Confirm New Password:</label></th>
                        <td><input type="password" name="confirmpw" id="confirmpw"/></td>
                    </tr>
                    <tr>
                    	<th align="left"><label for="frequency">Frequency of Updates:</label></th>
                    	<td><input type="radio" name="frequency" value="Daily"/>Daily<br>
						<input type="radio" name="frequency" value="Weekly" checked/>Weekly<br>
						<input type="radio" name="frequency" value="Monthly"/>Monthly<br></td>
					</tr>
					<tr>
                    	<th align="left"><label for="option">Do you want to get alerts<br>through your email address?</label></th>
                    	<td><input type="checkbox" name="option" value="emailalert"><br></td>
                    </tr>                                             
                    <tr>
						<td><input type="submit" id="changeprofile" name="changeprofile" value="Change My Account Info"/></td>
					</tr>
			   </table>
				<?php
	   			    // Not completed - frequency & email alert
					  
					  if($_POST['changeprofile']){
					    
					    $fname = $_POST['firstname'];
					    $lname = $_POST['lastname'];
					    $email = $_POST['email'];
					    $oldpassword = $_POST['opword'];
					    $newpassword = $_POST['npword'];
					    $confirmpw = $_POST['confirmpw'];
					    
					    // new variables for frequency and option
					    $frequency = $_POST['frequency'];
					    $option = $_POST['option'];
					    
					    $error = 0;
					    //test output
					    //echo "frequency : $frequency<Br>" ."option : $option<Br>";
								 
					    echo "<br>";
					    // empty field checking
					  	if(!$fname) {
					      $error ++;
					      echo $error . ". You didn't enter first name!<br>";
					    }
					    if(!$lname) {
					      $error ++;
					      echo $error . ". You didn't enter last name!<br>";
					    }
					    if(!$email) {
					      $error ++;
					      echo $error . ". You didn't enter a email address!<br>";
					    }
					    if(!$oldpassword) {
					      $error ++;
					      echo $error . ". You have to enter a password to change your information!<br>";
					    }
					    
					    // old password checking
					    if($oldpassword != $user['password']) {
					      $error ++;
					      echo $error . ". Password Incorrect!<br>";
					    }
					    
					    // new password checking
					    if($newpassword != $confirmpw) {
					      $error ++;
					      echo $error . ". New password confimation failed!<br>";
					    }
					    
					 	// checking query for duplicates
				    	/*
				    	$sql = Doctrine_Query::create()
								  ->from('User u')
						          ->where('u.email_address=?', $email);
				    	$checking = $sql->fetchOne();
				    	if ($checking) {
				    		$error ++;
				      		echo $error . ". The email '".$email."' already exist!<br>";
				    	}
				    	*/
				    	
				    	// create user if no errors
				    	if ($error == 0) {
					      	
					      	require_once('../database/config.php');
							$conn = Doctrine_Manager :: connection(DSN);
							//$userTable = Doctrine::getTable('users');
							//$who = $userTable->find($user);
							
							// modify user info
							$user['first_name'] = $fname;
							$user['last_name'] = $lname;
							$user['email_address'] = $email;
							
							if ($newpassword) {
								$user['password'] = $newpassword;
							}
							//$user->save();
							
							/*
							try {
								$user->save();
							} catch (Doctrine_Connection_Pgsql_Exception $e) {
								print $e;
							}
							*/		
					    	echo "Your account has been changed!";
					    }
					  }
				?>
			   </form>
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>