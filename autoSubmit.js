// JavaScript Document
function checkForm(f){
	var unameDefault = "Rocker";
	if( f.uname.value == '' || f.uname.value == unameDefault ){
		f.uname.value = unameDefault;
		return false;
	}else{ return true; }
}

onload = function(){
	checkForm(document.forms.unameForm);
}

function reloadcode()
{
	document.getElementById('safecode').src='code.php?t'+ Math.random() ;
}