<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo($uname) ?>, welcome home</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<?php
$news = mysql_query("SELECT count(*) as cnt FROM rockinus.news_info");
if(!$news)	die("Error quering the Database: " . mysql_error());
$news_f = mysql_fetch_object($news);
$news_cnt = $news_f->cnt;

$course_comment = mysql_query("SELECT count(*) as cnt FROM rockinus.course_memo_info");
if(!$course_comment)	die("Error quering the Database: " . mysql_error());
$course_comment_f = mysql_fetch_object($course_comment);
$course_comment_cnt = $course_comment_f->cnt;

$house = mysql_query("SELECT count(*) as cnt FROM rockinus.house_info");
if(!$house)	die("Error quering the Database: " . mysql_error());
$house_f = mysql_fetch_object($house);
$house_cnt = $house_f->cnt;

$article = mysql_query("SELECT count(*) as cnt FROM rockinus.article_info");
if(!$article)	die("Error quering the Database: " . mysql_error());
$article_f = mysql_fetch_object($article);
$article_cnt = $article_f->cnt;

$interview = mysql_query("SELECT count(*) as cnt FROM rockinus.interview_question");
if(!$interview)	die("Error quering the Database: " . mysql_error());
$interview_f = mysql_fetch_object($interview);
$interview_cnt = $interview_f->cnt;

$people = mysql_query("SELECT count(*) as cnt FROM rockinus.user_check_info WHERE status='A'");
if(!$people)	die("Error quering the Database: " . mysql_error());
$people_f = mysql_fetch_object($people);
$people_cnt = $people_f->cnt;
?>
<table width="250" cellspacing="0" cellpadding="0" style="border-right:0px dashed #999999">
  <tr>
    <td height="511" valign="top">
	<a href="HouseRental.php" class="two"><div style="margin-bottom:25; -moz-border-radius: 5px; border-radius: 5px; width:200px; height:35px; padding:5 0 5 0; background:#FF9966; font-size:24px; line-height:150%; border:1px solid #666666; color:#FFFFFF; cursor:pointer" align="center">
	  <img src="img/houseMenuIcon.jpg" width="20" /> House Rent</div></a>
  	  
	<table border="0" cellpadding="0" cellspacing="0" onmouseover="this.style.backgroundColor='#FFFFFF';" onmouseout=" this.style.backgroundColor='#FFFFFF';" style="margin-top:10">
        <tr>
          <td width="35" rowspan="2" style="border-bottom:0px #DDDDDD solid; padding-left:5px; padding-top:5px" valign="top">
		  <img src="img/colorBuyIcon.jpg" width="25" /></td>
          <td width="213" height="25" style="font-weight:normal; font-size:24px; border-bottom:0px #DDDDDD solid; padding-left:5px"><a href="FleaMarket.php" class="one">Sale & Buy</a> <font color="#999999" style='font-weight:normal; font-size:16px'><?php echo("($article_cnt)") ?></font> </td>
        </tr>
        <tr>
          <td height="40" valign="top" style="line-height:150%; font-weight: ; border-bottom:0px #DDDDDD solid; padding-left:5px; font-size:12px; color:"><table width="160" height="200" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="198" height="24" align="left" style="width:100px; padding-bottom:4; padding-top:4; font-size:12px; font-weight:bold; font-family:Arial, Helvetica, sans-serif">Search by Category</td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <a href="FleaMarket.php?type=All" class="one">All Types </a></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span id="electronicsBTN" class="button2" style="cursor:pointer">Electronics</span>
                    <div style="display:none" id="electronics">
                      <div style="margin-left:28px; margin-top:5px; font-size:12px"><a href="FleaMarket.php?aname=Laptop" class="one">Laptop</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Computer" class="one">Computer</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=PCaccessory" class="one">PC accessory</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Printer" class="one">Printer/Scaner</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Camera" class="one">Camera</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=AC" class="one">Air Conditioning</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Phone" class="one">Phone</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=TVscreen" class="one">TV Screen</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Playstation" class="one">Play Station</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Efan" class="one">Electronic Fan</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Heater" class="one">Heater</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Shaver" class="one">Beard shaver</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=MP3" class="one">MP3</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Light" class="one">Light/lamp</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Ereader" class="one">E-reader</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Microwave" class="one">Microwave</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Speaker" class="one">Speaker</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Lmachine" class="one">Laundry Machine</a></div>
                      <div style="margin-left:28px; font-size:12px; margin-bottom:10px">
					  <a href="FleaMarket.php?type=Electronics&amp;&amp;aname=Others" class="one">Others</a></div>
                </div></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span class="STYLE25 STYLE83"><a href="FleaMarket.php?type=Books" class="one">Books</a></span></span></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span id="furnitureBTN" class="button2" style="cursor:pointer">Furniture</span>
                    <div style="display:none" id="furniture">
                      <div style="margin-left:28px; margin-top:5px; font-size:12px"><a href="FleaMarket.php?aname=Mattress" class="one">Mattress</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Bedstead" class="one">Bedstead</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Closet" class="one">Closet</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Table" class="one">Dining table</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Chairs" class="one">Chairs</a></div>
                      <div style="margin-left:28px;; font-size:12px; margin-bottom:10px"><a href="FleaMarket.php?type=Furniture&amp;&amp;aname=Others" class="one">Others</a></div>
                </div></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span id="costumeBTN" class="button2" style="cursor:pointer">Costume</span>
                    <div style="display:none" id="costume">
                      <div style="margin-left:28px; margin-top:5px; font-size:12px"><a href="FleaMarket.php?aname=Clothes" class="one">Clothes</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Pants" class="one">Pants</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Shorts" class="one">Shorts</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Caps" class="one">Cap/hat</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Shoes" class="one">Shoes</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Shirts" class="one">Shirts</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Bags" class="one">Bags</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Suits" class="one">Suits</a></div>
                      <div style="margin-left:28px; margin-bottom:10px; font-size:12px">
					  <a href="FleaMarket.php?type=costume&amp;&amp;aname=Others" class="one">Others</a>					  </div>
                </div></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span id="transportationBTN" class="button2" style="cursor:pointer">Transportation</span>
                    <div style="display:none" id="transportation">
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Car" class="one">Car</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Bike" class="one">Bike</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Skating shoes" class="one">Skating shoes</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Skate board" class="one">Skate board</a></div>
                      <div style="margin-left:28px; margin-bottom:10px; font-size:12px"><a href="FleaMarket.php?type=transportation&amp;&amp;aname=Others" class="one">Others</a></div>
                </div></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span id="CosmeticsBTN" class="button2" style="cursor:pointer">Cosmetics</span>
                    <div style="display:none" id="Cosmetics">
                      <div style="margin-left:28px; margin-top:5px; font-size:12px"><a href="FleaMarket.php?aname=Shower Gel" class="one">Shower Gel</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Shampoo" class="one">Shampoo</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Perfume" class="one">Perfume</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Face Gel" class="one">Face Gel</a></div>
                      <div style="margin-left:28px; margin-bottom:10p; font-size:12pxx"><a href="FleaMarket.php?type=Cosmetics&amp;&amp;aname=Heater" class="one">Others</a></div>
                </div></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span id="InstrumentsBTN" class="button2" style="cursor:pointer">Instruments</span>
                    <div style="display:none" id="instrument">
                      <div style="margin-left:28px; margin-top:5px; font-size:12px"><a href="FleaMarket.php?aname=Guitar" class="one">Guitar</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Drum" class="one">Drum</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Voilin" class="one">Voilin</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Bass" class="one">Bass</a></div>
                      <div style="margin-left:28px; margin-bottom:10px; font-size:12px"><a href="FleaMarket.php?type=Instruments&amp;&amp;aname=Others" class="one">Others</a></div>
                </div></td>
              </tr>
              <tr>
                <td height="10" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span id="cardTixBTN" class="button2" style="cursor:pointer">Cards&amp;Tix </span>
                    <div style="display:none" id="cardTix">
                      <div style="margin-left:28px; margin-top:5px; font-size:12px"><a href="FleaMarket.php?aname=Metro Cards" class="one">Metro Cards</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Live Show tickets" class="one">Live Show tickets</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=NBA tickets" class="one">NBA tickets</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Soccer tickets" class="one">Soccer tickets</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Movie tickets" class="one">Movie tickets</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Shopping Coupon" class="one">Shopping Coupon</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?aname=Food Coupon" class="one">Food Coupon</a></div>
                      <div style="margin-left:28px; font-size:12px"><a href="FleaMarket.php?type=cardTix&amp;&amp;aname=Others" class="one">Others</a></div>
                </div></td>
              </tr>
            </table>
              <script>
