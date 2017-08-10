<?php 
	include( 'inc/header.inc.php' );

	if(!isset($_SESSION['uname_log'])){
		// user is not logged in
		header( "location: index.php" );
	}else{
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];	

		$upload_form = '';
		$gallery_album_list = '';

		// Check if gallery owner is set
		if(!isset($_GET['gallery_owner'])){
			header( "location: index.php" );
		}else{
			$gallery_owner = $_GET['gallery_owner'];
			if($gallery_owner == ""){
				header( "location: index.php" );
			}else{
				// Check if the viewer is the owner
				if($poster == $gallery_owner){
					$upload_form = '<form enctype="multipart/form-data" method="post" action="">
										<div class="gallery_upload_row">
											Select Album &nbsp;&nbsp;<select name="album" id="album_name" required>'. retrieveAlbumList($poster) .'</select><br><br>
											<label for="fileToUpload"><h3>Select Image to Upload</h3></label>
											<input type="file" name="fileToUpload[]" id="imgToUpload" multiple="multiple"/>
											
											<br>
											<output id="filesInfo"></output>
											<br>
										</div>
									</form>
									<hr>
									<br>
									<form action="" method="post">
										&nbsp;Create New Album&nbsp;&nbsp;
										<input type="text" name="new_album_name" placeholder="Enter Album Name" onkeypress="handle(event)" id="new_album_name">
										<input type="hidden" id="album_owner" value="'. $poster .'">
										<p id="create_album_message"></p>
									</form><br>';
				}else{
					$upload_form = '';
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
				<div class="upload_form"><?php echo $upload_form;  ?></div>
				<div class="album_title"><h2>ALBUMS</h2></div>
				<div class="albums">
					<ul>
						<?php
							displayAlbums($gallery_owner);
						?>
					</ul>
				</div>

				<div class="album_view">
					<p id="list_photo_title" class="album_title"></p>
					<p id="list_photo" class="list_photo"></p>
				</div>

				<div class="photo_view" id="photo_view">

				</div>
			</div>

		</div>
		

		<?php
			}
		}
	}
 ?>
	 
	 


<!-- Script for resize nd upload -->
 <script>
 	function enterComment(e){
 		if(e.keyCode == 13){
 			var comment_by = document.getElementById('comment_by').value;
 			var upload_id = document.getElementById('comment_upload_id').value;
 			var comment_text = document.getElementById('comment_text').value;
 			var comment_date = document.getElementById('comment_date').value;

 			var xhr = new XMLHttpRequest();
 			xhr.open('POST', 'commentGallery.php', true);
		    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		    var data = 'upload_id=' + upload_id + '&comment_text=' + comment_text + '&comment_date=' + comment_date;
		    xhr.send(data);
 		}
 		return false;
 	}

 	function handle(e){
 		if(e.keyCode == 13){
 			var album_name = document.getElementById('new_album_name').value;
 			var album_owner = document.getElementById('album_owner').value;

 			var xhr = new XMLHttpRequest();
 			xhr.open('POST', 'createAlbum.php', true);
		    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		    var data = 'album_name=' + album_name + '&owner=' + album_owner;
		    xhr.send(data);

		    xhr.onreadystatechange = function(){
		    	document.getElementById('create_album_message').innerHTML = xhr.responseText;
		    }
 		}
 		return false;
 	}

 	function showPhoto(img_url, owner){
 		document.getElementById('photo_view').innerHTML = "<img src='" + img_url + "' width='600'><br><p id='gallery_comments' class='gallery_comments' style='border: 1px solid;'></p>";

 		var xhr = new XMLHttpRequest();
 			xhr.open('POST', 'retrieveGalleryComments.php', true);
		    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		    var data = 'img_url=' + img_url + '&album_owner=' + owner;
		    xhr.send(data);

		    xhr.onreadystatechange = function(){
		    	document.getElementById('gallery_comments').innerHTML = xhr.responseText;
			}

 	}

 	function showAlbum(album, album_owner){
 		document.getElementById('list_photo_title').innerHTML = album;

 		var xhr = new XMLHttpRequest();
	 
	    xhr.open('POST', 'showPhotoList.php', true);
	    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    var data = 'album_name=' + album + '&owner=' + album_owner;
	    xhr.send(data);

	    xhr.onreadystatechange = function(){
	    	document.getElementById('list_photo').innerHTML = xhr.responseText;
	    }
 	}

 	function fileSelect(evt) {
	    if (window.File && window.FileReader && window.FileList && window.Blob) {
	        var files = evt.target.files;
	        var result = '';
	        var file;
	    for (var i = 0; file = files[i]; i++) {
	        result += '<li>' + file.name + ' ' + file.size + ' bytes</li>';
	        }
	    document.getElementById('filesInfo').innerHTML = '<ul>' + result + '</ul>';
	    } else {
	    alert('The File APIs are not fully supported in this browser.');
	    }
	}
	document.getElementById('imgToUpload').addEventListener('change', fileSelect, false);


	if (window.File && window.FileReader && window.FileList && window.Blob) {
	    document.getElementById('imgToUpload').onchange = function(){
	        var files = document.getElementById('imgToUpload').files;
	        var album_name = document.getElementById('album_name').value;
	        for(var i = 0; i < files.length; i++) {
	            resizeAndUpload(files[i], album_name);
	        }
	    };
	} else {
	    alert('The File APIs are not fully supported in this browser.');
	}
	 
	function resizeAndUpload(file, album) {
	var reader = new FileReader();
	    reader.onloadend = function() {
	 
	    var tempImg = new Image();
	    tempImg.src = reader.result;
	    tempImg.onload = function() {
	 
	        var MAX_WIDTH = 1500;
	        var MAX_HEIGHT = 800;
	        var tempW = tempImg.width;
	        var tempH = tempImg.height;
	        if (tempW > tempH) {
	            if (tempW > MAX_WIDTH) {
	               tempH *= MAX_WIDTH / tempW;
	               tempW = MAX_WIDTH;
	            }
	        } else {
	            if (tempH > MAX_HEIGHT) {
	               tempW *= MAX_HEIGHT / tempH;
	               tempH = MAX_HEIGHT;
	            }
	        }
	 
	        var canvas = document.createElement('canvas');
	        canvas.width = tempW;
	        canvas.height = tempH;
	        var ctx = canvas.getContext("2d");
	        ctx.drawImage(this, 0, 0, tempW, tempH);
	        var dataURL = canvas.toDataURL("image/jpeg");
	 
	        var xhr = new XMLHttpRequest();
	        xhr.onreadystatechange = function(ev){
	            document.getElementById('filesInfo').innerHTML = 'File/s uploaded successfully!';
	        };
	 
	        xhr.open('POST', 'uploadResized.php', true);
	        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	        var data = 'image=' + dataURL + '&album_name=' + album;
	        xhr.send(data);
	      }
	 
	   }
	   reader.readAsDataURL(file);
	}

 </script>
 <!-- End of script for resize and upload -->

 <?php

 	include( 'inc/footer.inc.php' );

 ?>