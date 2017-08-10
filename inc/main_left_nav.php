<!-- Left navigation -->

<?php
	// Retrieve the existing avatar to delete it
	$existing_avatar = implode(mysqli_fetch_assoc($mysqli->query("SELECT avatar FROM users WHERE username='$poster' LIMIT 1")));
?>

<div id="avatar">
	<a href="<?php echo $poster; ?>">
		<img src="<?php echo $existing_avatar; ?>" alt="profile_pic" >
	</a>
</div>
<div id="homeNavLink">
	<a href="<?php echo $poster; ?>">My Profile</a>
</div>

<div id="homeNavLink">
	<a href="account_setting.php">Account Setting</a>
</div>

<div id="homeNavLink">
	<a href="messages.php">Messages<?php getUnreadMessages($poster); ?></a>
</div>

<div id="homeNavLink">
	<a href="gallery.php?gallery_owner=<?php echo $poster; ?>">Gallery</a>
</div>

<div id="homeNavLink">
	<a href="private_vault.php">Private Vault</a>
</div>
<br>
<hr>
<br>
<div id="homeNavLink">
	<a href="members.php">Members</a>
</div>	
<div id="homeNavLink">
	<a href="online_members.php">Online Members</a>
</div>	
<div id="homeNavLink">
	<a href="articles.php">Articles</a>
</div>	

<div id="homeNavLink">
	<a href="forum.php">Discussion Board</a>
</div>	

<br>