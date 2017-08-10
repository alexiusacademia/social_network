<?php

	include( 'inc/header.inc.php' );

	// Check if user is logged in
	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header( "location: index.php" );
	}

	$poster = $_SESSION['uname_log'];
	$poster_id = $_SESSION['user_id'];
	$err_search = "";

	if(!isset($_POST['q'])){
		// The user did'nt really searched
		header( "location: index.php" );
	}else{
		$q = $_POST['q'];
		// Check if empty
		if($q == ""){
			// Search is empty
			$err_search = "Search item must not be empty!";
		}else{
			$err_search = "";
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
				<h3>Search Results</h3><br>
				<?php echo $err_search; ?>
				<?php listResults($q); ?>
			</div>
		</div>


		<?php
	}

	include( 'inc/footer.inc.php' );

?>