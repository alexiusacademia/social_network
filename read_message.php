<?php
	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header( "location: index.php" );
	}else{
		// Check if conversation is set
		if(!isset($_GET['c'])){
			header( "location: messages.php" );
		}
		$conversation_id = $_GET['c'];
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

				<div class="reply_box">
					<form action="send_message.php" method="POST">
						<textarea type="text" name="message_body" rows="3" class="timeline_input"></textarea>			
						<input type="hidden" name="conversation" value="<?php echo $conversation_id; ?>">
						<input type="submit" name="send_message" value="Send">
					</form>
				</div>


				<div class="conversations">

					<?php getMessages($conversation_id, $poster); ?>

				</div>

				
			</div>
		</div>

		<?php
	}


	include( 'inc/footer.inc.php' );
?>