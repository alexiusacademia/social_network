<?php
	include( 'inc/header.inc.php' );

	// Set the timezone
	// My timezone
	$timezone = "Asia/Manila";
	date_default_timezone_set ($timezone);

	if(isset($_SESSION['uname_log'])){
		if(isset($_POST['submit_post'])){
			$topic_id = $_POST['reply_topic'];
			
			$reply_body = $_POST['post_reply'];
			$reply_body = allow_chars($reply_body, array("b", "br/", "i"));
			$posted_by = $_SESSION['user_id'];
			$date_posted = date("Y-m-d H:i:s");

			// Insert into record
			$sql_post_reply = "INSERT INTO forum_posts VALUES ('', '$topic_id', '$posted_by', '$reply_body', '$date_posted')";
			if(!$result_post_reply = $mysqli->query($sql_post_reply))
			{
				echo "<br><br><br><br><br>";
				echo $mysqli->error;
				echo "<br>";
				echo $mysqli->errno;
			} else{
				// Entry success
				header( "location: posts.php?topic_id=$topic_id" );
			}

		}else{
			header( "location: forum.php" );
		}
	}else{
		header("location: index.php");
	}

	
?>