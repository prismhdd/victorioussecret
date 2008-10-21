<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>Artist Alert - SD&amp;D </title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<?php require_once('header.php'); ?>

<div id="content">
	<div id="sidebar">
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="download.php">Download</a></li>
				<li><a href="library.php">Library</a></li>
				<li><a href="about.php">About Us</a></li>
			</ul>
		</div>
		<div id="login" class="boxed">
			<h2 class="title">MyLibrary</h2>
			<div class="content">
				<?php require_once('login.php'); ?>
			</div>
		</div>
		
		<?php require_once('updates.php'); ?>
	</div>
	<div id="main">
		<div id="welcome">
			<h2 class="title">User Registration</h2>
				<form action="register.php">	      
                <table id="signupfields">
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
            </form>		
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>