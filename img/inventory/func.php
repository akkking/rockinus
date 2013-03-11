<?php
function getRam($length)   { 
	/*total   35   chars*/ 
	$source_chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
	$str   =   " "; 
	for($i=0;$i <$length;$i++){ 
	$j   =   rand(1,(strlen($source_chars)-1)); 
	$str   =   $str.$source_chars[$j]; 
	} 
	return   $str; 
}

function is_email($user_email)
{
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
	if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
	{
		if (preg_match($chars, $user_email))
		{
			return "1";
		}
		else
		{
			return "0";
		}
	}
	else
	{
		return "0";
	}
}

function smtp_mail( $sendto_email, $subject, $body, $extra_hdrs, $user_name, $chkcodelink, $tag){   
	date_default_timezone_set("America/New_York");//set the time zone
    $mail = new PHPMailer();        
    $mail->IsSMTP();                  // send via SMTP        
    $mail->Host = "smtp.gmail.com";   // SMTP servers     
    $mail->SMTPAuth = true;           // turn on SMTP authentication        
    $mail->Username = "gunit.inventory@gmail.com";     // SMTP username         
    $mail->Password = "264gunitcamera15"; // SMTP password        
    $mail->From = "gunit.inventory@gmail.com";      // sender email address       
    $mail->FromName =  "gunit.inventory@gmail.com";  // sender name         
    $mail->CharSet = "utf-8";   // character style    
	$mail->SMTPAuth   = true;     
	$mail->Port = 465;
	$mail->SMTPSecure = "ssl";
    $mail->Encoding = "base64";        
    $mail->AddAddress($sendto_email,$user_name);  // sender email address and name        
    $mail->AddReplyTo("gunit.inventory@gmail.com","admin");            
    $mail->IsHTML(true);  // send as HTML        
    $mail->Subject = $subject;
	if($tag=="passwd"){
		$mail->Body ="
		<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='200' height='42' bgcolor='#B82929'>&nbsp;</td>
              <td width='500' bgcolor='#B82929' align='right' style='padding-right:10px'><font size=5 color=white>Inventory Check-In Check-Out System</font></td>
            </tr>
            <tr>
              <td height='218' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear $user_name, <br />
                          <br />
                        Your new password is : $chkcodelink<br /><br />
                        <br />
                        Most Sincerely,<br />
                        Inventory Check-In Check-Out System <br />
                        BjornCG Inc. U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";
	}else if($tag=="regist"){
    	$mail->Body ="<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='200' height='42' bgcolor='#B82929'>&nbsp;</td>
              <td width='500' bgcolor='#B82929' align='right' style='padding-right:10px'><font size=5 color=white>Inventory Check-In Check-Out System</font></td>
            </tr>
            <tr>
              <td height='218' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear Admin, <br />
                          <br />
                        New user($chkcodelink) registered.<br /><br />
                        <br />
                        Most Sincerely,<br />
                        Inventory Check-In Check-Out System <br />
                        BjornCG Inc. U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";                                                                
    }else if($tag=='checkout'){
	$mail->Body ="<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='200' height='42' bgcolor='#B82929'>&nbsp;</td>
              <td width='500' bgcolor='#B82929' align='right' style='padding-right:10px'><font size=5 color=white>Inventory Check-In Check-Out System</font></td>
            </tr>
            <tr>
              <td height='218' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear Admin, <br />
                          <br />
                        User $user_name wants to borrow $chkcodelink from $body to $extra_hdrs.<br />
                        <br />
                        Most Sincerely,<br />
                        Inventory Check-In Check-Out System <br />
                        BjornCG Inc. U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";  
	}else if($tag=="overdue"){
    	$mail->Body ="<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='200' height='42' bgcolor='#B82929'>&nbsp;</td>
              <td width='500' bgcolor='#B82929' align='right' style='padding-right:10px'><font size=5 color=white>Inventory Check-In Check-Out System</font></td>
            </tr>
            <tr>
              <td height='218' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear Admin, <br />
                          <br />
                        Following Items are Overdue:<br /><br />
						$chkcodelink
                        <br />
                        Most Sincerely,<br />
                        Inventory Check-In Check-Out System <br />
                        BjornCG Inc. U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";                                                                
    }else if($tag=='deny'){
	$mail->Body ="<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='200' height='42' bgcolor='#B82929'>&nbsp;</td>
              <td width='500' bgcolor='#B82929' align='right' style='padding-right:10px'><font size=5 color=white>Inventory Check-In Check-Out System</font></td>
            </tr>
            <tr>
              <td height='218' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear Admin, <br />
                          <br />
                        Your request for $user_name is denied:<br /><br />
						The reason is : $chkcodelink
                        <br />
                        Most Sincerely,<br />
                        Inventory Check-In Check-Out System <br />
                        BjornCG Inc. U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";  
	}else if($tag=='ignore'){
	$mail->Body ="<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='200' height='42' bgcolor='#B82929'>&nbsp;</td>
              <td width='500' bgcolor='#B82929' align='right' style='padding-right:10px'><font size=5 color=white>Inventory Check-In Check-Out System</font></td>
            </tr>
            <tr>
              <td height='218' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear Admin, <br />
                          <br />
                        Your register request is denied by $user_name<br /><br />
                        The reason is : $chkcodelink
						<br />
                        Most Sincerely,<br />
                        Inventory Check-In Check-Out System <br />
                        BjornCG Inc. U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";  
	}
	$mail->AltBody ="text/html";        
    if(!$mail->Send()){        
       	echo "Sending ERROR: <p>";        
       	echo "Mail error info: " . $mail->ErrorInfo;        
       	exit;        
    }else{        
       	//echo "$user_name sending successful!<br />";        
    }
}        

function checkAvail($iid)
{
	include 'dbconnect.php';
	$sql="select * from inventory.item_info where iid ='$iid' ";
	$result = mysql_query($sql);
	if (!$result) die('Invalid query: ' . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['tag']=='Y')
	{
		return true;
	}
}

function show_rst($tag,$rst_msg){
        if($tag==0) $_SESSION['rst_msg']="<div valign=middle><br><font size=3 color=#336633><strong><img src=img/sucess.jpg> $rst_msg<br><br></strong></font></div>";
        else $_SESSION['rst_msg']="<div valign=middle><br><font size=4 color=red><strong><img src=img/fail.jpg> $rst_msg<br><br></strong></font></div>";
}

function is_date($date) 
{ 
	//$date = str_replace(array('\'', '-', '.', ','), '/', $date); 
	$date = explode('/', $date); 
	/*
	if(    count($date) == 1 // No tokens 
		and    is_numeric($date[0]) 
		and    $date[0] < 20991231 and 
		(    checkdate(substr($date[0], 4, 2) 
					, substr($date[0], 6, 2) 
					, substr($date[0], 0, 4))) 
	) 
	{ 
		return true; 
	} 
	*/
	if(    count($date) == 3 
		and    is_numeric($date[0]) 
		and    is_numeric($date[1]) 
		and is_numeric($date[2]) and 
		(checkdate($date[0], $date[1], $date[2])) //mmddyyyy 
		//or    checkdate($date[1], $date[0], $date[2]) //ddmmyyyy 
		//or    checkdate($date[1], $date[2], $date[0])) //yyyymmdd 
	) 
	{ 
		return true; 
	} 
	
	return false; 
} 
?>