<?php include("Header.php"); ?>
<style type="text/css">
<!--
.STYLE1 {
	color: #336633;
	font-style: italic;
}
.STYLE2 {color: #336633}
.STYLE3 {font-size: 18px}
.STYLE4 {color: #339933}
-->
</style>

<div align="center">
  <table width="1024" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="1033"><div align="center">
          <table width="1010" border="0" cellspacing="0" cellpadding="0">
            <tr  style="margin-bottom:5; padding-bottom:5">
              <td width="39"><span style="border-right: 1px solid #EEEEEE; padding-right:0; width:10">
                <div style="padding-left:0"><img src="img/u.s.flag_small" width="38" height="22"></div>
              </span></td>
              <td width="80"><img src="img/category.jpg" width="80" height="28"></td>
              <td width="22"><strong>NY</strong> </td>
              <td width="80"><img src="img/category.jpg" width="80" height="28"></td>
              <td width="100"><strong><a href="SchoolCourse.php" class="one">New York City</a> </strong></td>
              <td width="84"><img src="img/category.jpg" width="80" height="28"></td>
              <td width="347"><form name="schoolme" method="post" action="SchoolCourse_process.php" style="margin-bottom:-4">
                  <select name="school" id="school" class="school" onChange="document.schoolme.submit()">
                    <option value="all" selected="selected">All Schools</option>
                    <option value="NYPOLY">Polytechnic Institute of New York University</option>
                    <option value="NYNYU">New York University</option>
                    <option value="NYCOLUMBIA">Columbia University</option>
                    <option value="NYCUNY">City University of New York</option>
                    <option value="NYLIU">Long Island University</option>
                    <option value="NYYESHIVA">Yeshiva University</option>
                    <option value="NYTNS">The New School</option>
                    <option value="NYNYIT">New York Institute of Technology</option>
                    <option value="NYLAW">New York Law School</option>
                    <option value="NYFASHION">Fashion Institute of Technology</option>
                    <option value="NYSTJOHNS">St. Johns University</option>
                  </select>
              </form></td>
              <td width="258" style="padding-right:5"><span style="padding-left:10; padding-top:0; margin-top:0; padding-bottom:0; padding-right:5; border-top-style: dotted; border-top-width:0">
                <div style="padding-left:10; padding-top:0; margin-top:0; padding-bottom:0; padding-right:5; border-top-style: dotted; border-top-width:0" align="right">
                  <?php
//Global Variable: 
$page_name = "ProfessorDetail.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
$pid = $_GET["pid"];
$sid = $_GET["sid"];
$q = mysql_query("SELECT * FROM rockinus.professor_info WHERE sid='$sid' AND pid='$pid'");
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("No matches met your criteria.");
//$object = mysql_fetch_object($q);
//$major_name = $object->major_name;

//$q1 = mysql_query("SELECT * FROM rockinus.school_info where sid='$sid'");
//if(!$q1) die(mysql_error());
//$no_row = mysql_num_rows($q1);
//if($no_row == 0) echo("No matches met your criteria.");
//$object = mysql_fetch_object($q1);
//$school_name = $object->school_name;

//$q2 = mysql_query("SELECT * FROM rockinus.course_info where coid='$coid'");
//if(!$q2) die(mysql_error());
//$no_row = mysql_num_rows($q2);
//if($no_row == 0) echo("No matches met your criteria.");
//$object = mysql_fetch_object($q2);
//$course_name = $object->course_name;
?>
                </div>
              </span></td>
            </tr>
          </table>
      </div></td>
    </tr>
    <tr>
      <td height="313" valign="top"><div style="padding-left:0; padding-top:0; margin-top:0; padding-bottom:10; padding-right:0; border-top-style: dotted; border-top-width:0; " align="center">
          <table width="1024" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="729"><div style="padding-left:0; padding-top:0; margin-top:0; padding-bottom:5; padding-right:0; border-bottom:0 dotted #CCCCCC; margin-right:0" align="center">
                <table width="712" height="61" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE" style="border-top:1 #999999 dotted; margin-top:5">
                  <tr>
                    <td width="382" height="59" style="padding-left:20; padding-bottom:20; padding-top:20; border-bottom:1 #CCCCCC dotted"><span class="STYLE3"><font color="#006699"><?php echo($pid)?></font></span></td>
                    <td width="330" style="padding-left:20; padding-bottom:20; padding-top:20; border-bottom:1 #CCCCCC dotted"><div align="center"><span class="STYLE3"><font color="#999999"><?php echo($sid)?></font><font color="#CCCCCC"></font></span></div></td>
                  </tr>
                </table>
                <table style="margin-top:20">
                  <tr>
                    <td width="710" height="41" colspan="3"><?php
$q1 = mysql_query("SELECT * FROM rockinus.professor_memo_info WHERE sid='$sid' AND pid='$pid' ORDER BY memoid DESC");
if(!$q1) die(mysql_error());
$no_row = mysql_num_rows($q1);
if($no_row == 0){ echo("<em><font color=#CCCCCC>There is no comment on this professor, you could be the first one to post :)</font></em>");}
if($no_row > 0){ 
while($object = mysql_fetch_object($q1)){
	$memoid = $object->memoid;
	$sender = $object->sender;
	$rating = $object->rating;
	$descrip = $object->descrip;
	$ptime = $object->ptime;
	$pdate = $object->pdate; 
?>
                        <div style="padding-left:5; padding-right:5; line-height:180%; padding-top:0; padding-bottom:0; margin-bottom:10; width: 700px; background-color: ; border-bottom:1 #CCCCCC dotted">
                          <table width="700" height="63" border="0" cellpadding="0" cellspacing="4">
                            <tr>
                              <td width="103" height="29"><div align="left" style=" color:#336633"><?php echo($sender) ?></div></td>
                              <td width="226">&nbsp;</td>
                              <td width="112"><div align="center"><span style=" color: #999999; font-size:13px">
                                  <?php 
							  	for($i=1;$i<=$rating;$i++)echo("<img src=img/yellowstar.jpg width=15 height=13>"); 
								?>
                              </span></div></td>
                              <td width="129"><div align="left" style=" color: #999999; font-size:13px"><?php echo($pdate) ?> | <?php echo($ptime) ?></div></td>
                            </tr>
                            <tr>
                              <td height="22" colspan="4" style="padding-bottom:10; padding-top:10"><?php
									$len = strlen($descrip);
									$single_line_len = 95;
									$line_no = $len/$single_line_len; 
							
									for($i=0;$i<$line_no;$i++) {
										$str = substr($descrip,$i*$single_line_len, ($i+1)*$single_line_len)."<br>";
										echo $str;
									}?>
                              </td>
                            </tr>
                          </table>
                        </div>
                      <?php }}?></td>
                  </tr>
                </table>
                <br>
				  <form action="ProfessorComment.php" method="post" style="margin:0">
                  <table width="712" border="0" cellpadding="0" cellspacing="0" style="border-top:#999999 solid 1">
                    <tr>
                      <td width="131" height="38" bgcolor="#EEF2FF"><div align="right" style="padding-right:15">
                        <div align="left" style="padding-left:10"><strong>Comment</strong></div>
                      </div></td>
                      <td width="431" height="38" bgcolor="#EEF2FF"><input type="radio" name="rating" value="5" />
                        <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                        <input type="radio" name="rating" value="4" />
                        <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                        <input type="radio" name="rating" value="3" checked="checked" />
                        <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                        <input type="radio" name="rating" value="2" />
                        <img src="img/yellowstar.jpg" width="15" height="13" /><img src="img/yellowstar.jpg" width="15" height="13" />&nbsp;&nbsp;
                        <input type="radio" name="rating" value="1" />
                        <img src="img/yellowstar.jpg" width="15" height="13" /></td>
                      <td width="81" bgcolor="#EEF2FF"><div align="left"><span style="padding-left:8">
                        <?php  
						if(isset($_SESSION['rst_msg'])){
							echo($_SESSION['rst_msg']); 
							unset($_SESSION['rst_msg']); 
						}?>
                      </span></div></td>
                      <td width="69" bgcolor="#EEF2FF"><div align="center">
                          <input type="hidden" value="ProfessorDetail.php?sid=<?php echo($sid) ?>&&pid=<?php echo($pid) ?>" name="pagename" />
                          <input type="hidden" value="<?php echo($sid) ?>" name="sid" />
                          <input type="hidden" value="<?php echo($pid) ?>" name="pid" />
                          <span style="padding-bottom:0">
                          <input type="submit" name="Submit2" value="Submit" class="btn" />
                        </span></div></td></tr>
                    <tr>
                      <td height="86" colspan="4">
					  <div align="center"><br>
                          <textarea name="description" rows="4" style="width:700" id="styled"></textarea>
                          <br>
                        <br>
                      </div></td>
                    </tr>
					</table>
				  </form>
              </div>
                <div align="center">
                  <table width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>
					  <table border="0" cellpadding="0" cellspacing="0" style="margin-top:15; margin-bottom:10; border-top:1 #999999 dotted;border-left:1 #999999 dotted; border-right:1 #999999 dotted;">
                        <tr>
                          <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" style="padding-left:15; padding-bottom:10; padding-top:15; border-bottom:0 #CCCCCC dotted"><span class="STYLE1 STYLE3">Professor Introduction </span></td>
                        </tr>
                        <tr>
                          <td height="46" colspan="2" bgcolor="#FFFFFF" style="padding-left:10"><div class="STYLE12" style=" padding-left:10; padding-top:0; padding-right:10; padding-bottom:15; width:650; margin-top:5"><em>
                              <?php
					  	//$q1 = mysql_query("SELECT * FROM rockinus.course_info WHERE sid='$sid' AND mid='$mid' AND coid='$coid'");
						//if(!$q1) die(mysql_error());
						//$no_row = mysql_num_rows($q1);
						//if($no_row == 0)echo("This course is not found.");
						//if($no_row > 0){ 
							//$object = mysql_fetch_object($q1);
							//$coid = $object->coid;
							//$sid = $object->sid;
							//$course_name = $object->course_name;
							//$descrip = $object->descrip;
							//$descrip = $object->descrip;
							//$professors = $object->professors;
							//$pdate = $object->pdate;
							//echo(addslashes($descrip));
							//echo("<br><br><br>");
						//}?>
                          </em></div></td>
                        </tr>
                        <tr>
                          <td height="25" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:15; padding-top:5; padding-bottom:5; border-top:1 dotted #EEEEEE"> Profesor(s): <a href="#" class="one STYLE4"><?php echo($pid);?></a></td>
                        </tr>
                        <tr>
                          <td height="25" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:15; padding-top:5; padding-bottom:5; border-top:1 dotted #EEEEEE">Textbook Name: <span class="STYLE2">ABCDEFGHIGK</span> </td>
                        </tr>
                        <tr>
                          <td height="25" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:15; padding-top:5; padding-bottom:5; border-top:1 dotted #EEEEEE">Rockers who are in this course: <span class="STYLE2">James, Barmuya</span></td>
                        </tr>
                        <tr>
                          <td height="25" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:15; padding-top:5; padding-bottom:5; border-top:1 dotted #EEEEEE">Rockers who wanna the textbook: <span class="STYLE2">James</span></td>
                        </tr>
                        <tr>
                          <td height="25" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:15; padding-top:5; padding-bottom:15; border-top:1 dotted #EEEEEE">Rockers who have the textbook: <span class="STYLE2">Harvey</span> </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                </div></td>
              <td width="293" background="img/MeBayBridge.jpg" bgcolor="#EEEEEE" style="border-left: 0px solid #CCCCCC;">&nbsp;</td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
  <?php include("bottomMenu".$_SESSION['lan'].".php"); ?>
</body>
</html>