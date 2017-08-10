	<?php
		// Get the last active time

	?>

	<div class="footer">
		<div class="total_members">
			Total members:&nbsp;<?php getTotalMembers(); ?>
			<br>
			<?php onlineMembersCount(); ?>
		</div>

		<?php //getLastActive($poster, $_SESSION['id']); 
			updateActive($poster);
			deleteOldLoggedUsers();
		?>
		<br>
		Copyright NIAGROUP 2015
		<div class="total_members">All Rights Reserved</div>
	</div>
	</body>
</html>