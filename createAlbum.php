<?php

	//include( 'inc/header.inc.php' );
	session_start();
	include( 'inc/connect.inc.php' );
	include( 'inc/func.php' );

	if(!isset($_SESSION['uname_log'])){
		header( "location: index.php" );
	}

	if($_POST){
		$album_name = allow_chars($_POST['album_name'], array("b"));
		$album_owner = $_POST['owner'];

		$err_msg = "";

		if($album_name == ""){
			$err_msg = "Album name required!";
		}else{
			$sql = "INSERT INTO gallery_album VALUES('', '$album_name', '$album_owner')";
			if($result = $mysqli->query($sql)){
				$err_msg = "Album created successfully!";
			}else{
				$err_msg = $mysqli->error;
			}
		}
		echo $err_msg;
	}

?>