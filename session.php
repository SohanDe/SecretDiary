<?php

	session_start();
	
	//$_SESSION['username'] = "SohanDe";
	
	if($_SESSION['email']){
		
		echo "You are logged in";
		
	}
	else {
		
		header("Location: sql.php");
		
	}

?>