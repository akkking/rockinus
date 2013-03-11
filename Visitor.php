      <br><br><div class="visitListDiv" id="visitListDiv" style=" padding-left:5px; width:620px;">
        <table width="610" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="" style="margin-bottom:5; border-bottom:0px solid #DDDDDD">
          <tr>
            <td width="460" align="left" valign="middle" style="padding-left:0px; font-weight:normal; color:#000000; font-size:24px; ">
			Recent visitors
			&nbsp;</td>
            <td width="155" align="right" valign="middle" style="padding-right:0; font-size:24px">
			&nbsp;<?php
			  $v = mysql_query("SELECT visitor, vtime, vdate, fname, lname FROM rockinus.visit_info a JOIN rockinus.user_info b ON a.host='$uname' AND b.uname=a.visitor ORDER BY a.vdate DESC, a.vtime DESC;");
				if(!$v) die(mysql_error());
				$no_row_v = mysql_num_rows($v);
				
			  $v_total = mysql_query("SELECT visitor, vtime, vdate FROM rockinus.visit_history WHERE host='$uname' ORDER BY vdate DESC, vtime DESC;");
				if(!$v_total) die(mysql_error());
				$no_row_v_total = mysql_num_rows($v_total);
				if($no_row_v < 10)
					echo("<font color=#666666>($no_row_v/$no_row_v)</font>");
				else
					echo("<font color=#666666>(10/$no_row_v)</font>");
			?>
			</td>
          </tr>
  </table>
        <?php
		if($no_row_v == 0) echo("<div style='padding-top:30px; padding-left:0px; margin-bottom:10px; font-size: 12px' align='center'><strong><img src='img/join.jpg'>&nbsp;&nbsp; Nobody visited yet...</strong></div>");
		$i = 0;
		while($objv = mysql_fetch_object($v)){
			$i++;
			$visitor = $objv->visitor;
			$vfname = $objv->fname;
			$vlname = $objv->lname;
			$vdate = $objv->vdate;
			$vtime = substr($objv->vtime,0,5);
			
			// get user's memo status
			$q_memo = mysql_query("SELECT * FROM rockinus.memo_info where sender='$visitor' ORDER BY memoid DESC");
			if(!$q_memo) die(mysql_error());
			$object_memo = mysql_fetch_object($q_memo);
			$memo_descrip = $object_memo->descrip;
			if(strlen($memo_descrip)>100) $memo_descrip = substr($memo_descrip,0,100)."...";
			else if($memo_descrip==NULL || strlen(trim($memo_descrip))==0) $memo_descrip = "<font color='#999999'>$vfname has nothing shared...</font>";
			else $memo_descrip = "<font color=$_SESSION[hcolor]><strong>$vfname posted a status:</strong></font><br> $memo_descrip";
			//$visitpic100 = $visitor.'100.jpg';
			$visit_pic = $visitor.'60.jpg';
			//date('Y-m-d, H:i');
			$target_visitor = "upload/".$visitor;

			if(is_dir($target_visitor)){
			?>
        <div style="margin-bottom:10; margin-left:0; width:610px">
          <table width="610" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
            <tr>
              <td align='center' style='border:0px solid #EEEEEE; padding:5px; background:url("<?php echo("upload/$visitor/$visit_pic?".time()); ?>"); background-repeat:no-repeat;' width="73" height="70"></td>
              <td style='border:0px solid #EEEEEE; padding:5px; padding-top:0; padding-left:5; line-height:170%; font-size:14px; ' valign="top" align="left" width="312"><a href="RockerDetail.php?uid=<?php echo($visitor) ?>" class="one" style="font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>"><?php echo($vfname." ".$vlname) ?></a><br />
                <?php 
				echo("<font style='font-size:13px'>Last visit: ".getDateName($vdate).", ".substr($vtime,0,5)."</font>");
				?>
				&nbsp; &nbsp; <a href="SendMessage.php?recipient=<?php echo($visitor) ?>">
				<div style="font-size:11px; font-weight:normal; width:70; height:20; border:1px #999999 solid; background: url(img/master.png); color:#000000; padding:2 5 2 5; display:inline" align="center">Message</div>
				</a>			  </td>
              <td style='border-left: 1px dashed #EEEEEE; padding:5px;line-height:150%; background:#F5F5F5; font-size:12px; ' valign="top" align="left" width="225">
			  <?php echo($memo_descrip) ?>
			  </td>
            </tr>
          </table>
        </div>
        <?php }else{ ?>
        <div style="margin-bottom:10; margin-left:0; width:610px" >
          <table width="610" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #DDDDDD">
            <tr>
              <td align='left' style='border:0px solid #EEEEEE; padding-bottom:0' width='73'><a href='RockerDetail.php?uid=$visitor' class="one" title='$visitor | $vdate, $vtime'><img src='img/NoUserIcon_fixed.jpg' width="60" style='margin-right:0px;' /></a></td>
              <td style='border:0px solid #EEEEEE; padding:5px; padding-top:0; padding-left:10px; line-height:170%; font-size:14px; ' valign="top" align="left" width="315"><a href="RockerDetail.php?uid=<?php echo($visitor) ?>" class="one" style="font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>"><?php echo($vfname." ".$vlname) ?></a><br />
              <?php echo("<font style='font-size:13px'>Last visit: ".getDateName($vdate)."<br>".substr($vtime,0,5)."</font>") ?></td>
              <td style='border-left:1px dashed #EEEEEE; padding:5px; background:#F5F5F5; padding-top:0; padding-left:10px; line-height:170%; font-size:14px; ' valign="top" align="left" width="222">&nbsp;</td>
            </tr>
          </table>
        </div>
        <?php	}
			
			if($i==20)break;
		}
		?>
      </div>
