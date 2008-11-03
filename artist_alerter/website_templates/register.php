<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D </title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<?php require_once('sidebar.php') ?>
	<div id="main">
		<div id="welcome">
			<h2 class="title">User Registration</h2>
				<form method="POST">	      
                <table id="signupfields">
                    <tr>
                        <th align="left"><label for="username">Username:</label></th>
                        <td><input id="username" type="text" name="username"/></td>
                    </tr>
                    <tr>
                        <th align="left"><label for="firstname">First Name:</label></th>
                        <td><input id="firstname" type="text" name="firstname"/></td>
                    </tr>
					<tr>
                        <th align="left"><label for="lastname">Last Name:</label></th>
                        <td><input id="lastname" type="text" name="lastname"/></td>
                    </tr>
                    <tr>
                        <th align="left"><label for="email" dir="ltr">Email:</label></th>
                        <td><input type="text" name="email" id="email"/></td>
                    </tr>
                    <tr>
                        <th align="left"><label for="pword">Password:</label></th>
                        <td><input  type="password" name="pword" id="pword"/></td>
                    </tr>					
                    <tr>
                        <th align="left"><label for="confirmpw">Confirm Password:</label></th>
                        <td><input type="password" name="confirmpw" id="confirmpw"/></td>
                    </tr>                                                          
                    <tr>
						<td><input type="submit" id="createprofile" name="createprofile" value="Create My Account"/></td>
					</tr>
			   </table>
			   <?php
					  if($_POST['createprofile']){
					    
					    $fname = $_POST['firstname'];
					    $lname = $_POST['lastname'];
					    $email = $_POST['email'];
					    $password = $_POST['pword'];
					    $confirmpw = $_POST['confirmpw'];
					    $error = 0;
					    
					    
					    
					  	if(!$fname) {
					      $error ++;
					      echo $error . ". You didn't enter first name!<Br>\n";
					    }
					    if(!$lname) {
					      $error ++;
					      echo $error . ". You didn't enter last name!<Br>\n";
					    }
					    if(!$password) {
					      $error ++;
					      echo $error . ". You didn't enter a password!<Br>\n";
					    }
					    if(!$confirmpw) {
					      $error ++;
					      echo $error . ". You didn't enter a confirm password!<Br>\n";
					    }
					    
					    //password checking
					    if($password != $confirmpw) {
					      $error ++;
					      echo $error . ". You should enter a same password!<Br>\n";
					    }
					    
					 	// checking query for duplicates
					 	
					 	$sql = Doctrine_Query::create()
								  ->from('User u')
						          ->where('u.email_address=?', $email);
				    	
				    	$checking = $sql->fetchOne();
				    	if ($checking) {
				    		$error ++;
				      		echo $error . ". The username '".$email."' already exist!<br>";
				    	}
				    	else
				    		echo "what are you doing";
				    	
					    
					    // insert query to matching field
					    if ($error == 0) {
					      
					      /* test output
					      echo "Fist Name : $fname<Br>\n" ."Last Name : $lname<Br>\n" .
					      		"User Name : $username<Br>\n" ."Email : $email<Br>\n" .
								"Password : $password<Br>\n" ."Confirm : $confirmpw<Br>\n";
					      */
				      
					      require_once('../database/config.php');
							
							$conn = Doctrine_Manager :: connection(DSN);
							
							$user = new User();
							
							$user['first_name'] = $fname;
							$user['last_name'] = $lname;
							$user['password'] = md5($password);
							$user['email_address'] = $email;
							$user['username'] = 'test';
					    	$user->save();
					    }
					  }
				?>           
            </form>		
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>