<?php

	include( 'inc/header.inc.php' );

	// Check if logged in
	checkLogin();

	$poster = $_SESSION['uname_log'];
	$poster_id = $_SESSION['user_id'];

	if(!isset($_GET['a'])){
		header( "location: articles.php" );
	}

	$article_id = $_GET['a'];

	// Script for article deletion
	if(isset($_POST['delete_article'])){
		deleteArticle($article_id);
	}
	// End of script for article deletion

	// Find the article in the database
	$sql_article = "SELECT * FROM articles WHERE article_id='$article_id'";
	if($result_article = $mysqli->query($sql_article)){
		// Count if there is a record
		if($result_article->num_rows > 0){
			// There is a record
			$row_article = $result_article->fetch_assoc();
			$posted_by = $row_article['posted_by'];
			$article_title = $row_article['article_title'];
			// Check if the user owns the article
			if($poster_id == $posted_by){
				?>

				<div style="width: 900px; margin: 0px auto 0px auto;">
					<!-- Navigation pane -->
					<div class="homeNav">
						<?php include( 'inc/main_left_nav.php' ); ?>
					</div>	
					<!-- End of Navigation pane -->

					<!-- Main Contents -->
					<div class="homeMainContent">
					<form action="delete_article.php?a=<?php echo $article_id; ?>" method="POST">
						Delete article ('<?php echo $article_title; ?>')?&nbsp;
						<input type="submit" name="delete_article" value="Confirm">
					</form>
					</div>
				</div>

				<?php
			}
		}
	}

	include( 'inc/footer.inc.php' );

?>