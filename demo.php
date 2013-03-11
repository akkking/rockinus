<?php
function addHyperLink($string)
{
	$patterns = array();
	$replacements = array();
	$matches = array();
	preg_match('/[a-zA-Z]+:\/\/[0-9a-zA-Z;.\/?:@=_#&%~,+$]+/', $string, $matches);
	for($i=0;$i<count($matches);$i++){
		$patterns[$i] = str_replace("/", "\/", $matches[$i]);
		$patterns[$i] = str_replace("?", "\?", $patterns[$i]);
  		$patterns[$i] = "/".$patterns[$i]."/";
		$replacements[$i] = "<a href='".$matches[$i]."'>".$matches[$i]."</a>";
	}
	return preg_replace($patterns, $replacements, $string);
}

echo addHyperLink("http://www.youtube.com/watch?v=7N5OhNplEd4# This video is freakingly interesting! ");
//echo preg_replace("/\/www.youtube/", "<a href='aaa'>abc</a>", "http://www.youtube.com/watch?v=7N5OhNplEd4 This video is freakingly interesting! ");
?>
<font style=" text-decoration: line-through">aaaaaa</font>