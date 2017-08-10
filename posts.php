<?php

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// The user is not logged in
		header( "location: index.php" );
	}else{
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];

		if(!isset($_GET['topic_id'])){
			// Topic id not specified
			header( "location: forum.php" );
		}

		// Get the topic id
		$topic_id = $_GET['topic_id'];
		// Get the topic title
		$topic_title = implode(mysqli_fetch_assoc($mysqli->query( "SELECT topic_title FROM forum_topics WHERE topic_id='$topic_id'" )));

		?>
			<div style="width: 900px; margin: 0px auto 0px auto;">
				<!-- Navigation pane -->
				<div class="homeNav">
					<?php include( 'inc/main_left_nav.php' ); ?>
				</div>	
				<!-- End of Navigation pane -->

				<!-- Main Contents -->
				<div class="homeMainContent">
					<div class="posts_header">
						<!-- Display the Topic Title -->
						<?php echo $topic_title; ?>
						<br>
						<a href="#reply">Post a Reply</a>
					</div>
					<?php
						$limit_query = mysqli_query($mysqli, "SELECT COUNT(post_id) FROM forum_posts WHERE topic='$topic_id'");
						$row_query = mysqli_fetch_row($limit_query);
						$total_rows = $row_query[0];
						// Result per page
						$limit_per_page = 10;
						// Last page
						$last_page = ceil($total_rows/$limit_per_page);
						// Last page cannot be less than one
						if($last_page<1){
							$last_page = 1;
						}
						// Establish page num variable
						$pagenum = 1;
						if(isset($_GET['pn'])){
							$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
						}
						if($pagenum < 1){
							$pagenum = 1;
						}else if($pagenum > $last_page){
							$pagenum = $last_page;
						}
						// Set range or rows for every page
						$limit = 'LIMIT ' . ($pagenum-1) * $limit_per_page . ',' . $limit_per_page;
						// Query per page by applying limit
						$sql_forum_posts = "SELECT * FROM forum_posts WHERE topic='$topic_id' ORDER BY post_id DESC $limit";



						//$sql_forum_posts = "SELECT * FROM forum_posts WHERE topic='$topic_id' ORDER BY post_id DESC";

						if(!$result_forum_posts = $mysqli->query($sql_forum_posts)){
							echo $mysqli->error;
							echo "<br>" . $mysqli->errno;
						}else{

							// Show user where page are they
							$textline1 = "Total <b>$total_rows</b>";
							$textline2 = "Page <b>$pagenum</b> of <b>$last_page</b>";
							$paginationCtrls = '';
							if($last_page != 1){
								if($pagenum > 1){
									$previous = $pagenum - 1;
									$paginationCtrls .= '<a href="'. $_SERVER['PHP_SELF'] .'?topic_id='. $topic_id .'&pn='.$previous.'">Previous</a> &nbsp; &nbsp;';

								}
								if($pagenum != $last_page){
									$next = $pagenum + 1;
									$paginationCtrls .= '&nbsp; &nbsp; <a href="'. $_SERVER['PHP_SELF'] .'?topic_id='. $topic_id .'&pn='.$next.'">Next</a> ';
								}
							}


							while($row_forum_posts = $result_forum_posts->fetch_assoc()){
								$post_id = $row_forum_posts['post_id'];
								$posted_by = $row_forum_posts['posted_by'];
								$post_body = $row_forum_posts['post_body'];
								$date_posted = $row_forum_posts['date_posted'];
								?>
									<div class="post_box">
										<div class="poster_detail">
											<div class="poster_avatar">
												<?php getAvatar($posted_by); ?>
											</div>
											<div class="poster_username">
												<?php getName($posted_by); ?>
											</div>
											<div class="post_date">
												<?php echo 'Posted on: ' . $date_posted; ?>
											</div>
										</div>
										<div class="post_body">
											<?php echo $post_body; ?>
										</div>
										<?php
											// Check if the viewer is the poster
											if($poster_id == $posted_by){
												?>
													<div class="post_footer">
														<form action="delete_post.php" method="POST">
															<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
															<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
															<input type="submit" name="delete_post" value="Delete" class="delete_button" >
														</form>
													</div>
												<?php
											}
										?>
										
									</div>
								<?php
							}

							echo $textline1 . "<br>" . $textline2;
							echo $paginationCtrls;
						}
					?>
					<a name="reply">
					<div class="reply_box">
						<form action="post_reply.php" method="POST">
							<textarea id="txtArea" onkeypress="addNewLine()" type="text" name="post_reply" rows="4" class="timeline_input"></textarea>
							<script type="text/javascript">
								function addNewLine() {
								    var key = event.keyCode;

								    // If the user has pressed enter
								    if (key == 13) {
								    	var myText = document.getElementById("txtArea").value
								        document.getElementById("txtArea").value = myText + "<br/>";
								        return false;
								    }
								    else {
								        return true;
								    }
								}
							</script>
							
							<input type="hidden" name="reply_topic" value="<?php echo $topic_id; ?>">
							<input type="submit" name="submit_post" value="Post a Reply">
						</form>
					</div>
				</div>
			</div>

		<?php

	}

	include( 'inc/footer.inc.php' );

?>