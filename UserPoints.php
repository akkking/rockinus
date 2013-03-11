      <br><br><div class="recordBoardDiv" id="recordBoardDiv" style="display:; width:625px;">
        <table width="625" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD; margin-bottom:30; margin-top:10">
          <tr>
            <td width="625"><table width="625" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:10; border-bottom:1px solid #DDDDDD; background:">
              <tr>
                <td width="353" align="left" valign="middle" style="padding-left:10; font-weight:normal; color:<?php echo($_SESSION['hcolor']) ?>; font-size:22px; ">
				<img src="img/award_star.png" width="20"> &nbsp;Your current score: <?php echo($total_point) ?>&nbsp;</td>
                <td width="267" align="right" valign="middle" style="padding-right:10; font-size:13px">
				Score by each section
				</td>
              </tr>
            </table>
            <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10; ">Profile Completeness </td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($wid) ?>%</td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Times of headicon uploaded </td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_headicon) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Friend number</td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_friend) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Number of users who visited your page </td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_visit_user) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Times visited by other user </td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_visit_times) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:18px;padding-left:10">Interview questions posted </td>
                  <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_interview_question) ?></td>
                </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:18px;padding-left:10">Interview question solutions provided </td>
                  <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_interview_question_follow) ?></td>
                </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Course comments posted </td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_course_memo) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Course questions posted </td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_course_question) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Subscribed courses  </td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_course_subs) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Notice posts</td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_news) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">House posts</td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_house) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Sale posts</td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_article) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Status posts</td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_memo) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Message sent</td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_message) ?></td>
                  </tr>
              </table>
              <table width="625" height="30" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:18px;padding-left:10">Login times</td>
                    <td width="109" style="font-size:18px;padding-right:15; " align="right"><?php echo($total_login_times) ?></td>
                  </tr>
              </table>
              <table width="625" height="35" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="426" style="font-size:18px;padding-left:10; font-weight:bold">Total Points </td>
                    <td width="194" style="font-size:18px; ; font-weight:bold; color:<?php echo($_SESSION['hcolor']) ?>; padding-right:10; ; padding-top:5" align="right"><em><?php echo($total_point) ?></em></td>
                  </tr>
              </table></td>
          </tr>
        </table>
    </div>
	
	
      <div id="recordRuleDiv" class="recordRuleDiv" style="width:625px; display:; background:">
        <table width="625" height="110" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #DDDDDD; margin-bottom:20">
          <tr>
            <td valign="top"><table width="625" height="50" border="0" cellpadding="0" cellspacing="0" bgcolor="#F5F5F5" style="margin-bottom:0; border-bottom:1px solid #DDDDDD">
                <tr>
                  <td align="left" valign="middle" style="padding-left:10; font-weight:normal; color:<?php echo($_SESSION['hcolor']) ?>; font-size:22px; ">
				  <img src="img/edit-rule.png" width="15"> &nbsp;Points Rule</td>
                </tr>
              </table>
                <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-top:10">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Profile(&lt;50%, &gt;50%, &gt;85%)</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 2, 5, 10 </td>
                  </tr>
                </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10"> Have an head icon</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15</td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10"> Head Icon Like</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5</td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Friend</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Visited by others </td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 2 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:12px; ; padding-left:10">Interview Question </td>
                  <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 25 </td>
                </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                <tr>
                  <td width="241" style="font-size:12px; ; padding-left:10">Interv. question solution </td>
                  <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 25 </td>
                </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Course comment</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Course Question</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 20 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Subscribed course</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Notice post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">House post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15</td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Sale post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 15 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Status post</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Message sent</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 5 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:0px solid #EEEEEE; margin-bottom:0">
                  <tr>
                    <td width="241" style="font-size:12px; ; padding-left:10">Login</td>
                    <td width="109" style="font-size:12px; ; padding-right:10; font-family:Arial, Helvetica, sans-serif" align="right">+ 2 </td>
                  </tr>
              </table>
              <table width="625" height="25" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #EEEEEE; margin-top:10">
                  <tr>
                    <td style="font-size:11px; ; padding:10; line-height:140%; background-color:#EEEEEE">100 points for 1 star <br />
                      5 stars for 1 diamond<br />
                      Higher level means : <br />
                      Better&amp;Extra service, more exciting things </td>
                  </tr>
              </table></td>
          </tr>
        </table>
      </div>