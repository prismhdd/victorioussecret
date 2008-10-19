<html><head>
<title>Artist Alert - SD&D </title><link href="default.css" rel="stylesheet" type="text/css"></head>
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
				<form action="">
					<fieldset>
					<label for="inputtext1">User Name:</label>
					<input id="inputtext1" name="inputtext1" type="text">
					<label for="inputtext2">Password:</label>
					<input id="inputtext2" name="inputtext2" type="password">
					<input id="inputsubmit1" name="inputsubmit1" value="Sign In" type="submit"><br/>
					<a href="register.php">Need an account?</a>
					<p>
					</p>
					</fieldset>
				</form>
			</div>
		</div>
		
		<?php require_once('updates.php'); ?>
		
	</div>
	<div id="main">
		<div id="welcome">
			<h2 class="title">User Registration</h2>
				<form>	      
                <table id="signupfields">
                    <tr>
                        <th align="left" width="200px"><label for="firstname">First Name:</label></th>
                        <td><input id="firstname" type="text" name="firstname"/></td>
                    </tr>
					<tr>
                        <th align="left"><label for="username">Last Name:</label></th>
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
                        <td><input type="submit" id="createprofile" name="createprofile" value="Create My Account"/></td>
                </table>            
            </form>		
		</div>		
	</div>
</div>

<?php require_once('footer.php'); ?>

</body></html>