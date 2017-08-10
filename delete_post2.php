<?php
	include( 'inc/func.php' );
	include( 'inc/connect.inc.php' );

	if(isset($_POST['confirm'])){
		$post_id = $_POST['post_id'];
		$topic_id = $_POST['topic_id'];

		if(!deleteForumPost($post_id)){
			echo $mysqli->error;
		}
			header( 'location: posts.php?topic_id='. $topic_id );
		
	}
?>
