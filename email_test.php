<?php

$smtp="smtp.rockinus.com";  
$title="Subject";  
$username="admin@rockinus.com";  
$passwd="harvey9i"; 
$mailfrom="admin@rockinus.com"; 
//$mailfrom1="admin@rockinus.com"; 
$rcptto="ayigai01@students.poly.edu"; 
$mail="hello";     
 
smail($smtp,$title,$username,$passwd,$mailfrom,$mailfrom1,$rcptto,$mail);
 
function smail($smtp,$title,$username,$passwd,$mailfrom,$mailfrom1,$rcptto,$mail){
$message="";
$message .= "Connecting to Server...<br>";
$link = fsockopen($smtp,25);
if ($link){
 set_socket_blocking($link,true);
 $lastmessage=fgets($link,512);
 
 if (!ereg("^220",$lastmessage)){
  $message .= "Connection failed: " . $lastmessage . "<br>";
 }
 else{
  $message .= "Connection Successful, server is ready：" . $lastmessage . "<br>";
 
  fputs($link,"HELO phpsetmail"."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^250",$lastmessage)){
   $message .= "Successfully connected to server with HELO: " .$lastmessage. "<br>";
  }
  else{
   $message .= "Failed to connect to server with HELO: " .$lastmessage. "<br>";
  }
 
  fputs($link,"AUTH LOGIN"."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^334",$lastmessage)){
   $message .= "Authorized Successfully：" .$lastmessage. "<br>";
  }
  else{
   $message .= "Authorization failed: " .$lastmessage. "<br>";
  } 
 
  fputs($link,base64_encode($username)."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^334",$lastmessage)){
   $message .= "Server user validation successuful: " .$lastmessage. "<br>";
  }
  else{
   $message .= "Server user validation failed: " .$lastmessage. "<br>";
  }
 
  fputs($link,base64_encode($passwd)."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^235",$lastmessage)){
   $message .= "与服务器密码验证成功：" .$lastmessage. "<br>";
  }
  else{
   $message .= "与服务器密码验证失败：" .$lastmessage. "<br>";
  }
 
  fputs($link,"MAIL FROM:$mailfrom"."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^250",$lastmessage)){
   $message .= "与服务器MAIL FROM成功：" .$lastmessage. "<br>";
  }
  else{
   $message .= "与服务器MAIL FROM失败：" .$lastmessage. "<br>";
  }
 
  fputs($link,"RCPT TO:$rcptto"."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^250",$lastmessage)){
   $message .= "与服务器RCPT TO成功：" .$lastmessage. "<br>";
  }
  else{
   $message .= "与服务器RCPT TO失败：" .$lastmessage. "<br>";
  }
 
  fputs($link,"DATA"."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^354",$lastmessage)){
   $message .= "请求与服务器发送邮件数据成功：" .$lastmessage. "<br>";
   fputs($link,"From:$mailfrom1" . "\r\n");
   fputs($link,"Subject:$title" . "\r\n");
   fputs($link,"To:$rcptto" . "\r\n");
   fputs($link,"\r\n");
   fputs($link,$mail . "\r\n");
   fputs($link,"." . "\r\n");
   $lastmessage=fgets($link,2000);
   if (ereg("^250",$lastmessage)){
    $message .= "发送邮件数据成功：" .$lastmessage. "<br>";
   }
   else{
    $message .= "发送邮件数据失败：" .$lastmessage. "<br>";
   }
 
  }
  else{
   echo "请求与服务器发送邮件数据成功：" .$lastmessage. "<br>";
  }
 
  fputs($link,"QUIT"."\r\n");
  $lastmessage=fgets($link,2000);
  if (ereg("^221",$lastmessage)){
   $message .= "与服务器断开连接成功：" .$lastmessage. "<br>";
  }
  else{
   $message .= "与服务器断开连接失败：" .$lastmessage. "<br>";
  }
 
 }
 echo "s_".$message;
}
else{
 echo "err_";
}
fclose($link);
}

?>