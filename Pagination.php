<?php
//Global Variable: 
$page_name = "Pagination.php";

//REMEMBER TO CONNECT TO DATABASE!
include 'dbconnect.php';
 
//**EDIT TO YOUR TABLE NAME, ETC.
$q = "SELECT count(*) as cnt FROM rockinus.user_info ORDER BY uname DESC";
$t = mysql_query($q);
if(!$t){
	die("Error quering the Database: " . mysql_error());
}
 
$a = mysql_fetch_object($t);
$total_items = $a->cnt;
//echo "Total Number of records in Database: ".$total_items;
//echo "<br/>";
$limit= (isset($_GET["limit"])) ? $_GET["limit"] : 3;
$page= (isset($_GET["page"]))? $_GET["page"] : 1;
//echo "This is Page Number: " . $page . "<br/>";
//echo "Current Limit: ". $limit. "<br/>";
//Set defaults if: $limit is empty, non numerical,
//less than 10, greater than 50
if((!$limit) || (is_numeric($limit) == false)|| ($limit < 3) || ($limit > 50)) {
	$limit = 1; //default
}
 
//Set defaults if: $page is empty, non numerical,
//less than zero, greater than total available
if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items)) { 
	$page = 1; //default 
}
 
//calculate total pages
$total_pages = ceil($total_items / $limit);
$set_limit = ($page * $limit) - $limit;
//echo "Total Pages: $total_pages <br/>";

//prev. page
$prev_page = $page - 1;

if($prev_page >= 1) { 
	echo("<b><<</b> <a href=$page_name?limit=$limit&page=$prev_page><b>Prev.</b></a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo("<b> $a</b> | "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a> $a </a> | ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("<a href=$page_name?limit=$limit&page=$next_page><b>Next</b></a> > >");
}
?>
<br /><br />
<table width=880>
		<tr style=" font-weight:600">
			<td><div style="background:; padding-bottom:4; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; border:0 #CCCCCC solid; width: 30">Rocker</div>
			<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:100'>First Name</td>
			<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:75'>Last Name</td>
			<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:50'>Gender</td>
			<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:200'>Email</td>
			<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:120'>Phone</td>
			<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:100'>Signup_date</td>
			<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:100'>Signup_time</td>
		</tr>
	  <?php
		//query: **EDIT TO YOUR TABLE NAME, ETC.
		$q = mysql_query("SELECT * FROM rockinus.user_info LIMIT $set_limit, $limit");
		if(!$q) die(mysql_error());
		$no_row = mysql_num_rows($q);
		if($no_row == 0) die("No matches met your criteria.");
		while($object = mysql_fetch_object($q)) {
			$uname = $object->uname;
			$fname = $object->fname;
			$lname = $object->lname;
			$gender = $object->gender;
			$email = $object->email;
			$phone = $object->phone;
			$signup_date = $object->signup_date;
			$signup_time = $object->signup_time;
			if($gender=='F'){
				$gender = "Female";
			}else{
				$gender = "Male";
			}
			echo "<tr><td style='padding-bottom:5; margin-left:0; margin-right:0; padding-top:2; padding-left:7; padding-right:0; width:75'>$uname</td>";
			echo "<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:75'>$fname</td>";
			echo "<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:75'>$lname</td>";
			echo "<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:50'>$gender</td>";
			echo "<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:200'>$email</td>";
			echo "<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:120'>$phone</td>";
			echo "<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:100'>$signup_date</td>";
			echo "<td style='padding-bottom:0; margin-left:0; margin-right:0; padding-top:2; padding-left:5; padding-right:0; width:100'>$signup_time</td>";
			echo "</tr>";
		}
		?>
</table><br />

<?php
//Results Per Page: Same as earlier one
//echo("<br/>Records Per Page:<a href=$page_name?limit=10&page=1>10</a> | <a href=$page_name?limit=25&page=1>25</a> | <a href=$page_name?limit=50&page=1>50</a><br/> ");

//prev. page
$prev_page = $page - 1;

if($prev_page >= 1) { 
	echo("<b><<</b> <a href=$page_name?limit=$limit&page=$prev_page><b>Prev.</b></a>");
}
 
//Display middle pages: 
for($a = 1; $a <= $total_pages; $a++){
if($a == $page) {
	echo("<b> $a</b> | "); //no link
}else{ 
	echo("<a href=$page_name?limit=$limit&page=$a> $a </a> | ");
	}
}
 
//Next page:
$next_page = $page + 1;
 
if($next_page <= $total_pages) {
	echo("<a href=$page_name?limit=$limit&page=$next_page><b>Next</b></a> > >");
}
//all done
?>
