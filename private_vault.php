<?php

	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// User not logged in
		header( "location: index.php" );
	}

	$poster = $_SESSION['uname_log'];
	$pster_id = $_SESSION['user_id'];

	$upload_msg = "";

	$file_display = "";

	// Check if the user wanted to view a category
	if(isset($_GET['fcat'])){
		$cat = $_GET['fcat'];
		
		switch ($cat) {
			case 'img':
				$file_display = "<table border='1' cellpadding='20' style='border-collapse:collapse;'><caption><h2>Image Files</h2></caption>
									<tr height='40'>
										<td width='150' align='center'><h3>Filename</h3></td>
										<td width='200' align='center'><h3>Description</h3></td>
										<td width='100' align='center'><h3>File Size</h3></td>
										<td align='center'><h3>Action</h3></td>
									</tr>
								";
				// Show image files
				$sql_img = "SELECT * FROM vault WHERE file_owner='$poster' AND file_cat='image'";
				if($result_img = $mysqli->query($sql_img)){
					// Count the record
					if($result_img->num_rows > 0){
						while($row_img = $result_img->fetch_assoc()){
							$file_id = $row_img['file_id'];
							$file_name = $row_img['file_name'];
							$file_description = $row_img['file_description'];
							$file_size = $row_img['file_size']/1000;
							$file_url = $row_img['file_url'];
							$file_display = $file_display . 
										'<tr height="30">
											<td>' . $file_name . '</td>
											<td>'. $file_description .'</td>
											<td align="center">'. $file_size .' kb</td>
											<td align="center"><a href="'. $file_url .'">Download</a>&nbsp;|&nbsp;
											<a href="share-vault-file.php?fid='. $file_id .'">Share</a>
											<form id="share_form">
												<input name="file_id" type="hidden" value="'.$file_id.'">'.
												//<input type="button" id="share_button" onclick="showShareForm()" value="Share">
											'</form>'
										. '</td></tr>';
						}

						$file_display = $file_display . "</table><br><div id='share_to_user' class='share_to_user'><div id='share_file_form'></div><div id='share_search_result'></div></div>";
					}else{
						$file_display = "No upload yet in this category!";
					}
				}
				break;
			
			case 'docs':
				// Show docs files
				$file_display = "<table border='1' cellpadding='20' style='border-collapse:collapse;'><caption><h2>Document Files</h2></caption>
									<tr height='40'>
										<td width='150' align='center'><h3>Filename</h3></td>
										<td align='center'><h3>Description</h3></td>
										<td width='100' align='center'><h3>File Size</h3></td>
										<td align='center'><h3>Action</h3></td>
									</tr>
								";
				// Show image files
				$sql_docs = "SELECT * FROM vault WHERE file_owner='$poster' AND file_cat='docs'";
				if($result_docs = $mysqli->query($sql_docs)){
					// Count the record
					if($result_docs->num_rows > 0){
						while($row_docs = $result_docs->fetch_assoc()){
							$file_id = $row_docs['file_id'];
							$file_name = $row_docs['file_name'];
							$file_description = $row_docs['file_description'];
							$file_size = $row_docs['file_size']/1000;
							$file_url = $row_docs['file_url'];

							$file_display = $file_display . 
										'<tr height="30">
											<td>' . $file_name . '</td>
											<td>'. $file_description .'</td>
											<td align="center">'. $file_size .' kb</td>
											<td align="center"><a href="'. $file_url .'">Download</a>&nbsp;|&nbsp;
											<a href="share-vault-file.php?fid='. $file_id .'">Share</a>
											<form id="share_form">
												<input name="file_id" type="hidden" value="'.$file_id.'">'.
												//<input type="button" id="share_button" onclick="showShareForm()" value="Share">
											'</form>'
										. '</td></tr>';
						}

						$file_display = $file_display . "</table><br><div id='share_to_user' class='share_to_user'><div id='share_file_form'></div><div id='share_search_result'></div></div>";
						
					}else{
						$file_display = "No upload yet in this category!";
					}
				}
				break;

			case 'others':
				// Show other files
				// Show docs files
				$file_display = "<table border='1' cellpadding='20' style='border-collapse:collapse;'><caption><h2>Other Files</h2></caption>
									<tr height='40'>
										<td width='150' align='center'><h3>Filename</h3></td>
										<td width='200' align='center'><h3>Description</h3></td>
										<td width='100' align='center'><h3>File Size</h3></td>
										<td align='center'><h3>Action</h3></td>
									</tr>
								";
				// Show image files
				$sql_others = "SELECT * FROM vault WHERE file_owner='$poster' AND file_cat='others'";
				if($result_others = $mysqli->query($sql_others)){
					// Count the record
					if($result_others->num_rows > 0){
						while($row_others = $result_others->fetch_assoc()){
							$file_id = $row_others['file_id'];
							$file_name = $row_others['file_name'];
							$file_description = $row_others['file_description'];
							$file_size = $row_others['file_size']/1000;
							$file_url = $row_others['file_url'];

							$file_display = $file_display . 
										'<tr height="30">
											<td>' . $file_name . '</td>
											<td>'. $file_description .'</td>
											<td align="center">'. $file_size .' kb</td>
											<td align="center"><a href="'. $file_url .'">Download</a>&nbsp;|&nbsp;
											<a href="share-vault-file.php?fid='. $file_id .'">Share</a>
											<form id="share_form">
												<input name="file_id" type="hidden" value="'.$file_id.'">'.
												//<input type="button" id="share_button" onclick="showShareForm()" value="Share">
											'</form>'
										. '</td></tr>';
						}

						$file_display = $file_display . "</table><br><div id='share_to_user' class='share_to_user'><div id='share_file_form'></div><div id='share_search_result'></div></div>";

					}else{
						$file_display = "No upload yet in this category!";
					} 	
				}
				break;
		}
	}

	// Check if action is uploading
	if(isset($_FILES['file'])){
		if($_POST['file_description'] != ""){
			if((@$_FILES['file']['size'] <= 1572864)){
				// File size is within the allowable limit
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				// Generate a random 15 character name
				$rand_dir_name = substr(str_shuffle($chars), 0, 15);
				mkdir("vault/$rand_dir_name");
				// Check if file exists
				if (file_exists("vault/$rand_dir_name/".@$_FILES["file"]["name"])){
					// The same filename exists
					$upload_msg = @$_FILES["file"]["name"]." Already exists";
				}else{
					// Move uploaded files
					$t = time();
					$da = date("Y-m-d H:i:s");
					move_uploaded_file(@$_FILES["file"]["tmp_name"],"vault/$rand_dir_name/" . $t . $_FILES["file"]["name"]);
					$file_name = @$_FILES["file"]["name"];
					$file_url = "vault/$rand_dir_name/" . $t . $_FILES["file"]["name"];
					$upload_msg = $file_url;
					$file_owner = $poster;
					$file_cat = $_POST['file_cat'];
					$file_size = @$_FILES['file']['size'];
					$file_description = allow_chars($_POST['file_description'],array("b", "i"));

					$sql_file_upload = "INSERT INTO vault VALUES('', '$file_url', '$file_name', '$file_description', '$file_cat', '$file_owner', '$file_size', '$da')";
					if($result_file_upload = $mysqli->query($sql_file_upload)){
						$upload_msg = "File uploaded successfully!\n";
					}else{
						$upload_msg = $mysqli->error;
					}
				}
			}else{
				$upload_msg = "File size must not be more than 1.5MB!\n";
			}
		}else{
			$upload_msg = "File description must not be empty!\n";
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
			<div id="homeMainContentBox">
				<h3>Private Vault</h3>
				<div>&nbsp;</div>
				<div id="accountSettingEditBox">
					
					<p>UPLOAD FILE TO THE VAULT: [max. file size: 1.5MB]</p>
					<br>
					<form action="private_vault.php" method="POST" enctype="multipart/form-data">
						<table>
							<tr height="35">
								<td width="150">Select File&nbsp;</td>
								<td><input type="file" name="file" style="padding: 5px; height: 20px;" /></td>
							</tr>
							<tr height="35">
								<td>Category&nbsp;</td>
								<td>
									<select name="file_cat" required style="padding: 3px;">
										<option value="image">Image Files</option>
										<option value="docs">Document Files</option>
										<option value="others">Other Files</option>
									</select>
								</td>
							</tr>
							<tr height="35">
								<td>File Description&nbsp;</td>
								<td><input type="text" name="file_description"></td>
							</tr>
							<tr height="35">
								<td></td>
								<td><input type="submit" name="uploadfile" value="Upload File"></td>
							</tr>
						</table>	
					</form>
					<br>
					<?php echo $upload_msg; ?>
					<hr>
				</div>
				<center><h3>Vault Categories</h3></center>
				<div>&nbsp;</div>
				<div id="vault_folder"><a href="<?php $_SERVER['PHP_SELF'] ?>?fcat=img">Images Files</a></div>
				<div id="vault_folder"><a href="<?php $_SERVER['PHP_SELF'] ?>?fcat=docs">Document Files</a></div>
				<div id="vault_folder"><a href="<?php $_SERVER['PHP_SELF'] ?>?fcat=others">Others</a></div>
			</div>
			<hr>

			<?php echo $file_display; ?>

		</div>
		<!-- End of Main Contents -->
	</div>

	<?php

	include( 'inc/footer.inc.php' );

?>