<?php
	include( 'inc/header.inc.php' );

	// Check if user is logged in
	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in, redirect to homepage
		header( "location: index.php" );
	}else{
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];
		?>
		<div style="width: 900px; margin: 0px auto 0px auto;">
			<!-- Navigation pane -->
			<div class="homeNav">
				<?php include( 'inc/main_left_nav.php' ); ?>
			</div>	
			<!-- End of Navigation pane -->

			<!-- Main Contents -->
			<div class="homeMainContent">
				<div class="messagesTitle">
					<h2>Private Messages</h2>
					<hr>
				</div>

				<div class="conversations">

					<?php getConversations($poster); ?>

				</div>
				
			</div>
		</div>
		<?php
	}

	include( 'inc/footer.inc.php' );
?>