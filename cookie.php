<?php

	setcookie("username","",time()-60*24);
	
	echo $_COOKIE["username"];

?>