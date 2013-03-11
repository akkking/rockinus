<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<input type="text" id="myinput" value="更换主题" size="8" style="border-bottom:1px solid #999999; border-left:0px; border-right:0px; border-top:0px"/>
<script type="text/javascript">
$("#myinput").live("focus", function() { 
$("#option-dialog").toggle(); 
}); 
 
$(".option").live("click", function() { 
var opt_val = $(this).attr("value"); 
$("#myinput").val(opt_val); 
$("#option-dialog").toggle();
}); 

//$("#option-dialog").mouseout(function() {
//$("#option-dialog").fadeIn("normal");
//});
</script>
<div id="option-dialog" style="display:none;"> 
<img src="img/fashion_icon.jpg" class="option" value="1"/>
<img src="img/fashion_icon.jpg" class="option" value="2"/>
</div> 
</body>
</html>
