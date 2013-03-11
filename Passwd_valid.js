function validateForm(){
 var oldpasswd=document.forms["profile"]["oldpasswd"].value;
 var passwd=document.forms["profile"]["passwd"].value;
 var cpasswd=document.forms["profile"]["cpasswd"].value;
 
  if (oldpasswd==null || oldpasswd==""){
   alert("Where is the old Password?");
   return false;
 }
 
  if (passwd==null || passwd==""){
   alert("Please enter the new password");
   return false;
 }
 
 if (passwd != cpasswd) {  
   alert("New password and confirmation password do not match."); 
//   cpasswd.focus(); 
   return false;  
 } 
 
}
