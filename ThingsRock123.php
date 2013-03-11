<?php include("Header.php"); 

$ua=getBrowser();
  
$pic210_Name = $uname.'210.jpg';
$ProPercent = 70;
		
//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$hcolor = $object->hcolor;

$q = mysql_query("SELECT * FROM rockinus.user_info INNER JOIN rockinus.user_check_info INNER JOIN rockinus.user_edu_info INNER JOIN rockinus.user_contact_info ON user_info.uname='$uname' AND user_info.uname=user_check_info.uname AND user_info.uname=user_edu_info.uname AND user_info.uname=user_contact_info.uname");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$fname = $object->fname;
$lname = $object->lname;
$birthdate = $object->birthdate;
$sterm = $object->sterm;
$fregion = $object->fregion;
$fcountry = $object->fcountry;
$email = $object->email;
$cmajor = $object->cmajor;
if(trim($cmajor)=="empty") $cmajor=NULL;
$cschool = $object->cschool;
if(trim($cschool)=="empty") $cschool=NULL;
$cdegree = $object->cdegree;
if(trim($cdegree)=="empty") $cdegree=NULL;
$cstate = $object->cstate;
$ccity = $object->ccity;

if($cschool!=NULL){
	$q = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cschool = $obj->school_name;
}else $cschool = "Unknown School";

if($cmajor!=NULL){	
	$q = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
	if(!$q) die(mysql_error());
	$obj = mysql_fetch_object($q);
	$cmajor = $obj->major_name;
}else $cmajor = "Unknown Major";

if($ccity==NULL || $ccity=="empty" ) $ccity = "Unknown City";
if($cstate==NULL || $cstate=="em" ) $cstate = "Unknown State";
if($cdegree==NULL) $cdegree = "Unknown Diploma";
if($mstatus==NULL) $mstatus = "Unknown Status";

$q = "SELECT count(*) as cnt FROM rockinus.message_info where recipient='$uname'";
$t = mysql_query($q);
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

//$q = mysql_query("SELECT descrip FROM rockinus.memo_info WHERE sender='$uname' ORDER BY memoid DESC");
//$object = mysql_fetch_object($q);
//$default_textarea = $object->descrip;
//if($default_textarea==NULL)$default_textarea = "What you think? Write it down here, share with others.";

//Message Number
$qu = "SELECT count(*) as cnt FROM rockinus.message_info where recipient='$uname' and rstatus='N'";
$tu = mysql_query($qu);
$au = mysql_fetch_object($tu);
$total_unread_items = $au->cnt;

//Friend Number
$friendq = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info where recipient='$uname' and rstatus='A'";
$friendt = mysql_query($friendq);
$friendu = mysql_fetch_object($friendt);
$total_friend1_items = $friendu->cnt;

$friendq = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info where sender='$uname' and rstatus='A'";
$friendt = mysql_query($friendq);
$friendu = mysql_fetch_object($friendt);
$total_friend2_items = $friendu->cnt;
$total_friend_items = $total_friend1_items + $total_friend2_items;

//Friend Request Number
$friendrq = "SELECT count(*) as cnt FROM rockinus.rocker_rel_info where recipient='$uname' and rstatus='P'";
$friendrt = mysql_query($friendrq);
$friendru = mysql_fetch_object($friendrt);
$total_friendrqst_items = $friendru->cnt;

$q = mysql_query("SELECT descrip FROM rockinus.memo_info WHERE sender='$uname' ORDER BY memoid DESC");
$object = mysql_fetch_object($q);
$default_textarea = $object->descrip;
if($default_textarea==NULL)$default_textarea = "What you think? Write it down, share with others!";

