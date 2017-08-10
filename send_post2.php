<?php

	include( 'inc/connect.inc.php' );
	include( 'inc/header.inc.php' );

	// Get the user
	$added_by = $_SESSION['uname_log'];

	// Set the timezone
	// My timezone
	$timezone = "Asia/Manila";
	date_default_timezone_set ($timezone);

	// Set the variables
	$post = $_POST['post'];
	$user_posted_to = $_POST['profile_owner'];
	if($post != ""){
		$date_added = date("Y-m-d");

		$query = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$added_by', '$user_posted_to')";

		if(!$result = $mysqli->query($query)){
			echo "An error has occured!<br>";
			echo "Query: " . $query . "\n";
			echo "Errno: " . $mysqli->errno . "\n";
			echo "Error: " . $mysqli->error . "\n";
			exit();
		}

		header("location: $added_by");
	}else{
		echo "You must enter a message.\n";
	}

?>