<div style=" padding-bottom:25px">
<a href="postInterviewQuestion.php" class="two">
		<div style="margin-top:20px; -moz-border-radius: 2px; border-radius: 2px; width:250px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  + Post Interview Questions</div>
	  </a>
	<a href="postJob.php" class="two">
		<div style="margin-top:15px; -moz-border-radius: 2px; border-radius: 2px; width:250px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  + Post Job Positions</div>
	  </a>
	<a href="interviewQuestions.php" class="two">
		<div style="margin-top:15px; -moz-border-radius: 2px; border-radius: 2px; width:250px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  Review Interview Questions</div>
	  </a>
	  <a href="interviewQuestions.php" class="two">
		<div style="margin-top:15px; -moz-border-radius: 2px; border-radius: 2px; width:250px; height:25px; padding:10 0 5 0; background: url(img/GrayGradbgDown.jpg); border:1px solid #DDDDDD; font-size:14px; color:<?php echo($_SESSION['hcolor']) ?>; cursor:pointer" align="center" onmouseover="this.style.border='1px #CCCCCC solid'" onmouseout="this.style.border='1px #DDDDDD solid'">
	  Review Job Positions</div>
	  </a>
	<div style=" border-bottom:0px dashed #DDDDDD; height:25; margin-bottom:25px; font-size:14px;  margin-top:25; padding-left:5px; line-height:175%;"> <span style="font-size:14px; font-weight:normal"><img src="img/company.png" width="10" />&nbsp; Company List:</span><br />
        <div style="padding-left:20px">
          <?php
		mysql_query("SET NAMES GBK");
		$q = mysql_query("SELECT company FROM rockinus.interview_question ORDER BY q_id DESC");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		if ($no_row == 0)echo("<div style='background-color:#FFFFFF; border: 1 dashed #DDDDDD; width:730px; padding-top:50px; padding-bottom:50px' align='center'><font color=black size=4><strong>No interview question found with your search<p> <a href='postInterviewQuestion.php' class='one'>>> <font color=#B92828>Post a New Question</font></a> </strong></font></div>");
		$i=0; 
		$arr_company = array();
		while($object = mysql_fetch_object($q)){
			$companyname = $object->company;
			if(in_array($companyname,$arr_company))continue;
			else{
				if($i==0)
					echo("<a href='interviewQuestions.php?company=$companyname' class=one><font style='color:$_SESSION[hcolor];; font-weight:bold'>$companyname</font></a><br>");
				else
					echo("<font style='color:$_SESSION[hcolor]; font-weight:bold'></font><a href='interviewQuestions.php?company=$companyname' class=one><font style='color:$_SESSION[hcolor];; font-weight:bold'>$companyname</font></a><br>");
				array_push($arr_company, $companyname);
			}
			$i++;
		}
		?>
        </div>
	  </div>
	  </div>