<?php
	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header( "location: index.php" );
	}else{
		if(!isset($_POST['delete_post'])){
			// The user did'nt clicked the delete button
			header( "location: forum.php" );
		}else{
			// Get the user
			$poster = $_SESSION['uname_log'];
			$poster_id = $_SESSION['user_id'];
			// Get the post_id
			$post_id = $_POST['post_id'];
			$topic_id = $_POST['topic_id'];
			?>


			<div style="width: 900px; margin: 0px auto 0px auto;">
				<!-- Navigation pane -->
				<div class="homeNav">
					<?php include( 'inc/main_left_nav.php' ); ?>
				</div>	
				<!-- End of Navigation pane -->

				<!-- Main Contents -->
				<div class="homeMainContent">
					<form action="delete_post2.php" method="POST">
						Delete the selected post?
						<input type="hidden" name="delete_post">
						<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
						<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
						<input type="submit" name="confirm" value="Confirm" >
					</form>
					
				</div>
			</div>

			<?php
				
		}
	}


	include( 'inc/footer.inc.php' );
?>