<?php 
		  if(
			 ($expire_tag==0&&$edu_tag==0)
			 ||
			 ($expire_tag==1&&($edu_tag==0||$work_tag==0))
			 ){
		  ?>
		  <div style="margin-bottom:20; width:725px; font-size:13px; margin-top:10px" align="left">
              <table width="725" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; border:0px solid #999999; margin-top:0; background:">
                <tr>
                  <td width="511" height="31" valign="top" style="padding-left:0px; line-height:230%">
				  <table width="511" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="28" align="left" style="padding:20 5 20 0;"><img src="img/blackSmileIcon.png" width="20" /> </td>
                        <td width="483" style="font-size:18px; font-family:Arial, Helvetica, sans-serif; font-weight:; padding-left:5" align="left">
                          <?php 
				  if($_SESSION['lan']=='CN'){
				  	if($fname==NULL) $fname = "新同学";
				  	echo("<font color=$_SESSION[hcolor]> 你好, $fname </font>");
				  }else if($_SESSION['lan']=='EN'){
				  	if($fname==NULL) $fname = $uname;
				  	echo("<font color=#333333>$fname</font>");
				}
				  ?>
                            <?php if($_SESSION['lan']=='CN')
				  echo("<font color=#C82929> 目前资料详细度仅 $wid% </font>");
				  else if($_SESSION['lan']=='EN')
				  echo("<font color=$_SESSION[hcolor]> 
				  , <span>let's sharp the profile very quick! (Now only $wid%)</span> 
				  </font>")
				  ?> 
				  </td>
                  </tr>
                  </table>
				  </td>
                  <td width="225" height="31" align="right" valign="top" style="padding:15 10 10 10; padding-top:20">
                    <a href="ThingsRock.php">
					<div style="background: <?php echo($_SESSION['hcolor']) ?>; padding-left:10px; padding-right:10px; padding-bottom:5px; padding-top:4px; display:inline; height:20; font-size:13px" align="center">
                      <?php if($_SESSION['lan']=='CN')
				  echo("完善我的资料");
				  else if($_SESSION['lan']=='EN')
				  echo("Skip this step")
				  ?>
                    </div>
					</a>
                  </td>
                </tr></table>
				  <?php if(isset($_SESSION['profile_err_rst_msg'])){
				  			echo("<div style='margin-bottom:10'>".$_SESSION['profile_err_rst_msg']."</div>");
							unset($_SESSION['profile_err_rst_msg']);
				  }?>
				  
				  <?php 
				  if($_SESSION['lan']=='CN')
				  	echo("<font size=2>建立一份详尽、真实的个人资料，十分有利于您享受更贴切的服务。因此，我们建议您维护一份完整的个人资料，这样一来，您会发现身边的生活原来是如此的丰富多彩. <a href=EditUserInfo.php class=one><strong><font color=$_SESSION[hcolor]>立即完善</font>>></strong></a></font></font>");
				  else if($_SESSION['lan']=='EN')
				  	echo("<div style='margin-bottom:35px; padding:5px; background:#F5F5F5; border:1px solid #DDDDDD; margin-top:10'>Rockinus is dedicated to provide first-hand info that you need. In this case, it's very critical to maintain an integral profile. It's actually double-side benefit for you and us. So let's complete major things of your profile now, which is really quick!</div>");
				  
				  echo("<form method='post'>");
				  
				  if($cdegree_tag==0){
					echo("<div style='border-bottom:0px solid #EEEEEE; height:15; height:28; margin-top:0; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif;'>
					<strong>Education Level</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<select name='cdegree' style='font-size:13px; font-family:Arial, Helvetica, sans-serif;'>
				  	<option value='Undergraduate'>Undergraduate student</option>
				    <option value='Graduate' selected>Graduate student</option>
				  	<option value='PHD'>P.h.D student</option>
				    <option value='Certificate'>Exchange(J1)/Certificate student</option>
					</select>
					</div>");
				  }else{
				  	echo("<div style='height:25; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Education Level:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $cdegree student</div>");
				  }
				  
				  if($cschool_tag==0){
					echo("<div style='border-bottom:0px solid #EEEEEE; height:28; font-weight:major; font-size:13px; font-family:Arial, Helvetica, sans-serif;'>
					<strong>Most Recent School</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<select name='cschool' style='font-size:13px; font-family:Arial, Helvetica, sans-serif'>"); 
				  	include 'dbconnect.php';
					
					$q = mysql_query("SELECT * FROM rockinus.school_info ORDER BY school_name ASC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopsid = $obj->sid;
						$school_name = trim($obj->school_name);
						if($loopsid=='NYPOLY'&&strlen(strstr($uname_email,"poly.edu"))>0)
							echo ("<option value=$loopsid selected>$school_name</option>");
						else
							echo ("<option value=$loopsid>$school_name</option>");
					}
					 
					if(strlen(strstr($uname_email,"poly.edu"))>0) 
						echo ("<option value=empty>Select your School</option></select></div>");
					else
						echo ("<option value=empty selected>Select your School</option></select></div>");
				  }else{
				  	include 'dbconnect.php';
					$q_school = mysql_query("SELECT * FROM rockinus.school_info WHERE sid='$cschool'");
					if(!$q_school) die(mysql_error());
					$obj_school = mysql_fetch_object($q_school);
					$cschool_show = trim($obj_school->school_name);

				  	echo("<div style='height:25; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Recent school:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $cschool_show</div>");
				 }
				 
				 if($cmajor_tag==0){
				 	echo("<div style='border-bottom:0px solid #EEEEEE; background:; height:30; margin-top:0; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif;'>
					<strong>Major/What study?</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<select name='cmajor' style='font-size:13px; font-family:Arial, Helvetica, sans-serif'>"); 
				  	include 'dbconnect.php';
					$q = mysql_query("SELECT * FROM rockinus.major_info ORDER BY major_name");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopmid = trim($obj->mid);
						$loopmajor_name = trim($obj->major_name);
						echo ("<option value=$loopmid>$loopmajor_name</option>");
					}
					echo ("<option value=empty selected>Select your Major</option></select></div>");				  
				}else{
					$q_major = mysql_query("SELECT * FROM rockinus.major_info WHERE mid='$cmajor'");
					if(!$q_major) die(mysql_error());
					$obj_major = mysql_fetch_object($q_major);
					$major_name = trim($obj_major->major_name);

			  		echo("<div style='height:25; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Program/Major title:</strong>&nbsp;&nbsp;&nbsp;&nbsp; $major_name</div>");
				}
				  
				  if($sterm_tag==0){
					echo("<div style='border-bottom:0px solid #EEEEEE; height:30; margin-top:0; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif;'>
					<strong>When you Enrolled</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<select name='sterm' id='sterm' style='font-size:13px; font-family:Arial, Helvetica, sans-serif'>"); 
				  	include 'dbconnect.php';
					$q = mysql_query("SELECT * FROM rockinus.school_term_info WHERE sid='NYPOLY' ORDER BY tyear DESC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopterm = trim($obj->tyear).trim($obj->tterm);
						$displayterm = trim($obj->tyear)." ".trim($obj->tterm);
						echo ("<option value=$loopterm>$displayterm</option>");
					}
					echo ("<option value=empty selected>Select a Term</option></select>");
				  	echo ("</div>");
				  }else{
				  	if($sterm!="empty")$sterm = substr($sterm, 0, 4)." ".substr($sterm,4,strlen($sterm)-4);
				  	echo("<div style='height:25; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Enrolled Term:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $sterm</div>");
				  }
				  
				  if($eterm_tag==0){
					echo("<div class='etermDiv' id='etermDiv' style='border-bottom:0px solid #EEEEEE; height:30; margin-top:0; font-weight:normal; font-size:13px; font-family:Arial, Helvetica, sans-serif; display:'>
					<strong>When Graduate(d)<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<select name='eterm' style='font-size:13px; font-family:Arial, Helvetica, sans-serif'>"); 
				  	include 'dbconnect.php';
					$q = mysql_query("SELECT * FROM rockinus.school_term_info WHERE sid='NYPOLY' ORDER BY tyear DESC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$loopterm = trim($obj->tyear).trim($obj->tterm);
						$displayterm = trim($obj->tyear)." ".trim($obj->tterm);
						echo ("<option value=$loopterm>$displayterm</option>");
					}
					echo ("<option value=empty selected>Select a Term</option></select>");
					
					echo ("</div>");
				}else{
					if($eterm!="empty")$eterm = substr($eterm, 0, 4)." ".substr($eterm,4,strlen($eterm)-4);
				  	echo("<div style='height:10; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Graduate(d) Term:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $eterm");
				  	if(strlen(trim($eterm))>0&&trim($eterm)!="empty"&&strlen(trim($sterm))>0&&trim($sterm)!="empty")
				  	echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='EditEduInfo.php' class=one><font style='font-size:11px'>[+ Edit]</font></a>");
					echo("</div>");
				  }
				  
				 if($cstate_tag==0){ ?>
				  <script>
$(document).ready(function() { 
	//$("#attendOrNot").hide();
	$('#cstate').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item != "NY" && selected_item != "NJ"){
        	$('#cityDiv').hide();
    	}else{
       		$('#cityDiv').show();
    	}
	});
});
</script>

<script>
$(document).ready(function() { 
	//$("#attendOrNot").hide();
	$('#companyname').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item == "Others"){
        	$('#companyname').hide();
			$('#jobtitleDiv').hide();
       		$('#newcompanyname').show();
       		$('#backtoSelectCompany').show();
			$('#jobtitleDiv').show();
    	}else if(selected_item == "seekjob"){
			$('#jobtitleDiv').hide();
		}else{
       		$('#newcompanyname').hide();
       		$('#backtoSelectCompany').hide();
			$('#jobtitleDiv').show();
		}
	});
	
	$('#backtoSelectCompany').click(function(){
        $('#newcompanyname').hide();
       	$('#backtoSelectCompany').hide();
       	$('#companyname').show();
    });
	
	$('#jobtitle').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item == "Others"){
			$('#jobtitle').hide();
       		$('#newjobtitle').show();
       		$('#backtoSelectjob').show();
    	}else if(selected_item == "seekjob"){
			$('#jobtitleDiv').hide();
		}else{
       		$('#newjobtitle').hide();
       		$('#backtoSelectjob').hide();
			$('#jobtitle').show();
		}
	});
	
	$('#backtoSelectjob').click(function(){
        $('#newjobtitle').hide();
       	$('#backtoSelectjob').hide();
       	$('#jobtitle').show();
    });
});
</script>
					  <div style="height:20; font-size:13px; font-family:Arial, Helvetica, sans-serif; width:650;">
					  <strong>Current Location:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <select name="cstate" id="cstate" onChange="cityChange(this);" style="font-family:Arial, Helvetica, sans-serif; font-size:13px">
                            <option value="empty">Select a State</option>
                            <?php
							$q = mysql_query("SELECT * FROM rockinus.state_info ORDER by state_name ASC");
						
							if(!$q) die(mysql_error());
							while($obj = mysql_fetch_object($q)){
								$loop_state_id = trim($obj->state_id);
								$loop_state_name = trim($obj->state_name);
								if($loop_state_id == trim($cstate)){
									$selected = " selected"; 
								}else $selected = "";
								
								echo ("<option value='$loop_state_id' $selected>$loop_state_name</option>");
							}
						?>
							<option value="ZZ" <?php echo $cs_options[4]; ?>>Outside of USA</option>
                          </select>
						  <span id="cityDiv" class="cityDiv" style="display:inline">
                          <select name="ccity" id="ccity" style="font-family:Arial, Helvetica, sans-serif; font-size:13px">
                            <?php 
				  	include 'dbconnect.php';
					//$tag_in = 0;
					
					if($cstate=='NY'||$cstate=='NJ'||$cstate=='ZZ'){
					  	if($cstate=='NY')
						$q = mysql_query("SELECT * FROM rockinus.city_info WHERE state_name='New York' ORDER by city_name");
						else if($cstate=='NJ')
						$q = mysql_query("SELECT * FROM rockinus.city_info WHERE state_name='New Jersy' ORDER by city_name");
						else 
						$q = mysql_query("SELECT * FROM rockinus.city_info WHERE state_name='Other' ORDER by city_name");
						
						if(!$q) die(mysql_error());
						while($obj = mysql_fetch_object($q)){
							$loopcity = trim($obj->city_name);
							if($loopcity == trim($ccity)){
								$selected = " selected"; 
								$tag_in = 1;
							}
							else 
                      			$selected = NULL;
							echo ("<option value=$loopcity $selected>$loopcity</option>");
						}
					}else if($cstate!=NULL||trim($cstate)==""){
						if($cstate=='ZZ')
							echo ("<option value=$cstate selected>Other City</option>");
						else
							echo ("<option value=$cstate selected>$cstate</option>");
					}else
						echo ("<option value='ZZ' selected>Select a City</option>");
					?>
                      </select>
					  </span>
					  </div>
					<?php }else{
							if($ccity_tag==0){						
								$q = mysql_query("SELECT * FROM rockinus.state_info WHERE state_id='$cstate'");
								if(!$q) die(mysql_error());
								$obj = mysql_fetch_object($q);
								$cstate_name = trim($obj->state_name);
								if(strlen(trim($cstate_name))==0||$cstate_name=="empty") $cstate_name = "Unknown Region";
					  			echo("<div style='height:15; margin-top:15; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal'><strong>Current Location:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $cstate_name, USA</div>");
							}else
					  			echo("<div style='height:15; margin-top:15; font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal'><strong>Current Location:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ccity, $cstate</div>");
				  		}
					?>
				  
				  <?php
				  if($fcountry_tag==0){ 
				  ?>
				  <div style="height:15; margin-top:10;  font-size:13px; font-family:Arial, Helvetica, sans-serif; width:650;">
					  <strong>Proudly From:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <select name="fcountry" id="fcountry" onChange="getRegion('findRegion.php?fcountry='+this.value)" style="font-size:13px; font-family:Arial, Helvetica, sans-serif">
			<option value="all" selected="selected">Select Country</option>
				  <?php 
				  	include 'dbconnect.php';
				  	$q = mysql_query("SELECT * FROM rockinus.region_info GROUP BY country_name ASC");
					if(!$q) die(mysql_error());
					while($obj = mysql_fetch_object($q)){
						$country_name = trim($obj->country_name);
						if($country_name == trim($fcountry))
							$selected = " selected"; 
						else 
                      		$selected = NULL;
						echo ("<option value=$country_name $selected>$country_name</option>");
					}				
					?>
                    </select>
					<div id="regionDiv" class="regionDiv" style="display: inline; ">
                    <select name="fregion" id="fregion" class="fregion" style="font-size:13px; font-family:Arial, Helvetica, sans-serif">
					<?php 
						if($fcountry!="empty"&&$fcountry!="all"){
						  	$q = mysql_query("SELECT region_name FROM rockinus.region_info WHERE country_name='$fcountry'");
							if(!$q) die(mysql_error());
							while($obj = mysql_fetch_object($q)){
								$region_name = trim($obj->region_name);
								if($region_name == trim($fregion))
									$selected = " selected"; 
								else 
                      				$selected = NULL;
							
								echo("<option value=$region_name $selected>$region_name</option>");
							}
						}else
						echo("<option value='all' style='font-size:14px; font-family:Arial, Helvetica, sans-serif'>Select Region</option>");						
					?>
					  </select>
				  </div>
				  <?php 
				  }else
				  	echo("<div style='height:15; margin-top:10; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Proudly From:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $fregion, $fcountry</div><br>");
				  
				  if($cschool_tag==0||$cmajor_tag==0||$cdegree_tag==0||$sterm_tag==0||$eterm_tag==0||$cstate_tag==0||$fcountry_tag==0||$fregion_tag==0)
				  	echo ("<div style='margin-top:15;'><input name='eduSubmit' type='submit' style='font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; height:30; border:1px #999999 solid; background: url(img/master.jpg); cursor:pointer; color:$_SESSION[hcolor]; margin-top:15; width:80; display:' value='Submit' onmouseover=this.style.background='url(img/blackgraybg.jpg)' onmouseout=this.style.background='url(img/master.jpg)' /></div>");
					
				  echo("</form>");
				  ?>
				  
				  
				  <script>
