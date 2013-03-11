<?php
$image = imagecreatefrompng('upload/a4/1_100.png');
imagejpeg($image, 'upload/a4/1_100.jpg', 100);
imagedestroy($image);
?>