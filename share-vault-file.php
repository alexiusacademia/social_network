<?php 

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// User not logged in
		header( 'location: index.php' );
	}

	if(!isset($_GET['fid'])){
		header('location: index.php');
	}

	$fid = @$_GET['fid'];

	$poster = $_SESSION['uname_log'];
	$poster_id = $_SESSION['user_id'];

	$file_name = "";
	$file_description = "";

	// Retrieve the record of the file
	$sql_file = "SELECT * FROM vault WHERE file_id='$fid'";
	if($result_file = $mysqli->query($sql_file)){
		// Count
		if($result_file->num_rows > 0){
			while($row_file = $result_file->fetch_assoc()){
				$file_name = $row_file['file_name'];
				$file_description = $row_file['file_description'];
			}
		}else{
			// File doesn't exist
			header( 'location: private_vault.php' );
		}
	}

	?>

	<div class="share-file-form">
		<h4>Share File</h4><br>
		<form method="get" action="share_file.php">
			File:&emsp;&emsp;&emsp;&emsp;<?php echo $file_name; ?><br><br>
			Description:&emsp;<?php echo $file_description; ?><br><br>
			Share to:<br>
			<input type="text" name="recipient" placeholder="Recipient" id="recipient" onkeyup="searchUser(this.value, <?php echo $fid; ?>)">
			<div id="share_search_result"></div><br>
			<input type="text" name="msg" placeholder="Message" size="40"><br><br>
			<input type="hidden" name="file_id" value="<?php echo $fid; ?>">
			<input type="submit" value="Send">
		</form>
	</div>

	<?php

	include( 'inc/footer.inc.php' );

?>