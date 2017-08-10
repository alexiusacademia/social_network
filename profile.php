<?php

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in, redirect to ome page
		header( "location: index.php" );
	}else{
		// Get the username of the viewer
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];

		if(isset($_GET['user'])){
			$user = $_GET['user'];
			$sql_profile_owner = "SELECT * FROM users WHERE username ='$user'";
			if(!$result_profile_owner = $mysqli->query($sql_profile_owner)){
				echo "There is something wrong!";
				exit();
				header( "location: index.php" );
			}

			if($result_profile_owner->num_rows == 1){
				$row_profile_owner = $result_profile_owner->fetch_assoc();
				$id_profile_owner = $row_profile_owner['id'];
				$fname_profile_owner = $row_profile_owner['first_name'];
				$lname_profile_owner = $row_profile_owner['last_name'];
				$username_profile_owner = $row_profile_owner['username'];
				$avatar_profile_owner = $row_profile_owner['avatar'];
				$email_profile_owner = $row_profile_owner['email'];
				$sex_profile_owner = $row_profile_owner['sex'];
				$signup_profile_owner = $row_profile_owner['sign_up_date'];
				$region_profile_owner = $row_profile_owner['region'];
			}else{
				// User does'nt exist
				header( "location: index.php" );
			}

			?>

			<br />
			<div style="width: 800px; margin: 60px auto 0px auto; margin-bottom: 80px;">
				<div id="profileAcctSetting">
					<a href="account_setting.php">Account Setting</a>
				</div>
				
				<h2>Personal Information</h2>
				<div id="profileGroupContainer">
					<table>
						<tr valign="top">
							<td>
								<div id="profileInfoLabel">
									Avatar
								</div>	
							</td>
							<td>
								<div id="profileInfoContent">
									<img src="<?php echo $avatar_profile_owner; ?>" /><br />
									<?php
										// Put an add friend button below the picture if the viewer is not the owner of the account being viewed
										if($poster != $username_profile_owner){
											?>
												<form action = "blog.php" method="POST">
													<input type="hidden" name="blog_owner" value="<?php echo $username_profile_owner; ?>">
													<input type="submit" name="view_blog" value="View Blog">
												</form>
												<form action="start_conversation.php" method="POST">
													<input type="hidden" name="user2" value="<?php echo $username_profile_owner; ?>">
													<input type="submit" name="send_message" value="Send Message">
												</form>
												<br>
												<a href="gallery.php?gallery_owner=<?php echo $username_profile_owner; ?>" style="font-size: 15px;">View Gallery</a>
											<?php
										}	
									?>
								</div>	
							</td>
						</tr>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Name
								</div>	
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php echo $fname_profile_owner ." ". $lname_profile_owner; ?></p>
								</div>	
							</td>
						</tr>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Username
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php echo $username_profile_owner; ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Email address
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php echo $email_profile_owner; ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Gender
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php echo $sex_profile_owner; ?></p>
								</div>
							</td>
						</tr>
						<!--
						<tr>
							<td>
								<div id="profileInfoLabel">
									Birthday
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php echo date('F d, Y',strtotime($birthday_profile_owner)); ?></p>
								</div>
							</td>
						</tr>
						-->
						<tr>
							<td>
								<div id="profileInfoLabel">
									Member since
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php echo date('F d, Y',strtotime($signup_profile_owner)); ?></p>
								</div>
							</td>
						</tr>
					</table>
					
				</div>

				<h2>Work</h2>
				<div id="profileGroupContainer">
					<table>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Regional Office
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php echo $region_profile_owner; ?></p>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<h2>Statistics</h2>
				<div id="profileGroupContainer">
					<table>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Number of Forum Posts
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php getNumberOfPosts($id_profile_owner); ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Number of Topics Created
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php getNumberOfTopics($username_profile_owner); ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Number of Articles Submitted
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php getNumberOfArticles($id_profile_owner); ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="profileInfoLabel">
									Status
								</div>
							</td>
							<td>
								<div id="profileInfoContent">
									<p><?php onlineStatus($username_profile_owner); ?></p>
								</div>
							</td>
						</tr>
					</table>
				</div>

			</div>

			<?php
		}else{
			// User not specified, redirect to homepage
			header( "location: index.php" );
		}
	}
	include( 'inc/footer.inc.php' );

?>