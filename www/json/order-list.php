<?php //  ######### 주문/배달 리스트 ########

include "./lib/common_rest.php";


$store_idx = $input[store_idx];
$rider_idx = $input[rider_idx]; //기사 idx
$io_status = $input[io_status]; //주문접수:0 //배달완료 : 1 // 
$sdate = $input[sdate]; //검색 시작일
$edate = $input[edate]; //검색 마지막일 


if($store_idx>0){
	$addWhere =" AND st.u_idx='".$store_idx."'";

}
if($io_status){
 $addWhere.=" AND inouts.io_status='".$io_status."'";
}



	switch ($method) {  
	  case 'GET': 
		//io는 예약어임 
		$sql="SELECT io_idx,io_date,order_date,store_idx,io_amt,io_status,inouts.rider_idx, IFNULL(comm.u_name,'매장정보없음')AS u_name ,st.tel, inouts.remark AS io_remark,inouts.reg_date AS io_reg,inouts.last_update AS io_last 
			FROM inouts AS inouts
			LEFT OUTER JOIN user_store AS st ON inouts.store_idx = st.u_idx 
			LEFT OUTER JOIN user_common AS comm ON inouts.store_idx = comm.u_idx
			WHERE inouts.rider_idx ='$rider_idx' AND inouts.io_status='$io_status' AND io_date BETWEEN '$sdate' AND '$edate' ".$addWhere."
			ORDER BY io_date asc, io_idx desc;";

//$sql;
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
