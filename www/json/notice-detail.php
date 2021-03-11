<?php // P04 펫샵 리스트   ######### 정상작동 list ########

$table_name = 'write_notice';
include "./lib/common_rest.php";


//필터와 정렬 : 거리
//태그
//인기순 == myshop에 많이 등록된 순서 SELECT `style_num`,COUNT(*) AS s_like FROM `Pet_mystyle` GROUP BY style_num ORDER BY s_like DESC

	switch ($method) {  
	  case 'GET': 
	
		$sql="SELECT *FROM write_notice where 1".($key?" AND wn_num=$key":' ');
		//$sql="SELECT *FROM write_notice where 1 and wn_num='1'";
		//$cnt_sql ="select count(*)AS cnt";
		
		if($page&&$scale){ //0611 페이징추가 
			$start_list_num=($page-1)*$scale;
			$limit =" LIMIT $start_list_num,$scale"; 
		}
		
		break;
	  
		default : header("HTTP/1.1 405 Method Not Allowed");
			badRequestEcho(405,"Method Not Allowed");
		break;
	}

// excecute SQL statement


//조건에 맞는 데이터 출력 (기본쿼리+조건+limit)
//$result_sql = $sql.$limit;

$result=mysqli_query($link,$sql);



//echo($result_sql);
 //sql이 제대로 실행되지 않았을때 
if (!$result) {
	sql_err();
	//badRequestEcho(400,$err_log);
}

include "./lib/reqcode.php"; //응답코드 
?>
