<?php  //P07 펫샵화면 정보탭 (스타일3개출력은 shop-detail-style에서) 


include "./lib/common_rest.php";

?>


<?

$str = "평일^11:00^20:00||금요일(대체공휴일)^11:00^20:30||주말^11:00^20:30||공휴일^11:00^20:30||";

exDate($str);
function exDate($dt){

	$result = array();
	$tmp1 = explode("||",$dt); //평일^11:00^20:00   금요일(대체공휴일)^11:00^20:30   주말^11:00^20:30   공휴일^11:00^20:30   

	foreach($tmp1 as $val){
echo $val;
	//if( $val == "") continue; //추가

	$tmp2 = explode("^",$val);//0평일 1 11:00  2 20:00
	//echo $tmp2[0];
	$item = array();
	$item["day"] = $tmp2[0];
	$item["time"] = $tmp2[1]."~".$tmp2[2];

	$result[] = $item;

	}

return $result;
echo'ssa';
echo json_encode($result, JSON_UNESCAPED_UNICODE);
echo'ss';
}

















?>