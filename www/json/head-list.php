<?php //  ######### 정상작동 list ########

$table_name = 'Branch';
include "./lib/common_rest.php";


$ri_idx = $input[rider_idx]; //기사 idx
$st_idx = $input[store_idx]; //지점 idx

if($st_idx>0){ //지점로그인인 경우, 해당지점만 출력
	$addWhere = " where st.u_idx='$st_idx'";
}else{ //기사인 경우, 소속 지점 출력 
	$addWhere = " where st.rider_idx='$ri_idx' ";
}


	switch ($method) {  
	  case 'GET': 
	
		/*$sql="SELECT DISTINCT st.head_idx AS u_idx, h_comm.u_name, h_h.image FROM (SELECT * FROM user_common WHERE is_use='0') AS comm 
		INNER JOIN user_store AS st ON comm.u_idx =st.u_idx AND st.rider_idx='$ri_idx' 
		INNER JOIN user_common AS h_comm ON st.head_idx =h_comm.u_idx
		INNER JOIN user_head AS h_h ON st.head_idx =h_h.u_idx".$addWhere;*/

		$sql="SELECT DISTINCT st.head_idx AS u_idx, h_comm.u_name, h_h.image FROM (SELECT * FROM user_common WHERE is_use='0') AS comm 
			INNER JOIN user_store AS st ON comm.u_idx =st.u_idx 
			INNER JOIN user_common AS h_comm ON st.head_idx =h_comm.u_idx
			INNER JOIN user_head AS h_h ON st.head_idx =h_h.u_idx".$addWhere;
		//echo $sql;
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

//echo($result_sql);
 //sql이 제대로 실행되지 않았을때 
if (!$result) {
	sql_err();
	//badRequestEcho(400,$err_log);
}

include "./lib/reqcode.php"; //응답코드 
?>
