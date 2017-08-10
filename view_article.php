<?php

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header("location: index.php");
	}

	// Check if article id is set
	if(!isset($_GET['a'])){
		// Not set
		header( "location: articles.php" );
	}

	// Get the article id
	$article_id = $_GET['a'];
	// Check if numeric
	if(!is_numeric($article_id)){
		// article id set is not numeric, redirect
		header( "location: articles.php" );
	}

	// Get the user
	$poster = $_SESSION['uname_log'];
	$poster_id = $_SESSION['user_id'];

	// Retrieve from the database
	$err_article = "";
	$sql_view_article = "SELECT * FROM articles WHERE article_id='$article_id'";
	if(!$result_view_article = $mysqli->query($sql_view_article)){
		echo "<br><br><br><br>" . $mysqli->error;
	}else{
		// Count the record if to know if it exists
		if($result_view_article->num_rows == 0){
			// The article doesn't exist!
			header( "location: articles.php" );
		}else{
			// Retrieve it
			$row_view_article = $result_view_article->fetch_assoc();
			$article_title = $row_view_article['article_title'];
			$article_body = $row_view_article['article_body'];
			$posted_by = getUsername($row_view_article['posted_by']);
			$date_posted = $row_view_article['date_posted'];

			?>

			<div style="width: 900px; margin: 0px auto 0px auto;">
				<!-- Navigation pane -->
				<div class="homeNav">
					<?php include( 'inc/main_left_nav.php' ); ?>
				</div>	
				<!-- End of Navigation pane -->

				<!-- Main Contents -->
				<div class="homeMainContent">
					<h2><?php echo $article_title; ?></h2>
					<br>
					<div id="labels">Posted by:&nbsp;</div>
					<div class="view_article_posted_by"><a href="<?php echo $posted_by; ?>"><?php echo $posted_by; ?></a></div>
					<div class="article_body"><?php echo $article_body; ?></div>
					<?php
						// Check if the owner own the article, if it is, show delete
						if($poster == $posted_by){
							echo '<a href="delete_article.php?a='. $article_id .'" style="padding: 10px;">Delete Entry</a>';
						}
					?>
				</div>
			</div>

			<?php
		}
	}

	include( 'inc/footer.inc.php' );

?>