<?php 
session_start(); 
$uname = $_SESSION['usrname']; 
// echo "$uname";
 
 $target = "upload/".$uname."/";
 if(!is_dir($target)) mkdir($target);
 
 $file_name = $_FILES['uploaded']['tmp_name'];
 $uploaded_size = ($_FILES["uploaded"]["size"]) / 1024;
 $uploaded_type = $_FILES["uploaded"]["type"];
 $ok=1; 
 
 //This is our limit file type condition 
	if (($uploaded_type != "image/gif") && ($uploaded_type != "image/jpeg") && ($uploaded_type != "image/pjpeg") && ($uploaded_type != "image/png") && ($uploaded_type != "image/x-png")){
		$tmp_rst_msg = "This file type is not allowed.".$uploaded_type; 
 		$ok=0; 
 	}
		
	if ( $uploaded_type == "image/gif" && $ok==1 ){
		$image = imagecreatefromgif($file_name);
		imagejpeg($image, $target.'.jpg', 100);
		imagedestroy($image);
		$file_name = $target.'.jpg';
	}
		
	if ( $uploaded_type == "image/jpeg" && $ok==1 ){
		$image = imagecreatefromjpeg($file_name);
		imagejpeg($image, $target.'.jpg', 100);
		imagedestroy($image);
		$file_name = $target.'.jpg';
	}
		
	if ( ($uploaded_type == "image/png" || $uploaded_type == "image/x-png") && $ok==1 ){
		$image = imagecreatefrompng($file_name);
		imagejpeg($image, $target.'.jpg', 100);
		imagedestroy($image);
		$file_name = $target.'.jpg';
	}
 
 $fileNameParts   = explode( ".", $file_name ); // explode file name to two part
 $fileExtension   = end( $fileNameParts ); // give extension
 $fileExtension   = strtolower( $fileExtension ); // convert to lower case
 $new_file_name   = $uname.".".$fileExtension;  // new file name
 //$new_file_name_fixed50   = $uname."_fixed50.".$fileExtension;  // new file name
 //$new_file_name_fixed70   = $uname."_fixed70.".$fileExtension;  // new file name
 $new_file_name60   = $uname."60.".$fileExtension;  // new file name
 $new_file_name100   = $uname."100.".$fileExtension;  // new file name
 $new_file_name210   = $uname."210.".$fileExtension;  // new file name  
 $new_file_name250   = $uname."250.".$fileExtension;  // new file name 
 $new_file_name   	 = $target.$new_file_name;
 //$new_file_name_fixed50   = $target.$new_file_name_fixed50;
 //$new_file_name_fixed70   = $target.$new_file_name_fixed70;
 $new_file_name60   = $target.$new_file_name60;
 $new_file_name100   = $target.$new_file_name100;
 $new_file_name210   = $target.$new_file_name210;
 $new_file_name250   = $target.$new_file_name250;
 
 //This is our size condition 
 if($uploaded_size > 2048){ 
 	$tmp_rst_msg = "it is too large."; 
 	$ok=0; 
 } 
 
 //This is our limit file type condition 
 if($uploaded_type == "text/php" || $uploaded_type == "application/octet-stream"){ 
 	$tmp_rst_msg = "the type is not allowed."; 
 	$ok=0; 
 } 
 
 //Here we check that $ok was not set to 0 by an error 
 if($ok==0){ 
 	$_SESSION['rst_msg'] = "<div align='center' style='width=450; padding-top:30; padding-bottom:30; margin-top:10; margin-bottom:-30'><strong><font color=#B92828 size=3><img src=img/error_new.jpg width=20px>&nbsp;&nbsp;&nbsp;Sorry the file was not uploaded, ".$tmp_rst_msg."<br></font></strong><br></div>"; 
	header("location:EditHeadIcon.php");
 }else{ 
 	if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $new_file_name)) { 
   		include('SimpleImage.php');
/**
   		$image_fixed50 = new SimpleImage();
   		$image_fixed50->load($new_file_name);
   		$image_fixed50->resize(50,50);
   		$image_fixed50->save($new_file_name_fixed50);   

   		$image_fixed70 = new SimpleImage();
   		$image_fixed70->load($new_file_name);
   		$image_fixed70->resize(70,70);
   		$image_fixed70->save($new_file_name_fixed70);   		
**/
   		$image60 = new SimpleImage();
   		$image60->load($new_file_name);
   		$image60->resizeToWidth(60);
   		$image60->save($new_file_name60);   	

   		$image100 = new SimpleImage();
   		$image100->load($new_file_name);
   		$image100->resizeToWidth(100);
   		$image100->save($new_file_name100);   	
			
		$image210 = new SimpleImage();
   		$image210->load($new_file_name);
   		$image210->resizeToWidth(210);
   		$image210->save($new_file_name210);
		
		$image250 = new SimpleImage();
  		$image250->load($new_file_name);
  		$image250->resizeToWidth(250);
  		$image250->save($new_file_name250);
		
		include 'dbconnect.php'; 
		$result = mysql_query("INSERT INTO rockinus.headicon_history(uname,descrip,pdate,ptime)VALUES('$uname','',CURDATE(), NOW())");
		if (!$result) die('Invalid query: ' . mysql_error());
		mysql_close($link);
		
		$_SESSION['rst_msg'] = "<div align='center' style='width:300px; border:1px solid #DDDDDD; background:#F5F5F5; -moz-border-radius: 5px; border-radius: 5px; font-size:18px; padding:15 25 15 25; margin-top:30; margin-bottom:-30; color:$_SESSION[hcolor]'><img src=img/addsuccessIcon.jpg width=15>&nbsp;&nbsp; Beautiful. New icon is set!</div>"; 
		$_SESSION['rst_flag'] = "success";
		header("location:EditHeadIcon.php");
 	}else{ 
		$_SESSION['rst_msg'] = "<div align='center' style='width=400; padding-top:30; padding-bottom:-20; margin-top:10; margin-bottom:-30'><strong><font color='#B92828' size=3><img src=img/error_new.jpg width=20>&nbsp;&nbsp;&nbsp;Sorry, wrong upload, try again<p><br></font></strong><br></div>";
 		header("location:EditHeadIcon.php");
 	} 
 } 
 ?> 