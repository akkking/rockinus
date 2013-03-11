<?php include("Header.php"); ?>
<div align="center">
<?php 
$pic100_Name = $uname.'100.jpg';
		
//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';

$q = mysql_query("SELECT * FROM rockinus.user_info where uname='$uname'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) die("No matches met your criteria.");
$object = mysql_fetch_object($q);
$sstatus = $object->sstatus;
$gender = $object->gender;
$mstatus = $object->mstatus;
$birthdate = $object->birthdate;
$fcity = $object->fcity;
$fcountry = $object->fcountry;
$email = $object->email;
$cmajor = $object->cmajor;
$cschool = $object->cschool;
$cdegree = $object->cdegree;
$ccity = $object->ccity;
$cstate = $object->cstate;

if($gender=='M')$gender='Gentle Man';
else if($gender=='F')$gender='Female';

if($sstatus=='S')$sstatus='Student';
else if($sstatus=='E')$sstatus='Empolyee(r)';

if($cdegree=='G')$cdegree='Master Student';
else if($cdegree=='P')$cdegree='P.H.D.';
else if($cdegree=='U')$cdegree='Undergraduate';
else $cdegree='Certificate Student';

if($mstatus=='S')$mstatus='Single';
else if($mstatus=='M')$mstatus='Married';
else if($mstatus=='I')$mstatus='In a relationship';

$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$cschool'");
if(!$q1) die(mysql_error());
$obj1 = mysql_fetch_object($q1);
$cschool = $obj1->school_name;
	
$q2 = mysql_query("SELECT * FROM rockinus.major_info where mid='$cmajor'");
if(!$q2) die(mysql_error());
$obj2 = mysql_fetch_object($q2);
$cmajor = $obj2->major_name;

$q = "SELECT count(*) as cnt FROM rockinus.message_info where recipient='$uname'";
$t = mysql_query($q);
$a = mysql_fetch_object($t);
$total_items = $a->cnt;

$q = mysql_query("SELECT descrip FROM rockinus.memo_info WHERE sender='$uname' ORDER BY memoid DESC");
$object = mysql_fetch_object($q);
$default_textarea = $object->descrip;
if($default_textarea==NULL)$default_textarea = "What you think? Write it down here, share with others.";

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
?>
  <table width="1018" height="394" border="0" cellpadding="0" cellspacing="0" style="padding-top:-5; margin-top:-1;">
    <tr>
      <td width="136" align="left" valign="top" style="border-right: 1px solid #CCCCCC; padding-right:0; padding-left:10;width:10">
          <div style="margin-top: 0; margin-bottom: -20; margin-left:0; margin-right: -5; padding-left:10; border-left: 0px solid #CCCCCC; background-color: #; height:550px" align="left">
            <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:8"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="HouseRental.php" class="one">House</a>  </div>
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"><img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="FleaMarket.php" class="one">Market  </a></div>
			  <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted">
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="SchoolCourse.php" class="one">Schools</a> </div>
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="SchoolCourse.php" class="one">Courses</a> </div>
			  <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted">
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"><img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="FriendGroup.php" class="one">Friends</a> </div>
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="FriendGroup.php" class="one">Groups </a></div>
			  <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted">
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="RockerDetail.php?uid=<?php echo($uname) ?>" class="one">Profile </a></div>
			  <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted">
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="SendMessage.php" class="one">Send <span class="STYLE18">(Message)</span></a></div>
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> <a href="MessageList.php" class="one">Read <span class="STYLE18">(Message)</span></a></div>
			  <hr width="120"  size="1" color="#CCCCCC" style="margin-left:-5; border-bottom:dotted">
			  <div class="STYLE8" style="border-bottom: 0px dotted #999999; padding-right:0; margin-left:-5; width:125; padding-bottom:4; margin-top:5"> <img src="img/RightArrow.jpg" width="12" height="12" style="border:0"> Wisdom </a></div>
			  <br>
          </div>
	  </td>
      <td width="882" align="left" valign="top" style=" border:#CCCCCC solid 0; padding-left:3;">
	  <table width="888" height="500" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="606" valign="top"><div align="center" style="margin-right:4">
              <table width="600" height="281" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100" height="23" style="border: #CCCCCC solid 1; border-bottom:0; padding-left:20"><strong>Rock Me </strong> </td>
                  <td width="73" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="70" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="71" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="71" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="71" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="83" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="81" class="STYLE12" style="border: #CCCCCC dotted 0; border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">More...</td>
                </tr>
                <tr>
                  <td height="253" colspan="8" valign="top" style="border: #CCCCCC solid 0; border-top:0">
				    <div style="margin-top:4; margin-bottom:4; padding-left:0; padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
				      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5; padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/TalkAddIcon.jpg" width="13" height="13"></span></div></td>
                          <td width="500"><span class="STYLE12 STYLE16" style="margin-top:4; margin-bottom:4; padding-left:5; padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">James wants to become your friend. </span></td>
                          <td width="74"><span class="STYLE12 STYLE16">2012-01-02</span></td>
                        </tr>
                      </table>
				      </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/NewJoin.jpg" width="13" height="13"></span></div></td>
                          <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Tursun from Beijing has joined the network. </span></td>
                          <td width="74"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:4;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/SaleMeIcon.jpg" width="12" height="11"></span></div></td>
                          <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"> Artificial Intelligence Text Book on sale by Justin. </span></td>
                          <td width="74"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/NewJoin.jpg" width="13" height="13"></span></div></td>
                          <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Amazon Corp. will have an info session next tuesday 17th Jan.</span></td>
                          <td width="74"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
</div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/PenIcon.jpg" width="13" height="13"></span></div></td>
                          <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5; padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">New post on &quot;Puzzle on Alpha Beta Pruning Algorithm&quot; by Jack.</span></td>
                          <td width="74"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/PenIcon.jpg" width="13" height="13"></span></div></td>
                          <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Comment by Qirong Sun on course &quot;Software Engineering I&quot;.</span></td>
                          <td width="74"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                        <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                          <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/PenIcon.jpg" width="13" height="13"></span></div></td>
                              <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Comment on Professor Joseph Vaisan by Qirong Sun.</span></td>
                              <td width="74"><span class="STYLE12">2012-01-02</span></td>
                            </tr>
                          </table>
                        </div>
                        <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                          <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/GroupMeIcon.jpg" width="13" height="13"></span></div></td>
                              <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">New Soccer group &quot;Kick off the dream@Brooklyn&quot; by Julio. </span></td>
                              <td width="74"><span class="STYLE12">2012-01-02</span></td>
                            </tr>
                          </table>
                        </div>
                        <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                          <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/GroupMeIcon.jpg" width="13" height="13"></span></div></td>
                              <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">New Hometown group &quot;Mumby road back home&quot; by Abhishek. </span></span></td>
                              <td width="74"><span class="STYLE12">2012-01-02</span></td>
                            </tr>
                          </table>
                        </div>
                        <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                          <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/VoiceIcon.jpg" width="13" height="13"></span></div></td>
                              <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Remote Gift Delivery Service becomes online by Rockinus. </span></span></span></td>
                              <td width="74"><span class="STYLE12">2012-01-02</span></td>
                            </tr>
                          </table>
                        </div>					
                        <div style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                          <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="26"><div align="center"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/HouseIcon.jpg" width="13" height="13"></span></div></td>
                              <td width="500"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Single Room lease at 59 Str, N/R Train, Brooklyn<span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:0;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">. </span></span></span></span></td>
                              <td width="74"><span class="STYLE12">2012-01-02</span></td>
                            </tr>
                          </table>
                        </div></td>
                </tr>
              </table>
              <table width="600" height="249" border="0" cellpadding="0" cellspacing="0" style="margin-top:8; margin-right:0">
                <tr>
                  <td width="102" height="23" align="center" style="border: #CCCCCC solid 1; border-bottom:0;"><span class="STYLE14">Around</span> </td>
                  <td width="84" style="border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="67" style="border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="67" style="border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="67" style="border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="67" style="border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="66" style="border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20">&nbsp;</td>
                  <td width="85" style="border-bottom: #CCCCCC dotted 1; border-right:0; border-top:0; padding-left:20"><span class="STYLE16">More...</span></td>
                </tr>
                <tr>
                  <td colspan="8" valign="top" style="border: #CCCCCC solid 0; border-top:0"><div style="margin-top:4; margin-bottom:4; padding-left:5; padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                    <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="60"><div align="center"><strong><img src="img/LeaseIcon.jpg" width="60" height="20"></strong></div></td>
                        <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5; padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">59 Street, Brooklyn, single room leasing~ [Jack] </span></td>
                        <td width="75"><span class="STYLE12">2012-01-02</span></td>
                      </tr>
                    </table>
                  </div>
                      <div style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                        <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="60"><div align="center"><strong><img src="img/JoinIcon.jpg" width="60" height="20"></strong></div></td>
                            <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">New Rocker(Tursun) from Beijing has joined the network. </span></td>
                            <td width="75"><span class="STYLE12">2012-01-02</span></td>
                          </tr>
                        </table>
                      </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60"><div align="center"><img src="img/SaleIcon.jpg" width="60" height="20"></div></td>
                          <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">LED screen $200 on sale, in Bensonhurt, Brooklyn. </span></td>
                          <td width="75"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                      </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60"><div align="center"><img src="img/BuyIcon.jpg" width="60" height="20"></div></td>
                          <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Immediately purchase a cellphone iphone.</span></td>
                          <td width="75"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60"><div align="center" class="STYLE16"><img src="img/GroupIcon.jpg" width="60" height="20"></div></td>
                          <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Single Club club has been created for single ones. </span></td>
                          <td width="75"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60"><div align="center" class="STYLE16"><img src="img/CourseIcon.jpg" width="60" height="20"></div></td>
                          <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">Course comment on Algorithm, added by Luthen.</span></td>
                          <td width="75"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60"><div align="center" class="STYLE16"><img src="img/SchoolIcon.jpg" width="60" height="20"></div></td>
                          <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">School comment on Algorithm, added by Luthen. </span></td>
                          <td width="75"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60"><div align="center" class="STYLE16"><img src="img/RentIcon.jpg" width="60" height="20"></div></td>
                          <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">I want a studio from $700 to 1000 in Brooklyn. </span></td>
                          <td width="75"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div>
                    <div style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1" class="STYLE12">
                      <table width="600" height="17" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60"><div align="center" class="STYLE16"><img src="img/WisdomIcon.jpg" width="60" height="20"></div></td>
                          <td width="464"><span class="STYLE12" style="margin-top:4; margin-bottom:4; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1">&quot;Love never fades&quot; by James from New York University. </span></td>
                          <td width="75"><span class="STYLE12">2012-01-02</span></td>
                        </tr>
                      </table>
                    </div></td>
                </tr>
              </table>
            </div></td>
            <td width="282" valign="top" style="border-left: 1px solid #CCCCCC;">
			<table width="280" height="228" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:1 #CCCCCC SOLID; border-left:0; border-bottom:0;">
              <tr>
                <td height="28" background="img/master.png" style="padding-left:8">
                  <?php 
 		if($_SESSION['usrname']=="")echo(Login);
		else echo "<strong>$uname</strong>";
	?>                </td>
                <td width="138" height="28" background="img/master.png" style="padding-left:10">&nbsp;</td>
                <td width="34" background="img/master.png" style="padding-left:2"><span class="STYLE17"><a href="RockerEdit.php" class="one">Edit</a></span></td>
              </tr>
              <tr>
                <td width="110" height="110" rowspan="4"><div align="center" style="padding-left:3; padding-right:3; padding-bottom:2; padding-top:3"><?php echo("<a href=RockerDetail.php?uid=$uname><img src=upload/$pic100_Name style='border:0'></a>") ?></div></td>
                <td height="22" colspan="2" style="padding-left:5; border-bottom:#EEEEEE dotted 1" width="170"><span class="STYLE12 STYLE15"><?php echo($ccity) ?>, <?php echo($cstate) ?> </span></td>
              </tr>
              <tr>
                <td height="22" colspan="2" style="padding-left:5; border-bottom:#EEEEEE dotted 1"><div class="STYLE12 STYLE15" style=" width:160"><?php echo($cschool) ?></div></td>
              </tr>
              <tr>
                <td height="24" colspan="2"  style="padding-left:5; border-bottom:#EEEEEE dotted 1"><div class="STYLE12 STYLE15" style=" width:160"><?php echo($cdegree) ?> | <?php echo($cmajor) ?></div></td>
              </tr>
              <tr>
                <td height="21" colspan="2"  style="padding-left:5; border-bottom:#EEEEEE dotted 0"><span class="STYLE15" style="padding-left:0; border-bottom:#EEEEEE dotted 1"><?php echo($mstatus) ?></span></td>
              </tr>
              <tr>
                <td height="58" colspan="3" style="padding-left:0; border:0 #999999 SOLID; border-bottom:1 #CCCCCC dotted"><div align="right">
				<form method="post" name="MemoPost" action="MemoPost.php" style=" margin-top:5">
                  <table width="272" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3"><textarea cols=39 rows=4 style="color: #006699; background-color:#; font:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; border-color: #CCCCCC; border-style: dotted; border-width: 1; padding: 3px;" name="limitedtextarea" onClick="select_all();"><?php echo($default_textarea) ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="124" height="31" style="padding-bottom:10; padding-top:10">&nbsp;
                          <input readonly type="text" name="countdown" size=3 value="150" style="border:0;">
                        / &nbsp;<font size="-1.5">150</font>
						<input type="hidden" name="pagename" value="ThingsRock.php">
						</td>
                      <td width="86"><span style="padding-left:8">
                        <?php  
						if(isset($_SESSION['rst_msg'])){
							echo($_SESSION['rst_msg']); 
							unset($_SESSION['rst_msg']); 
						}?>
                      </span></td>
                      <td width="62"><input name="submit" type="submit" class="btn" value=" Share "></td>
                    </tr>
                  </table>
				  </form>
                </div></td>
              </tr>
            </table>
              <div class="STYLE12" style="width:280; padding-left:5; padding-top:7; padding-bottom:7;background-color:#; border-bottom:#CCCCCC dotted 1; border-right: #CCCCCC solid 1">
                <table width="270" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="23"><div align="left"><span class="STYLE12" style="margin-top:5; margin-bottom:5; padding-left:5;  padding-top:5; padding-bottom:5; border-bottom:#EEEEEE dotted 1"><img src="img/NewJoin.jpg" width="13" height="13"></span></div></td>
                    <td width="108" style="padding-left:5"><strong><a href="FriendList.php" class="one">Friend List</a> </strong></td>
                    <td width="139"><div align="right"><a href="RequestList.php" class="one"><?php echo($total_friendrqst_items) ?></a> request(s)   | <a href="FriendList.php" class="one"><?php echo($total_friend_items) ?></a>&nbsp;&nbsp;</div></td>
                  </tr>
                </table>
              </div>
              <div class="STYLE12" style="width:280; padding-left:10; padding-top:7; padding-bottom:7; background-color:#; border-bottom:#CCCCCC dotted 1; border-right: #CCCCCC solid 1">
                <table width="265" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="23"><strong><img src="img/MessageIcon.jpg" width="13" height="13"></strong></td>
                    <td width="104"><strong><a href="MessageList.php" class="one">Message Box</a></strong></td>
                    <td width="138"><div align="right"><?php echo($total_unread_items) ?> Unread | <a href="MessageList.php" class="one"><?php echo($total_items) ?></a>&nbsp;&nbsp;</div></td>
                  </tr>
                </table>
              </div>
			<table width="280" height="257" border="0" cellpadding="0" cellspacing="0" style="border-right:0 solid #CCCCCC">
              <tr>
                <td width="280"><div align="center" style="margin-bottom:25"><img src="img/NYU_logo.jpg" width="159" height="160"></div>
                  <div class="STYLE12" style="width:280; padding-left:10; padding-top:7; padding-bottom:7; background-color:#EEEEEE; border-bottom:#CCCCCC dotted 1; border-top:#CCCCCC dotted 1; border-right:#CCCCCC dotted 1">
                    <table width="265" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="23"><strong><img src="img/LogOffIcon.jpg" width="13" height="13"></strong></td>
                        <td width="169">Quit Rockinus </td>
                        <td width="73">&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <p style="border-bottom: 1px dotted #999999; margin-top:-10; margin-left:12; margin-bottom:10; width: 1010"></p>
  </font>
  <div style="font-size:12px">
  <a class="one" href="rockinus_intro.php">About us</a>&nbsp;|&nbsp; Jobs &nbsp;|&nbsp; Advertising&nbsp; |&nbsp; <span class="STYLE7">Give us a feedback.</span></div>
  <div style="margin-bottom:4; margin-top:4; font-size:12px">Copyright &copy; 2011 Rockinus Inc. </div>
</div>
</div>
<br>
</body>
</html>
