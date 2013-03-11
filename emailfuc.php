<?php
function CheckPasswordStrength($vpass) 
{      
    $strength = 0; 
    $patterns = array('#[a-z]#','#[A-Z]#','#[0-9]#','/[?"?%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/'); 
    foreach($patterns as $pattern) 
    { 
        if(preg_match($pattern,$vpass,$matches)) 
        { 
            $strength++; 
        } 
    } 
    return $strength; 
     
    // 1 - weak 
    // 2 - not weak 
    // 3 - acceptable 
    // 4 - strong 
}

function is_email($user_email)
{
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
//	if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false&&strpos($user_email, '.edu') !== false)
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

function smtp_mail( $sendto_email, $subject, $body, $extra_hdrs, $user_name, $chkcodelink, $tag){   
	date_default_timezone_set("America/New_York");//set the time zone
    $mail = new PHPMailer();        
    $mail->IsSMTP();                  // send via SMTP 
    $mail->SMTPDebug = 1;       
//    $mail->SMTPSecure = "ssl"; 
    $mail->Host = "localhost";   // SMTP servers     
//    $mail->Host = "smtp.rockinus.com";   // SMTP servers     
//    $mail->SMTPAuth = true;           // turn on SMTP authentication        
    $mail->Username = "admin@rockinus.com";     // SMTP username         
    $mail->Password = "harvey9i"; // SMTP password        
    $mail->From = "admin@rockinus.com";      // sender email address       
    //$mail->FromName =  "admin@rockinus.com";  // sender name         
    $mail->FromName =  "New York Community Network";
	$mail->CharSet = "utf-8";   // character style        
    $mail->Encoding = "base64";        
	$recipient_email_num = count(explode(";", $sendto_email));
	$recipient_num = count(explode(";", $user_name));
	if( $recipient_email_num!=$recipient_num ){
		echo("Email recipient number is not equal to recipient number!");
		exit;
	}
	
	if( $recipient_email_num>1 ){
		$array_sendto_email = explode(";", $sendto_email);
		$array_user_name = explode(";", $user_name);
		for($i=0; $i<$recipient_email_num; $i++)
			$mail->AddBCC($array_sendto_email[$i],$array_user_name[$i]);
	}else
		$mail->AddAddress($sendto_email,$user_name);  // sender email address and name        
    
	$mail->AddReplyTo("admin@rockinus.com","admin");            
	$mail->IsHTML(true);  // send as HTML        
    $mail->Subject = $subject;
	if($tag=="passwd"){
		$mail->Body ="
		<table width='700' height='262' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='519' height='42' bgcolor='#336633'>&nbsp;</td>
              <td width='181' bgcolor='#336633' align='center'><font size=5 color=white>Rockinus.com</font></td>
            </tr>
            <tr>
              <td height='218' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear $user_name, <br />
                          <br />
                        Please click on the following link to reset your password.<br /><br />
                        <a href='$chkcodelink'>$chkcodelink</a><br />
                        <br />
                        We look forward your show up! <br />
                        <br />
                        Most Sincerely,<br />
                        Rockinus Team <br />
                        New York City U.S.
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>";
	}else if($tag=="regist"){
    	$mail->Body ="
	         <table width='700' height='420' border='0' cellpadding='0' cellspacing='0' style='margin-bottom:40; margin-top:50; border:0 #006699 solid; background-color:' alight='left'>
            <tr>
              <td width='519' height='42' bgcolor='#336633'>&nbsp;</td>
              <td width='181' bgcolor='#336633' align='center'><font size=5 color=white>Rockinus.com</font></td>
            </tr>
            <tr>
              <td height='400' colspan='2' bgcolor='#EEEEEE'>
                <div align='center'>
                  <table width='684' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='684' align='left'>Dear $user_name, <br />
                          <br />
                        Welcome to Rockinus.com - New York Community Network. <br />
                        <br />
                        With Rockinus, you can follow up with New York students' openning jobs, internal referrals, interview questions, campus news and so on. You can also find apartments, roommates, useful things on sale very close to you. Reviewing what others say about courses you may be interested in. Commenting on courses to help others taking decison before registering the courses. Connecting with alumnus is rather practical. Do not lose people from your hometown, school and same city. What are you waiting for? Find them out in Rockinus.com. <br />
                         <br />
                        There is more for you to explore, hope you enjoy the experience. We make it simple, local and free.<br />
                        <br />
                        Please click on the following link to activate your account.<br />
                        <a href='$chkcodelink'>$chkcodelink</a><br />
                        <br />
                        Looking forward to your show-up.<br />
                        <br />
                        Warmly Regards,<br />
                        Rockinus Team <br />
                        New York City, USA
				</td>
                    </tr>
                  </table>
			    </div>
			  </td>
            </tr>
</table>
	         ";                                                                  
    }else
		$mail->Body = $body;
	
	$mail->AltBody ="text/html";        
    if(!$mail->Send()){        
       	echo "Sending ERROR: <p>";        
       	echo "Mail error info: " . $mail->ErrorInfo;        
       	exit;        
    }else{        
       	//echo "$user_name sending successful!<br />";        
    }
}        

?>