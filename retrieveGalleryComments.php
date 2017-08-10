<?php
	include( 'inc/connect.inc.php' );
	include( 'inc/func.php' );

	session_start();

	if(!isset($_SESSION['uname_log'])){
		header( "location: index.php" );
	}

	$poster = $_SESSION['uname_log'];

	$timezone = "Asia/Manila";
	date_default_timezone_set ($timezone);

	if($_POST){
		if(isset($_POST['img_url']) && isset($_POST['album_owner'])){
			
			$comment_display = '';
			$img_url = $_POST['img_url'];
			$album_owner = $_POST['album_owner'];
			$upload_id = getGalleryUploadId($img_url);

			$comment_form = '<form method="post">
								<input type="text" id="comment_text" name="comment_text" placeholder="Enter comment..." style="margin-top: 5px; margin-left: 5px; width: 90%;" onkeypress="enterComment(event)">
								<input type="hidden" id="comment_upload_id" value="'. $upload_id .'">
								<input type="hidden" id="comment_by" value="'. $poster .'">
								<input type="hidden" id="comment_date" value="'. date("Y-m-d H:i:s") .'">
								<input type="hidden" id="ao" value="'. $album_owner .'">
								<input type="hidden" id="iurl" value="'. $img_url .'">
							</form><p id="comment_msg"></p>';

			$sql_comments = "SELECT * FROM gallery_comments WHERE upload_id='$upload_id'";
			if($result_comments = $mysqli->query($sql_comments)){
				// Count
				if($result_comments->num_rows > 0){
					while($row_comments = $result_comments->fetch_assoc()){
						$comment_by = $row_comments['comment_by'];
						$comment_date = $row_comments['comment_date'];
						$comment_text = $row_comments['comment_text'];
						$comment_display .= '<hr>';
						$comment_display .= '<div style="padding-bottom: 5px;"><div class="comment_by"><a href="'. $comment_by .'">'. $comment_by .'</a></div><div class="comment_date">('. $comment_date .')</div>';
						$comment_display .= '<div class="comment_text">'. $comment_text .'</div></div>';
					}
				}else{
					$comment_display = '';
				}
			}
			echo '<center><h3>Comments</h3></center>';
			
			echo $comment_display . "<br>";
			echo $comment_form;
		}
	}
?>