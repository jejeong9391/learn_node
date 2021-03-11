<?php //  ######### 주문/배달 상세 ########


include "./lib/common_rest.php";


//시간설정
$today = date("Y-m-d");
$now_time = date("Y-m-d H:i:s");

//put,delete일 때 보내온 key가 db에 있는 값인지 체크 
valid_check_put_del($link,$method,$key,$table_name);

//input object에서 컬럼과 데이터값을 추출 
$set = setting_set_value($link,$input,$o_num);


$st_idx = $input[st_idx]; //매장 idx
$center_idx = $input[center_idx]; //매장 idx

// 전표번호 있어야함. 
switch ($method) { 
	
  case 'GET':
	// store_idx는 어떤경우라도 가지고 있으니 전표번호를 key로 가져야함. 

	if($key!=''){ // 전표번호가 있는경우 
						//전표번호, iop_num, 배달여부, 입출고 여부, 입고일자,입고가능일자, 상품num , 상품이름, 상품규격(18L..), 주문수량, 상품별 단가, 상품별 총액 
		/*$sql = "SELECT iop.io_idx,iop_idx,ios.io_status,iop.io_type,iop.io_date,st.visit_day,st.tel,iop.p_idx,pro.p_name,pro.p_stand,iop.amount,iop.amt_price,iop.amt_total  FROM inout_product AS iop
					INNER JOIN inouts AS ios ON iop.io_idx= ios.io_idx
					INNER JOIN user_store AS st ON st.u_idx=ios.store_idx
					INNER JOIN product AS pro ON iop.p_idx = pro.p_idx
				WHERE iop.io_idx =$key";*/
				
// 2020-07-31 매장정보 지운경우 전표 상세 자체가 안나오는 오류 // INNER JOIN user_store ->LEFT OUTER 으로 변경  
		$sql = "SELECT iop.io_idx,iop_idx,ios.io_status,iop.io_type,ios.io_date,st.visit_day,st.tel,iop.p_idx,pro.p_idx AS 
					p_num,pro.p_name,pro.p_stand,iop.amount,iop.amt_price,iop.amt_total,ios.remark,(SELECT cfg_value FROM co_config WHERE cfg_type='deadline_rider')AS cfg_value 
				FROM inouts AS ios
					LEFT OUTER JOIN user_store AS st ON st.u_idx=ios.store_idx
					LEFT OUTER JOIN inout_product AS iop ON ios.io_idx= iop.io_idx and ios.center_idx = iop.center_idx
					LEFT OUTER JOIN product AS pro ON iop.p_idx = pro.p_idx
				WHERE ios.center_idx = $center_idx AND ios.io_idx =$key";
				
				//echo $sql;
				break;
				
	}else{
		//기본 상품 셋팅해야함. //2020-04-09 셋팅상품은 있는데 product에 해당상품이 없는경우 처리 (inner join으로 변경)
		$sql = "SELECT st.visit_day,st.tel,hp.hp_idx,hp.head_idx,hp.io_type,hp.p_idx,pro.p_idx AS p_num, pro.p_name,pro.p_stand,pro.p_amt_out,hp.amount,(SELECT cfg_value FROM co_config WHERE cfg_type='deadline_rider')AS cfg_value FROM user_store AS st
					LEFT OUTER JOIN head_product AS hp ON hp.head_idx= st.head_idx
					LEFT OUTER JOIN product AS pro ON hp.p_idx = pro.p_idx
				WHERE st.u_idx=$st_idx"; 
				break;
	}

	default : header("HTTP/1.1 405 Method Not Allowed");
		badRequestEcho(405,"Method Not Allowed");
	break;
}

// excecute SQL statement
$result = mysqli_query_log($link,$sql);

 //sql이 제대로 실행되지 않았을때 
if (!$result) {

	//echo $bad_rq;
	//die(mysqli_error());  #die(): 메세지 출력 후,종료  # exit: 그냥종료  -- 파라미터에 따라 다르지 둘다 같은 함수임. 

	sql_err();
}
	
include "./lib/reqcode.php"; //응답코드 
?>
