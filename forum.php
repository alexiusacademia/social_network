<?php

	include( 'inc/header.inc.php' );

	// Set the timezone
	// My timezone
	$timezone = "Asia/Manila";
	date_default_timezone_set ($timezone);

	// Check if the user is logged in
	if(!isset($_SESSION['uname_log'])){
		// Redirect to homepage
		header( "location: index.php" );
	}else{
		// Get the username of the user
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];
		$err_create_topic = "";
		// Check if the user created a topic
		if(isset($_POST['new_topic'])){
			$topic_title = strip_tags($_POST['topic_title']);
			if($topic_title == ""){
				$err_create_topic = "Topic title must not be empty!";
			}else if(strlen($topic_title) < 10){
				$err_create_topic = "Topic title must not be less than 10 characters!";
			}else{
				// Get the category
				$date_created = date("Y-m-d H:i:s");
				$category = $_POST['category'];
				$sql_create_topic = "INSERT INTO forum_topics VALUES ('', '$category', '$topic_title', '$poster', '$date_created')";
				if(!$result_create_topic = $mysqli->query($sql_create_topic)){
					$err_create_topic = "Error creating topic!";
				}else{
					$err_create_topic = "Topic successfully created!";
					//header("location: forum.php");
				}
			}
		}



		// Display the page
		?>

			<div style="width: 900px; margin: 0px auto 0px auto;">
				<!-- Navigation pane -->
				<div class="homeNav">
					<?php include( 'inc/main_left_nav.php' ); ?>
				</div>	
				<!-- End of Navigation pane -->

				<!-- Main Contents -->
				<div class="homeMainContent">
					<h2>Discussion Board</h2>
						<hr>
							<h3>Create Topic</h3>
							<?php echo $err_create_topic; ?>
							<form action="forum.php" method="POST">
								<input type="text" name="topic_title" placeholder="Enter topic title" size="60">
								<select name="category" required>
									<?php getForumCategories() ?>
								</select>
								<input type="submit" name="new_topic" value="Create Topic">
							</form>
							<br>
							<hr>
					
						
							<?php
								// Retrieve category names
								$sql_cat_name = "SELECT * FROM forum_cat";
								if(!$result_cat_name = $mysqli->query($sql_cat_name)){
									echo $mysqli->error;
								}else{
									while($row_cat_name = $result_cat_name->fetch_assoc()){
										$cat_name = $row_cat_name['cat_name'];
										$cat_id = $row_cat_name['cat_id'];
										echo '	<div class="board_category">
													<div class="board_category_header">
													'. $cat_name .'
													</div>';

										getTopics($cat_id);

										echo '	</div>';
									}
								}
							?>
						
					
				</div>
				<!-- End of Main Contents -->
			</div>
		<?php
	}


	include( 'inc/footer.inc.php' );

?>