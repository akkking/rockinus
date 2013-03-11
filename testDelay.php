<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<meta charset="UTF-8" />
<title>A Simple jQuery Fade In/Fade Out</title>
 
<style>
#picOne, #picTwo {
position:absolute;
display: none;
}
 
#pics {
width:100px;
height:100px;
}
</style>
 
<script src="http://code.jquery.com/jquery-1.4.4.min.js" type="text/javascript"></script>
 
<script type="text/javascript">
$(function () {
    var $element1 = $('#picOne');
    var $element2 = $('#picTwo');
    function fadeInOut () {
        $element1.fadeIn(300, function () {
            $element1.delay(3000).fadeOut(300, function () {
                $element2.fadeIn(300, function () {
	                $element2.delay(3000).fadeOut(300, function () {
    	                setTimeout(fadeInOut, 100);
                	});
				});
            });
        });
    }

    fadeInOut();
});
</script>
 
</head>
<body>
 
<div id="pics">
<img src="img/arrow-right.png" width="100" height="100" id="picOne" />
<img src="img/blackBuy.jpg" width="100" height="100" id="picTwo" />
</div>
 
</body>
</html>