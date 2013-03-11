function validateForm(){
 var uname=document.forms["profile"]["uname"].value;
 var passwd=document.forms["profile"]["passwd"].value;
 var cpasswd=document.forms["profile"]["cpasswd"].value;
 var birthdate=document.forms["profile"]["birthdate"].value;
 var sstatus=document.forms["profile"]["sstatus"].value;
 var cstate=document.forms["profile"]["cstate"].value;
 var ccity=document.forms["profile"]["ccity"].value;
 var cschool=document.forms["profile"]["cschool"].value;
 var cdegree=document.forms["profile"]["cdegree"].value;
 var cmajor=document.forms["profile"]["cmajor"].value;
 var fcountry=document.forms["profile"]["fcountry"].value;
 var fcity=document.forms["profile"]["fcity"].value;
 var phone=document.forms["profile"]["phone"].value;
 var address=document.forms["profile"]["address"].value;
 var email=document.forms["profile"]["email"].value;
 var atpos=email.indexOf("@");
 var dotpos=email.lastIndexOf(".");
 if (uname==null || uname==""){
   alert("Rock name must be filled out");
   return false;
 }
 
  if (passwd==null || passwd==""){
   alert("Password is a must");
   return false;
 }
 
 if (passwd != cpasswd) {  
   alert("Your password and confirmation password do not match."); 
//   cpasswd.focus(); 
   return false;  
 } 
 
  if (birthdate==null || birthdate=="" || birthdate=="empty"){
   alert("Birth Date is a must");
   return false;
 }
 
  if (cstate==null || cstate=="" || cstate=="empty"){
   alert("Current State must be filled out");
   return false;
 }
 
  if (ccity==null || ccity=="" || ccity=="empty"){
   alert("Current City must be filled out");
   return false;
 }
 
  if (cschool==null || cschool=="" || cschool=="empty"){
   alert("Current school must be filled out");
   return false;
 }
 
  if (cmajor==null || cmajor=="" || cmajor=="empty" ){
   alert("Program must be filled out");
   return false;
 }
 
   if (fcountry ==null || fcountry=="" || fcountry=="empty"){
   alert("Country From must be filled out");
   return false;
 }
 
  if (fcity==null || fcity=="" || fcity=="empty"){
   alert("City From must be filled out");
   return false;
 }

 if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
   alert("Not a valid e-mail address");
   return false;
 }
}
