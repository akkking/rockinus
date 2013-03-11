<?php
function getMutalFriends($uname_1,$uname_2){
	$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b 
			ON a.uname IN (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname_1'
						   UNION
						   SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname_1')
			AND
				a.uname IN (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname_2'
						   UNION
						   SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname_2')
			AND
				a.uname=b.uname
			ORDER BY b.signup_date DESC, b.signup_time DESC";
	$q = mysql_query($sql_stmt);
	if(!$q) die(mysql_error());
	$no_row = mysql_num_rows($q);
	if($no_row == 0) echo("");
	$i = 1;
	$array_mutal_friends=array();
	while($object = mysql_fetch_object($q)){
		$loopName = $object->uname;
		array_push($array_mutal_friends,$loopName);
	}
	return $array_mutal_friends;
}
?>

<?php				
$sql_stmt = "SELECT * FROM rockinus.user_info a 
			JOIN rockinus.user_check_info b 
			ON a.uname NOT IN (SELECT sender FROM rockinus.rocker_rel_info WHERE recipient = '$uname'
						   UNION
						   SELECT recipient FROM rockinus.rocker_rel_info WHERE sender = '$uname')
			AND
				a.uname=b.uname
			ORDER BY b.signup_date DESC, b.signup_time DESC";
$q = mysql_query($sql_stmt);
if(!$q) die(mysql_error());
$no_row = mysql_num_rows($q);
if($no_row == 0) echo("");
$i = 1;
while($object = mysql_fetch_object($q)){
	$loopName = $object->uname;
?>
