<?php

	include( 'inc/header.inc.php' );
	if(!isset($_SESSION['uname_log'])){
		// Redirect to homepage
		header("location: index.php");
	}else{
		$poster = $_SESSION['uname_log'];
		?>

		<div style="width: 900px; margin: 0px auto 0px auto;">
			<!-- Navigation pane -->
			<div class="homeNav">
				<?php include( 'inc/main_left_nav.php' ); ?>
			</div>	
			<!-- End of Navigation pane -->

			<!-- Main Contents -->
			<div class="homeMainContent">
				<h3>Online Members</h3><br>
				<hr>
				<br>
				<?php
					$sql = "SELECT * FROM users_log WHERE status='1'";
					if(!$result = $mysqli->query($sql)){
						echo "Problem in query.\n";
						exit();
					}else{
						if($result->num_rows > 0){
							while($row = $result->fetch_assoc()){
								$username = $row['username'];
								$user_id = getUserId($username);
								echo 	"<div id='members'>

											<a href='". $username ."'>
												". getAvatar($user_id) . getName($user_id) . "

											</a>
										</div>";
							}
						}else{
							echo "No members yet.\n";
						}
					}
				?>
			</div>
		</div>

		<?php
	}

	include( 'inc/footer.inc.php' );

?>