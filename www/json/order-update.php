<?php //  ######### 주문/배달 PUT/POST/DELETE ######## 2020-04-01 업뎃이전 백업


include "./lib/common_rest.php";


//시간설정
//date_default_timezone_set('Asia/Seoul');

$today = date("Y-m-d");
$now_time = date("Y-m-d H:i:s");

$u_idx =  $input[u_idx]; //작성자 idx	
$io_idx =  $input[io_idx];		   //전표idx
$io_date =  $input[io_date];       //입고날짜
$io_status =  $input[io_status];   //주문/배송여부
$store_idx =  $input[store_idx];   //지점 idx 
$rider_idx =  $input[rider_idx];	   //center_idx
$center_idx =  $input[center_idx]; //지점 idx
$io_amt =  $input[io_amt];		   //총 금액
$memo =  $input[memo];			   //메모
$p_idx =  $input[p_idx];           //상품idx
$del_idx =  $input[del_idx];       //삭제한 iop_idx



//마감

/*
$key = "";
$value = "";
foreach ($data_all as $val) { //바깥배열에서 val만 빼오기
 foreach ($val as $value) { // 내부배열에서 val로 key / value 만들기
	 $key= $val[name];
	 $value = $val[value];
 }// echo($key." : ".$value.'  |');
}
//print_r ($input[p_idx]);
*/

switch ($method) { 
	case 'POST':
	//insert한 io_idx가져오기 
	$i_sql ="SELECT FN_IO_IDX('$center_idx');";
	$i_result = mysqli_fetch_row(mysqli_query($link,$i_sql));
	$io_idx = $i_result[0];

	//전표 insert
	$io_sql = "insert into inouts set
				io_idx=$io_idx,
				io_date='$io_date',
				order_date='$today',
				store_idx ='$store_idx',
				center_idx ='$center_idx',
				rider_idx ='$rider_idx',
				io_amt='$io_amt',
				io_status ='$io_status',
				remark='$memo',
				reg_date='$now_time',
				reg_user='$u_idx',
				last_update='$now_time';";  
			//echo $io_sql;
			//exit;
			//print_r ($input[data_all]);
	$result =mysqli_query_log($link,$io_sql);
	
	if($result){
		//$io_idx= mysqli_insert_id($link);
	

	//echo $io_idx;
		//상품별 하나씩 insert
		foreach ($p_idx as $key => $val) { 
			$p_idx =  $input[p_idx][$key]; //입고날짜
			$iop_idx =  $input[iop_idx][$key]; // 주문/배송여부
			$io_type = $input[io_type][$key];
			
			if($io_type<0){ //출고
				$amount =  $input[out_amt][$key]; //총 금액
				$amt_price =  $input[out_total][$key]; //총 금액
				$amt_total=$amount*$amt_price;
			}else{
				$amount =  $input[in_amt][$key]; //총 금액
				$amt_price =  $input[in_total][$key]; //총 금액
				$amt_total=$amount*$amt_price;
			}

			// 총금액 
				$sql = "insert into inout_product set
						io_idx='$io_idx',
						center_idx ='$center_idx',
						io_date='$io_date',
						io_type='$io_type',
						p_idx ='$p_idx',
						amount='$amount',
						amt_price ='$amt_price',
						amt_total='$amt_total',
						reg_date='$now_time',
						last_update='$now_time';";  
				//echo 'sql :'.$sql;
			$io_result = mysqli_query_log($link,$sql);
		}

	}else{
		//echo 'io insert에러';
		sql_err();
	}
	break;

  case 'PUT':
		//전표 update
	$io_sql = "UPDATE inouts set
			io_date='$io_date',
			store_idx ='$store_idx',
			center_idx ='$center_idx',
			rider_idx ='$rider_idx',
			io_amt='$io_amt',
			io_status ='$io_status',
			remark='$memo',
			reg_user='$u_idx',
			last_update='$now_time'
			where center_idx ='$center_idx' AND io_idx = '$io_idx'";
	$io_result =mysqli_query_log($link,$io_sql);

	//전표업뎃하면 
	if($io_result){
		//del_idx삭제처리 
		foreach ($del_idx  as $key => $val) { 
			$del_iop = $input[del_idx][$key];
			$del_sql = "DELETE FROM inout_product where 
			iop_idx='$del_iop'";
		
			$result =mysqli_query_log($link,$del_sql);
		}
	
		//while돌면서 상품별 하나씩 넣어야함 
		foreach ($p_idx as $key => $val) { 
			$p_idx =  $input[p_idx][$key]; //상품idx
			$iop_idx =  $input[iop_idx][$key]; // 전표상품idx
			$io_type = $input[io_type][$key];
			
			if($io_type<0){ //출고
				$amount =  $input[out_amt][$key]; //수량 
				$amt_price =  $input[out_total][$key]; //단가
				$amt_total=$amount*$amt_price; // 수량*단가
			}else{
				$amount =  $input[in_amt][$key]; //수량
				$amt_price =  $input[in_total][$key]; //단가
				$amt_total=$amount*$amt_price; // 수량*단가
			}



			if($iop_idx>0){ // 전표 상품idx가 0보다 크면 update
				$sql = "UPDATE inout_product set
						io_idx='$io_idx',
						center_idx ='$center_idx',
						io_date='$io_date',
						io_type='$io_type',
						p_idx ='$p_idx',
						amount='$amount',
						amt_price ='$amt_price',
						amt_total='$amt_total',
						last_update='$now_time'
						where center_idx ='$center_idx' AND io_idx=$io_idx AND iop_idx=$iop_idx;";  
					//echo 'sql :'.$sql;
				$result = mysqli_query_log($link,$sql);
			
			}else{  // 전표 상품idx가 0보다 작으면 insert  

				$sql = "insert into inout_product set
					io_idx='$io_idx',
					center_idx ='$center_idx',
					io_date='$io_date',
					io_type='$io_type',
					p_idx ='$p_idx',
					amount='$amount',
					amt_price ='$amt_price',
					amt_total='$amt_total',
					reg_date='$now_time',
					last_update='$now_time';";  
				//echo 'sql :'.$sql;
				$result = mysqli_query_log($link,$sql);
			}

			//delete는 어떻게 알고 처리하지?

				
			}
	}else{
		//echo 'io insert에러';
		sql_err();
	}	
	break;

  case 'DELETE':
	//io삭제
	$io_sql = "delete FROM inouts where center_idx ='$center_idx' AND io_idx=$io_idx";
	// echo 'io_sql :'.$io_sql;
	$result = mysqli_query_log($link,$io_sql); //처리여부 result로 판단

	//iop삭제 
	$sql = "delete FROM inout_product where center_idx ='$center_idx' AND io_idx=$io_idx";
	// echo 'iop_sql :'.$sql;
	$io_result = mysqli_query_log($link,$sql);

    if ($result){
		$last_num=1; // 삭제처리 된경우 num넣어줌 
		
	}else{
		sql_err();
	}

  break; 

 default : header("HTTP/1.1 405 Method Not Allowed");
	badRequestEcho(405,"Method Not Allowed");
	break;
}


 //sql이 제대로 실행되지 않았을때 
//if (!$result) {

	//echo $bad_rq;
	//die(mysqli_error());  #die(): 메세지 출력 후,종료  # exit: 그냥종료  -- 파라미터에 따라 다르지 둘다 같은 함수임. 

	//sql_err();
//}

//insert한 값 반환(이미지 전송 시 사용)
//$last_num = mysqli_insert_id($link);

	
include "./lib/reqcode.php"; //응답코드 
?>
