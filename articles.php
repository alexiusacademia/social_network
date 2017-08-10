<?php

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header( "location: index.php" );
	}

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
			<div class="article_heading_left"><h2>Articles</h2></div>
			<div class="article_heading_right"><a href="submit_article.php">+Submit Article</a></div>
			<div class="article_list">
				<?php getArticleList(); ?>
			</div>
		</div>
	</div>


	<?php

	include( 'inc/footer.inc.php' );

?>