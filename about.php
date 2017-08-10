<?php
	
	include( 'inc/header.inc.php' ); 

	if(isset($_SESSION['uname_log'])){
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
				<em>ABOUT US</em> <br><br>
				<p style="line-height: 30px;" align="justify">
				Ease is considered as the most effective way to do something. We are all seeking for ease when we&#39;re doing 
				something so that it could be done with a shorter period of time. <br>
				Here in <b>niaGroup</b>, one of the factors/secrets so job could be done right way, is the EASE OF COMMUNICATION.
				This site was constructed for the employees of NIA to communicate easily and connect with each other with the latest topics or job to be done. In this site, it features topics on various sections. 
				With this site, we&#39;ll be able to tackle topics that will open our minds to the latest issues regarding our works. 
				</p>
			</div>

		</div>

		<?php

	}else{
		// User not logged in
		header( "location: index.php" );
	}

	include( 'inc/footer.inc.php' );

?>