$wid = ProfileProgress($uname);
?>
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="123" align="left" valign="top" style="padding-left:<?php if(contains("Chrome",$ua['name']))echo("10px"); else echo("15"); ?>; border-right:0px #DDDDDD dashed">
	  <?php include("leftMenu".$_SESSION['lan'].".php"); ?>	  </td>
      <td width="900" align="left" valign="top">
	  <table border="0" cellspacing="0" cellpadding="0" width="874">
        <tr>
          <td width="657" valign="top" style="margin-right:10px; margin-left:10px;" align="left"><?php 
				  if( ProfileProgress($uname) < $ProPercent ){
				  ?>
              <table width="650" height="112" border="0" cellpadding="0" cellspacing="0" style="border:1 #DDDDDD SOLID; margin-bottom:10px; margin-top:0px;">
                <tr>
                  <td width="219" height="35" valign="bottom" bgcolor="#F5F5F5" style="padding-left:15px; padding-top:5px; padding-bottom:5px; line-height:230%">
				  <strong>
				  <?php 
				  if($_SESSION['lan']=='CN'){
				  	if($fname==NULL) $fname = "新同学";
				  	echo("<font color=#006699 size=4> 你好, $fname </font>");
				  }else if($_SESSION['lan']=='EN'){
				  	if($fname==NULL) $fname = "New Student";
				  	echo("<font color=#006699 size=4> Hi, $fname</font>");
				}
				  ?>				  
				  </strong>				  </td>
                  <td width="297" height="35" align="left" valign="bottom" bgcolor="#F5F5F5" style="padding-top:5px; padding-bottom:5px; padding-left:0px; line-height:230%"><?php if($_SESSION['lan']=='CN')
				  echo("<font color=#C82929 size=3> <strong>目前资料详细度仅 $wid%</strong> </font>");
				  else if($_SESSION['lan']=='EN')
				  echo("<font color=#C82929 size=3> 
				  <strong>Only $wid% Profile Completion</strong> 
				  </font>")
				  ?></td>
                  <td width="132" height="35" align="right" valign="middle" bgcolor="#F5F5F5" style="padding-left:0; padding-top:5; padding-bottom:5; "><font color="#006699" size="2"><strong>
                    <div style="background: <?php echo($_SESSION['hcolor']) ?>; padding-bottom:6px; padding-top:6px; margin-top:2px; margin-right:8px; border-right:#000000 solid 2; border-bottom:#000000 solid 2" align="center">
					<?php if($_SESSION['lan']=='CN')
				  echo("<a href=EditUserInfo.php>完善我的资料</a>");
				  else if($_SESSION['lan']=='EN')
				  echo("<a href=EditUserInfo.php>Edit My Profile</a>")
				  ?>
					</div>
					</strong>
                  </font></td>
                </tr>
                <tr>
                  <td height="66" colspan="3" valign="top" bgcolor="#F5F5F5" style="padding-left:15; padding-right:10; padding-top:2px; padding-bottom:5; line-height:200%">
				  <?php if($_SESSION['lan']=='CN')
				  echo("<font size=2>建立一份详尽、真实的个人资料，十分有利于您享受更贴切的服务。因此，我们建议您维护一份完整的个人资料，这样一来，您会发现身边的生活原来是如此的丰富多彩。 <a href=EditUserInfo.php class=one><strong>立即完善>></strong></a></font></font>");
				  else if($_SESSION['lan']=='EN')
				  echo("<font size=2>Being connected with more exciting things and people, especially for new users, having a detailed profile is important. So we would be able to provide miscellaneous interested updates that you care about, here we strongly recommend you polish your profile at the new registration. <a href=EditUserInfo.php class=one><strong>Edit Now>></strong></a></font>") ?>				  </td>
                </tr>
            </table>
            <?php }
			?>
			<div class="friendsDiv" style="width:650px">
			<table width="650" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:2px; border-top:1px #DDDDDD solid; border-right:0px #DDDDDD solid">
                <tr>
                  <td width="570" height="25" valign="top" bgcolor="#EEEEEE" style="padding-left:10px; padding-top:8px; border-bottom: 0px #DDDDDD solid">
                    <?php if($_SESSION['lan']=='CN')
				  echo("<font color=black size=3> <strong>可能认识的同学</strong> </font>");
				  else if($_SESSION['lan']=='EN')
				  echo("<font color=black size=2><strong>Students You May Know</strong></font>")
				  ?></td>
                  <td width="35" height="25" align="center" bgcolor="#EEEEEE" style="padding-right:5px; padding-top:2px; padding-bottom:1px;">
<div id="but" style="display:inline; width:25px; padding-top:4">
	<div id="a"><input type="button" id="but1" value=" << " class="btnSlide"/></div>
</div></td>
                  <td width="35" height="25" align="center" bgcolor="#EEEEEE" style="padding-left:0px; padding-top:2px; padding-bottom:2px;">
				  <div id="b" style="margin-left:0px">
                    <input name="button" type="button" class="btnSlide" id="but2" value=" &gt;&gt; "/>
                  </div>
                    <script type="text/javascript">
/*获取id节点的函数*/
$(function(){
	function getId(id){
		return $('#'+id);
	}
/*创建图片滚动对象(前四个参数是标签的id)*/
	function marquee(divElem,imgElem,lBut,rBut,imgWidth,speed,autoSpeed){//参数含义(包含两组图片的div，包含一组图片的ul，左侧按钮，右侧按钮,图片宽度，单张图片滚动时间，图片滚动间隔时间)
		this.box=getId(divElem);
		this.img=getId(imgElem);
		this.lBut=getId(lBut);
		this.rBut=getId(rBut);//获取各个节点
		this.imgWidth=imgWidth;
		this.speed=speed;
		this.autoSpeed=autoSpeed;
		this.num=0;//全局变量,用来进行条件控制
		var that=this;
		/*图片自动滚动函数*/
		this.autoGo=function(){
			that.num+=that.imgWidth;
			that.box.animate({right:"+="+that.imgWidth+"px"},that.speed);
			if(that.num>=that.img.width()){
				that.num=0;
				that.box.animate({right:"0px"},0);
			}
		}
	}
	/*对象方法*/
	marquee.prototype={
		/*图片的自动滚动*/
		autoScroll:function(){
			var that=this;
			auto=setInterval(this.autoGo,this.autoSpeed);
			this.box.mouseover(function(){
				clearInterval(auto);						 
			});
			this.box.mouseout(function(){
				auto=setInterval(that.autoGo,that.autoSpeed);							
			})
			this.lBut.mouseover(function(){
				clearInterval(auto);
				if(that.num==that.img.width()){
					that.num=0;
					that.box.animate({right:"0px"},0);
				}
			});
			this.lBut.mouseout(function(){
				auto=setInterval(that.autoGo,that.autoSpeed);							
			});
			this.rBut.mouseover(function(){
				clearInterval(auto);
				if(that.num==0){
					that.num=that.img.width();
					that.box.animate({right:that.img.width()+"px"},0);
				}
			});
			this.rBut.mouseout(function(){
				auto=setInterval(that.autoGo,that.autoSpeed);
				if(that.num==that.img.width()){
					that.num=0;
					that.box.animate({right:"0px"},0);
				}
			});
		},
		/*单击左侧按钮,图片向左滚动*/
		leftScroll:function(){
			var that=this;
			this.lBut.click(function(){
				that.num+=that.imgWidth;
				that.box.animate({right:"+="+that.imgWidth+"px"},that.speed);
				if(that.num>=that.img.width()){
					that.num=0;
					that.box.animate({right:"0px"},0);
				}
			});
		},
		/*单击右侧按钮,图片向右滚动*/
		rightScroll:function(){
			var that=this;
			this.rBut.click(function(){
				that.num-=that.imgWidth;
				that.box.animate({right:"-="+that.imgWidth+"px"},that.speed);
				if(that.num<=0){
					that.num=that.img.width();
					that.box.animate({right:that.img.width()+"px"},0);
				}
			});
		}
	}
	
	var a=new marquee("div","img","but1","but2",320,2000,6000);//初始化对象
	a.autoScroll();
	a.leftScroll();
	a.rightScroll();
});
</script>
	</td>
                  <td width="30" height="25" align="center" bgcolor="#EEEEEE" style="padding-left:5px; padding-right:5px; padding-top:5px; color:#FFFFFF; border-bottom:0px solid #DDDDDD; font-size:18px">
				  <script type="text/javascript">
 $(document).ready(function(){

 $(".friendsDiv .deleteDiv").click(function(){
 $(this).parents(".friendsDiv").animate({ opacity: 'hide' }, "slow");
 });

 });
 </script>
				  <div style="display:inline; background-color:#; padding-left:15px; padding-right:8px" id="left1" onMouseOver="changeColor(this.id, '#');" onMouseOut="changeColor(this.id, '#');"><a href="#"><img src="img/deleteDiv.jpg" alt="delete" class="deleteDiv" style='border:1px solid #666666' height="18px" width="18px"/></a></div></td>
                </tr>
                <tr>
                  <td height="100px" colspan="4" align="left" valign="top" bgcolor="#FFFFFF" style="padding-bottom:0px; padding-top:0px; line-height:200%">
				  <script type="text/javascript">
function changeColor(id, color) {
element = document.getElementById(id);
event.cancelBubble = true;
oldColor = element.currentStyle.background;
element.style.background = color;
}
</script>
				  <div style="padding-left:2px;padding-right:2px;line-height:250%;">
				  <?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$sql_stmt = "SELECT * FROM rockinus.user_check_info a INNER JOIN rockinus.user_info b ON a.uname=b.uname AND a.uname!='$uname' AND b.uname!='$uname' ORDER BY signup_date DESC,signup_time DESC;";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		//echo($sql_stmt);
		echo("<div id='box' style='margin-top:0px'><div id='div'><ul id='img'>");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;
			$pic100_Name = "upload/".$loopname."/".$loopname.'100.jpg';
			$tbname = $object->tbname;
			$target = "upload/".$loopname;
			if(file_exists($pic100_Name))
			echo("<li id='liimg'><div style='background-color:#; width:102px' align='center'><a href='RockerDetail.php?uid=$loopname' class='one'><strong><font color=$_SESSION[hcolor]>$loopname</font></strong></a></div><a href='RockerDetail.php?uid=$loopname' class='one'><img src=$pic100_Name /></a></li>");
			else 
			echo("<li id='liimg'><div style='background-color:#; width:100px' align='center'><a href='RockerDetail.php?uid=$loopname' class='one'><strong><font color=$_SESSION[hcolor]>$loopname</font></strong></a></div><a href='RockerDetail.php?uid=$loopname' class='one'><img src=img/NoUserIcon100.jpg style='border:0px solid #CCCCCC' /></a></li>");
		} 
		echo("</ul><ul id='img1'>");
		
		$sql_stmt = "SELECT * FROM rockinus.user_check_info a INNER JOIN rockinus.user_info b ON a.uname=b.uname AND a.uname!='$uname' AND b.uname!='$uname' ORDER BY signup_date,signup_time DESC;";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;	
			$pic100_Name = "upload/".$loopname."/".$loopname.'100.jpg';
			$tbname = $object->tbname;
			$target = "upload/".$loopname;
			
			if(file_exists($pic100_Name))
			echo("<li id='liimg'><div style='background-color:#; width:100px' align='center'><a href='RockerDetail.php?uid=$loopname' class='one'><strong><font color=$_SESSION[hcolor]>$loopname</font></strong></a></div><img src=$pic100_Name /></li>");
			else 
			echo("<li id='liimg'><div style='background-color:#; width:100px' align='center'><a href='RockerDetail.php?uid=$loopname' class='one'><strong><font color=$_SESSION[hcolor]>$loopname</font></strong></a></div><img src=img/NoUserIcon100.jpg /></li>");
		}
		echo("</ul></div></div>");
		?>
				  </div></td>
                </tr>
            </table>
			</div>
			<?php 
				  	$q = mysql_query("SELECT priority FROM rockinus.user_setting WHERE uname='$uname'");
					$object = mysql_fetch_object($q);
					$priority = $object->priority;
					if($priority=="D"){
				  ?>
              <table width="599" height="115" border="0" cellpadding="0" cellspacing="0" style="margin-top:<?php 
				  if( ProfileProgress($uname) < $ProPercent )echo("5px"); else echo("0px");
				  ?>; margin-right:5px; margin-bottom:5px;">
                <tr>
                  <td width="130" height="40" align="left" style="padding-left:0px; padding-bottom:10px; padding-top:10px"><strong><font size="3" color="black">
                      <?php if($_SESSION['lan']=="CN")echo("最新动态");else echo("Recent Update"); ?>
                  </font></strong></td>
                  <td width="574" height="40" style="padding-right:10px" align="right">
                      <?php ?>
				</td>
                </tr>
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="650" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="663" height="85" valign="top" >
						<?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$sql_stmt = "SELECT email,uname, NULL as col_1,status, signup_date,signup_time,tbname, NULL as col_2, NULL as col_3, NULL as col_4, NULL as col_5, NULL as col_6 FROM rockinus.user_check_info a UNION SELECT hid,uname,subject,rentlease,pdate,ptime,tbname, type, city, rate, NULL, NULL FROM rockinus.house_info b UNION SELECT aid,uname,subject,buysale,pdate,ptime,tbname,aname,city,rate,delivery,type FROM rockinus.article_info c  UNION SELECT coid, sender, descrip, rating, pdate, ptime, tbname, pid, NULL, NULL, NULL, NULL FROM rockinus.course_memo_info d UNION SELECT eid, creater, eventTitle, descrip, pdate, ptime, tbname, eventSpot, NULL,NULL, NULL, NULL FROM rockinus.event_info e UNION SELECT cafeid, creater, cafeTitle, descrip, pdate, ptime, tbname, category, location, NULL, NULL, NULL FROM rockinus.cafe_info f UNION SELECT cafeid, sender, rating, descrip, pdate, ptime, tbname, NULL, NULL, NULL, NULL, NULL FROM rockinus.cafe_memo_info g ORDER BY signup_date DESC, signup_time DESC";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$tbname = $object->tbname;			
			$pdate = $object->signup_date;
			$ptime = $object->signup_time;
			$id = $object->email;
			$subject = $object->col_1;
			$aname = $object->col_2;
			$city = $object->col_3;
			$rate = $object->col_4;
			$delivery = $object->col_5;
			$type = $object->col_6;
			$action = $object->status;
			if(strlen($subject)>50) $subject = substr(trim($subject), 0, 50)."...";
			//echo($tbname);
			if($tbname=="user_check_info"){
//			}else if($tbname=="house_info"){
//				echo("<img src='img/housect.jpg' width='35' height='35' />");						   
//			}else if($tbname=="article_info"){
//			  	echo("<img src='img/marketct.jpg' width='35' height='35' />");			
//			}else if($tbname=="memo_info"){
//			  	echo("<img src='img/pencil.jpg' width='35' height='35'  />");
//			}else if($tbname=="course_memo_info"){
//			  	echo("<img src='img/pencil.jpg' width='35' height='35' />");
//			}else if($tbname=="professor_memo_info"){
//			 	echo("<img src='img/professorct.jpg' width='35' height='35' />");						
			?>
                          <div style="margin-top:0; margin-bottom:0px; padding-left:0; padding-top:10px; padding-bottom: 0px; border-top:1px #EEEEEE solid">
                            <table width="650" height="65" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="68" rowspan="4" valign="top" bgcolor="#FFFFFF" style="padding-top:5px; padding-right:5px; padding-bottom:10px;"><?php
									$loopImg = "upload/$loopname/$loopname"."100.jpg";
							  if(file_exists($loopImg)) echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=$loopImg width=80px /></a>");
							  else echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=img/NoUserIcon100.jpg width=80px /></a>");
							  ?></td>
                                <td height="18" colspan="2" align="left" valign="top" style="padding-left:10px; padding-top:5px">
								<?php
							  if($tbname=="user_check_info") 
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=$_SESSION[hcolor] size=3><strong>$loopname</strong></font></a>");	
								if($_SESSION['lan']=="CN")echo " 已加入社区网络";
								else echo(" has joined the network.");
								?>								</td>
                                <td height="18" colspan="2" align="right" valign="top" style="padding-right:10px; padding-top:5px">
								<font size="1">
								<?php
							  echo("$pdate | ".substr($ptime,0,5));
							  ?>
							  </font>							  </td>
                              </tr>
                              <tr>
                                <td width="153" height="20" valign="top" style="padding-left:10px; padding-top:0px">
								<?php 
							  	if($tbname=="user_check_info"){
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("From NYU-Poly ");
									else echo($id);
								} 
								?>
								&nbsp;</td>
                                <td width="259" valign="middle" style="padding-left:10px; padding-top:0px">&nbsp;</td>
                                <td height="20" colspan="2" style="padding-right:10px" align="right">&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="20" colspan="2" valign="top" style="padding-left:10px; padding-top:0px">
								<?php if($loopname!=$uname)echo("<img src=img/addIcon.jpg />") ?>
								</td>
                                <td width="79" height="20" style="padding-left:5">&nbsp;</td>
                                <td width="91" height="20" align="right" style="padding-right:10px">&nbsp;</td>
                              </tr>
                            </table>
                          </div>
                          <?php 
							}else if($tbname=="house_info"){
							?>
                            <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2; border-top:1px #EEEEEE solid ">
                              <table width="650" height="105" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="50" height="35" bgcolor="#FFFFFF" style="padding-right:0px; padding-top:5px" align="center">
								  <img src="img/NoHouse100.jpg" width="35" height="35" /></td>
                                  <td width="459" align="left" style="padding-left:15px">
								  
								  <?php 
				echo("<a href=HouseRental.php?type=".$aname."><strong><font size=3 color=$_SESSION[hcolor]>$aname</a> | $action</font> <font color=#999999 size=3>[$city]</font></strong>");
							  ?>
                                  </td>
                                  <td width="148" style="padding-right:10px" align="right">
								  <font size="1">
								  <?php 
										  echo("$pdate | ".substr($ptime,0,5));
							  ?></font>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td align="left" style="padding-left:15px"><?php 
										  echo("<a href=HouseDetail.php?hid=$id class=one><strong>".substr($subject,0,80)." ...</strong></a>");
							  ?>
                                  </td>
                                  <td align="right" style="padding-right:10px">
								  <font size="1">
								  <?php echo("<a href=RockerDetail.php?uid=$loopname class=one>$loopname</a>") ?>
								  </font>
								  </td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td align="left" style="padding-left:15px">
								  <?php
							  	if($rate!=NULL && $rate>0)
									echo("$ ".$rate." /Month");
								else {
									if($_SESSION['lan']=='CN') echo("<a href=HouseDetail.php?hid=$id class=one>详细进入>></a>");
									else if($_SESSION['lan']=='EN') echo("<a href=HouseDetail.php?hid=$id class=one>Read details >></a>");
								}	
								?></td>
                                  <td align="right" style="padding-right:10px">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
							<?php 
							}else if($tbname=="article_info"){
							?>
							<div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:5px; border-top:1px #EEEEEE solid">
                              <table width="650" height="96" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="50" align="center" height="32" bgcolor="#FFFFFF" style="padding-right:5px; padding-top:5px">
								  <?php echo("<img src=img/$aname"."Icon.jpg width=35 height=35>") ?> </td>
                                  <td width="444" align="left" style="display:inline; padding-left:10px; border-bottom:0px #BBBBBB dotted">
								  <?php
							  	echo("<a href=FleaMarket.php?aname=$aname><strong><font color=$_SESSION[hcolor] size=3>$aname</a> | $action</font> <font color=#999999 size=3>[$city]</font></strong></font>");	
								?></td>
                                  <td width="165" align="right" style="padding-right:10px"><font size="1"><?php echo("$pdate | ".substr($ptime,0,5))?></font></td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td height="35" align="left" style="display:inline; padding-left:10px;"><?php 
										  echo("<a href=articleDetail.php?aid=$id class=one><strong>".substr($subject,0,60)." ...</strong></a>");
							  ?>
                                  </td>
                                  <td height="35" align="right" style="display:inline; padding-right:10px;">
								  <font size="1">
								  <?php
							  	echo($loopname);	
								?>
								</font>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td height="35" colspan="2" align="left" style="padding-left:10px">
								  <?php 
								  if($delivery=='N') echo("$ $rate | Self take");
								  if($delivery=='Y') echo("$ $rate | Can bring to you") ?> </td>
                                </tr>
                              </table>
						  </div>
						  <?php }else if($tbname=="course_memo_info"){ 
						  		$memo_q = mysql_query("SELECT * FROM rockinus.course_info WHERE coid='$id';");
								if(!$memo_q) die(mysql_error());
								$obj = mysql_fetch_object($memo_q); 
								$course_name = $obj->course_name;
						  ?>
						  <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2; border-top:1px #EEEEEE solid">
                            <table width="650" height="70" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="50" align="center" height="35" style="padding-right:5px; padding-top:5px">
								<img src="img/book100.jpg" width="35" height="35" /></strong></font></td>
                                <td width="467" height="35" style="padding-left:10px"><?php
							  	echo("Comment on Course <font color=$_SESSION[hcolor]><strong>$id - $course_name</strong></font> :");
							  ?></td>
                                <td width="143" height="35" align="right" style="padding-right:10px"><font size="1"><?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
                              </tr>
                              <tr>
                                <td width="40" height="35" style="padding-left:5px">&nbsp;</td>
                                <td height="35" style="padding-left:10px"><?php 
										  echo("<a href=CourseDetail.php?sid=NYPOLY&pid=$aname&coid=$id class=one><font size=2 color=#666666><strong>$subject</strong></font></a>");
							  ?></td>
                                <td height="35" align="right" style="padding-right:10px">
								<?php 
								for($i=0;$i<$action;$i++)
									echo("<img src=img/yellowstar.jpg /> "); 
								?>                                </td>
                              </tr>
                            </table>
					      </div>
                          <?php }else if($tbname=="event_info"){  ?>
						  <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2px;">
                            <table width="650" height="110" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
                              <tr>
                                <td width="50" height="40" bgcolor="#FFFFFF" style="padding-right:0px; padding-top:5px">
								<img src="img/calendar100.jpg" width="35" height="35" /></strong></font></td>
                                <td width="467" height="40" style="padding-left:10px">
								<?php echo("<a href=RockerDetail.php?uid=$loopname><font color=$_SESSION[hcolor]><strong>$loopname</strong></font></a> has created an event :") ?>								</td>
                                <td width="143" height="40" align="right" style="padding-right:10px"><font size="1">
								<?php echo("$pdate | ".substr($ptime,0,5)) ?></font> </td>
                              </tr>
                              <tr>
                                <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                <td height="35" style="padding-left:10px"><?php 
										  echo("<a href=EventDetail.php?eid=$id><font size=3 color=black><strong>$subject</strong></font></a>");
							  ?></td>
                                <td height="35" align="right" style="padding-right:10px">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                <td height="35" style="padding-left:10px; padding-bottom:10px; padding-top:5px">
								<font color="#999999"><?php echo("$action") ?></font></td>
                                <td height="35" align="right" style="padding-right:5px">&nbsp;</td>
                              </tr>
                            </table>
					      </div>
                          <?php }else if($tbname=="cafe_info"){  ?>
						  <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2px; border-top:1px #EEEEEE solid">
                            <table width="650" height="95" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="40" height="30" rowspan="2" bgcolor="#FFFFFF" style="padding-right:5px; padding-top:10px" valign="top">
								<img src="img/<?php echo($aname."FoodIcon.jpg") ?>" width="50" height="50" /></strong></font></td>
                                <td width="491" height="35" style="padding-left:10px; padding-top:10px" valign="top">
								<?php echo("<a href=RockerDetail.php?uid=$loopname><font color=$_SESSION[hcolor]><strong>$loopname</strong></font></a> introduced a <a href=foodcafe.php?cafeid=$id class=one>new Cafe</a>:") ?>								</td>
                                <td width="119" height="35" align="right" style="padding-right:10px"><font size="1">
								<?php 
	//							echo(date("y-m-d",time()));
	//							echo(substr(date(" G:i:s",time()),2,17));
								echo(" $pdate | ".substr($ptime,0,5)) ?>
								</font> </td>
                              </tr>
                              <tr>
                                <td height="35" style="padding-left:10px; padding-top:5px" valign="top"><?php 
										  echo("<a href=CafeDetail.php?cafeid=$id class=one><font size=3><strong>$subject</strong></font></a>");
							  ?></td>
                                <td width="119" height="35" align="right" style="padding-right:10px">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="40" height="30" style="padding-left:5px">&nbsp;</td>
                                <td height="30" style="padding-left:10px; padding-bottom:10px; padding-top:5px; line-height:150%" valign="top">
								<font color="#999999"><?php echo("<font size=2 color=#666666><strong>$action</strong></font>") ?></font></td>
                                <td height="30" align="right" style="padding-right:5px">&nbsp;</td>
                              </tr>
                            </table>
					      </div>
                          <?php }else if($tbname=="cafe_memo_info"){  
						  $q1 = mysql_query("SELECT * FROM rockinus.cafe_info WHERE cafeid='$id';");
						  if(!$q1) die(mysql_error());
						  $obj = mysql_fetch_object($q1);
						  $cafeTitle = $obj->cafeTitle;
						  $category = $obj->category;
						  ?>
						  <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2px; border-top:1px #EEEEEE solid">
                            <table width="650" height="60" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="40" height="40" rowspan="2" bgcolor="#FFFFFF" style="padding-right:5px; padding-top:10px">
								<img src="img/<?php echo($category."FoodIcon.jpg") ?>" width="50" height="50" />
								<?php echo($aname) ?>
								</strong></font></td>
                                <td width="489" height="20" style="padding-left:10px; padding-top:10px" valign="top">
								<?php echo("<a href=RockerDetail.php?uid=$loopname><font color=black><strong>$loopname</strong></font></a> commented on <a href=cafeDetail.php?cafeid=$id class=one><strong><font color=$_SESSION[hcolor]>$cafeTitle</font></a> <font color=#CCCCCC>[ $category Food ]</font></strong>") ?>								</td>
                                <td width="121" height="20" align="right" style="padding-right:10px"><font size="1">
								<?php 
	//							echo(date("y-m-d",time()));
	//							echo(substr(date(" G:i:s",time()),2,17));
								echo(" $pdate | ".substr($ptime,0,5)) ?>
								</font> </td>
                              </tr>
                              <tr>
                                <td height="20" style="padding-left:10px; padding-top:10px" valign="top">
                                  <?php 
									echo("<a href=CafeDetail.php?cafeid=$id class=one><font size=2 color=#999999>");
										  
									$len = strlen($action);
									$single_line_len = 70;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($action,$i*$single_line_len, $single_line_len)."<br>";
										echo("<font size=2 color=#666666><strong>$str</strong></font>");
									}
								echo("</font></a>");
							  ?>							  </td>
                                <td width="121" height="20" align="right" style="padding-right:10px">
                                  <?php 
								for($i=0;$i<$subject;$i++)
									echo("<img src=img/ThumbUpIcon20.jpg /> "); 
								?>								</td>
                              </tr>
                            </table>
					      </div>
                          <?php } }?>
                        </td>
                      </tr>
                  </table></td>
                </tr>
            </table>
            <?php }else if( strlen($priority) >1 ){
						for( $i=0;$i<=strlen($priority);$i+=2 ){
							if(substr($priority,$i+1,1)=="F"){
					?>
              <table width="599" height="125" border="0" cellpadding="0" cellspacing="0" bgcolor="white" style="margin-top:<?php 
				  if( ProfileProgress($uname) < $ProPercent )echo("5px"); else echo("0px");
				  ?>; margin-right:5px; margin-bottom:10px; border-bottom:#CCCCCC solid 1px; border-left:#EEEEEE dashed 1px;border-right:#EEEEEE dashed 1px">
                <tr>
                  <td width="162" height="40" style="padding-left:5px; padding-bottom:20px; padding-top:5px"><strong><font size="3" color="#000000">
                      <?php if($_SESSION['lan']=="CN")echo("好友近况");else echo("Friends | Others"); ?>
                  </font></strong>				  </td>
                  <td width="488" height="40" align="right" style="padding-right:10px">
                      <a href="FriendList.php" class="one">See More</a>                  </td>
                </tr>
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="650" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="663" height="85" valign="top"><?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$sql_stmt = "SELECT * FROM rockinus.user_info a INNER JOIN rockinus.user_check_info b ON a.uname=b.uname ORDER BY signup_time,signup_date DESC;";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$tbname = $object->tbname;			
			$pdate = $object->signup_date;
			$ptime = $object->signup_time;
			$id = $object->email;
			$action = $object->status;
			?>
                            <div style="margin-top:0; margin-bottom:10px; padding-left:0; padding-top:0; padding-bottom:2; border-bottom:1px #EEEEEE dashed">
                              <table width="650" height="70" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="63" rowspan="2" valign="top" bgcolor="#FFFFFF" style="padding-left:5px; padding-right:5px; padding-bottom:5px; "><?php
									$loopImg = "upload/$loopname/$loopname"."100.jpg";
							  if(file_exists($loopImg)) echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=$loopImg width=80px /></a>");
							  else echo("<a href=RockerDetail.php?uid=$loopname class=one><img src=img/NoUserIcon100.jpg width=80px /></a>");
							  ?></td>
                                  <td height="20" align="left" style="padding-left:15px"><?php
							  if($tbname=="user_check_info") 
							  	echo("<a href=RockerDetail.php?uid=$loopname class=one><font color=#336633 size=3><strong>$loopname</strong></font></a> has joined the network.");	
								?>                                  
								</td>
                                  <td height="20" colspan="2" align="right" style="padding-right:10px">
								  <?php
							  echo("$pdate | ".substr($ptime,0,5));
							  ?></td>
                                </tr>
                                <tr>
                                  <td height="35" style="padding-left:15">
                                    <?php 
							  	if($tbname=="user_check_info"){
									$pieces = explode('@', $id);
									if(stristr($pieces[1],'poly')==true) echo("From NYU-Poly ");
								} 
								?>
                                  </td>
                                  <td width="74" style="padding-left:5">&nbsp;</td>
                                  <td width="81" align="right" style="padding-right:5px">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                          <?php } ?>                        
					    </td>
                      </tr>
                  </table></td>
                </tr>
            </table>
            <?php
					}else if(substr($priority, $i+1, 1)=="M"){
					?>
              <table width="599" height="115" border="0" cellpadding="0" cellspacing="0" bgcolor="white" style="margin-top:<?php 
				  if( ProfileProgress($uname) < $ProPercent )echo("5px"); else echo("0px");
				  ?>; margin-right:5px; margin-bottom:10px; border-top:0px #000000 solid; border-bottom:#CCCCCC solid 1px; border-left:#EEEEEE dashed 1px;border-right:#EEEEEE dashed 1px">
                <tr>
                  <td width="144" height="40" style="padding-left:5px; padding-bottom:15px"><strong><font size="3" color="#000000">
                      <?php if($_SESSION['lan']=="CN")echo("我关心的");else echo("Interested updates"); ?>
                  </font></strong></td>
                  <td width="506" height="40" align="right" style="padding-right:10px;">
                  <?php 
				  	$q = mysql_query("SELECT hobby FROM rockinus.user_hobby_info WHERE uname='$uname'");
					if(!$q) die(mysql_error());
					$no_row = mysql_num_rows($q);
					if($no_row == 0) echo("");
					$object = mysql_fetch_object($q);
					$hobby = explode(",",$object->hobby);
					if($no_row != 0)echo("See More");
				  	else echo("");
				  ?>
				  </td>
                </tr>
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="650" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="663" valign="top">
						<?php
		//echo "a UNION SELECT category,recipient,sender,NULL,descrip,rstatus,pdate,ptime FROM rockinus.rocker_rel_info b WHERE uname='$uname' AND sender<>'$uname' ORDER BY rstatus, ptime DESC LIMIT $set_limit, $limit;";
		for($i=0;$i<count($hobby);$i++){
			$q = mysql_query("SELECT * FROM rockinus.event_info WHERE eventType='$hobby[$i]' ORDER BY eid DESC");
			if(!$q) die(mysql_error());
			$no_row = mysql_num_rows($q);
			if($no_row != 0){
				while($object = mysql_fetch_object($q)){
					$eid = $object->eid;
					$eventTitle = $object->eventTitle;
					$creater = $object->creater;
					$pdate = $object->pdate;
					$ptime = $object->ptime;
					$eventType = $object->eventType;
					$descrip = $object->descrip;
					?>
					<table width="650" height="96" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:10px">
                            <tr>
                              <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px; padding-top:5px"><?php echo("<img src=img/$eventType"."100.jpg height=35 width=35>") ?> </td>
                              <td width="475" height="35" align="left" style="display:inline;  padding-left:15px; border-bottom:0px #BBBBBB dotted"> <?php echo("<font color=$_SESSION[hcolor]><strong>$creater</strong></font> has created an event :") ?>                              </td>
                              <td height="35" colspan="2" style="padding-left:5"><?php echo($pdate);?> | <?php echo($ptime);?></td>
                            </tr>
                            <tr>
                              <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                              <td height="35" align="left" style="display:inline;  padding-left:15px; border-bottom:0px #BBBBBB dotted">
							  <font size="3">
							  <strong>
                                <?php 
										  echo("<a href=eventDetail.php?eid=$eid class=one>".substr($eventTitle,0,50)." ...</a>");
							  ?>
                              </strong>							  </font>							  </td>
                              <td width="59" height="35" style="padding-left:5">&nbsp;</td>
                              <td width="75" height="35" align="right" style="padding-right:5px">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="40" height="45" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                              <td height="45" align="left" style="display:inline;  padding-left:15px; border-bottom:0px #BBBBBB dotted; padding-top:8px; padding-bottom:10px">
							  <font size="2">
                                <?php 
										  echo($descrip);
							  ?>
                              </font></td>
                              <td height="45" style="padding-left:5">&nbsp;</td>
                              <td height="45" align="right" style="padding-right:5px">&nbsp;</td>
                            </tr>
                          </table>
				<?php 
				}
			}
		}
		?>                
					    </td>
                      </tr>
                  </table></td>
                </tr>
            </table>
            <?php
							}else if(substr($priority, $i+1, 1)=="A"){
					?>
              <table width="599" height="115" border="0" cellpadding="0" cellspacing="0" bgcolor="white" style="margin-top:<?php 
				  if( ProfileProgress($uname) < $ProPercent )echo("5px"); else echo("0px");
				  ?>; margin-right:5px; margin-bottom:10px; border-bottom:#CCCCCC solid 1px; border-left:#EEEEEE dashed 1px;border-right:#EEEEEE dashed 1px">
                <tr>
                  <td width="120" height="40" style="padding-left:10px; padding-bottom:10px" align="left"><strong><font size="3" color="#000000">
                      <?php if($_SESSION['lan']=="CN")echo("二手物品");else echo("Flea Market"); ?>
                  </font></strong></td>
                  <td width="506" height="40" align="right" style="padding-right:10px;"><a href="FleaMarket.php" class="one">See More</a></td>
                </tr>
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="650" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="663" height="85" valign="top"><?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$sql_stmt = "SELECT * FROM rockinus.article_info a INNER JOIN rockinus.user_info b ON a.uname=b.uname OR a.uname=b.uname ORDER BY a.aid DESC";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$aid = $object->aid;	
			$subject = $object->subject;
			$buysale = $object->buysale;
			$aname = $object->aname;
			$rate = $object->rate;
			$city = $object->city;
			$delivery = $object->delivery;			
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			if($delivery="Y")$delivery = "Can be delivered";
			else $delivery = "Self Take";
			?>
                            <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2;">
                              <table width="650" height="96" border="0" cellpadding="0" cellspacing="0" bgcolor="#f5f5f5">
                                <tr>
                                  <td width="40" height="32" bgcolor="#FFFFFF" style="padding-left:5px; padding-top:5px"><?php echo("<img src=img/$aname"."Icon.jpg width=35 height=35>") ?> </td>
                                  <td width="444" align="left" style="display:inline; padding-left:15px; border-bottom:0px #BBBBBB dotted">
								  <?php
							  	echo("<strong><font color=$_SESSION[hcolor] size=3>$aname | $buysale</font> <font color=#999999 size=3>[$city]</font></strong></font>");	
								?></td>
                                  <td width="165" align="right" style="padding-right:10px"><?php echo("$pdate | ".substr($ptime,0,5))?></td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td height="35" align="left" style="display:inline; padding-left:15px;">
								  <?php 
										  echo("<a href=articleDetail.php?aid=$aid class=one><strong>".substr($subject,0,60)." ...</strong></a>");
							  ?>
								  </td>
                                  <td height="35" align="right" style="display:inline; padding-right:10px;">
                                    <?php
							  	echo($loopname);	
								?>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td height="35" colspan="2" align="left" style="padding-left:15px">
								  <?php echo("$ $rate | $delivery") ?>
								  </td>
                                </tr>
                              </table>
                            </div>
                          <?php } ?>                        </td>
                      </tr>
                  </table></td>
                </tr>
            </table>
            <?php
							}else if(substr($priority, $i+1, 1)=="H"){
					?>
              <table width="599" height="125" border="0" cellpadding="0" cellspacing="0" bgcolor="white" style="margin-top:<?php 
				  if( ProfileProgress($uname) < $ProPercent )echo("5px"); else echo("0px");
				  ?>; margin-right:5px; margin-bottom:10px; border-top:0px #000000 solid; border-bottom:#CCCCCC solid 1px; border-left:#EEEEEE dashed 1px;border-right:#EEEEEE dashed 1px">
                <tr>
                  <td width="144" height="40" style="display:inline; padding-left:5px; padding-bottom:15px">
				  <strong><font size="3" color="#000000">
                      <?php if($_SESSION['lan']=="CN")echo("房屋信息");else echo("House | Rental"); ?>
                  </font></strong></td>
                  <td width="506" height="40" align="right" style="padding-right:10px;">
                     <a href="HouseRental.php" class="one">See More</a></td>
                </tr>
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="650" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="663" height="85" valign="top"><?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$sql_stmt = "SELECT * FROM rockinus.house_info a INNER JOIN rockinus.user_info b ON a.uname=b.uname ORDER BY a.hid DESC;";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$hid = $object->hid;	
			$subject = $object->subject;	
			$rate = $object->rate;
			$city = $object->city;	
			$type = $object->type;
			$rentlease = $object->rentlease;	
			$pdate = $object->pdate;
			$ptime = $object->ptime;
			?>
                            <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2;">
                              <table width="650" height="105" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="border-bottom:1px #F5F5F5 solid">
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px; padding-top:5px"><img src="img/NoHouse100.jpg" width="35" height="35" /></td>
                                  <td width="459" align="left" style="padding-left:15px">
                                    <?php 
										  echo("<strong><font size=3 color=$_SESSION[hcolor]>$type | $rentlease</font> <font color=#999999 size=3>[$city]</font></strong>");
							  ?>
							  </td>
                                  <td width="148" style="padding-right:10px" align="right">
								  <?php 
										  echo("$pdate | ".substr($ptime,0,5));
							  ?>                                  </td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td align="left" style="padding-left:15px">
                                    <?php 
										  echo("<a href=HouseDetail.php?hid=$hid class=one><strong>".substr($subject,0,80)." ...</strong></a>");
							  ?>
                                  </td>
                                  <td align="right" style="padding-right:10px"><?php echo("<a href=RockerDetail.php?uid=$loopname class=one>$loopname</a>") ?></td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td align="left" style="padding-left:15px">
								  <?php
							  	echo("$ ".$rate." /Month");		
								?></td>
                                  <td align="right" style="padding-right:10px">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                          <?php } ?>                        </td>
                      </tr>
                  </table></td>
                </tr>
            </table>
            <?php
							}else if(substr($priority, $i+1, 1)=="C"){
					?>
              <table width="599" height="110" border="0" cellpadding="0" cellspacing="0" bgcolor="white" style="margin-top:<?php 
				  if( ProfileProgress($uname) < $ProPercent )echo("5px"); else echo("0px");
				  ?>; margin-right:5px; margin-bottom:10px; border-top:0px #000000 solid; border-bottom:#CCCCCC solid 1px; border-left:#EEEEEE dashed 1px;border-right:#EEEEEE dashed 1px">
                <tr>
                  <td width="201" height="40" style="display:inline; padding-left:5px; padding-bottom:10px">
				  <strong><font size="3" color="#000000">
                      <?php if($_SESSION['lan']=="CN")echo("课程相关");else echo("Course & Professor"); ?>
                  </font></strong>				  </td>
                  <td width="449" height="40" align="right" style=" padding-right:10px;">
                     <a href="SchoolCourse.php" class="one">See More</a>				  </td>
                </tr>
                <tr>
                  <td height="85" colspan="2" valign="top" style="border-right:0 dotted #666666; border-left:0 dotted #666666"><table width="650" height="85" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="663" height="85" valign="top"><?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$sql_stmt = "SELECT * FROM rockinus.user_course_info a INNER JOIN rockinus.user_info b INNER JOIN rockinus.course_memo_info c INNER JOIN rockinus.user_edu_info d ON a.uname=b.uname AND b.uname=c.sender AND a.coid=c.coid ORDER BY a.coid DESC;";
		$q = mysql_query($sql_stmt);
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) echo("");
		while($object = mysql_fetch_object($q)){
			$loopname = $object->uname;		
			$descrip = $object->descrip;	
			$coid = $object->coid;		
			$rating = $object->rating;			
			$pdate = $object->pdate;
			$ptime = $object->ptime;
		
			$q = mysql_query("SELECT * FROM rockinus.course_info WHERE coid='$coid';");
			if(!$q) die(mysql_error());
			$object = mysql_fetch_object($q); 
			$course_name = $object->course_name;
			?>
                            <div style="margin-top:0; margin-bottom:5px; padding-left:0; padding-top:0; padding-bottom:2;">
                              <table width="650" height="105" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5">
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px; padding-top:5px"><img src="img/book100.jpg" width="35" height="35" /></strong></font></td>
                                  <td width="467" style="padding-left:15">
                                  <?php
							  	echo("Comment was given on Course <font color=$_SESSION[hcolor]><strong>$coid - $course_name</strong></font> :");
							  ?></td>
                                  <td width="143" align="right" style="padding-right:10px"><?php echo("$pdate | ".substr($ptime,0,5)) ?> </td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td style="padding-left:15">
								  <?php 
				 echo("<a href=CourseDetail.php?sid=NYPOLY&pid=$aname&coid=$id class=one><font size=3><strong>$descrip</strong></font></a>");
							  ?></td>
                                  <td align="right" style="padding-right:10px">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="40" height="35" bgcolor="#FFFFFF" style="padding-left:5px">&nbsp;</td>
                                  <td style="padding-left:15"><?php echo("$rating Star(s) has been rated") ?></td>
                                  <td align="right" style="padding-right:5px">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                          <?php } ?>                        </td>
                      </tr>
                  </table></td>
                </tr>
            </table>
            <?php		
							}
						}
					 }
					 ?>
          </td>
          <td width="215" valign="top" align="center" style="padding-left:0px"><table width="205" height="386" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td width="68" height="30" background="img/master.png" bgcolor="#EEEEEE" style="padding-left:8"><font color="#000000">
                  <?php 
 				if(!isset($_SESSION['usrname']))echo(Login);
				else echo "<strong><a href=RockerDetail.php?uid=$uname class=one>$uname</a></strong>";
			?>
                </font></td>
                <td height="30" background="img/master.png" bgcolor="#EEEEEE" style="padding-right:10px" align="right">
				  <a href="EditHeadIcon.php" class="one">+Change</a></td>
              </tr>
              <tr>
                <td height="33" colspan="2"><div align="center" style="margin-bottom:5; margin-top:5">
                    <?php 
					$target = "upload/".$uname;
					if(is_dir($target)){
						echo("<a href=RockerDetail.php?uid=$uname class=one><img src=upload/$uname/$pic210_Name style=border:0></a>");
				  	}else 
				  		echo("<a href=RockerDetail.php?uid=$uname class=one><img src=img/NoUserIcon210.jpg style=border:0></a>");
					?>
                </div></td>
              </tr>
              <tr>
                <td height="30" colspan="2" bgcolor="#F5F5F5" style="padding-left:10; border-bottom:1 #EEEEEE solid">
				<?php echo($ccity) ?>, <?php echo($cstate) ?></td>
              </tr>
              <tr>
                <td height="30" colspan="2" bgcolor="#F5F5F5" style="padding-left:10; border-bottom:1 #EEEEEE solid; line-height:150%; padding-right:5px; padding-bottom:5px">
				<?php echo($cschool) ?> | <font color="#336633"><?php echo($cdegree) ?></font></td>
              </tr>
              <tr>
                <td height="30" colspan="2" bgcolor="#F5F5F5" style="padding-left:10; border-bottom:1 #EEEEEE solid; padding-bottom:5px; padding-right:5px; line-height:150%">
		<?php 
		$s = mysql_query("SELECT cmajor FROM rockinus.user_edu_info WHERE uname='$uname'");
		if(!$s) die(mysql_error());
		$object = mysql_fetch_object($s);
		$cmajor = $object->cmajor;		

		if($cmajor!=NULL){
			$sql_stmt = "SELECT * FROM rockinus.major_info WHERE mid='$cmajor'";
			$q = mysql_query($sql_stmt);
			if(!$q) die(mysql_error());
			$object = mysql_fetch_object($q);
			$major_name = $object->major_name;		
		}else $major_name = "Unkown Major";
		echo($major_name) ?>			</td>
              </tr>
              <tr>
                <td height="30" colspan="2" bgcolor="#F5F5F5" style="padding-left:10">
				<font color="#336633"><?php echo($mstatus) ?></font></td>
              </tr>
              <tr>
                <td height="29" colspan="2" align="center" style="padding-top:8px; padding-bottom:0px">
				<div align="left" style="padding-left:7px; padding-bottom:7px; background-color:#F5F5F5; width:215px; padding-top:7px; border-top:1px #CCCCCC solid">
				<font size="3"><strong>
				<?php 
				//query: **EDIT TO YOUR TABLE NAME, ETC.
				$sql_stmt = "SELECT * FROM rockinus.user_hobby_info WHERE uname='$uname';";
				$q = mysql_query($sql_stmt);
				if(!$q) die(mysql_error());
				$no_row = mysql_num_rows($q);
				if($no_row == 0) echo("");
				$object = mysql_fetch_object($q);
				$hobbyArray = explode(",",$object->hobby);
		
				if( $object->hobby == NULL ){
					if($_SESSION['lan']=='CN')
					  echo("我的关注");
					  else if($_SESSION['lan']=='EN')
					  echo("Interested Items");
				}else{
					if($_SESSION['lan']=='CN')
					  echo("我的关注 | <a href=EditHobbyInfo.php class=one><font color=#999999>增加+</font></a>");
					  else if($_SESSION['lan']=='EN')
					  echo("Interested Items | <a href=EditHobbyInfo.php class=one><font color=#999999>Add +</font></a>");
				}
				  ?></strong></font></div>
                   <?php
					if( $object->hobby == NULL ){
						if($_SESSION['lan']=='CN')
					  		echo("<div style='padding-top:2px; padding-left:7px; padding-right:5px; padding-bottom:5px; line-height:180%; background-color=#F5F5F5' align=left>增加喜欢和关注的事物，会在第一时间收到所关心的内容. <a href=EditHobbyInfo.php class=one><strong><u><font color=$_SESSION[hcolor]>马上添加+</font></u></strong></a></div>");
					  	else if($_SESSION['lan']=='EN')
					  		echo("<div style='padding-top:2px; padding-left:7px; padding-right:5px; padding-bottom:5px; line-height:180%; background-color=#F5F5F5' align=left>Adding interested items help you updated with things your cared about. <a href=EditHobbyInfo.php class=one><strong><u><font color=$_SESSION[hcolor]>Add Now+</font></u></strong></a><div>");
				}else{
					for($i=0;$i<count($hobbyArray);$i++){
						$t = mysql_query("SELECT count(*) AS cnt FROM rockinus.user_hobby_info WHERE hobby LIKE '%$hobbyArray[$i]%' AND uname in ((SELECT sender FROM rockinus.rocker_rel_info WHERE recipient='$uname' AND rstatus='A') OR ( SELECT recipient FROM rockinus.rocker_rel_info WHERE sender='$uname' AND rstatus='A'));");
						$a = mysql_fetch_object($t);
						$total_items = $a->cnt;
			?>
                      <table width="215" height="45" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="45" height="35" style="padding-left:5px; padding-top: 3px"><?php
									$loopImg = "img/$hobbyArray[$i]"."100.jpg";
							  if(file_exists($loopImg)) echo("<img src=$loopImg width=35 />");
							  else echo("<img src=img/cactusct.jpg width=35 />");
							  ?></td>
                          <td width="124" align="left" style="padding-left:15px">
						  <font color="#003366"><strong>
                            <?php 
								echo(ucfirst($hobbyArray[$i]));
								?>
                          </strong></font></td>
                          <td width="46" align="right" style="padding-right:10px"><?php echo("<strong><font size=3>".$total_items."</font></strong> ") ?> <img src="img/user40.jpg" /></td>
                        </tr>
                  </table>
                    <?php } }?></div></td>
              </tr>
              <tr>
                <td height="29" colspan="2" align="center" style="padding-top:5px;"><form action="MemoPost.php" method="post" name="MemoPost" id="MemoPost" style=" margin-top:5">
                  <table width="210" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3"><textarea cols="<?php if(contains("Chrome",$ua['name']))echo("22"); else echo("29"); ?>" rows="4" style="color: #006699; background-color:#; font:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; border: #CCCCCC solid 1px; padding: 5px; margin-top:0; margin-bottom:5" name="limitedtextarea" onclick="select_all();"><?php echo($default_textarea) ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="124" height="40" style="padding-bottom:10; padding-top:10">&nbsp;
                          <input readonly="readonly" type="text" name="countdown2" size="3" value="150"/>
                        / &nbsp;<font size="-1.5">150</font>
                        <input type="hidden" name="Pagename" value="ThingsRock.php" />
                      </td>
                      <td width="86" height="40"><span style="padding-left:8">
                        <?php  
						if(isset($_SESSION['rst_msg'])){
							echo($_SESSION['rst_msg']); 
							unset($_SESSION['rst_msg']); 
						}?>
                      </span></td>
                      <td width="62" height="40"><input name="submit2" type="submit" class="btn" value=" Share " /></td>
                    </tr>
                  </table>
                </form></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>
