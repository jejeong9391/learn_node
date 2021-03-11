<?php // ######### 공지사항 LIST ########

$table_name = 'write_notice';
include "./lib/common_rest.php";


$rider_idx = $input[rider_idx]; //기사 idx
 

//0. 필수 인자값 존재유무 확인할 변수 배열선언 (요청페이지)
$param = array("page","scale");//,"b_cate"

// 조건은 $sql이 아닌 addwhere로 지정 

//필터와 정렬 : 거리
//태그
//인기순 == myshop에 많이 등록된 순서 SELECT `style_num`,COUNT(*) AS s_like FROM `Pet_mystyle` GROUP BY style_num ORDER BY s_like DESC

//$key='77';
	switch ($method) {  
	  case 'GET': 
		/*if($key){
		$c_sql="SELECT center_idx FROM user_rider WHERE u_idx = $key";
		$c_sel = mysqli_query_log($link,$c_sql);
		$c_row=mysqli_fetch_array($c_sel);
	  }

	  if($c_row[center_idx]){
		$sql="SELECT wn_num,head_idx,region_idx, center_idx,u_idx,wn_title,reg_date FROM write_notice where center_idx in('0','2')";
	  }*/

		$sql="SELECT wn_num,head_idx,region_idx, noti.center_idx,noti.u_idx,noti.wn_title,noti.reg_date FROM write_notice AS noti
			LEFT OUTER JOIN user_rider AS ri ON noti.center_idx = ri.center_idx
			WHERE ri.u_idx='".$rider_idx."' OR noti.center_idx=0 ORDER BY noti.reg_date DESC";

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
