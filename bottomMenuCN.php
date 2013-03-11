<div align="center" style="background-image:url(<?php if(isset($_SESSION['topi']))echo("img/".$_SESSION['topi'].".jpg")?>); background-color: <?php if($_SESSION['topi']=='slashopi'||!isset($_SESSION['topi']))echo("#EEEEEE")?> ; height: 10%;">
<?php if(isset($_SESSION['usrname'])){ ?>
<div style="padding-bottom:7px; padding-top:7px; background-color:<?php echo($_SESSION['hcolor']) ?>"></div>
<?php }?>
   <div style="margin-top:0px; width:1010px; border-top:1px #CCCCCC dotted; padding-top:15px; background-color:#; width:1024px">
   <a class="one" href="rockinus_intro.php">关于我们</a> &nbsp;|&nbsp; 工作机会 &nbsp;|&nbsp; 广告合作&nbsp; |&nbsp; 留言我们
   </div>
   <div style="padding-top:10px; padding-bottom:15px; background-color:#; width:1024px">
	  版权所有 &copy; 2012 Rockinus 社区网络 | 纽约
	  </div>
</div>