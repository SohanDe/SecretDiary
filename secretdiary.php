<?php

	session_start();

	$error = "";
	
	if(array_key_exists("logout",$_GET)) {
		
		unset($_SESSION);
		session_unset();    
		session_destroy();
		
		setcookie("id","",time()-60*60);
		
		$_COOKIE["id"] = "";
		
	}
	else if((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])) {
		
		header("Location: loggedinpage.php");
		
	}
	
	if(array_key_exists("submit",$_POST)) {
		
		include("connection.php");
		
		if(!$_POST['email']){
			$error .= "Email id is required<br>";
		}
		
		if(!$_POST['password']){
			$error .= "password is required<br>";
		}
		
		if($error) {
			
			$error = "<p>There were some errors</p>".$error;
			
		}
		else {
			
							
				if($_POST["signUp"]=='1') {
			
					$query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
					
					$result = mysqli_query($link,$query);
					
					if(mysqli_num_rows($result)>0) {
						
						$error = "This email is already taken";
						
					}
					else {

				
						$query = "INSERT INTO `users` (`email`,`password`) VALUES ( '".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";
						
						if(!mysqli_query($link,$query)) {
							
							$error = "There were some error please try later";
							
						}
						else {
							
							$query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link).$_POST['password']))."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1 ";
																	   
							
							mysqli_query($link,$query);
							
							$_SESSION["id"] = mysqli_insert_id($link);
							
							if($_POST["stayLoggedIn"]=="1") {
								
								setcookie("id",mysqli_insert_id($link),time()+60*60*24*365); 
								
							}
							
							header("Location: loggedinpage.php");
							
						 }
					
					}
				}
				else {
					
					$query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";
					
					$result = mysqli_query($link,$query);
					
					$row = mysqli_fetch_array($result);
					
					if(isset($row)) {
						
						$hashedPassword = md5(md5($row['id'].$_POST['password']));
						
						if($hashedPassword==$row['password']) {
							
							$_SESSION['id'] = $row['id'];
							
							if($_POST["stayLoggedIn"]=="1") {
							
								setcookie("id",$row['id'],time()+60*60*24*365); 
							
							}
							
							header("Location: loggedinpage.php");
							
							
						}
						else{
							
							$error = "Email/password combination doesnot match";
							
						}
						
					}
					else {
						
						$error = "Email/password combination doesnot match";
						
					}
					
				}
			
			
			
		}
		
	}

?>
	<?php include("header.php") ?>
  
	<div class="container-fluid" id="homepageContainer" style="background-color:#ffddcc; max-width:600px">
		<h1>Secret Diary</h1>
		
		<p id="store"><strong>Store your thoughts permanently and securely</strong></p>
	
		<div id="error"><?php if($error!="") {
			
			echo "<div class='alert alert-danger' role='alert'>".$error."</div>";
			
			
		} ?></div>
		
			<form method="post"id="signUpId">
			
				<p>Interested? Sign up now</p>

				<div class="mb-3 forms">
					
					<label for="exampleInputEmail1" class="form-label">Email address</label>
					<input type="email" class="form-control" name="email" placeholder="Your email">
				</div>
				
				<div class="mb-3">
				
					<label for="exampleInputPassword1" class="form-label">Password</label>
					<input type="password" class="form-control" name="password" placeholder="Password">
					
				</div>
				
				<div class="mb-3 form-check">
					<input type="checkbox"class="form-check-input" id="exampleCheck1"name="stayLoggedIn" value=1>
					<input type="hidden" name="signUp" value="1">
					<label class="form-check-label" for="exampleCheck1">Check me out</label>
				</div>
					
					<input class="btn btn-success"type="submit" name="submit" value="Sign Up">

				<p><a class="toggleButton1" style="cursor: pointer;">Log  in</a></p>
				
			</form>
		
			<form method="post" id="logInId">
			
				<p>Log in with your username and password</p>

				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Email address</label>
					<input type="email"class="form-control" name="email" placeholder="Your email">
				</div>
				
				<div class="mb-3">
				
					<label for="exampleInputPassword1" class="form-label">Password</label>
					<input type="password"class="form-control" name="password" placeholder="Password">
				</div>
				
				<div class="mb-3 form-check">
					<input type="checkbox"class="form-check-input"id="exampleCheck1" name="stayLoggedIn" value=1>
					<input type="hidden" name="signUp" value="0">
					<label class="form-check-label" for="exampleCheck1">Check me out</label>
				</div>
					<input class="btn btn-success" type="submit" name="submit" value="Log In">

				<p><a class="toggleButton1" style="cursor: pointer;">Sign up</a></p>
			</form>
		
	</div>

<?php include("footer.php") ?>
