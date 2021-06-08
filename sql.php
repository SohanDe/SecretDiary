<?php

	session_start();
	
	$link = mysqli_connect("sql313.unaux.com","unaux_28245947","vudbihnz","unaux_28245947_users");
	
	if(mysqli_connect_error()) {
		
		die("There was an error connecting to database");
		
	}
	
	if(array_key_exists('email',$_POST)OR array_key_exists('password',$_POST)){
		
		if($_POST['email']=='' OR $_POST['password']=='') {
			
			echo "<p>Enter both username and password</p>";
			
		}
		else {
			
			$query = "SELECT `id` FROM `users` WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";
			
			$result = mysqli_query($link,$query);
			
			if(mysqli_num_rows($result)>0) {
				echo "<p>email is already registered</p>";
			}
			
			else {
				
				$query = "INSERT INTO `users` (`email`,`password`) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";
				
				if(mysqli_query($link,$query)) {
					
					$_SESSION['email'] = $_POST['email'];
					
					header("Location: session.php");
					
				}
				else{
					
					echo "<p>failed. Please try again later</p>";
					
				}
				
			}
			
		}
		
	}


?>

<form method="post">

	<input type="text" name="email" placeholder="Enter email">
	<input type="password" name="password" placeholder="Enter password">
	<input type="submit" value="sign up">
	

</form>