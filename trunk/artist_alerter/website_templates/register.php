
<html><head>
<title>Artist Alert - SD&D </title><link href="default.css" rel="stylesheet" type="text/css"></head>
<body>

<div style="height: 100px;" id="logo">
	<img src="images/banner.jpg">
</div>

<div id="content">
	<div id="sidebar">
		<div id="menu">
			<ul>
				<li<a href="index.php">Home</a></li>
				<li><a href="download.php">Download</a></li>
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
		<div id="updates" class="boxed">
			<h2 class="title">Recent Updates</h2>
			<div class="content">
				<ul>
					<li>
						<h3>October 5, 2008</h3>
						<p><a href="index.php">Website work has begun</a></p>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="main">
		<div id="welcome">
			<h2 class="title">User Registration</h2>
				<form>	      
                <table id="signupfields" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <th><label for="username">Username:</label></th>
                        <td width="420px">
                            <input id="username" type="text" name="username" maxlength="15" onkeypress="clearField('username');"  />
                            <span id="username_status" class="formstatus">&nbsp;</span><br />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="email" dir="ltr">Email:</label></th>
                        <td>
                            <input type="text" name="email" id="email"/>
                            <span id="email_status" class="formstatus">&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="pword">Password:</label></th>
                        <td>
                            <input  type="password" name="pword" id="pword"/>
                            <span id="password_status" class="formstatus">&nbsp;</span>
                        </td>
                    </tr>					
                    <tr>
                        <th><label for="confirmpw">Confirm password:</label></th>
                        <td>
                            <input type="password" name="confirmpw" id="confirmpw"/>
                            <span id="confirmpw_status" class="formstatus">&nbsp;</span>
                        </td>
                    </tr>
                                                            
                        <td>
                            <input type="submit" id="createprofile" name="createprofile" value="Create My Account" />
                        </td>
                </table>            
            </form>		
		</div>		
	</div>
</div>

<div id="footer">
	<p style="margin-left: 0px; width: 800px;" id="legal">Team Victorious Secret<br/>2008 SD&D
</p></div>


</body><.php>