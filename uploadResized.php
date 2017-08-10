<?php
	include( 'inc/header.inc.php' );
	if(!isset($_SESSION['uname_log'])){
		header( "location: index.php" );
	}

	$poster = $_SESSION['uname_log'];
	$poster_id = $_SESSION['user_id'];

	if ($_POST) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		// Generate a random 15 character name
		$rand_dir_name = substr(str_shuffle($chars), 0, 15);
		mkdir("litrato/$rand_dir_name");

	    define('UPLOAD_DIR', 'litrato/' . $rand_dir_name . '/');

	    $d = date("Y-m-d H:i:s");
	    $t = time();
	    

	    $img = $_POST['image'];
	    $img = str_replace('data:image/jpeg;base64,', '', $img);
	    $img = str_replace(' ', '+', $img);
	    $data = base64_decode($img);
	    $file = UPLOAD_DIR . uniqid() . $t . '.jpg';
	    $fname = uniqid() . $t . '.jpg';
	    $success = file_put_contents($file, $data);

	    $album_name = $_POST['album_name'];

	    $sql_upload = "INSERT INTO gallery_uploads VALUES('', '$file', '$fname', '$album_name', '$poster', '$d')";
	    if($result_upload = $mysqli->query($sql_upload)){
	    	// hooray
	    }else{
	    	echo "Error!";
	    }

	    print $success ? $file : 'Unable to save the file.';

	    // Redirect
	}

?>