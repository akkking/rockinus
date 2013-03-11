<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><html><head><title>Untitled</title><script language="javascript" type="text/javascript">function checkForm(f){	var barcodeDefault = "Enter a barcode";	if( f.barcode.value == '' || f.barcode.value == barcodeDefault ){		f.barcode.value = barcodeDefault;		return false;	}	else{ return true; }} onload = function(){	checkForm(document.forms.barcodeForm);} </script></head> <body> <form id="barcodeForm" action="action.php" method="post" onsubmit="return checkForm(this);"><input name="barcode" type="text" value="" onfocus="this.value=''" onblur="if(checkForm(this.form))this.form.submit();" />&nbsp;<input type="submit" value="Add" /></form> </body></html><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Untitled</title>
<script language="javascript" type="text/javascript">
function checkForm(f){
	var barcodeDefault = "Enter a barcode";
	if( f.barcode.value == '' || f.barcode.value == barcodeDefault ){
		f.barcode.value = barcodeDefault;
		return false;
	}
	else{ return true; }
}

onload = function(){
	checkForm(document.forms.barcodeForm);
}

</script>
</head>

<body>

<form id="barcodeForm" action="action.php" method="post" onsubmit="return checkForm(this);">
<input name="barcode" type="text" value="" onfocus="this.value=''" onblur="if(checkForm(this.form))this.form.submit();" />&nbsp;
<input type="submit" value="Add" />
</form>

</body>
</html>
