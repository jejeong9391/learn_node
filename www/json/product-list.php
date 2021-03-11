<?php // ######### 상품 LIST ########

$table_name = 'Product';
include "./lib/common_rest.php";

$io_type = $input[io_type]; //기사 idx


if($io_type=='-1'){ //출고
	$addwhere =" pro.p_type not in ('200002') AND ";
}else{
	$addwhere =" pro.p_type in ('200002') AND ";
}

//$key='77';
	switch ($method) {  
	  case 'GET': 

		//st.u_idx == 지점 idx  if 걸어서 이게 없으면 에러 출력? order_detail에서 먼저 막아서 괜찮을까? 
		$sql="SELECT p_idx,p_code,p_name,p_type,sc.comm_name,p_stand,p_amount,p_amt_in,p_amt_out,p_remark,pro.head_idx,pro.is_use,pro.reg_date,pro.last_update FROM product AS pro 
				LEFT outer JOIN user_store AS st ON pro.head_idx = st.head_idx  
				INNER JOIN co_system_code AS sc ON pro.p_unit = sc.comm_no
				WHERE $addwhere pro.is_use='0' and
				(st.u_idx='$key' OR pro.head_idx IS NULL);";
		break;
	  
		default : header("HTTP/1.1 405 Method Not Allowed");
			badRequestEcho(405,"Method Not Allowed");
		break;
	}

// excecute SQL statement


//echo($sql);
//조건에 맞는 데이터 출력 (기본쿼리+조건+limit)
//$result_sql = $sql.$limit;

$result=mysqli_query($link,$sql);

//조건에 맞는 전체 샵 개수 출력 
/*$count_sql = $cnt_sql.$sql;
$cnt = mysqli_query($link,$count_sql);
$cnt_row = mysqli_fetch_array($cnt);
*/

 //sql이 제대로 실행되지 않았을때 
if (!$result) {
	sql_err();
	//badRequestEcho(400,$err_log);
}

include "./lib/reqcode.php"; //응답코드 
?>
