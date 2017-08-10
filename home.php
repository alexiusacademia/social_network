<?php
	include( 'inc/header.inc.php' );

	// Check if the user is logged in
	if(!isset($_SESSION['uname_log'])){
		header("location: index.php");
	}else{
		// Get the username of the user
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];

		$latest_member_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT id FROM users ORDER BY id DESC LIMIT 1")));
		$latest_member_fname = implode(mysqli_fetch_assoc($mysqli->query("SELECT first_name FROM users WHERE id='$latest_member_id'")));
		$latest_member_lname = implode(mysqli_fetch_assoc($mysqli->query("SELECT last_name FROM users WHERE id='$latest_member_id'")));
		$latest_member_username = implode(mysqli_fetch_assoc($mysqli->query("SELECT username FROM users WHERE id='$latest_member_id'")));
		$latest_member_avatar = implode(mysqli_fetch_assoc($mysqli->query("SELECT avatar FROM users WHERE id='$latest_member_id'")));
?>

<div style="width: 900px; margin: 0px auto 0px auto;">
	<!-- Navigation pane -->
	<div class="homeNav">
		<?php include( 'inc/main_left_nav.php' ); ?>

		<hr>
		<br>
		<table name="latest_topic" class="latest_topic">
				<tr>
					<td>
						<h3>Latest Topic</h3>
					</td>
				</tr>
				<tr>
					<td>
						<?php getLatestTopic(); ?>
					</td>
				</tr>
			</table>
			<br>
			<hr>
			<br>
		<table name="newest_member" class="latest_topic">
			<tr>
				<td>
					<h3>Newest Member</h3>
				</td>
			</tr>
			<tr>
				<td>
					<a href="<?php echo $latest_member_username; ?>">
						<img src="<?php echo $latest_member_avatar; ?>" width="80" height="90">
						<?php echo "<br>" . $latest_member_fname ." ". $latest_member_lname; ?>
					</a>
				</td>
			</tr>
		</table>	
	</div>	
	<!-- End of Navigation pane -->

	<!-- Main Contents -->
	<div class="homeMainContent">
		<div id="homeMainContentBox">
			<h3>Latest Post</h3>
			<div class="post_box">
				<?php getLatestPost(); ?>
			</div>
		</div>
			
		<div id="homeMainContentBox">
			<h3>Latest Article</h3>
			<div class="article_box">
				<?php getLatestArticle(); ?>
			</div>
		</div>
		<div id="homeMainContentBox">
			<?php //include( 'simplestats/simplestats.inc' ); ?>
		</div>

	</div>
	<!-- End of Main Contents -->
</div>

<?php
	}
	include( 'inc/footer.inc.php' );
?>