<?php

	include( 'inc/header.inc.php' );
	require_once( 'image_manipulator.php' );
	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in, redirect to homepage
		header( "location: index.php" );
	}else{
		$poster = $_SESSION['uname_log'];

		// Get the email of the user
		$sql_email_poster = "SELECT email FROM users WHERE username='$poster'";
		$result_email_poster = implode(mysqli_fetch_assoc($mysqli->query($sql_email_poster)));

		// Declare some variables
		$err_old_pass = "";
		$err_new_pass = "";
		$err_new_email = "";

		//Profile Image upload script
	  	if (isset($_FILES['profilepic'])) {
			if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || 
			  					(@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)) // Megabyte
			{
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				// Generate a random character name
				$rand_dir_name = substr(str_shuffle($chars), 0, 15);
				mkdir("avatar/$rand_dir_name");

				if (file_exists("avatar/$rand_dir_name/".@$_FILES["profilepic"]["name"])){
					// The same filename exists
					echo @$_FILES["profilepic"]["name"]." Already exists";
				}else{
					// Retrieve the existing avatar to delete it
				    $existing_avatar = implode(mysqli_fetch_assoc($mysqli->query("SELECT avatar FROM users WHERE username='$poster' LIMIT 1")));
				    if($existing_avatar != "img/male.jpg" && $existing_avatar != "image/female.jpg"){
				    	// Delete the file
				    	unlink($existing_avatar);
				    }

				    // Create instance of the image manipulator class
				    $img_manipulator = new ImageManipulator($_FILES["profilepic"]["tmp_name"]);
				    // Resize to 200 x 250 pixels
				    $new_image = $img_manipulator->resample(200, 250);
				    // Save the file
				    $img_manipulator->save("avatar/$rand_dir_name/".$_FILES["profilepic"]["name"]);

					//move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"avatar/$rand_dir_name/".$_FILES["profilepic"]["name"]);
				    
				    $profile_pic_name = @$_FILES["profilepic"]["name"];
				    $profile_pic_query = ("UPDATE users SET avatar='avatar/$rand_dir_name/$profile_pic_name' WHERE username='$poster'");
				    $profile_pic_result = $mysqli->query($profile_pic_query);
				    
				    header("Location: account_setting.php");
				    
				}
			}else{
			    echo "<br><br><br>Invalid File! Your image must be no larger than 1MB and it must be either a .jpg, .jpeg, .png or .gif";
			}
	  	
	  	// End of profile image upload script

	  	// Change password script
	  	}else if(isset($_POST['new_pass'])){
	  		// Validate inputs
	  		$new_pass = $_POST['new_pass'];
	  		$new_pass2 = $_POST['new_pass2'];

	  		// Check for old password
	  		$old_pass = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['old_pass']);
	  		$old_pass_md5 = md5($old_pass);
	  		if(!$old_pass_retrieve = implode(mysqli_fetch_assoc($mysqli->query("SELECT password FROM users WHERE username='$poster'")))){
	  			echo "Error retrieving from database!";
	  		}else{
		  		if($old_pass_md5 == $old_pass_retrieve){
		  			// Old password matched
		  			
		  			// Check if new password is entered
		  			if($new_pass != "" || $new_pass2 != ""){
		  				// Check if they match
		  				if($new_pass == $new_pass2){
		  					// Encrypt the password
		  					$new_pass = md5($new_pass);
		  					$sql_update_password = "UPDATE users SET password = '$new_pass' WHERE username = '$poster'";
		  					if($result = $mysqli->query($sql_update_password)){
		  						$err_new_pass = "Password updated successfully!";	
		  					}else{
		  						echo "Error updating password!";
		  					}
		  					
		  				}else{
		  					$err_new_pass = "New password did'nt match!";
		  				}
		  			}else{
		  				$err_new_pass = "Password field must not be empty!";
		  			}

		  			$err_old_pass = "";
		  		}else{
		  			$err_old_pass = "Old password is incorrect!";
		  		}
	  		}
	  	// End of change password script
	  	}else if(isset($_POST['new_email'])){
	  		// Check if user has input
	  		$new_email = $_POST['new_email'];
	  		if($new_email != ""){
	  			// Process the request
	  			$sql_update_email = "UPDATE users SET email = '$new_email' WHERE username = '$poster'";
	  			$mysqli->query($sql_update_email);
	  			$err_new_email = "Email updated successfully!";
	  		}else{
	  			// Email is empty
	  			$err_new_email = "Input required to change your email!";
	  		}
	  	}
	  	

	?>
	<div style="width: 900px; margin: 0px auto 0px auto;">
		<!-- Navigation pane -->
		<div class="homeNav">
			<?php include( 'inc/main_left_nav.php' ); ?>
		</div>	
		<!-- End of Navigation pane -->

		<!-- Main Contents -->
		<div class="homeMainContent">
			<div id="wrapperAccountSetting">
				<h2>Edit Account Setting below</h2><br>
				<div id="accountSettingEditBox">
					<p>UPLOAD YOUR PROFILE PHOTO:</p>
					<form action="account_setting.php" method="POST" enctype="multipart/form-data">
						<img src="img/male.jpg" width="70" />
						<input type="file" name="profilepic" /><br />
						<input type="submit" name="uploadpic" value="Upload Image">
					</form>
				</div>
				<div id="accountSettingEditBox">
					<p>CHANGE PASSWORD</p>
					<form action="account_setting.php" method="POST">
						<input type="password" name="old_pass" placeholder="Old Password"> &nbsp; <?php echo $err_old_pass; ?> <br />
						<input type="password" name="new_pass" placeholder="New Password"> &nbsp; <?php echo $err_new_pass; ?> <br />
						<input type="password" name="new_pass2" placeholder="Re-type Password"><br />
						<input type="submit" value="Change Password">
					</form>
				</div>
				<div id="accountSettingEditBox">
					<p>CHANGE EMAIL</p>
					<form action="account_setting.php" method="POST">
						<br>
						<?php echo $result_email_poster; ?>
						<br>
						<input type="text" name="new_email" placeholder="New Email"><br /> &nbsp; <?php echo $err_new_email; ?> <br />
						<input type="submit" name="change_pass" value="Change">
					</form>
				</div>
			</div>
		</div>
	</div>


<?php
	}
	include( 'inc/footer.inc.php' );
?>