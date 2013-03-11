
<?php
 setcookie("user", "Alex Porter", time()+3600);
?>

<?php
 // Print a cookie
 echo $_COOKIE["user"].'<br>';
 
// A way to view all cookies
 print_r($_COOKIE);
 ?> 
 
 <?php
 if (isset($_COOKIE["user"]))
   echo "Welcome " . $_COOKIE["user"] . "!<br />";
 else
   echo "Welcome guest!<br />";
 ?>
 
 
<html>
 <body>
 
<form action="welcome.php" method="post">
 Name: <input type="text" name="name" />
 Age: <input type="text" name="age" />
 <input type="submit" />
 </form>
 
</body>
 </html> 