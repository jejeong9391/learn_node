<?php //  ######### 비밀번호 변경  PUT ######## 


include "./lib/common_rest.php";


//시간설정
//date_default_timezone_set('Asia/Seoul');

$today = date("Y-m-d");
$now_time = date("Y-m-d H:i:s");

$u_idx =  $input[u_idx]; //작성자 idx	
$new_pw =  $input[new_pw]; //작성자 idx	


switch ($method) { 

  case 'PUT':
	//전표 update
	$sql = "UPDATE user_common SET u_pass='$new_pw' WHERE u_idx='$u_idx';";
	$result =mysqli_query_log($link,$sql);
	break;

	default : header("HTTP/1.1 405 Method Not Allowed");
	badRequestEcho(405,"Method Not Allowed");
	break;
}


	
include "./lib/reqcode.php"; //응답코드 
?>
