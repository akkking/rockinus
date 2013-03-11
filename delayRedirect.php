<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$('#blogLink').click (function (e) {
		alert("aaaa");
		e.preventDefault(); //will stop the link href to call the blog page

		setTimeout(function () {
			window.location.href = "ThingsRock.php"; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs.
	});
});
</script>
<div id="blogLink">blog</div>