<?php

	session_start();

	if(array_key_exists("content",$_POST)) {
		
		include("connection.php");
		
		//echo $_POST['content'];
		
		//echo $_SESSION["id"];
		
		$query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($link,$_POST['content'])."' WHERE id = ".mysqli_real_escape_string($link,$_SESSION['id'])." LIMIT 1";
		
		//$query = "UPDATE `users` SET `diary` = 'asdf' WHERE id = 12 LIMIT 1";
		
		if(mysqli_query($link,$query)) {
			echo "success";
		}
		else {
			echo "failed";
			
		}
		
	}

?>