<div style="padding: 5 0 5 0px">
<ul id="menu">
  <li><a>+ Post New</a>
    <ul>
    <li><a href="postJob.php">Job Position</a></li>
    <li><a href="postInterviewQuestion.php">Interview Question</a></li>
    <li><a href="PostRental.php">House</a></li>
    <li><a href="PostFlea.php">Sales</a></li>
    <li><a href="createNews.php">Campus Notice</a></li>
    </ul>
  </li>
  <li><a>My Channels</a>
    <ul>
	<?php if($custom_eventnews=='Y'){?>
    <li onclick="toggle_on('eventnews','N', 'off', 'Campus Notice')"><a>Campus notice (on)</a></li>
	<?php }else{ ?>
    <li onclick="toggle_on('eventnews','Y', 'on', 'Campus Notice')"><a>Campus notice (Off)</a></li>
	<?php } ?>
    
	<?php if($custom_interviewQuestion=='Y'){?>
    <li onclick="toggle_on('interviewQuestion','N', 'off', 'Interview Question')"><a>Interview question (on)</a></li>
    <?php }else{ ?>
    <li onclick="toggle_on('interviewQuestion','Y', 'on', 'Interview Question')"><a>Interview question (off)</a></li>
    <?php } ?>
    
	<?php if($custom_jobReferral=='Y'){?>
    <li onclick="toggle_on('jobReferral', 'N', 'off', 'Job Referral')"><a>Job referral (on)</a></li>
    <?php }else{ ?>
    <li onclick="toggle_on('jobReferral', 'Y', 'on', 'Job Referral')"><a>Job referral (off)</a></li>
    <?php } ?>
    
	<?php if($custom_examQuestion=='Y'){?>
    <li onclick="toggle_on('examQuestion', 'N', 'off', 'Exam Question')"><a>Exam question (on)</a></li>
    <?php }else{ ?>
    <li onclick="toggle_on('examQuestion', 'Y', 'on', 'Exam Question')"><a>Exam question (off)</a></li>
    <?php } ?>
    
	<?php if($custom_ccomment=='Y'){?>
    <li onclick="toggle_on('ccomment', 'N', 'off', 'Course Comment')"><a>Course comment (on)</a></li>
    <?php }else{ ?>
    <li onclick="toggle_on('ccomment', 'Y', 'on', 'Course Comment')"><a>Course comment (off)</a></li>
    <?php } ?>
    
	<?php if($custom_house=='Y'){?>
    <li onclick="toggle_on('house', 'N', 'off', 'House Rentals')"><a>House rental (on)</a></li>
    <?php }else{ ?>
    <li onclick="toggle_on('house', 'Y', 'on', 'House Rentals')"><a>House rental (off)</a></li>
    <?php } ?>
    
	<?php if($custom_article=='Y'){?>
    <li onclick="toggle_on('article', 'N', 'off', 'Sales & Bargin')"><a>Sales bargin (on)</a></li>
    <?php }else{ ?>
    <li onclick="toggle_on('article', 'Y', 'on', 'Sales & Bargin')"><a>Sales bargin (off)</a></li>
    <?php } ?>
    
	<?php if($custom_features=='Y'){?>
    <li onclick="toggle_on('features', 'N', 'off', 'Site New Feauture')"><a>Site new feature (on)</a></li>
    <?php }else{ ?>
    <li onclick="toggle_on('features', 'Y', 'on', 'Site New Feauture')"><a>Site new feature (off)</a></li>
    <?php } ?>
    </ul>
  </li>
  <li><a href="UserPointsRock.php">Points(<?php echo($total_point) ?>)</a>
  </li>
  <li><a href="UserSetting.php">Settings</a>
  </li>
  <li><a href="EditUserInfo.php">My Profile</a>
  </li>
  <li><a href="newsList.php">My campus</a>
  </li>
</ul>
</div>