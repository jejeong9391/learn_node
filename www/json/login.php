<?php   ######### 로그인 ########

include "./lib/common_rest.php";

$u_id = $input[u_id]; 
$u_pass = $input[u_pass]; 


	switch ($method) {  
	  case 'GET': 

		// 지점 로그인하는 경우 : rider_idx는 지점소속 rider_idx 출력 
		//token, id, 이름, 
		$sql="SELECT comm.u_token,comm.u_idx,comm.u_name, comm.u_type,IF(comm.u_type=4,st.center_idx,rid.center_idx)AS center_idx,
			IF(comm.u_type=4,st.rider_idx,rid.u_idx)AS rider_idx,IF(comm.u_type=4,comm.u_idx,0)AS store_idx FROM user_common AS comm
				LEFT OUTER JOIN user_rider AS rid ON comm.u_idx= rid.u_idx
				LEFT OUTER JOIN user_store AS st ON comm.u_idx = st.u_idx 
				WHERE u_id='$u_id' AND u_pass='$u_pass'";
				//u_type으로 구분해서 가져올 컬럼명 다르게 가져오기 
				//outer join으로 걸어서 데이터를 다 가져와서 
		break;
	  
		default : header("HTTP/1.1 405 Method Not Allowed");
			badRequestEcho(405,"Method Not Allowed");
		break;
	}


$result=mysqli_query($link,$sql);


//echo($result_sql);
 //sql이 제대로 실행되지 않았을때 
if (!$result) {
	sql_err();
	//badRequestEcho(400,$err_log);
}

include "./lib/reqcode.php"; //응답코드 
?>
