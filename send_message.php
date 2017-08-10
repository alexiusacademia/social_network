<?php
	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header( "location: index.php" );
	}

	if(!isset($_POST['send_message'])){
		header( "location: index.php" );
	}

	echo "<br><br><br><br><br><br><br>";

	$conversation_id = $_POST['conversation'];
	$message_body = $_POST['message_body'];
	$message_body = allow_chars($message_body, array("b", "br", "br/", "i"));
	$date_sent = date("Y-m-d H:i:s");
	$sent_by = $_SESSION['uname_log'];

	$sql_send_message = "INSERT INTO messages VALUES ('', '$conversation_id', '$message_body', '$date_sent', '$sent_by')";
	$sql_set_isread = "UPDATE conversation SET isread = '0' WHERE conversation_id = '$conversation_id'";
	$sql_recent_poster = "UPDATE conversation SET recent_poster = '$sent_by' WHERE conversation_id = '$conversation_id'";
	if(!$result_send_message = $mysqli->query($sql_send_message)){
		echo $mysqli->error;
	}else{
		if($result_set_isread = $mysqli->query($sql_set_isread)){
				
			if($result_recent_poster = $mysqli->query($sql_recent_poster)){
				// The insert is successful
				header( "location: read_message.php?c=" . $conversation_id );	
			}
			
		}else{
			echo "<br><br><br><br><br><br>";
			echo $mysqli->error;
		}
		
		
	}
?>