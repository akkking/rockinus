<!DOCTYPE html><html>
<head>  
<style>  
div { background:#def3ca; margin:3px; width:80px;  display:none; float:left; text-align:center; }  
</style>  
<script src="js/jquery.min.js"></script>
</head>
<body>    
<button id="showr">Show</button>  
<button id="hidr">Hide</button>  
<div>Hello 3,</div>  
<div>how</div>  
<div>are</div>  
<div>you?</div>
<script>
$("#showr").click(function () {  
	$("div").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#hidr").click(function () {  
	$("div").hide(1000);}
);
</script>
</body>
</html>