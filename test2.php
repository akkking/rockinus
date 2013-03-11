<script src="autoSubmit.js"></script>
<script language="javascript">
function reloadcode()
{
	document.getElementById('safecode').src='code.php?t'+ Math.random() ;
}
</script>
<?php 
session_start();

$tag = 0;

if(isset($_SESSION['randcode'])&&isset($_POST['uname'])){
	if($_SESSION['randcode']==$_POST['uname']){
		$_SESSION['rst_msg'] = "Correct!";
		$tag = 1;
	}else {
		$_SESSION['rst_msg'] = "It's Wrong..";
		$tag = 0;
	}
}
?>
<form id="unameForm" action="test2.php" method="post" onSubmit="return checkForm(this);" style="margin-bottom:0; margin-top:0;">
	<input name="uname" type="text" class="box" maxlength="4" onFocus="this.value=''" onBlur="if(checkForm(this.form))this.form.submit();" >
<?php 
if( $tag == 0 )	echo "<img src='code.php' id='safecode' onclick='reloadcode()' onBlur='' title='看不清楚?点击切换!'></img>";
if(isset($_SESSION['rst_msg']))echo($_SESSION['rst_msg']);
unset($_SESSION['rst_msg']);
unset($_SESSION['randcode']);
?>		  
</form>