<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<script type="text/javascript" src="jsfile.js"></script>
<script type="text/javascript" >	
function setValue(str){
	document.getElementById("name").value=str;	
}
</script> 
<BODY>
Name:
<!--<input style="width: 200px;" id="name" onKeyUp="getInfo(this.value,200)" type="text" /><div id="autoSuggestionsList" style="position: relative; top: -4px; width='100px;'" ><
/div>!-->
<input style="width: 200px;" id="name" onKeyUp="getInfo(this.value)" type="text" />
<div id="autoSuggestionsList"></div>  
</BODY>
</HTML>