$(document).ready(function() { 
	//$("#attendOrNot").hide();
	$('#cstate').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item != "NY" && selected_item != "NJ"){
        	$('#cityDiv').hide();
    	}else{
       		$('#cityDiv').show();
    	}
	});
});
</script>

<script>
$(document).ready(function() { 
	//$("#attendOrNot").hide();
	$('#companyname').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item == "Others"){
        	$('#companyname').hide();
			$('#jobtitleDiv').hide();
       		$('#newcompanyname').show();
       		$('#backtoSelectCompany').show();
			$('#jobtitleDiv').show();
    	}else if(selected_item == "seekjob"){
			$('#jobtitleDiv').hide();
		}else{
       		$('#newcompanyname').hide();
       		$('#backtoSelectCompany').hide();
			$('#jobtitleDiv').show();
		}
	});
	
	$('#backtoSelectCompany').click(function(){
        $('#newcompanyname').hide();
       	$('#backtoSelectCompany').hide();
       	$('#companyname').show();
    });
	
	$('#jobtitle').change(function(){
    	var selected_item = $(this).val()
		//alert("111");
    	if(selected_item == "Others"){
			$('#jobtitle').hide();
       		$('#newjobtitle').show();
       		$('#backtoSelectjob').show();
    	}else if(selected_item == "seekjob"){
			$('#jobtitleDiv').hide();
		}else{
       		$('#newjobtitle').hide();
       		$('#backtoSelectjob').hide();
			$('#jobtitle').show();
		}
	});
	
	$('#backtoSelectjob').click(function(){
        $('#newjobtitle').hide();
       	$('#backtoSelectjob').hide();
       	$('#jobtitle').show();
    });
});
</script>
					  <?php
					  if($work_tag==0){
				  		echo("<form method='post'>");
				  	  
					  if($ccompany_tag==0){
					  ?>
					<div style='margin-top:0; height:30; font-size:13px; margin-top:10; font-family:Arial, Helvetica, sans-serif; width:670'>
					  <strong>Employer Name:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <select name="companyname" id="companyname" style="font-family:Arial, Helvetica, sans-serif; font-size:13px">
                            <option value="empty">Select a Company or other</option>
							<option value="seekjob">I'm still looking for job</option>
                            <?php
							$q = mysql_query("SELECT * FROM rockinus.company_info ORDER by company_name ASC");
						
							if(!$q) die(mysql_error());
							while($obj = mysql_fetch_object($q)){
								$loop_company_name = trim($obj->company_name);
								if($loop_company_name == trim($ccompany)){
									$selected = " selected"; 
								}else $selected = "";
								
								echo ("<option value=$loop_company_name $selected>$loop_company_name</option>");
							}
						?>
							<option value="Others">Not in this list..</option>
                        </select>
					  <input type="text" name="newcompanyname" id="newcompanyname" size="50" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; display:none" /> &nbsp;&nbsp; <span class="backtoSelectCompany" id="backtoSelectCompany" style="cursor:pointer; display:none; font-size:12px"><u>Back to select Employer</u></span>
                    </div>
					<?php
					}else{
						if($ccompany=="seekjob")
					  		echo("<div style='height:22; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Company Name:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Looking for job</div>");
						else
					  		echo("<div style='height:22; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Company Name:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $ccompany</div>");
				  	}
					
					if($cjobtitle_tag==0){
					?>
					<div class="jobtitleDiv" id="jobtitleDiv" style=" display:none; margin-top:0; height:30; font-size:13px; font-family:Arial, Helvetica, sans-serif; width:670">
					  <strong>Job Title/Position:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <select name="jobtitle" id="jobtitle" style="font-family:Arial, Helvetica, sans-serif; font-size:13px">
                            <option value="empty">Select a Position</option>
   							<option value="Software Engineer">Software Engineer</option>
   							<option value="Developer">Software Developer</option>
							<option value="Analyst">Software Analyst</option>
   							<option value="Quality Assurance">Quality Assurance</option>
   							<option value="Software Manager">Software Manager</option>
   							<option value="Electrical Engineer">Electrical Engineer</option>
   							<option value="Civil Engineer">Software Manager</option>
   							<option value="Others">Not in the list..</option>
   					</select>
					<input type="text" name="newjobtitle" id="newjobtitle" size="50" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; display:none" /> &nbsp;&nbsp; <span class="backtoSelectjob" id="backtoSelectjob" style="cursor:pointer; display:none"><u>Back to select job title</u></span>
					</div>
					<?php
					}else{
				  		if($cjobtitle=="seekjob")
					  		echo("<div style='height:25; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Job Position/field:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Looking for job</div>");
						else
							echo("<div style='height:25; font-size:13px; font-family:Arial, Helvetica, sans-serif;'><strong>Job Position/field:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $cjobtitle</div>");
				  	}
					
					echo ("<div style='margin-top:15'><input name='workSubmit' type='submit' style='font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; height:30; border:1px #999999 solid; background: url(img/master.jpg); cursor:pointer; color:$_SESSION[hcolor]; margin-top:15; width:80; display:' value='Submit' onmouseover=this.style.background='url(img/blackgraybg.jpg)' onmouseout=this.style.background='url(img/master.jpg)' /></div>");
					echo ("</form>");
				  }
				  ?>
            <?php }
			?></div>
			
			<?php if($headicon_tag==0)
				include("uploadHeadIcon.php");
			?>