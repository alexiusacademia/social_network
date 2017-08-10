<?php

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		header( "location: index.php" );
	}

	$poster = $_SESSION['uname_log'];

	if($_POST){
		if(isset($_POST['upload_id']) && isset($_POST['comment_text']) && isset($_POST['comment_date'])){
			$comment_msg = '';

			$upload_id = $_POST['upload_id'];
			$comment_text = $_POST['comment_text'];
			$comment_date = $_POST['comment_date'];
			$sql_comment = "INSERT INTO gallery_comments VALUES('', '$upload_id', '$comment_text', '$poster', '$comment_date')";

			if($result_comment = $mysqli->query($sql_comment)){
				$comment_msg = "Comment submitted!";
				
			}

		}


	}

?>