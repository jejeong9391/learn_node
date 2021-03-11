<?php //  ######### 정상작동 list ########


include "./lib/common_rest.php";


$ri_idx = $input[rider_idx]; //기사 idx
$st_idx = $input[store_idx]; //지점 idx


if($st_idx>0){ //지점로그인인 경우, 해당지점만 출력
	$addWhere = " AND st.u_idx='$st_idx'";
}else{ //기사인 경우, 소속 지점 출력 
	$addWhere = " AND st.rider_idx='$ri_idx' ";
}

// 조건은 $sql이 아닌 addwhere로 지정 

//필터와 정렬 : 거리
//태그
//인기순 == myshop에 많이 등록된 순서 SELECT `style_num`,COUNT(*) AS s_like FROM `Pet_mystyle` GROUP BY style_num ORDER BY s_like DESC

	switch ($method) {  
	  case 'GET': 
		$sql="SELECT comm.u_idx, comm.u_name, comm.u_type, comm.is_use, st.head_idx ,st.tel FROM user_common AS comm 
			INNER JOIN user_store AS st ON st.u_idx=comm.u_idx 
			WHERE comm.u_type='4' AND comm.is_use='0'".$addWhere.($key?" AND st.head_idx=$key":'');
		//$cnt_sql ="select count(*)AS cnt";
		//echo $sql;
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

//조건에 맞는 전체 샵 개수 출력 
/*$count_sql = $cnt_sql.$sql;
$cnt = mysqli_query($link,$count_sql);
$cnt_row = mysqli_fetch_array($cnt);
*/

echo($result_sql);
 //sql이 제대로 실행되지 않았을때 
if (!$result) {
	sql_err();
	//badRequestEcho(400,$err_log);
}

include "./lib/reqcode.php"; //응답코드 
?>
