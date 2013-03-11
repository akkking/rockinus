<html>
<head></head>
<body>
<img src="img/DarkSky.jpg">
<?php
   include('SimpleImage.php');
   $image1 = new SimpleImage();
   $image1->load('img\DarkSky.jpg');
   $image1->resize(250,400);
   $image1->save('img\Demo1.jpg');
?>
<img src="img/Demo1.jpg">
<?php
   $image2 = new SimpleImage();
   $image2->load('img\DarkSky.jpg');
   $image2->resizeToWidth(90);
   $image2->save('img\Demo2.jpg');
?>
<img src="img/Demo2.jpg">
</body>
</html>