<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json; charset=UTF-8');

$b_addr= "부산광역시 해운대구 센텀4로 15 센텀시티몰 B2층";
$b_code= "A0001";
$b_detail= "";
$b_gpslat= "35.1698923";
$b_gpslong= "129.1283173";
$b_image= "http://www.prape.co.kr/json/img/Branch/샵2.jpg";
$b_introduce= "";
$b_name= "몰리스펫샵신백점";
// $b_opening= "[
  //{"day":"평일", "time1":"09:00", "time2":"17:00"},
  //{"day":"주말", "time1":"11:00", "time2":"20:00"},
  //{"day":"공휴일", "time1":"11:00", "time2":"20:00"},
  //{"day":"격주", "time1":"", "time2":""}
  //]";
$b_tel= "055-543-1564";
$is_shop= "Y";
$pro_list= null;
$shop_tag= "1인샵,예약제";
$style_total= _json_encode(33);

function _json_encode($val) {
    if (is_string($val)) return '"'.addslashes($val).'"'; 
    if (is_numeric($val)) return $val;
    if ($val === null) return 'null';
    if ($val === true) return 'true';
    if ($val === false) return 'false';

    $assoc = false;
    $i = 0;
    foreach ($val as $k=>$v){
        if ($k !== $i++){
            $assoc = true;
            break;
        }
    }
    $res = array();
    foreach ($val as $k=>$v){
        $v = _json_encode($v);
        if ($assoc){
            $k = '"'.addslashes($k).'"';
            $v = $k.':'.$v;
        }
        $res[] = $v;
    }
    $res = implode(',', $res);
    return ($assoc)? '{'.$res.'}' : '['.$res.']';
}

$json = _json_encode(
array(
	array(b_addr => $b_addr, b_code => $b_code, b_detail => $b_detail, b_gpslat => $b_gpslat,
		  b_gpslong => $b_gpslong, b_image => $b_image, b_introduce => $b_introduce, b_name => $b_name,
		  b_opening => array(
		    0 => array(day => '평일', time => '09:00', time2 => '17:00'),
		    1 => array(day => '주말', time => '09:00', time2 => '17:00'),
		    2 => array(day => '공휴일', time => '09:00', time2 => '17:00'),
		    3 => array(day => '격주', time => '09:00', time2 => '17:00'),
		  ), b_tel => $b_tel, is_shop => true, pro_list => null, shop_tag => $shop_tag, style_total => $style_total
	),array(b_addr => $b_addr, b_code => $b_code, b_detail => $b_detail, b_gpslat => $b_gpslat,
		  b_gpslong => $b_gpslong, b_image => $b_image, b_introduce => $b_introduce, b_name => $b_name,
		  b_opening => array(
		    0 => array(day => '평일', time => '09:00', time2 => '17:00'),
		    1 => array(day => '주말', time => '09:00', time2 => '17:00'),
		    2 => array(day => '공휴일', time => '09:00', time2 => '17:00'),
		    3 => array(day => '격주', time => '09:00', time2 => '17:00'),
		  ), b_tel => $b_tel, is_shop => true, pro_list => null, shop_tag => $shop_tag, style_total => $style_total
	),array(b_addr => $b_addr, b_code => $b_code, b_detail => $b_detail, b_gpslat => $b_gpslat,
		  b_gpslong => $b_gpslong, b_image => $b_image, b_introduce => $b_introduce, b_name => $b_name,
		  b_opening => array(
		    0 => array(day => '평일', time => '09:00', time2 => '17:00'),
		    1 => array(day => '주말', time => '09:00', time2 => '17:00'),
		    2 => array(day => '공휴일', time => '09:00', time2 => '17:00'),
		    3 => array(day => '격주', time => '09:00', time2 => '17:00'),
		  ), b_tel => $b_tel, is_shop => true, pro_list => null, shop_tag => $shop_tag, style_total => $style_total
	))
,JSON_UNESCAPED_UNICODE);

echo $json;

?>