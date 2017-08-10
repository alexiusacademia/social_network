<?php

	include( 'inc/header.inc.php' );

	// Set the timezone
	// My timezone
	$timezone = "Asia/Manila";
	date_default_timezone_set ($timezone);

	// Check if logged in
	if(!isset($_SESSION['uname_log'])){
		// The user isn't log in
		header( "location: articles.php" );
	}

	$poster = $_SESSION['uname_log'];
	$poster_id = $_SESSION['user_id'];

	$err_submit_article = "";

	if(isset($_POST['submit_article'])){
		// Get the data
		$article_title = allow_chars($_POST['article_title'], array("b"));
		$article_body = allow_chars($_POST['article_body'], array("b", "i", "br/"));
		$date_posted = date("Y-m-d H:i:s");

		$sql_submit_article = "INSERT INTO articles VALUES ('', '$article_title', '$article_body', '$poster_id', '$date_posted')";
		if(!$result_submit_article = $mysqli->query($sql_submit_article)){
			$err_submit_article = $mysqli->error;
		}else{
			$err_submit_article = "Article successfully submitted!\n";
		}
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
			<h2>Submit an Article</h2>
			<br>
			<?php echo $err_submit_article; ?>
			<form action="submit_article.php" method="POST">
				<font style="font-size: 12px;">Title</font><br>
				<input type="text" name="article_title" placeholder="Title of the Article"><br>
				<font style="font-size: 12px;">Body</font><br>
				<textarea name="article_body" placeholder="Article contents..." rows="15" cols="100%" style="background-color: #FFFFFF;"></textarea>
				<input type="submit" name="submit_article" value="Submit">
			</form>
		</div>
	</div>

	<?php

	include( 'inc/footer.inc.php' );

?>