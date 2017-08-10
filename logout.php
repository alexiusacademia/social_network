<?php
	include( 'inc/func.php' );
	session_start();

	if(isset($_SESSION['uname_log'])){
		$poster = $_SESSION['uname_log'];
		session_destroy();
		userLogout($poster);
	}

	

	// Update the users_log
	


	header("location: index.php");
?>