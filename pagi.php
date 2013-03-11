<?php
include('dbconnect.php');
 $per_page = 3; 
//Calculating no of pages
 $sql = "select * from rockinus.user_info";
 $result = mysql_query($sql);
 $count = mysql_num_rows($result);
 $pages = ceil($count/$per_page)
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript" src="jquery_pagination.js"></script>
<div id="loading" ></div>
<div id="content" ></div>
<ul id="pagination">
<?php
//Pagination Numbers
for($i=1; $i<=$pages; $i++){
 echo '<li id="'.$i.'">'.$i.'</li>';
}
?>
</ul>