$("#electronicsBTN").click(function () {  
	$("#electronics").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#furnitureBTN").click(function () {  
	$("#furniture").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#costumeBTN").click(function () {  
	$("#costume").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#transportationBTN").click(function () {  
	$("#transportation").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#CosmeticsBTN").click(function () {  
	$("#Cosmetics").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#InstrumentsBTN").click(function () {  
	$("#Instruments").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#cardTixBTN").click(function () {  
	$("#cardTix").first().show("fast", function showNext() {    
		$(this).next("div").show("fast", showNext);  
	});
});

$("#hidr").click(function () {  
	$("div").hide(1000);}
);
        </script>
              
              <table width="160" height="150" border="0" cellpadding="0" cellspacing="0" style="margin-top:5; margin-bottom:10">
                <tr>
                  <td width="200" height="24" style=" font-size:12px; padding-bottom:4; padding-top:4; font-weight:bold; font-family:Arial, Helvetica, sans-serif">Searh by Location</td>
                </tr>
                <tr>
                  <td height="15" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <a href="FleaMarket.php?city=All" class="one">All Cities </a></td>
                </tr>
                <tr>
                  <td height="15" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span class="STYLE25 STYLE83"><a href="FleaMarket.php?city=Brooklyn" class="one">Brooklyn</a></span></span></td>
                </tr>
                <tr>
                  <td height="15" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span class="STYLE25 STYLE83"><a href="FleaMarket.php?city=Manhattan" class="one">Manhattan</a></span></span></td>
                </tr>
                <tr>
                  <td height="15" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <span class="STYLE25 STYLE83"><a href="FleaMarket.php?city=Queens" class="one">Queens</a></span></span></td>
                </tr>
                <tr>
                  <td height="15" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <a href="FleaMarket.php?city=Bronx" class="one">Bronx </a></span></td>
                </tr>
                <tr>
                  <td height="15" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <a href="FleaMarket.php?city=Long Island" class="one">Long Island</a> </span></td>
                </tr>
                <tr>
                  <td height="15" style="padding-top:0; font-size:14px;"><strong>&middot;</strong>&nbsp;&nbsp; <a href="FleaMarket.php?type=Others" class="one">Others</a></span></td>
                </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
