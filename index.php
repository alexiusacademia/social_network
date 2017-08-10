<?php
	include( 'inc/header.inc.php' );
	if(isset($_SESSION['uname_log'])){
		header("location: home.php");
	}

	$err_login = "";
	$err_reg = "";
?>

<?php
	/********************/
	/* For registration */
	/********************/

	// Set the timezone
	// My timezone
	$timezone = "Asia/Manila";
	date_default_timezone_set ($timezone);

	$reg = @$_POST['reg'];
	// Declare variables
	$fn = "";			// First name
	$ln = "";			// Last name
	$un = "";			// User name
	$sex = "";		// Sex
	$em = "";			// Email
	$em2 = "";			// Email 2
	$pass = "";			// Password
	$pass2 = "";		// Password 2
	$d = "";			// Sign up date
	$avatar = "";		// Avatar url

	$u_check = "";		// Check if username exist
	// Registration form
	$fn = strip_tags(@$_POST['fname']);
	$ln = strip_tags(@$_POST['lname']);
	$un = strip_tags(@$_POST['uname']);
	$sex = strip_tags(@$_POST['sex']);
	$em = strip_tags(@$_POST['email']);
	$em2 = strip_tags(@$_POST['email2']);
	$pass = strip_tags(@$_POST['password']);
	$pass2 = strip_tags(@$_POST['password2']);
	$d = date("Y-m-d H:i:s");			// Year-month-day
	$region = strip_tags(@$_POST['region']);

	// Decide for default avatar
	if($sex == "male"){
		$avatar = "img/male.jpg";
	}else{
		$avatar = "img/female.jpg";
	}

	if($reg){
		// Check the email if the same
		if($em == $em2){
			// Check if username exists
			$u_check = "SELECT username FROM users WHERE username='$un'";
			if(!$result1 = $mysqli->query($u_check)){
				// Oh no! The query failed. 
			    echo "Sorry, the website is experiencing problems.";

			    // Again, do not do this on a public site, but we'll show you how
			    // to get the error information
			    echo "Error: Our query failed to execute and here is why: \n";
			    echo "Query: " . $u_check . "\n";
			    echo "Errno: " . $mysqli->errno . "\n";
			    echo "Error: " . $mysqli->error . "\n";
			    exit;
			}
			// Count the amount of rows with username $un
			if($result1->num_rows == 0){
				// This means the user doesn't exist yet
				// Check if all the fields are filled
				if($fn && $ln && $un && $em && $em2 && $pass && $pass2){
					// Check if the password matched
					if($pass == $pass2){
						// The password matched
						// Check the maximum lenth of firstname/lastname/username <= 25 characters
						if(strlen($un) > 25 || strlen($fn) > 25 || strlen($ln) > 25){
							$err_reg = "The maximum allowed characters for username, first name and last name is 25!<br>";
						}else{
							// Check the maximum and minimum length of password
							if(strlen($pass) > 30 || strlen($pass) < 5){
								$err_reg = "Password must be between 5 and 30 characters!<br>";
							}else{
								// Encrypt the password before sending to database
								$pass = md5($pass);
								$query = "INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$sex', '$em', '$pass', '$d', '$avatar', '1', '$region')";
								if(!$result2 = $mysqli->query($query)){
									echo "An error has occured!<br>";
								}else{
									
									$err_reg = "<h2>Congratulations! You can now login to your account.</h2><br>";
									
								}
								
							}
						}
					}else{
						$err_reg = "Your password didn't matched!<br>";
					}
				}else{
					$err_reg = "Please fill in all the fields.<br>";
				}
			}else{
				$err_reg = "Sorry, this username is taken.<br>";
			}
		}else{
			$err_reg = "Your emails didn't matched!<br>";
		}
	}
	/*************/
	/* For Login */
	/*************/
	if(isset($_POST['uname_log']) && isset($_POST['password_log'])){
		$username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['uname_log']);
		$password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['password_log']);
		$password = md5($password);
		$query3 = "SELECT id FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		if(!$result3 = $mysqli->query($query3)){
			// Oh no! The query failed. 
			echo "Sorry, the website is experiencing problems.";

			// Again, do not do this on a public site, but we'll show you how
			// to get the error information
			echo "Error: Our query failed to execute and here is why: \n";
			echo "Query: " . $query3 . "\n";
			echo "Errno: " . $mysqli->errno . "\n";
			echo "Error: " . $mysqli->error . "\n";
			exit;
		}
		// Count the record if user exist
		if($result3->num_rows == 1){
			$row3 = $result3->fetch_assoc();
			$id = $row3['id'];
			// Save session
			//session_start();
			$_SESSION['uname_log'] = $username;
			$_SESSION['user_id'] = $id;
			
			$s_id = session_id();
			$_SESSION['id'] = $s_id;
			$t = date("Y-m-d H:i:s");

			// Delete existing log
			deleteExistingActive($username);
			$sql_session = "INSERT INTO users_log VALUES ('', '$s_id', '$username', '$t', '1')";
			if($result_session = $mysqli->query($sql_session)){
				header("location: home.php");
			}
			
			
			//exit();
		}else{
			/*
			echo '<div id="wrapperAbout">';
			echo "Login failed! Please check your username and password.\n";
			echo '</div>'; */
			$err_login = "Login failed! Please check your username and password.";
			
		}
	}
