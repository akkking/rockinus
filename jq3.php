<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
     <input type='submit' value='Like' onclick='' id='aa' />	 
	 <p style='clear: left;'> <span>first</span> like this. </p>	 
	 <script>         
	 $("#aa").click(function () {
	 	var v = $("span").text();	         
	 	if (v=="first") v = 1;
		var n = parseInt(v, 10);			 
		var a=0;			 			 
		n = n + 1;			              
		$("span").text( a = parseInt(a) + parseInt(n));         
	});     
	</script>
</body>
</html>