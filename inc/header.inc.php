<?php
	include( 'connect.inc.php' );
	include( 'func.php' );
	session_start();
	/*
	if(!isset($_SESSION['uname_log'])){
		$username = "";
	}else{
		$username = $_SESSION['uname_log'];
	}
	*/
	// Set the timezone
	// My timezone
	$timezone = "Asia/Manila";
	date_default_timezone_set ($timezone);

?>
<!doctype html>
<html>
	<head>
		<title>niaGroup</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="./js/main.js"></script>
	</head>
	
	<body>
		<div class="headerMenu">
			<div id="wrapper">
				<div class="logo">
					<!--<img src="img/find_friends_logo.png" /> -->
				</div>
				<div class="search_box">
					<form action="search_topic.php" method="POST" id="search">
						<input type="text" name="q" size="60" placeholder="Search Topics..." />
					</form>
				</div>
				<div id="menu">
					<a href="index.php">Home</a>
					<a href="about.php">About</a>
					<?php
						// If the user is not logged in, show sign-in and sign-up
						if(!isset($_SESSION['uname_log'])){
							echo '
							<a href="index.php">Sign up</a>
							<a href="index.php">Sign in</a>';
						}else{
							// Show the options for logged in users
							echo '
							<a href="'.$_SESSION['uname_log'].'">Profile</a>
							<a href="blog.php">Blog</a>
							<a href="logout.php">Sign out</a>';
						}
					?>
				</div>
			</div>
		</div>