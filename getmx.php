<?php

	$arr_out = array();	

	function mx($arr_p, $m, $d, $pre,$n_max=3)
	{
		global $arr_out;
		global $obj;

		if(count($arr_p)==0) return ;

		$v = array_pop($arr_p);
		if ($v <=0 ) return;

		$n = min(ceil($m/$v),$n_max);
		for ($i = $n ; $i >0; $i--)
		{
			if( $i*$v <= $m+$d ){

				$pre1 = ($pre=="")?  $pre:$pre . " + ";

				$pre1 .= ($i>1)? "$v * $i": "$v";
			
				if ($i *$v >= $m) {
					$pre1 = ($obj->total + $i*$v -$m ) ." = " . $pre1;
					array_push($arr_out,$pre1);
				}else{
					mx($arr_p, $m- $i*$v,$d, $pre1,$n_max);
				}
			}
		}
		mx($arr_p, $m, $d, $pre,$n_max);
		return ;
	}

	$obj = json_decode(file_get_contents("php://input"));

	#$input = '{"total":20, "tolerance":0,"price_array":[2,6,4,5,4,3],"item_max":3}';
	#$obj = json_decode($input);

	$arr_price = $obj->price_array;
	$arr_price = array_unique($arr_price);
	sort($arr_price); 
	

	mx($arr_price, $obj->total,$obj->tolerance,"",$obj->item_max);
	header('Content-Type:application/json');
	echo json_encode($arr_out);

?>

