<?php //  ######### 주문/배달 개수 ########

include "./lib/common_rest.php";

$store_idx = $input[store_idx]; //기사 idx
$rider_idx = $input[rider_idx]; //기사 idx
$io_status = $input[io_status]; //주문접수:0 //배달완료 : 1 // 
$sdate = $input[sdate]; //검색 시작일
$edate = $input[edate]; //검색 마지막일 

if($store_idx>0){
	$addWhere =" AND st.u_idx='".$store_idx."'";

}

//0. 필수 인자값 존재유무 확인할 변수 배열선언 (요청페이지)
$param = array("page","scale");//,"b_cate"

	switch ($method) {  
	  case 'GET': 

		$sql="SELECT 
			SUM(IF(inouts.io_status=0,1,0)) AS io_0,
			SUM(IF(inouts.io_status=1,1,0)) AS io_1
				FROM inouts AS inouts
			INNER JOIN user_store AS st ON inouts.store_idx = st.u_idx 
			WHERE inouts.rider_idx ='$rider_idx' AND io_date BETWEEN '$sdate' AND '$edate'".$addWhere;
			//echo $sql;
		//$cnt_sql ="select count(*)AS cnt";
		
		
		break;
	  
		default : header("HTTP/1.1 405 Method Not Allowed");
			badRequestEcho(405,"Method Not Allowed");
		break;
	}

// excecute SQL statement


//조건에 맞는 데이터 출력 (기본쿼리+조건+limit)
//$result_sql = $sql.$limit;

$result=mysqli_query($link,$sql);


//echo($sql);
 //sql이 제대로 실행되지 않았을때 
if (!$result) {
	sql_err();
	//badRequestEcho(400,$err_log);
}

include "./lib/reqcode.php"; //응답코드 
?>