?>

		<!-- Designing the homepage -->
		<div style="width: 800px; margin: 0px auto 0px auto; position: relative; top: 60px;">
			<table>
				<tr>
					<td width="60%" valign="top" class="mainPage">
						<h2>Already a member? <br>Login below!</h2>
						<form action="index.php" method="POST">
							<input type="text" name="uname_log" size="25" placeholder="Username"><br>
							<input type="password" name="password_log" size="25" placeholder="Password"><br>
							<input type="submit" name="login" value="Sign In">
						</form>

						<br>

						<?php echo $err_login; ?>

					</td>
					<td width="40%" valign="top">
						<h2>Are you a NIA employee or Affiliate?<br> <br>Join Us!</h2>
						<form action="index.php" method="POST">
							<input type="text" name="fname" size="25" placeholder="First Name"><br>
							<input type="text" name="lname" size="25" placeholder="Last Name"><br>
							<input type="text" name="uname" size="25" placeholder="User Name"><br>
							
							<table cellpadding="10">
								<tr valign="top">
									<td>Gender</td>
									<td align="right">
										<input type="radio" name="sex" value="male" checked> Male<br>
										<input type="radio" name="sex" value="female"> Female
									</td>
								</tr>
								<tr>
									<td>Regional Office &nbsp; &nbsp; &nbsp;</td>
									<td align="right">
										<select name="region" required>
											<option value="CAR">C.A.R.</option>
											<option value="Region 1">Region 1</option>
											<option value="Region 2">Region 2</option>
											<option value="MRIIS">MRIIS</option>
											<option value="Region 3">Region 3</option>
											<option value="UPRIIS">UPRIIS</option>
											<option value="Region 4A">Region 4A</option>
											<option value="Region 4B">Region 4B</option>
											<option value="Region 5">Region 5</option>
											<option value="Region 6">Region 6</option>
											<option value="Region 7">Region 7</option>
											<option value="Region 8">Region 8</option>
											<option value="Region 9">Region 9</option>
											<option value="Region 10">Region 10</option>
											<option value="Region 11">Region 11</option>
											<option value="Region 12">Region 12</option>
											<option value="Region 13">Region 13</option>
											<option value="Central Office">Central Office</option>
										</select>
									</td>
								</tr>
							</table>
							
							<input type="text" name="email" size="25" placeholder="Email"><br>
							<input type="text" name="email2" size="25" placeholder="Re-enter Email"><br>
							<input type="password" name="password" size="25" placeholder="Password"><br>
							<input type="password" name="password2" size="25" placeholder="Retype Password"><br>
							<input type="submit" name="reg" value="Sign Up">
						</form>
					</td>
					<br>
					<?php echo $err_reg; ?>
				</tr>
			</table>
<?php
	//include( 'inc/footer.inc.php' );
?>