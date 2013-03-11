<html>
<title>goTop</title>
<head>
<style>
#message a
{
    /* display: block before hiding */
    display: block;
    display: none;

    /* link is above all other elements */
    z-index: 999; 

    /* link doesn't hide text behind it */
    opacity: 0.5;
	filter:alpha(opacity=70);
    /* link stays at same place on page */
    position: fixed;
 	_position:absolute;
	_top:expression(eval(document.body.scrollTop+500));
    _bottom:auto;
	/* link goes at the bottom of the page */
    /* top: 100%; */
    /* margin-top: -80px; */ 
	/* = height + preferred bottom margin */
	bottom:10%;
    /* link is centered */
    right: 2%;
    /* margin-left: -160px; */
	/* = half of width */

    /* round the corners (to your preference) */
    -moz-border-radius: 24px;
    -webkit-border-radius: 24px;

    /* make it big and easy to see (size, style to preferences) */
    width: 300px;
    line-height: 48px;
    height: 48px;
    padding: 10px;
    background-color: #000;
    font-size: 24px;
    text-align: center;
    color: #fff;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
// scroll body to 0px on click
$('#message a').click(function () {
	$('body,html').animate({
			scrollTop: 0
		}, 900);
	return false;
});
</script>
<script>
$(function () {
    /* set variables locally for increased performance */
    var scroll_timer;
    var displayed = false;
    var $message = $('#message a');
    var $window = $(window);
    var top = $(document.body).children(0).position().top;

    /* react to scroll event on window */
    $window.scroll(function () {
        window.clearTimeout(scroll_timer);
        scroll_timer = window.setTimeout(function () {
            if($window.scrollTop() <= top)
            {
                displayed = false;
                $message.fadeOut(500);
            }
            else if(displayed == false)
            {
                displayed = true;
                $message.stop(true, true).show().click(function () { $message.fadeOut(500); });
            }
        }, 100);
    });
});
</script>
</head>
<div id="top"></div>
<!-- put all of your normal content stuff here -->
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
fasfdsffdsa<br>
<div id="message" align="right"><a href="#">Scroll to top</a></div>

</html>