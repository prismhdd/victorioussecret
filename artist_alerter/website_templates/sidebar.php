<?php
/*
 * Created on Nov 1, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

?>
<div id="sidebar">
		<div id="menu">
			<ul>
				<li class="<?php if (strpos($_SERVER['PHP_SELF'],'index.php') != false) print('active');?>"><a href="index.php">Home</a></li>
				<li class="<?php if (strpos($_SERVER['PHP_SELF'],'download.php') != false) print('active');?>"><a href="download.php">Download</a></li>
				<li class="<?php if (strpos($_SERVER['PHP_SELF'],'library.php') != false) print('active');?>"><a href="library.php">Library</a></li>
				<li class="<?php if (strpos($_SERVER['PHP_SELF'],'about.php') != false) print('active');?>"><a href="about.php">About Us</a></li>
				<?php if ($_SESSION['user']) { ?>
					<!-- This stuff shows up when the user is logged in -->
					 <li class="<?php if (strpos($_SERVER['PHP_SELF'],'send_recommendation.php') != false) print('active');?>"><a href="send_recommendation.php">Send Recommendations</a></li>
					 <li class="<?php if (strpos($_SERVER['PHP_SELF'],'view_recommendations.php') != false) print('active');?>"><a href="view_recommendations.php">View Recommendations</a></li>
					 <li><a href="index.php?logout=1">Logout</a></li>
				<?php } ?>
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