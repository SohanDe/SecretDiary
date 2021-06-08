    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

	<script type="text/javascript">
	
	$(document).ready(function() {	
		$(".toggleButton1").click(function(){
		
			$("#signUpId").toggle();
			$("#logInId").toggle();
			
		});
	});
	
	$('#diary').bind('input propertychange', function() {

      $.ajax({
		  method: "POST",
		  url: "updateDatabase.php",
		  data: { content: $("#diary").val() }
		});
	  
	});
	
	</script>

  </body>
</html>