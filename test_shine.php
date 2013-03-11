<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>&#26080;&#26631;&#39064;&#25991;&#26723;</title>
</head>
<style>
#zeus { background-color: blue; color: white; display:none}
#zeuss { background-color: red; color: white; }
</style>

<body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
setTimeout(Animate,1000)
var flag;
function Animate()
{
  if(flag!="message2")
  {
    $("#message2").fadeOut(0);
    $("#message1").fadeIn(100);
    flag="message2"
  }
  else
  {
    $("#message1").fadeOut(0);
    $("#message2").fadeIn(100);
    flag="message1"
  }
setTimeout(Animate,10000)
}

function Init()
{
$("#message2").fadeOut(0);
}
</script>
</head>
<body onload="Init();">
  <div id="message1" style="width:300px; height:200px;background-color:Gray;font-size:50">
       Message1
  </div>
  <div id="message2" style="width:300px; height:200px;background-color:white;font-size:50">
     Message2
  </div>
</body>
</html>