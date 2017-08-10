
<?php

	// Function to get filename of an upload
	function getFilename($file_id){
		return "Hello";
	}

	// Function to get gallery upload id
	function getGalleryUploadId($image_url){
		include( 'connect.inc.php' );
		$upload_id = 0;
		$sql = "SELECT upload_id FROM gallery_uploads WHERE image_url='$image_url' LIMIT 1";
		if($result = $mysqli->query($sql)){
			// Count
			if($result->num_rows > 0){
				// record exist
				while($row = $result->fetch_assoc()){
					$upload_id = $row['upload_id'];
				}
			}
		}
		return $upload_id;
	}

	// Function to delete old logged users
	function deleteOldLoggedUsers(){
		include( 'connect.inc.php' );
		$timezone = "Asia/Manila";
		date_default_timezone_set ($timezone);
		$sql_find = "SELECT * FROM users_log WHERE status='1'";
		if($result_find = $mysqli->query($sql_find)){
			// Count
			if($result_find->num_rows > 0){
				// Get the time
				while($row_find = $result_find->fetch_assoc()){
					$log_id = $row_find['log_id'];
					$last_active = time() - strtotime($row_find['last_active']);
					if($last_active > 14400){
						// Log the user out
						$sql = "UPDATE users_log SET status='0' WHERE log_id='$log_id'";
						if($result = $mysqli->query($sql)){

						}
					}
				}
			}
		}
	}

	// Function to display albums
	function displayAlbums($album_owner){
		include( 'connect.inc.php' );
		$sql_album = "SELECT * FROM gallery_album WHERE album_owner='$album_owner'";
		if($result_album = $mysqli->query($sql_album)){
			// Count the record
			if($result_album->num_rows > 0){
				// retrieve albums
				while($rows_album = $result_album->fetch_assoc()){
					$album_name = $rows_album['album_name'];
					echo 	'<li><div class="album_block" onclick="showAlbum(\''.$album_name.'\',\''.$album_owner.'\')">
									<div class="album_image" >'. retieveImageFromAlbum($album_name) .'</div>
									<div class="album_name" >'. $album_name .'</div>
								</div>
							</li>';
				}
			}else{
				echo "The user has no album yet!\n";
			}
		}else{
			echo $mysqli->error;
		}
	}

	// Function to retrieve a picture on an album
	function retieveImageFromAlbum($album_name){
		include( 'connect.inc.php' );
		$img = "<img src='' alt='nophoto' />";
		$sql = "SELECT image_url FROM gallery_uploads WHERE album_name='$album_name' LIMIT 1";
		if($result = $mysqli->query($sql)){
			// Count record
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()) {
					$src = $row['image_url'];
					$img = "<img src='". $src ."' alt='' height='160' />";
				}
			}else{
				$img = "<img src='' alt='nophoto' height='160' width='160' />";
			}
		}else{
			$img = "";
		}
		echo $img;
	}

	// Function to retrieve albums of the user
	function retrieveAlbumList($album_owner){
		include( 'inc/connect.inc.php' );
		$sql = "SELECT album_name FROM gallery_album WHERE album_owner='$album_owner'";
		$list = "";
		if($result = $mysqli->query($sql)){
			// Count the record
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$album_name = $row['album_name'];
					$list .= '<option value="'. $album_name .'">'. $album_name .'</option>';
				}
			}else{
				$list = "";
			}
		}else{
			echo $mysqli->error;
		}
		return $list;
	}

	// Function to hide conversation
	function hideConversation($cid, $hide_by){
		include( 'connect.inc.php' );
		// Check if the user is user1 or user2
		$x = "";
		$msg = "";
		$sql = "SELECT * FROM conversation WHERE conversation_id='$cid'";
		if($result = $mysqli->query($sql)){
			while($row = $result->fetch_assoc()){
				$user1 = $row['user1'];
				$hb = $row['hide_by'];
				if($hb == '1' || $hb == '2'){
					$x = '3';
				}else{
					if($user1 == $hide_by){
						$x = '1';
					}else{
						$x = '2';
					}
				}
				// Update database
				$sql_update = "UPDATE conversation SET hide_by='$x' WHERE conversation_id='$cid'";
				//if()
			}
		}
		echo $msg;
	}
	
	// Function to get online status
	function onlineStatus($username){
		include( 'connect.inc.php' );
		$sql = "SELECT status FROM users_log WHERE username='$username' AND status='1'";
		if($result = $mysqli->query($sql)){
			// Count if it exist
			$count = mysqli_num_rows($result);
			if($count > 0){
				// The user is logged on
				echo "[Online] ";
			}else{
				echo "[Offline] ";
			}
		}else{
			echo $mysqli->error;
		}
	}
	
	// Count online members
	function onlineMembersCount(){
		include( 'connect.inc.php' );
		$sql = "SELECT * FROM users_log WHERE status='1'";
		if($result = $mysqli->query($sql)){
			$row_count = mysqli_num_rows($result);
			echo "Online members: " . $row_count ;
		}else{
			echo $mysqli->error;
		}
	}

	// Function to logout the user in the database
	function userLogout($username){
		include( 'connect.inc.php' );
		$sql = "UPDATE users_log SET status='0' WHERE username='$username' AND status='1'";
		if($result = $mysqli->query($sql)){
			//header( "location: index.php" );
		}else{
			echo $mysqli->error;
		}
	}
	
	// Function to update last active
	function updateActive($username){
		include( 'connect.inc.php' );
		$timezone = "Asia/Manila";
		date_default_timezone_set ($timezone);
		$t = date("Y-m-d H:i:s");
		// Get the inactive time
		if((currentTime() - getLastActive($username)) > 14400){
			// The user is inactive for 4hrs, redirect to logout
			userLogout($username);
			session_destroy();
			//header("location: logout.php");
		}else{
			$sql = "UPDATE users_log SET last_active = '$t' WHERE username='$username' AND status='1'";
			if(!$result = $mysqli->query($sql)){
				//echo $mysqli->error;
			}
		}
		
	}

	// Function to get current time
	function currentTime(){
		$timezone = "Asia/Manila";
		date_default_timezone_set ($timezone);
		return time();
	}

	// Function to get last active time
	function getLastActive($username){
		include( 'connect.inc.php' );
		$last_active_msg = "";
		$sql_last_active = "SELECT * FROM users_log WHERE username='$username' AND status='1' LIMIT 1";
		if($result_last_active = $mysqli->query($sql_last_active)){
			// Count the record
			if($result_last_active->num_rows > 0){
				while($row_last_active = $result_last_active->fetch_assoc()){
					$last_active = $row_last_active['last_active'];
				}
			}else{
				$last_active = 0;
			}
		}
			return strtotime($last_active);	
	}

	// Function to delete existing active log
	function deleteExistingActive($username){
		include( 'connect.inc.php' );
		$sql_find = "SELECT * FROM users_log WHERE username='$username' AND status='1'";
		if($result_find = $mysqli->query($sql_find)){
			// Count
			if($result_find->num_rows > 0){
				// delete the record
				$sql_delete = "DELETE FROM users_log WHERE username='$username' AND status='1'";
				$result_delete = $mysqli->query($sql_delete) or die();
			}
		}
	}

	// Function to get total number of members
	function getTotalMembers(){
		include( 'connect.inc.php' );
		$err_msg = "";
		$sql_users = "SELECT * FROM users";
		if($result_users = $mysqli->query($sql_users)){
			// Count the record
			$total = $result_users->num_rows;
			$err_msg = $total;
		}else{
			$err_msg = $mysqli->error;
		}

		echo $err_msg;
	}

	// Function to get number of articles submitted
	function getNumberOfArticles($user_id){
		include( 'connect.inc.php' );
		$num_articles_msg = "";
		$sql_num_articles = "SELECT * FROM articles WHERE posted_by='$user_id'";
		if($result_num_articles = $mysqli->query($sql_num_articles)){
			// Check number of record
			if($result_num_articles->num_rows > 0){
				$num_articles = $result_num_articles->num_rows;
				$num_articles_msg = $num_articles;
			}else{
				$num_articles_msg = "No article submitted yet.";
			}
		}else{
			$num_articles_msg = $mysqli->error;
		}
		echo $num_articles_msg;
	}

	// Function to get number of topics created
	function getNumberOfTopics($user){
		include( 'connect.inc.php' );
		$num_topic_msg = "";
		$sql_num_topics = "SELECT * FROM forum_topics WHERE created_by='$user'";
		if($result_num_topics = $mysqli->query($sql_num_topics)){
			// Check number of record
			if($result_num_topics->num_rows > 0){
				$num_topics = $result_num_topics->num_rows;
				$num_topic_msg = $num_topics;
			}else{
				$num_topic_msg = "No topic created yet.";
			}
		}else{
			$num_topic_msg = $mysqli->error;
		}
		echo $num_topic_msg;
	}

	// Function to get number of posts
	function getNumberOfPosts($user_id){
		include( 'connect.inc.php' );
		$num_post_msg = "";
		$sql_num_posts = "SELECT * FROM forum_posts WHERE posted_by='$user_id'";
		if($result_num_posts = $mysqli->query($sql_num_posts)){
			// Check number of record
			if($result_num_posts->num_rows > 0){
				$num_posts = $result_num_posts->num_rows;
				$num_post_msg = $num_posts;
			}else{
				$num_post_msg = "No forum post yet.";
			}
		}else{
			$num_post_msg = $mysqli->error;
		}
		echo $num_post_msg;
	}

	// Function to delete article
	function deleteArticle($article_id){
		include( 'connect.inc.php' );
		$sql_delete = "DELETE FROM articles WHERE article_id='$article_id'";
		if($result_delete = $mysqli->query($sql_delete)){
			// Deleted
			header( "location: articles.php" );
		}
	}

	// Function to check if the user is logged in
	function checkLogin(){
		if(!isset($_SESSION['uname_log'])){
			// The user is not logged in
			header( "location: index.php" );
		}
	}

	// Function to list results from a search
	function listResults($q){
		$q = "%" . $q . "%";
		include( 'connect.inc.php' );
		$sql_search = "SELECT * FROM forum_topics WHERE topic_title LIKE '$q'";
		if($result_search = $mysqli->query($sql_search)){
			if($result_search->num_rows > 0){
				// Create numbering
				$counter = 1;
				while($row_search = $result_search->fetch_assoc()){
					$topic_title = $row_search['topic_title'];
					$topic_id = $row_search['topic_id'];
					?>
					<div class="search_row"><?php echo $counter; ?>.&nbsp;<a href="posts.php?topic_id=<?php echo $topic_id; ?>"><?php echo $topic_title; ?></a></div>
					<?php
					$counter++;
				}
			}else{
				$err_search = "No result!";
				echo $err_search;
			}
		}else{
			echo $mysqli->error;
		}
	}

	// Function to allow some tags but filter special characters
	function allow_chars($str, $allowed){
	    $str = htmlspecialchars($str, ENT_QUOTES);
	    foreach( $allowed as $a ){
	        $str = str_replace("&lt;".$a."&gt;", "<".$a.">", $str);
	        $str = str_replace("&lt;/".$a."&gt;", "</".$a.">", $str);
	    }
	    return $str;
	}

	// Function to get list of article list
	function getArticleList(){
		include( 'connect.inc.php' );
		$sql_artile_list = "SELECT * FROM articles ORDER BY article_id DESC";
		if(!$result_article_list = $mysqli->query($sql_artile_list)){
			echo $mysqli->error;
		}else{
			// Count if entry is more than one
			if($result_article_list->num_rows == 0){
				echo "There is no entry yet!\n";
			}else{
				echo '<table>';
				echo 	'<tr>
							<td align="center" class="article_title">Title</td><td align="center" class="article_title" width="120">Posted By</td>
						</tr>';
				while($row_article_list = mysqli_fetch_assoc($result_article_list)){
					$article_id = $row_article_list['article_id'];
					$title = $row_article_list['article_title'];
					$body = $row_article_list['article_body'];
					$posted_by = $row_article_list['posted_by'];
					$date_posted = $row_article_list['date_posted'];

					?>
						<tr>
							<td class="article_title"><a href="view_article.php?a=<?php echo $article_id; ?>"><?php echo $title; ?></a></td>
							<td class="article_posted_by"><a href="<?php echo getUsername($posted_by); ?>"><?php echo getUsername($posted_by); ?></a></td>
						</tr>
					<?php
				}
				echo '</table>';
			}
		}
	}

	// Function to know if record exist
	function isRecordExist($table_name){
		include( 'connect.inc.php' );
		$sql = "SELECT * FROM " . $table_name;
		if($result = $mysqli->query($sql)){
			if($result->num_rows > 0){
				return true;
			}
		}
	}

	// Function to get the latest article
	function getLatestArticle(){
		include( 'connect.inc.php' );
		// Check if record exist
		if(isRecordExist("articles")){
			if($latest_article_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT article_id FROM articles ORDER BY article_id DESC LIMIT 1")))){
				$latest_article_title = implode(mysqli_fetch_assoc($mysqli->query("SELECT article_title FROM articles WHERE article_id='$latest_article_id'")));
				$latest_article_body = implode(mysqli_fetch_assoc($mysqli->query("SELECT article_body FROM articles WHERE article_id='$latest_article_id'")));
				$posted_by = implode(mysqli_fetch_assoc($mysqli->query("SELECT posted_by FROM articles WHERE article_id='$latest_article_id'")));

				echo '<div class="article_title">'. $latest_article_title;
					echo '<div class="article_posted_by">';
						echo 'Posted by <a href="' . getUsername($posted_by) . '">' . getUsername($posted_by) . '</a>';
					echo '</div>';
				echo '</div>';
				echo '<div class="article_body">'. $latest_article_body .'</div>';
			}
		}else{
			echo '<div class="article_body">No article entry yet. Want to submit?&nbsp; <br><a href="submit_article.php">+Submit Article</a></div>';
		}
		

	}

	// Function to get username
	function getUsername($user_id){
		include( 'connect.inc.php' );
		if($username = implode(mysqli_fetch_assoc($mysqli->query("SELECT username FROM users WHERE id='$user_id'")))){
			return $username;
		}
	}

		/**
	 * Image resize while uploading
	 * @author Resalat Haque
	 * @link http://www.w3bees.com/2013/03/resize-image-while-upload-using-php.html
	 */
	 
	/**
	 * Image resize
	 * @param int $width
	 * @param int $height
	 */
	function resize($width, $height){
		/* Get original image x y*/
		list($w, $h) = getimagesize($_FILES['image']['tmp_name']);
		/* calculate new image size with ratio */
		$ratio = max($width/$w, $height/$h);
		$h = ceil($height / $ratio);
		$x = ($w - $width / $ratio) / 2;
		$w = ceil($width / $ratio);
		/* new file name */
		$path = 'uploads/'.$width.'x'.$height.'_'.$_FILES['image']['name'];
		/* read binary data from image file */
		$imgString = file_get_contents($_FILES['image']['tmp_name']);
		/* create image from string */
		$image = imagecreatefromstring($imgString);
		$tmp = imagecreatetruecolor($width, $height);
		imagecopyresampled($tmp, $image,
	  	0, 0,
	  	$x, 0,
	  	$width, $height,
	  	$w, $h);
		/* Save image */
		switch ($_FILES['image']['type']) {
			case 'image/jpeg':
				imagejpeg($tmp, $path, 100);
				break;
			case 'image/png':
				imagepng($tmp, $path, 0);
				break;
			case 'image/gif':
				imagegif($tmp, $path);
				break;
			default:
				exit;
				break;
		}
		return $path;
		/* cleanup memory */
		imagedestroy($image);
		imagedestroy($tmp);
	}

	// Function to post timeline
	function postToTimeline($poster_id, $post_content){
		$post_date = date("Y-m-d H:i:s");
		$sql_post_timeline = "INSERT INTO timeline VALUES ('', '$poster_id', '$post_content', '$post_date')";
		if(!$result_post_timeline = $mysqli->query($sql_post_timeline)){
			echo "Error posting!\n";
		}else{
			echo "You have successfully posted to your blog!\n";
		}
	}

	// Get forum categories
	function getForumCategories(){
		include( 'connect.inc.php' );
		$sql_category = "SELECT * FROM forum_cat";
		if(!$result_category = $mysqli->query($sql_category)){
			echo $mysqli->error;
		}else{
			while($row_category = $result_category->fetch_assoc()){
				echo '<option value="'. $row_category['cat_id'] .'">'. $row_category['cat_name'] .'</option>';
			}
		}
	}

	//
	function getUnreadMessages($user){
		include( 'connect.inc.php' );
		$sql_unread = "SELECT * FROM conversation WHERE recent_poster!='$user' AND isread='0' AND (user1='$user' OR user2='$user')";
		if($result_unread = $mysqli->query($sql_unread)){
			// Count
			$count = $result_unread->num_rows;
			if($count > 0){
				echo " [". $count ." <font style='background-color: transparent; color: red;'>new!</font>]";
			}
		}
	}
	

	// Function to retrieve the messages in a conversation
	function getMessages($c_id, $poster){
		include( 'connect.inc.php' );
		$sql_messages = "SELECT * FROM messages WHERE conversation='$c_id' ORDER BY message_id DESC";

		// Check if the viewer is the last one who sent a message
		if(!$recent_poster = implode(mysqli_fetch_assoc($mysqli->query("SELECT recent_poster FROM conversation WHERE conversation_id='$c_id'")))){
			header("location: messages.php");
		}
		if($poster != $recent_poster){
			$sql_set_isread = "UPDATE conversation SET isread = '1' WHERE conversation_id = '$c_id'";
			if(!$result_set_isread = $mysqli->query($sql_set_isread)){
				echo "<br><br><br><br><br><br><br>";
				echo $mysqli->error;
			}
		}

		if(!$result_messages = $mysqli->query($sql_messages)){
			echo $mysqli->error;
		}else{

			// Check the number 
			if($result_messages->num_rows >0){
				//$mysqli->query($sql_set_isread);
				// Display the messages
				while($row_messages = $result_messages->fetch_assoc()){
					$message_body = $row_messages['message_body'];
					$sender = $row_messages['sent_by'];
					$time_sent = $row_messages['date_sent'];
					if($sender == $poster){
						$class_message = "message_sent";
					}else{
						$class_message = "message_received";
					}
					echo '<div class="'. $class_message .'">';
						echo '<div class="message_time">'. $time_sent .'</div>';
						echo $message_body;
					echo '</div>';
				}
			}
		}
	}

	// Function to retrieve conversations
	function getConversations($user){
		// Retieve conversations which the user has
		include( 'connect.inc.php' );
		$sql_conversations = "SELECT * FROM conversation WHERE user1='$user' || user2='$user'";
		if(!$result_conversations = $mysqli->query($sql_conversations)){
			echo $mysqli->error;
		}else{
			// Conversation message info
			$conv_count = "";
			// Count the conversations
			$count = $result_conversations->num_rows;

			if($count == 0){
				$conv_count = "There is no existing conversation yet.";
			}else{
				$conv_count = "";
			}

			// Print the conversations
			while($rows_conversation = $result_conversations->fetch_assoc()){
				$conversation_id = $rows_conversation['conversation_id'];

				// Who are you talking to?
				$talking_to = "";
				$user1 = implode(mysqli_fetch_assoc($mysqli->query("SELECT user1 FROM conversation WHERE conversation_id='$conversation_id'")));
				$user2 = implode(mysqli_fetch_assoc($mysqli->query("SELECT user2 FROM conversation WHERE conversation_id='$conversation_id'")));
				$isread = implode(mysqli_fetch_assoc($mysqli->query("SELECT isread FROM conversation WHERE conversation_id='$conversation_id'")));
				// Get the recent person who sent a message
				$recent_poster = implode(mysqli_fetch_assoc($mysqli->query("SELECT recent_poster FROM conversation WHERE conversation_id='$conversation_id'")));
				if($user == $user1){
					$talking_to = $user2;
				}else{
					$talking_to = $user1;
				}
				// Check if the message is read already
				if($isread == false){
					if($user != $recent_poster){
						$read_tag = "<b>";
						$read_tag_end = "</b> [New]";
					}else{
						// The user is the one who sent the last message
						$read_tag = "";
						$read_tag_end = "";
					}
					
				}else{
					$read_tag = "";
					$read_tag_end = "";
				}
				echo '<div class="conversation_message">';
				echo $read_tag . '<a href="read_message.php?c='. $conversation_id .'">'. $talking_to .'</a>' . $read_tag_end;
				echo '</div>';
				echo '<hr>';
			}
		}
	}


	// Function to get latest topic
	function getLatestTopic(){
		include ( 'connect.inc.php' );
		$latest_topic_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT topic_id FROM forum_topics ORDER BY topic_id DESC LIMIT 1")));
		$latest_topic_title = implode(mysqli_fetch_assoc($mysqli->query("SELECT topic_title FROM forum_topics WHERE topic_id='$latest_topic_id'")));
		echo '<a href="posts.php?topic_id='. $latest_topic_id .'">'. $latest_topic_title .'</a>';
	}

	// Function to delete forum post
	function deleteForumPost($post_id){
		include( 'connect.inc.php' );
		$sql_delete_post = "DELETE FROM forum_posts WHERE post_id='$post_id'";
		$mysqli->query($sql_delete_post);
	}

	// Function to display avatar
	function getAvatar($user_id){
		include( 'connect.inc.php' );
		$avatar = implode(mysqli_fetch_assoc($mysqli->query( "SELECT avatar FROM users WHERE id='$user_id'" )));
		echo '<img src="'. $avatar .'" width="50" height="55"/>';
	}

	// Function to get user id
	function getUserId($username){
		include( 'connect.inc.php' );
		if($uid = implode(mysqli_fetch_assoc($mysqli->query( "SELECT id FROM users WHERE username='$username'" )))){
			return $uid;
		}
	}

	// Function to display username
	function getName($user_id){
		include( 'connect.inc.php' );
		$fname = implode(mysqli_fetch_assoc($mysqli->query( "SELECT first_name FROM users WHERE id='$user_id'" )));
		$lname = implode(mysqli_fetch_assoc($mysqli->query( "SELECT last_name FROM users WHERE id='$user_id'" )));
		$username = implode(mysqli_fetch_assoc($mysqli->query( "SELECT username FROM users WHERE id='$user_id'" )));
		echo '<a href="'. $username .'" >'. $fname . " " . $lname .'</a>';
	}

	// Function to get the latest post
	function getLatestPost(){
		include( 'connect.inc.php' );
		if($latest_post_id = implode(mysqli_fetch_assoc($mysqli->query("SELECT post_id FROM forum_posts ORDER BY post_id DESC LIMIT 1")))){
			if($latest_post_body = implode(mysqli_fetch_assoc($mysqli->query("SELECT post_body FROM forum_posts ORDER BY post_id DESC LIMIT 1")))){
				$latest_posted_by = implode(mysqli_fetch_assoc($mysqli->query("SELECT posted_by FROM forum_posts ORDER BY post_id DESC LIMIT 1")));
				$latest_date_posted = implode(mysqli_fetch_assoc($mysqli->query("SELECT date_posted FROM forum_posts ORDER BY post_id DESC LIMIT 1")));
				echo 	'<div class="poster_detail">
							<div class="poster_avatar">
								'. getAvatar($latest_posted_by) .'
							</div>
							<div class="poster_username">
								Posted by&nbsp;<a href="'. getUsername($latest_posted_by) .'">'. getUsername($latest_posted_by) .'</a>
							</div>
							<div class="post_date">
								Posted on: ' . $latest_date_posted .'
							</div>
						</div>
						<div class="post_body">
							'. $latest_post_body .'
						</div>';
			}
			
		}else{
			exit("Error!");
		}
		
		
	}

	// Function to get the posts
	function getForumPosts($topic_id){
		include( 'connect.inc.php' );
		$sql_forum_posts = "SELECT * FROM forum_posts WHERE topic='$topic_id'";
		if(!$result_forum_posts = $mysqli->query($sql_forum_posts)){
			echo $mysqli->error;
		}else{
			while($row_forum_posts = $result_forum_posts->fetch_assoc()){
				$post_id = $row_forum_posts['post_id'];
				$posted_by = $row_forum_posts['posted_by'];
				$post_body = $row_forum_posts['post_body'];
				$date_posted = $row_forum_posts['date_posted'];

				echo '<div class="post_box">';
					echo '<div class="poster_detail">';
						echo '<div class="poster_avatar">';
							getAvatar($posted_by);
						echo '</div>';
						echo '<div class="poster_username">';
							getName($posted_by);
						echo '</div>';
						echo '<div class="post_date">';
							echo 'Posted on: ' . $date_posted;
						echo '</div>';
					echo '</div>';
					echo '<div>';
						echo $post_body;
					echo '</div>';
				echo '</div>';
			}
		}
	}

	// Function to get the topics of a category
	function getTopics($cat_id){
		include( 'connect.inc.php' );
		$sql_forum_topics = "SELECT * FROM forum_topics WHERE cat='$cat_id'";
		if(!$result_forum_topics = $mysqli->query($sql_forum_topics)){
			echo $mysqli->error;
		}else{
			// Count the topics
			if($result_forum_topics->num_rows == 0){
				echo "No topics yet in this category!\n";
			}else{
				echo "<table style='width: 100%'>";
				echo "<tr>
						<td align='center' width='350' style='padding-left: 20px; font-size: 12px;'>Topic Name</td>
						<td align='center' style='padding-left: 20px; font-size: 12px;'>Posted By</td>
						<td align='center' style='padding-left: 20px; font-size:12px;'>No. of Posts</td>
					</tr>";
				while($row_forum_topics = $result_forum_topics->fetch_assoc()){
					$topic_id = $row_forum_topics['topic_id'];
					$topic_title = $row_forum_topics['topic_title'];
					$topic_created_by = $row_forum_topics['created_by'];
					$topic_date_created = $row_forum_topics['date_created'];
					$topic_posts = $mysqli->query("SELECT * FROM forum_posts WHERE topic='$topic_id'")->num_rows;

					?>	
					
						<tr>
							<td>
								<div class="forum_topic_row">
									<a href="./posts.php?topic_id=<?php echo $topic_id; ?>"><?php echo $topic_title; ?></a>
								</div>
							</td>
							<td align="center" class="posts_posted_by">
									<a href="./<?php echo $topic_created_by; ?>"><?php echo $topic_created_by; ?></a>
							</td>
							<td align="center" style="padding-left: 20px;">
								<?php echo $topic_posts; ?>
							</td>
						</tr>
					

					<?php

				
				}
				echo "</table>";
			}
		}
	}
?>