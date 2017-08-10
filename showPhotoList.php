<?php
	//include( 'inc/header.inc.php' );
	session_start();
	include( 'inc/connect.inc.php' );
	if(!isset($_SESSION['uname_log'])){
		header( "location: index.php" );
	}

	if($_POST){
		$album_name = $_POST['album_name'];
		$album_owner = $_POST['owner'];
		$img_list = '';
		$count = 0;

		$sql = "SELECT image_url FROM gallery_uploads WHERE album_name='$album_name' AND owner='$album_owner'";
		if($result = $mysqli->query($sql)){
			// Count record
			if($result->num_rows > 0){
				$img_list .= '<ul>';
				while($rows = $result->fetch_assoc()){
					$img_url = $rows['image_url'];
					//$img_list .= '<li>';
					//$img_list .= '<div class="album_photos">';
					//$img_list .= 	'<li><img src="'. $img_url .'" height="80" class="individual_photo" onclick="showPhoto(\''.$img_url.'\') /></li>';
					//$img_list .= '</div>';
					//$img_list .= '</li>';
					$img_list .= '<li><div class="album_photos">
									<img src="'. $img_url .'" height="80" class="individual_photo" onclick="showPhoto(\''. $img_url .'\',\''. $album_owner .'\')" />
									</div></li>';
				}
				$img_list .= '</ul>';

			}else{
				$img_list = "No uploads yet in this album!";
			}
		}else{
			$img_list = $mysqli->error;
		}
		//echo "Hello";
		echo $img_list;
	}

?>