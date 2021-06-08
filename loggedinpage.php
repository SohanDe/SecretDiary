<?php

	session_start();
	
	$diaryContent = "";
	
	if(array_key_exists("id",$_COOKIE)) {
		
		$_SESSION['id'] = $_COOKIE['id'];
		
	}
	
	if(array_key_exists("id",$_SESSION)) {
		
		include("connection.php");
		
		$query = "SELECT diary FROM `users` WHERE id = ".$_SESSION['id']." LIMIT 1";
		
		$row = mysqli_fetch_array(mysqli_query($link,$query));
		
		$diaryContent = $row['diary'];
		
	}
	else {
		
		header("Location: secretdiary.php");
		
	}
	
	include("header.php");

?>	<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Secret Diary</a>
      <div class="d-flex">
        <a href='secretdiary.php?logout=1'><button class="btn btn-success" type="submit">logout</button></a>
      </div>
    </div>
  </div>
</nav>
	
	<div class="container-fluid" id="containerLoggedIn">
	
		<textarea class="form-control" id="diary" rows="25" ><?php echo $diaryContent ?></textarea>
		
	</div>
	
<?php

	include("footer.php");

?>