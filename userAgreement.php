<?php
session_start();
header("Content-Type: text/html; charset=gb2312");
include 'dbconnect.php';
if(isset($_SESSION['usrname'])){
$q1 = mysql_query("SELECT * FROM rockinus.user_setting where uname='$uname'");
if(!$q1) die(mysql_error());
$object = mysql_fetch_object($q1);
$_SESSION['hcolor'] = $object->hcolor;
$_SESSION['lan'] = $object->lan;
$hcolor = $_SESSION['hcolor'];
$lan = $_SESSION['lan'];
	header("location:ThingsRock.php");
}
$uname = "Login";

$_SESSION['lan'] = "#336633";
?>
<LINK REL="SHORTCUT ICON" HREF="img/rockinTag.jpg">
<title>NYU-Poly's Local Social Network - Rockinus</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style type="text/css">
.bg1 { background-color: #6c0000; }
.bg2 { background-color: #5A2A00; }
.bg3 { background-color: #00345B; }
ul.switchcolor {
	margin: 0;
	padding: 0;
	height: 33px;
	line-height: 33px;
	border:0px #CCCCCC dotted
}

ul.switchcolor a {
	text-decoration: none;
	color: #B82929;
	display: block;
	padding: 0 20px;
	outline: none;
}
ul a:hover {
	background:;
}	

html ul.tabs li.active, html ul.tabs li.active a:hover  {
	background: #09F;
	border-bottom: 0px solid #fff;
}

p { 
font-size:100%; cursor:pointer; line-height: 300% }

.capfontClass {
	font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;
   color:  #999999;
}  

.capfontClass A {color: #666666; font-size: 9px;}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<div id="othercontent" style="margin-bottom: 0px; margin-top: 0px; margin-left:0;" align="center">
<?php 
$q_user = mysql_query("SELECT * FROM rockinus.user_info;");
if(!$q_user) die(mysql_error());
$no_row_user = mysql_num_rows($q_user);

$q_house = mysql_query("SELECT * FROM rockinus.house_info WHERE rentlease='lease';");
if(!$q_house) die(mysql_error());
$no_row_house = mysql_num_rows($q_house);

$q_article = mysql_query("SELECT * FROM rockinus.article_info;");
if(!$q_article) die(mysql_error());
$no_row_article = mysql_num_rows($q_article);

$q_job = mysql_query("SELECT * FROM rockinus.job_info;");
if(!$q_job) die(mysql_error());
$no_row_job = mysql_num_rows($q_job);

$q_file = mysql_query("SELECT * FROM rockinus.user_file_info;");
if(!$q_file) die(mysql_error());
$no_row_file = mysql_num_rows($q_file);

$q_course_memo = mysql_query("SELECT * FROM rockinus.course_memo_info;");
if(!$q_course_memo) die(mysql_error());
$no_row_course_memo = mysql_num_rows($q_course_memo);

$q_friend = mysql_query("SELECT * FROM rockinus.rocker_rel_info;");
if(!$q_friend) die(mysql_error());
$no_row_friend = mysql_num_rows($q_friend);

$q_course = mysql_query("SELECT * FROM rockinus.unique_course_info;");
if(!$q_course) die(mysql_error());
$no_row_course = mysql_num_rows($q_course);

$q_major = mysql_query("SELECT * FROM rockinus.major_info;");
if(!$q_major) die(mysql_error());
$no_row_major = mysql_num_rows($q_major);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>NYU-Poly's Local Social Network</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
span.error{
	font-size:14px;
	display:inline;
	color: #B92828;
}
-->
</style>
<link type="text/css" href="style/PasswordStyle.css" rel="stylesheet" />
<script type="text/javascript" src="js/mocha.js"></script>
<script src="autoSubmit.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
</head>
<body>
<?php 
	if(isset($_SESSION['uname']))$uname = $_SESSION['uname']; 
	if(isset($_SESSION['uname_tag'])) $uname_tag = $_SESSION['uname_tag']; else $uname_tag="";
	if(isset($_SESSION['rid'])) {$rid = $_SESSION['rid']; unset($_SESSION['rid']); }else $rid="";
?>
<div align="center">
<?php include("main_header.php") ?>
  <div style=" background-color:; border-top:0px #333333 solid; border-bottom:0px #666666 dashed; width:100%" class="IntroDiv" id="IntroDiv">
    <table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="320" align="left" valign="top" style="padding-left:5; padding-bottom:10; padding-top:10; font-size:24px; font-weight:bold; color:">
			<img src="img/rockinus_new.jpg">
			<div style="font-size:20px; margin-top:40; margin-bottom:30">Introduction >></div>
            <div align="left" style=" width:230; margin-bottom:40; font-size:14px; font-weight:normal; font-family:Arial, Helvetica, sans-serif; line-height:150%; padding:0px; color:;">Rockinus is an open, free, school-based social network for students who study, wish to study, or graduated in Polytechnic Institute of NYU. You can post house rentals, sales, course comments, upload course files, look for jobs, etc. Also, it is an exciting place to find new friends, exchange topics with other students as well. We hope you enjoy this network :)</div>            <div style="font-size:14px"> <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 0px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="commentUs.php" class="one"><a href="NewFreeAboutUs.php" class="one"><strong>About Us</strong></a></span> &nbsp; <span align="center" style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; margin-top: 00px; display:inline; margin-bottom:5px; background: #FFFFFF; border:2 solid #666666; height:25;"><a href="commentUs.php" class="one"><strong>Comments</strong></a></span></div></td>
            <td width="680" align="right" style="padding-top:20" valign="top">
			<table width="720" border="0" cellspacing="0" cellpadding="0" style="border:1px #DDDDDD solid; background-color:#F5F5F5">
              <tr>
                <td height="35" align="left" valign="middle" background="img/master.png" bgcolor="#EEEEEE" style=" border-bottom:1px solid #CCCCCC; line-height:150%; padding-left:15; font-size:16px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif">
				Website User Agreement</td>
			  </tr>
				<tr>
                <td align="left" valign="top" style="line-height:150%; padding:15; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif">
                  Covers Terms of Use, Disclaimer Statement, Limitation of Liability,
                  Endorsements, Content Usage Policy, Logo, Linking websites to Rockinus Social Network,
                  Rockinus Social Network website linking to external websites, Privacy Policy Statement.
                  See also Legal and Copyright Notice, and Privacy Policy.<br><br>
                  This is the website of Rockinus Social Network Group (��Rockinus Social Network��). <br>
				  Furthermore, ��Rockinus�� refers to our product(s).<br>
                  We can be contacted at:<br>
                  Rockinus Social Network Group <br>
                  Phone: +1 347-610-8875<br>
                  Email: admin@rockinus.com<br><br>
                  <strong>Terms of Use</strong><br><br>
                  This website with its home page in the domain www.rockinus.com (the
                  &quot;Website&quot;) is a complimentary information service offered by Rockinus Social Network Group
                  (&quot;Rockinus Social Network&quot;) at no charge to users of the World Wide Web, with the express
                  condition that these users agree to be bound by the terms and conditions set
                  forth in this User Agreement.
                  Rockinus Social Network reserves the right to change these terms and conditions at any time
                  and you must consult the most recent version of this User Agreement (not an
                  older cached version) each time you view the Website.
                  Use of this Website constitutes your acceptance of all of the following terms and
                  conditions.
                  The Rockinus Social Network website is for informational purposes only and is not meant to
                  serve as technical advice or to replace consultation with Rockinus Social Network or an
                  accredited Rockinus dealer. You acknowledge that the information on the
                  Website is provided &quot;as is&quot; for general information only.
                  <br><br><strong>Limitation of Liability</strong><br><br>
                  You agree that you will hold harmless Rockinus Social Network and its officers, directors,
                  employees, and volunteers from all claims arising out of or related to your access
                  or use of, or your inability to access or use, this Website or the information
                  contained in this Website or other websites to which it is linked. This includes, but
                  is not limited to, information or materials viewed or downloaded from this Website
                  Website User Agreement Rockinus Social Network_090828.doc 2
                  or another website to which it is linked that appear to you or are construed by you
                  to be obscene, offensive, defamatory, or that infringe upon your intellectual
                  property rights.
                  In no event will Rockinus Social Network or the contributors of information to this website be
                  liable to you or anyone else for any decision made or action taken by you in
                  reliance on such information or for any consequential, special or similar
                  damages, even if advised of the possibility of such damages.
                  <br><br><strong>Endorsements</strong><br><br>
                  You acknowledge that the opinions and recommendations contained in this
                  Website are not necessarily those of Rockinus Social Network or endorsed by Rockinus Social Network.
                  Rockinus Social Network may provide links on the Website to other websites, which are not
                  under the control of Rockinus Social Network. In general, any website which has an address
                  (or URL) which does not contain &quot; Rockinus Social Network &quot; is such a website. These links
                  are provided for convenience of reference only and are not intended as an
                  endorsement by Rockinus Social Network of the organisation or individual operating the
                  website or a warranty of any type regarding the website or the information on the
                  website.<br>
                  <br><strong>Content Usage Policy</strong><br><br>
                  Unless otherwise indicated, all information contained on our website or in written
                  form including but not limited to text, graphics, logos, button icons, video or audio
                  clips is copyrighted by and proprietary to Rockinus Social Network Group (��Rockinus Social Network��) and
                  may not be copied, reproduced, transmitted, displayed, performed, distributed,
                  sublicensed, altered, stored for subsequent use or otherwise used in whole or in
                  part any manner without Rockinus Social Network��s prior written consent.<br><br>
                  The exception to this is that the user may make such temporary copies in a
                  single computer's RAM and hard drive cache as are necessary to browse the
                  website, and the user may make one permanent copy of each page of the
                  website, brochure or booklet to be used by the user for personal and
                  non-commercial uses which do not harm the reputation of Rockinus Social Network.
                  Once written consent is given in the form of a signed permission agreement, the
                  following restrictions apply:<br><br>
                  1. The content may only be used for informational purposes or for promotion
                  of Rockinus product.<br><br>
                  2. The content may not be further modified in any way, other than as
                  described in #3, next.<br><br>
                  3. Any copy of content or portion thereof must include the Rockinus Social Network Group
                  cite line as &quot;copyrighted and published by Rockinus Social Network Group, no part of this
                  document may be reproduced without written consent&quot;<br><br>
                  4. Rockinus Social Network Group has the right to revoke any authorisation at any time,
                  and any such use must be discontinued upon notice from Rockinus Social Network.<br>
                  <br><strong>Logo</strong><br><br>
                  This logo is the registered trade mark of Rockinus Social Network Group.
                  A logo for authorised Rockinus Dealers is available to suitably qualified
                  organisations on request.<br>
                  See &quot;Linking websites to Rockinus Social Network &quot; next for more details.
                  Linking websites to Rockinus Social Network
                  Rockinus Social Network may grant the owner of an approved website permission to use a
                  hyper-text link on his or her web site, provided:<br><br>
                  1. Any text-only link must clearly be marked &quot; Rockinus Social Network Group&quot;;<br><br>
                  2. The appearance, position and other aspects of either the link or the host
                  website may not be such as to damage or dilute the goodwill associated
                  with Rockinus Social Network 's name and trade marks;<br><br>
                  3. The appearance, position and other aspects of either the link or the host
                  website may not create the false appearance that an entity other than
                  Rockinus Social Network is associated with or sponsored by Rockinus Social Network;<br><br>
                  4. The link, when activated by a user, must display this Website full-screen
                  and not with a &quot;frame&quot; on the linked website. Rockinus Social Network Group considers
                  framing, the practice of intact reproduction of a page or pages of one
                  website to another website, to be deceptive and a violation of the
                  Rockinus Social Network Group's copyright rights. No authorization or permission is given
                  for framing our content, whether in whole or in part;<br><br>
                  5. Rockinus Social Network reserves the right to revoke its consent to the link at any time.
                  in its sole discretion by amending this User Agreement; and<br><br>
                  6. Rockinus Social Network reserves the right to require a reciprocal link to the linking
                  site.<br><br>
                  Further, if you have any questions, or have a proposed use that is not in strict
                  conformance with these policies, please contact our site administrator who will
                  forward the message to the appropriate person.<br><br>
                  The Rockinus Social Network linking logo (the 'Logo') provided above may only be used as a
                  link to Rockinus Social Network��s homepage and for no other purpose. It may not link to other
                  pages on your Website, or to a third party Website.<br><br>
                  You agree and acknowledge that this is not a 'trade mark license' by which you
                  are in any way using the Logo to indicate origin of any product or service you
                  offer.<br><br>
                  You agree not to alter the Logo in any manner, including proportions, colours,
                  elements, etc., or animate, morph or otherwise distort its perspective or twodimensional
                  appearance.<br><br>
                  You agree not to use the Logo on any site that disparages Rockinus Social Network or its
                  Rockinus (&amp; other) products or services, infringes on Rockinus Social Network intellectual
                  property or other rights, or violates any state, federal or international law.
                  Your use of the Logo must be truthful and not misleading.<br><br>
                  You agree not to use the Logo to imply any relationship with, or endorsement or
                  sponsorship by Rockinus Social Network that is not true.<br><br>
                  You agree not to display the Logo in a manner which displays it in a negative
                  light, disparages it, or uses it in connection with immoral materials or any other
                  way that detracts from the good taste represented by Rockinus Social Network.<br><br>
                  You agree not to use the Logo as a predominant feature on your Website. This
                  means (at a minimum) that it must appear smaller than your Web page title and
                  your company logo, it may not be displayed larger or more prominently than
                  other company logos on your page, and it should not appear at the top of the
                  page, but rather at the bottom, along the sides, or in some location less
                  prominent than the top.<br><br>
                  You agree to display the Logo by itself.<br><br>
                  You agree not to use the Logo as a feature or design element of any other logo
                  or any other name or trade mark. However, subject to these conditions of use,
                  other company logos may appear on the same Web page.<br><br>
                  Unless required to use more specific trade mark attribution language by any
                  license or agreement you may have from Rockinus Social Network, you agree to use the
                  following language on the page where the Logo appears or where there are other
                  legal notices: Rockinus, Rockinus Social Network and the Rockinus Social Network stylised logo are
                  trade marks or registered trade marks of Rockinus Social Network Group.<br><br>
                  Rockinus Social Network reserves the right to approve or disapprove the use of the Logo on
                  your Web page (size, surrounding text, etc.) to ensure that it complies with these
                  policies.<br><br>
                  
                  You agree and acknowledge Rockinus Social Network rights in the Logo and agree not to
                  adopt, use, register, or attempt to register anywhere in the world any logo or
                  trade mark confusingly similar to the Logo. You agree that you will not at any
                  time do or cause to be done, or fail to do or cause to be done, any act or thing,
                  directly or indirectly, contesting or in any way impairing Rockinus Social Network right, title
                  or interest in the Logo.<br><br>
                  You agree that use of the Logo shall inure to the benefit of Rockinus Social Network. If you
                  happen to obtain rights in the Logo, you agree to give such rights back to
                  Rockinus Social Network. Rockinus Social Network Group DISCLAIMS ANY WARRANTIES THAT MAY
                  BE EXPRESS OR IMPLIED BY LAW REGARDING THE LOGOS, INCLUDING
                  WARRANTIES AGAINST INFRINGEMENT. YOU AGREE TO INDEMNIFY
                  Rockinus Social Network Group FROM AND AGAINST ALL CLAIMS AND LIABILITIES
                  ARISING OUT OF YOUR USE OF THE LOGO.<br><br>
                  Rockinus Social Network reserves the right in its sole discretion to modify or terminate
                  permission to use the Logo at any time. Rockinus Social Network reserves the right to take
                  action against any use that does not conform with the terms of this Agreement,
                  infringes any Rockinus Social Network intellectual property or other right, or violates other
                  applicable law.<br><br>
                  Rockinus Social Network website linking to external websites
                  Rockinus Social Network is not responsible for the information or materials contained on the
                  host website. Links to external websites are provided for convenience of
                  reference only and are not intended as an endorsement by Rockinus Social Network of the
                  organisation or individual operating the host website or a warranty of any type
                  regarding the host website or the information on the host website.<br><br>
                  <strong>Privacy Policy Statement</strong><br><br>
                  For each visitor to our Web page, our Web server automatically recognises the
                  consumer's domain name, aggregate information on what pages consumers
                  access or visit, information volunteered by the consumer, such as survey
                  information, e-mail addresses and/or site registrations. We automatically collect
                  only the domain name. If you do not want to receive e-mail from us in the future,
                  please let us know by writing to us at the address below.<br><br>
                  If you supply us with your postal address on-line you will only receive the
                  information for which you provided us your address. Persons who supply us with
                  their telephone numbers on-line will only receive telephone contact from us with
                  information regarding orders they have placed on-line. The information we collect
                  Website User Agreement Rockinus Social Network
                  is used for marketing purposes, internal review, and to improve the content of our
                  Web page, but is not shared with other organisations for commercial purposes.<br><br>
                  Cookies: We do not use cookies on the general public area of the website. We
                  do use cookies on the operational and administrative functions of the site, and
                  also use cookies to remember login details when authorised users login to
                  Rockinus Social Network support login.<br><br>
                  Ad Servers: We do not partner with or have special relationships with any ad
                  server companies.<br><br>
                  If our information practices change at some time in the future, we will post the
                  policy changes to our Website to notify you of these changes and provide you
                  with the ability to opt out of these new uses. If you are concerned about how your
                  information is used, you should check back at our Website periodically. Upon
                  request, we provide site visitors with access to contact information (e.g., name,
                  address, phone number) that we maintain about them and users have the right to
                  opt out of having their information collected. Consumers can do this by writing to
                  us at the address below.<br><br>
                  With respect to security, at present we do not transfer and receive certain types
                  of sensitive information such as financial information. When in future we do so,
                  we will redirect visitors to a secure server and will notify visitors through a pop-up
                screen on our site.</td>
              </tr>
            </table></td>
          </tr>
    </table>
  </div>
  
  <br>
<br>
<?php include("bottomMenuEN_login.php"); ?>
</div>
</body>
</html>
