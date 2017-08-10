<?php

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header( "location: index.php" );
	}else{
		$poster = $_SESSION['uname_log'];
		if(!isset($_POST['user2'])){
			header( "location: index.php" );
		}else{
			$user2 = $_POST['user2'];

			// Check if the conversation between the 2 users exist
			$sql_check_conversation = "SELECT * FROM conversation WHERE (user1='$poster' AND user2='$user2') OR (user1='$user2' AND user2='$poster')";
			if($result_check_conversation = $mysqli->query($sql_check_conversation)){
				$count_conv = $result_check_conversation->num_rows;
				if($count_conv > 0){
					// There is a conversation, get the conversation id
					$c_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT conversation_id FROM conversation WHERE 
													(user1='$poster' AND user2='$user2') OR (user1='$user2' AND user2='$poster')")));
					header( 'location: read_message.php?c=' . $c_id );
				}else{
					// Create a conversation
					$sql_create_conversation = "INSERT INTO conversation VALUES ('', '$poster', '$user2', '$poster', '1')";
					if($result_create_conversation = $mysqli->query($sql_create_conversation)){
						// Get the latest id
						$c_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT conversation_id FROM conversation WHERE 
													(user1='$poster' AND user2='$user2') OR (user1='$user2' AND user2='$poster')")));
						header( 'location: read_message.php?c=' . $c_id );
					}
				}
			}
		}
	}

?>