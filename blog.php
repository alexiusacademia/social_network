<?php
	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header("location: index.php");
	}else{
		$poster = $_SESSION['uname_log'];
		if(isset($_POST['blog_owner'])){
			$blog_owner = $_POST['blog_owner'];
		}else{
			$blog_owner = $poster;
		}
		$poster_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT id FROM users WHERE username='$blog_owner'")));
		$poster_avatar = implode(mysqli_fetch_assoc($mysqli->query("SELECT avatar FROM users WHERE username='$blog_owner'")));

		// Set the timezone
		// My timezone
		$timezone = "Asia/Manila";
		date_default_timezone_set ($timezone);

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
				<h2>Personal Blog</h2>

				<?php
					// Post form if you are the owner
					if($poster == $blog_owner){
						
						// Post to timeline script
						?>
						<div id="homeMainContentBox">
							<form action="blog.php" method="POST">
								<!--<h2>Post on your Blog</h2>-->
								<textarea name="timeline_post" class="timeline_input" rows="6" onkeyup="checkMax(this, 10000)"></textarea>
								<input type="submit" name="submit_timeline" value="Post to Blog">
							</form>
							<?php
								// Post to timeline script
								if(isset($_POST['submit_timeline'])){
									// Check if not empty
									$post_date = date("Y-m-d H:i:s");
									$post_content = $_POST['timeline_post'];
									if($post_content != ""){
										$sql_post_timeline = "INSERT INTO timeline VALUES ('', '$poster_id', '$post_content', '$post_date')";
										if(!$result_post_timeline = $mysqli->query($sql_post_timeline)){
											echo "Error posting!\n";
										}else{
											echo "Your post is successfully added to your personal blog!\n";
										}
									}else{
										echo "You must enter a text in your post!\n";
									}
								}
								// End of post to timeline script
							?>
						</div>

						<script type="text/javascript">
							function checkMax(field, limit){
								if(field.value.length > limit){
									alert(limit + " max character changed!");
									field.value = field.value.substring(0, limit);
								}
							}
						</script>
						<?php
					}
				?>

				<?php
					// Retrieve the user timeline
					$sql_timeline = "SELECT * FROM timeline WHERE poster='$poster_id' ORDER BY timelinE_id DESC";
					if(!$result_timeline = $mysqli->query($sql_timeline)){
						echo "Error in query!\n";
					}else{
						// Count the record
						if($result_timeline->num_rows == 0){
							echo "There is no item yet on the blog.";
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