<?php
// Define array for storing artist name which exists leastly 50 lines
$array_gt50=array();
// Define array for storing each artist's occur times
$hash_artist_line=array();

$handle = @fopen("tmp/Artist_lists_small.txt", "r");
if ($handle) {
	$line_num = 1;
    while (($buffer = fgets($handle, 4096)) !== false) {
		$line_array = array();
		$current_line_array = array();
		$line_array = explode(",", $buffer);
		for($i=0;$i<count($line_array);$i++){
			if(in_array($line_array[$i],$current_line_array)) continue;
			else array_push($current_line_array,$line_array[$i]);

			if(!array_key_exists($line_array[$i],$hash_artist_line))
				$hash_artist_line[$line_array[$i]] = $line_num;
			else
				$hash_artist_line[$line_array[$i]] = $hash_artist_line[$line_array[$i]].",".$line_num;
			
			$tmp_arr = array();
			$tmp_arr = explode(",",$hash_artist_line[$line_array[$i]]);
			if(count($tmp_arr)==50){ 
				array_push($array_gt50,$line_array[$i]);
			}
		}
		$line_num++;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

// Loop and generate results
$seq=1;
echo("<strong>The result as below:</strong><br><br>");
for($j=0;$j<count($array_gt50);$j++){
	$tmp_arr_j = array();
	$tmp_j = $hash_artist_line[$array_gt50[$j]];
	$tmp_arr_j = explode(",",$tmp_j);

	for($k=$j+1;$k<(count($array_gt50)-$k);$k++){
		$overlap_num=0;
		$tmp_arr_k = array();
		$tmp_k = $hash_artist_line[$array_gt50[$k]];
		$tmp_arr_k = explode(",",$tmp_k);
		for($p=0;$p<count($tmp_arr_k);$p++){
			if($overlap_num>50){
				echo("<".$seq.">.".$array_gt50[$j].",".$array_gt50[$k]."<br>");
				$seq++;
				break;
			}
			
			if(in_array($tmp_arr_k[$p],$tmp_arr_j))
				$overlap_num++;
		}
	}
}
?>