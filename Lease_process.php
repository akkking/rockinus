<?php
session_start(); 
$uname = $_SESSION['usrname'];
$pagename = "HouseResult.php"; 
include 'dbconnect.php'; 
include 'emailfuc.php';
require("class.phpmailer.php");
$ok = 1;
//$tag = 1;
$rstatus = 'Y';
$subject = $_POST['subject'];
$_SESSION['rst_msg']="<div align='center' style='padding-top:10; padding-bottom:10; margin-top:10; color:#336633'><font size=3><strong><img src=img/addsuccessIcon_F5.jpg width=20>&nbsp;&nbsp; Your Lease Information has been posted successfully!</strong><br><br><a href=HouseRental.php class=one>Back Home</a></font></div>"; 

if(!isset($_POST['subject'])||trim(addslashes($_POST['subject']))==NULL){
	$pagename = "PostRental.php";
	$ok = 0;
	$tmp_rst_msg = "Subject is not filled";
}else if(!isset($_POST['description'])||trim(addslashes($_POST['description']))==NULL){
	$pagename = "PostRental.php";
	$ok = 0;
	$tmp_rst_msg = "Description is not filled, please write some description";
}

if($ok==1 && isset($_POST['rentalSubmit'])){
	$subject = addslashes($_POST['subject']);
	$type = $_POST['type'];
	$rentlease = $_POST['rentlease'];
	$subject = $_POST['subject'];
	$description = $_POST['description'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$duration = $_POST['duration'];
	$rate = $_POST['rate']; 
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$file1_name = $_FILES['uploaded1']['name'];
	$file2_name = $_FILES['uploaded2']['name'];
	$file3_name = $_FILES['uploaded3']['name'];
	$description = addslashes($_POST['description']);
	$metroline = $_POST['metroline'];
	$metrostop = $_POST['metrostop'];
	$metromins = $_POST['metromins'];    
	$expireday = $_POST['expireday'];
	$extra_fee_array = $_POST['extra_fee'];
	
	$extra_fee = NULL;
//	if(empty($extra_fee_array)){
//		echo("You didn't select any buildings.");
//		$extra_fee = NULL;
//	}else{
 	if(!empty($extra_fee_array)){
    	$N = count($extra_fee_array);
    	//echo("You selected $N door(s): ");

    	for($i=0; $i < $N; $i++){
			// echo($extra_fee_array[$i] . " ");
    		if($i==0) $extra_fee .= $extra_fee_array[$i];
			else $extra_fee .= ", ".$extra_fee_array[$i];
		}
  	}
	
	if( trim($file1_name)!=NULL || trim($file2_name)!=NULL || trim($file3_name)!=NULL ) {
		$qresult = mysql_query("SELECT * FROM rockinus.house_info ORDER BY hid DESC");
		$row = mysql_fetch_array($qresult);
		$hid = $row['hid'] + 1;

		$target = "upload/h".$hid."/";
		if(!is_dir($target)) mkdir($target);
	}

	if( trim($file1_name)!=NULL ) {
		$uploaded1_size = ($_FILES["uploaded1"]["size"]) / 1024;
		$uploaded1_type = $_FILES["uploaded1"]["type"];
		
		//This is our limit file type condition 
		if (($uploaded1_type != "image/gif") && ($uploaded1_type != "image/jpeg") && ($uploaded1_type != "image/pjpeg") && ($uploaded1_type != "image/png") && ($uploaded1_type != "image/x-png")){
			$tmp_rst_msg = "This file type is not allowed.".$uploaded1_type; 
 			$ok=0; 
 		}
		
		if ( $uploaded1_type == "image/gif" && $ok==1 ){
			$image = imagecreatefromgif($file1_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file1_name = $target.'1.jpg';
		}
		
		if ( $uploaded1_type == "image/jpeg" && $ok==1 ){
			$image = imagecreatefromjpeg($file1_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file1_name = $target.'1.jpg';
		}
		
		if ( ($uploaded1_type == "image/png" || $uploaded1_type == "image/x-png") && $ok==1 ){
			$image = imagecreatefrompng($file1_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file1_name = $target.'1.jpg';
		}
		
		$fileNameParts   = explode( ".", $file1_name ); // explode file name to two part
		$fileExtension   = end( $fileNameParts ); // give extension
		$fileExtension   = strtolower( $fileExtension ); // convert to lower case
		$new_file1_name   = "1.".$fileExtension;  // new file name	
		$new_file1_name100   = "1_100.".$fileExtension;  // new file name
		$new_file1_name600   = "1_600.".$fileExtension;  // new file name  
		$new_file1_name   	 = $target.$new_file1_name;
		$new_file1_name100   = $target.$new_file1_name100;
		$new_file1_name600   = $target.$new_file1_name600;

		//This is our size condition 
		if($uploaded1_size > 500){ 
			$tmp_rst_msg = "the file is too large.<br><br><a href=PostRental.php class=one>Go Back</a>"; 
			$ok=0; 
		} 
	}
	
	if( trim($file2_name)!=NULL  ) {
		$uploaded2_size = ($_FILES["uploaded2"]["size"]) / 1024;
		$uploaded2_type = $_FILES["uploaded2"]["type"];
		
		//This is our limit file type condition 
		if (($uploaded2_type != "image/gif") && ($uploaded2_type != "image/jpeg") && ($uploaded2_type != "image/pjpeg") && ($uploaded2_type != "image/png") && ($uploaded2_type != "image/x-png")){
			$tmp_rst_msg = "This file type is not allowed.".$uploaded2_type; 
 			$ok=0; 
 		}
		
		if ( $uploaded2_type == "image/gif" && $ok==1 ){
			$image = imagecreatefromgif($file2_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file2_name = $target.'1.jpg';
		}
		
		if ( $uploaded2_type == "image/jpeg" && $ok==1 ){
			$image = imagecreatefromjpeg($file1_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file2_name = $target.'1.jpg';
		}
		
		if ( ($uploaded2_type == "image/png" || $uploaded2_type == "image/x-png") && $ok==1 ){
			$image = imagecreatefrompng($file2_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file2_name = $target.'1.jpg';
		}
		
		$fileNameParts   = explode( ".", $file2_name ); // explode file name to two part
		$fileExtension   = end( $fileNameParts ); // give extension
		$fileExtension   = strtolower( $fileExtension ); // convert to lower case
		$new_file2_name   = "2.".$fileExtension;  // new file name
		$new_file2_name100   = "2_100.".$fileExtension;  // new file name
		$new_file2_name600   = "2_600.".$fileExtension;  // new file name  
		$new_file2_name   	 = $target.$new_file2_name;
		$new_file2_name100   = $target.$new_file2_name100;
		$new_file2_name600   = $target.$new_file2_name600;

		//This is our size condition 
		if($uploaded2_size > 500){ 
		$tmp_rst_msg = "the file is too large.<br><br><a href=PostRental.php class=one>Go Back</a>"; 
			$ok=0; 
		} 
	}
	
	if( trim($file3_name)!=NULL  ) {
		$uploaded3_size = ($_FILES["uploaded3"]["size"]) / 1024;
		$uploaded3_type = $_FILES["uploaded3"]["type"];
		
		//This is our limit file type condition 
		if (($uploaded3_type != "image/gif") && ($uploaded3_type != "image/jpeg") && ($uploaded3_type != "image/pjpeg") && ($uploaded3_type != "image/png") && ($uploaded3_type != "image/x-png")){
			$tmp_rst_msg = "This file type is not allowed.".$uploaded1_type; 
 			$ok=0; 
 		}
		
		if ( $uploaded3_type == "image/gif" && $ok==1 ){
			$image = imagecreatefromgif($file3_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file3_name = $target.'1.jpg';
		}
		
		if ( $uploaded3_type == "image/jpeg" && $ok==1 ){
			$image = imagecreatefromjpeg($file3_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file3_name = $target.'1.jpg';
		}
		
		if ( ($uploaded3_type == "image/png" || $uploaded3_type == "image/x-png") && $ok==1 ){
			$image = imagecreatefrompng($file3_name);
			imagejpeg($image, $target.'1.jpg', 100);
			imagedestroy($image);
			$file3_name = $target.'1.jpg';
		}
		
		$fileNameParts   = explode( ".", $file3_name ); // explode file name to two part
		$fileExtension   = end( $fileNameParts ); // give extension
		$fileExtension   = strtolower( $fileExtension ); // convert to lower case
		$new_file3_name   = "3.".$fileExtension;  // new file name
		$new_file3_name100   = "3_100.".$fileExtension;  // new file name
		$new_file3_name600   = "3_600.".$fileExtension;  // new file name  
		$new_file3_name   	 = $target.$new_file3_name;
		$new_file3_name100   = $target.$new_file3_name100;
		$new_file3_name600   = $target.$new_file3_name600;
 	
		//This is our size condition 
		if($uploaded3_size > 500){ 
			$tmp_rst_msg = "the file is too large.<br><br><a href=PostRental.php class=one>Go Back</a>"; 
			$ok=0; 
		} 
	}
}	
//Here we check that $ok was not set to 0 by an error 
if($ok==0){ 
	$_SESSION['rst_msg'] = "<div align='left' style='padding-top:10; padding-bottom:10; width:740; height:20; background-color:#F5F5F5; margin-bottom:5; font-size:16px; color:#B92828'>&nbsp;&nbsp;<img src='img/error_new.jpg' height=15>&nbsp;&nbsp;&nbsp;<strong>".$tmp_rst_msg."</strong></div>"; 
	//header("location:ChangeHeadIcon.php");
}else{
	if( ( trim($file1_name)!=NULL ) && move_uploaded_file($_FILES['uploaded1']['tmp_name'], $new_file1_name) ) { 
 		include('SimpleImage.php');
   		$image1001 = new SimpleImage();
   		$image1001->load($new_file1_name);
   		$image1001->resizeToWidth(100);
   		$image1001->save($new_file1_name100);   		
		$image6001 = new SimpleImage();
   		$image6001->load($new_file1_name);
   		$image6001->resizeToWidth(600);
   		$image6001->save($new_file1_name600);
	}
		
	if( ( trim($file2_name)!=NULL ) && move_uploaded_file($_FILES['uploaded2']['tmp_name'], $new_file2_name) ) { 
   		$image1002 = new SimpleImage();
   		$image1002->load($new_file2_name);
   		$image1002->resizeToWidth(100);
   		$image1002->save($new_file2_name100);   		
		$image6002 = new SimpleImage();
   		$image6002->load($new_file2_name);
   		$image6002->resizeToWidth(600);
   		$image6002->save($new_file2_name600);
	}
	
	if( ( trim($file3_name)!=NULL ) && move_uploaded_file($_FILES['uploaded3']['tmp_name'], $new_file3_name) ) { 
   		$image1003 = new SimpleImage();
   		$image1003->load($new_file3_name);
   		$image1003->resizeToWidth(100);
   		$image1003->save($new_file3_name100);   		
		$image6003 = new SimpleImage();
   		$image6003->load($new_file3_name);
		$image6003->resizeToWidth(600);
		$image6003->save($new_file3_name600);
	}

	mysql_query('set character_set_connection=utf8, character_set_results=utf8, character_set_client=utf8');
	$sql = "INSERT INTO rockinus.house_info(subject,type,rentlease,city,state,email,telephone,rate,descrip,duration,expireday,metroline, metrostop,  metromins, rstatus, extra_fee, uname,contact,pdate,ptime,tbname) VALUES('$subject','$type','$rentlease','$city','$state','$email','$telephone','$rate','$description','$duration', '$expireday', '$metroline', '$metrostop', '$metromins','$rstatus','$extra_fee','$uname','$contact',CURDATE(), NOW(), 'house_info')";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());

	$q_email = mysql_query("SELECT a.email, a.uname FROM rockinus.user_check_info a JOIN rockinus.user_email_setting b WHERE a.uname=b.uname AND b.house='Y'");
	if(!$q_email) die(mysql_error());
	while($object = mysql_fetch_object($q_email)){
		$email_list .= $object->email.";";
		$recipient_list .= $object->uname.";";
	}
		
	if(substr($email_list,strlen($email_list)-1,1)==";"){
		$email_list = substr($email_list,0,strlen($email_list)-1);
		$recipient_list = substr($recipient_list,0,strlen($recipient_list)-1);
	}	
	smtp_mail($email_list, "[Rockinus.House] ".$subject, nl2br($description), "admin@rockinus.com", $recipient_list, "", ""); 
}

header("location:$pagename");
mysql_close($link);
?>