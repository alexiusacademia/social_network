<?php
	include ( 'inc/header.inc.php' );

	// Define variables
	$fname = "";

	if(isset($_GET['user'])){
		// Check if the user is logged in
		if(!isset($_SESSION['uname_log'])){
			// Redirect to homepage
			header("location: index.php");
		}else{
			$poster = $_SESSION['uname_log'];
			$username = ($_GET['user']);
			$username = $mysqli->real_escape_string($username);
			// Check if alpha numeric
			if(ctype_alnum($username)){
				// Check if user exist
				$sql1 = "SELECT * FROM users WHERE username='$username'";
				if(!$result1 = $mysqli->query($sql1)){
					echo "Error: Our query failed to execute and here is why: \n";
					echo "Query: " . $query1 . "\n";
					echo "Errno: " . $mysqli->errno . "\n";
					echo "Error: " . $mysqli->error . "\n";
					exit;
				}
				// Count the record if user exist
				if($result1->num_rows == 1){
					$row1 = $result1->fetch_assoc();
					$id = $row1['id'];
					$fname = $row1['first_name'];
					$lname = $row1['last_name'];
					$avatar = $row1['avatar'];

				}else{
					echo "The selected user doesn't exist!\n";

				}
			}
		}
	}else{
		// Check if the user is logged in
		if(!isset($_SESSION['uname_log'])){
			// Redirect to homepage
			header("location: index.php");
		}else{
			$poster = $_SESSION['uname_log']	;
		}
	}
	?>

	<!-- Format the profile page -->
	<div id="wrapperProfile">
		<div class="profileBody">
			<?php
				
				if($poster != $username){
					?>
					<div class="postForm">
						<form action="send_post.php" method="POST">
							<textarea id="post" name="post" rows="4" cols="70"></textarea><br>
							<?php 
							echo '<input type="hidden" name="profile_owner" value="' . $username . '">';
							?>
							<!--<input type="hidden" name="profile_owner" value="'<?php echo $username; ?>'">-->
							<input type="submit" name="send" value="Send Message">
						</form>
					</div>
					<?php
				}
			?>
			<div class = "profilePosts">
				<!-- Display posts -->
				<?php
					$poster = $_SESSION['uname_log'];
					// If the user own this profile, he will be able to see the messages by other users
					if($poster == $username){
						$sql2 = "SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10";
						if(!$result2 = $mysqli->query($sql2)){
					
							echo "Error: Our query failed to execute and here is why: \n";
							echo "Query: " . $sql2 . "\n";
							echo "Errno: " . $mysqli->errno . "\n";
							echo "Error: " . $mysqli->error . "\n";
							exit;
						}
						// Count the record if post exist
						if($result2->num_rows > 0){
							while($row2 = $result2->fetch_assoc()){
								$id = $row2['id'];
								$body = $row2['body'];
								$date_added = $row2['date_added'];
								$added_by = $row2['added_by'];
								echo 	"<div class='posted_by'>
											<a href='" . $added_by . "'>" . $added_by . "</a><br>
											<div id='post_date'>" . $date_added . "</div><br>
											" . $body . "<br>
										</div>";
							}

						}else{
							echo "There are no messages!\n";

						}
					}
				?>
				<!-- End of Display posts-->

			</div>
			<img src="<?php echo $avatar; ?>" height="250" width="200" alt="<?php echo $username; ?>'s Profile" title="<?php echo $username; ?>'s Profile" />
			<br>
			<div class="textHeader"><?php echo $username; ?></div>
			<div class="profileLeftSideContent">Some info about this person.............</div>
			<div class="textHeader"><?php echo $username; ?>'s Friends</div>
			<img src="#" height="50" width="40">&nbsp;&nbsp;
			<img src="#" height="50" width="40">&nbsp;&nbsp;
			<img src="#" height="50" width="40">&nbsp;&nbsp;
			<img src="#" height="50" width="40">&nbsp;&nbsp;
			<img src="#" height="50" width="40">&nbsp;&nbsp;
		</div>
	</div>
	<!-- End of Profile page -->
