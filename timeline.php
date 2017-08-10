<?php
	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header("location: index.php");
	}else{
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];
		$poster_avatar = implode(mysqli_fetch_assoc($mysqli->query("SELECT avatar FROM users WHERE username='$poster'")))

	?>

	<div style="width: 900px; margin: 0px auto 0px auto;">
		<!-- Navigation pane -->
		<div class="homeNav">
			<?php include( 'inc/main_left_nav.php' ); ?>
		</div>	
		<!-- End of Navigation pane -->

		<!-- Main Contents -->
		<div class="homeMainContent">
			<div id="homeMainContentBox">
				<h2>Timeline</h2>

				<?php
					// Retrieve the user timeline
					$sql_timeline = "SELECT * FROM timeline WHERE poster='$poster_id'";
					if(!$result_timeline = $mysqli->query($sql_timeline)){
						echo "Error in query!\n";
					}else{
						// Count the record
						if($result_timeline->num_rows == 0){
							echo "There is no item yet on the timeline.";
						}else{
							// Query all the items
							while($row_timeline = $result_timeline->fetch_assoc()){
								$post_content = $row_timeline['post'];
								$post_date = $row_timeline['post_date'];
								$post_date = date('F d, Y H:i:s', strtotime($post_date));
								echo '
									<div class="timeline_content">
										<div class="timeline_header">
											<a href="' . $poster . '"><img src="'. $poster_avatar .'" width="25" height="25" /></a>
											'. $post_date .'
										</div>

										<div class="timeline_body">
											'. $post_content .'
										</div>
										
									</div>
								';
							}	
						}
					}
				?>

			</div>
		</div>
	</div>

	<?php
	}
	include( 'inc/footer.inc.php' );
?>