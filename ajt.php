<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js">
 </script>
 <script type="text/javascript" >
 $(function() {
 $(".comment_button").click(function() {
 
var test = $("#content").val();
 var dataString = 'content='+ test;
 
if(test=='')
 {
 alert("Please Enter Some Text");
 }
 else
 {
 $("#flash").show();
 $("#flash").fadeIn(400).html('<img src="ajax-loader.gif" align="absmiddle"> <span class="loading">Loading Comment...</span>');
 
$.ajax({
 type: "POST",
 url: "demo_insert.php",
 data: dataString,
 cache: false,
 success: function(html){
 $("#display").after(html);
 document.getElementById('content').value='';
 document.getElementById('content').focus();
 $("#flash").hide();
 }
 });
 } return false;
 });
 });
 </script>
 // HTML code
 <div>
<form method="post" name="form" action="">
<h3>What are you doing?</h3>
<textarea cols="30" rows="2" name="content" id="content" maxlength="145" >
</textarea><br />
<input type="submit" value="Update" name="submit" class="comment_button"/>
</form>
 </div>
 <div id="flash"></div>
 <div id="display"></div>