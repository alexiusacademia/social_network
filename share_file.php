<?php
	//include( 'inc/connect.inc.php' );
	//include( 'inc/func.php' );
	include( 'inc/header.inc.php' );

	if(isset($_SESSION['uname_log'])){
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];

		$timezone = "Asia/Manila";
		date_default_timezone_set ($timezone);

		if(isset($_GET['recipient']) && isset($_GET['file_id']) && isset($_GET['msg'])){
			$recipient = $_GET['recipient'];
			$file_id = $_GET['file_id'];
			$msg = $_GET['msg'];

			$send_error = "";

			// Retieve file from the database
			$sql_file = "SELECT * FROM vault WHERE file_id='$file_id'";
			if($result_file = $mysqli->query($sql_file)){
				// COunt
				if($result_file->num_rows > 0){
					while($row_file = $result_file->fetch_assoc()){
						$file_url = $row_file['file_url'];
						$file_name = $row_file['file_name'];
						$file_description = $row_file['file_description'];
						$file_cat = $row_file['file_cat'];
						$file_owner = $recipient;
						$file_size = $row_file['file_size'];
						$date_added = date("Y-m-d H:i:s");

						$sql_send_file = "INSERT INTO vault VALUES('', '$file_url', '$file_name', '$file_description', '$file_cat', '$file_owner', '$file_size', '$date_added')";
						if($result_send_file = $mysqli->query($sql_send_file)){
							// Send message to inbox
							// Check if the conversation between the 2 users exist
							$sql_check_conversation = "SELECT * FROM conversation WHERE (user1='$poster' AND user2='$recipient') OR (user1='$recipient' AND user2='$poster')";
							if($result_check_conversation = $mysqli->query($sql_check_conversation)){
								$count_conv = $result_check_conversation->num_rows;
								$c_id = 0;
								if($count_conv > 0){
									// There is a conversation, get the conversation id
									$c_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT conversation_id FROM conversation WHERE 
																	(user1='$poster' AND user2='$recipient') OR (user1='$recipient' AND user2='$poster')")));
									//header( 'location: read_message.php?c=' . $c_id );
								}else{
									// Create a conversation
									$sql_create_conversation = "INSERT INTO conversation VALUES ('', '$poster', '$recipient', '$poster', '1')";
									if($result_create_conversation = $mysqli->query($sql_create_conversation)){
										// Get the latest id
										$c_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT conversation_id FROM conversation WHERE 
																	(user1='$poster' AND user2='$recipient') OR (user1='$recipient' AND user2='$poster')")));
										//header( 'location: read_message.php?c=' . $c_id );
									}
								}
								// Send message script
								$conversation_id = $c_id;
								$message_body = $poster . " sent you a file.<br>Message: " . $msg . "<br>File: " . $file_name . 
										"<br>Check you vault under " . $file_cat . " category.";
								$message_body = allow_chars($message_body, array("b", "br", "br/", "i", "a", "/a"));
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
											$send_error = "File sent!";
										}
										
									}
									
									
								}
							}
						}
					}
				}else{
					$send_error = "File doesn't exist!";
				}
				?>
					<div class="send-file">
						<br><br>
						<?php echo $send_error; ?>
						<br>
						Go to <a href="private_vault.php">Private Vault</a>
					</div>
				<?php
			}
		}
	}
?>



<?php
	include( 'inc/footer.inc.php' );
?>