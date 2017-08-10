<?php

	//include( 'inc/header.inc.php' );
	include( 'inc/connect.inc.php' );

	session_start();

	if(isset($_SESSION['uname_log'])){
		$poster = $_SESSION['uname_log'];
		$poster_id = $_SESSION['user_id'];

		if(isset($_GET['u'])){
			$u = $_GET['u'];
			$file_id = $_GET['fid'];
			if($u != ""){
				// Query is not empty
				$sql_search = "SELECT * FROM users WHERE first_name LIKE '%". mysqli_real_escape_string($mysqli, $u) ."%'";
				if($result_search = $mysqli->query($sql_search)){
					// Count the record
					if($result_search->num_rows > 0){
						$str_result = '<div>';
						while($row_search = $result_search->fetch_assoc()){
							$username = $row_search['username'];
							$first_name = $row_search['first_name'];
							$last_name = $row_search['last_name'];
							$avatar = $row_search['avatar'];

							$str_result .= '<div class="searched_name" id="searched_name" onclick="nameSelected(\''.$username.'\',\''.$file_id.'\')">
												<img src="'. $avatar .'" width="20" />&nbsp;&nbsp;'. $first_name . '&nbsp;' . $last_name .'&nbsp;('.$username.')
											</div>';
						}
						$str_result .= '</div>';
						echo $str_result;
					}
				}
			}
		}
	}

?>