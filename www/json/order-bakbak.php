<?php //  ######### 주문/배달 상세 ########


include "./lib/common_rest.php";


//시간설정
//date_default_timezone_set('Asia/Seoul');

$today = date("Y-m-d");
$now_time = date("Y-m-d H:i:s");

//put,delete일 때 보내온 key가 db에 있는 값인지 체크 
//valid_check_put_del($link,$method,$key,$table_name);

//input object에서 컬럼과 데이터값을 추출 
//$set = setting_set_value($link,$input,$o_num);

$io_date =  $input[io_date]; //입고날짜
$io_status =  $input[io_status]; // 주문/배송여부
$store_idx =  $input[store_idx]; //지점 idx
$io_amt =  $input[io_amt]; //총 금액
$data_all =  $input[data_all]; //$('#write_form').serializeArray()  // 개별 상품배열 
$p_idx =  $input[p_idx]; //입고날짜
/*개별 상품배열 
$p_idx =  $input[p_idx]; //입고날짜
$iop_idx =  $input[iop_idx]; // 주문/배송여부
$amt_price =  $input[amt_price]; //지점 idx
$out_amt =  $input[out_amt]; //총 금액
$out_total =  $input[out_total]; //총 금액

*/


$key = "";
$value = "";
/*
	foreach ($data_all as $val) { 
	/*(
		[0] => Array
			(
				[name] => io_status
				[value] => 0
			)...

		$aaa = 0;
		if(is_array($val)) { // Array
			foreach ($val as $key => $value) {
				if($aaa==0)
				{
					$Skey = $value;
					$aaa++;
				}
				else
					$Svalue = $value;
				}
		} else {
			echo "@$key@";
		}
		echo($Skey." : ".$Svalue.'  |');
	}
*/

foreach ($data_all as $val) { //바깥배열에서 val만 빼오기
 foreach ($val as $value) { // 내부배열에서 val로 key / value 만들기
	 $key= $val[name];
	 $value = $val[value];

 }
// echo($key." : ".$value.'  |');
}

//print_r ($input[p_idx]);




//$st_idx = json_decode(file_get_contents('php://input'));
// 전표번호 있어야함. 
switch ($method) { 

  case 'PUT':
	$sql = "update $table_name set $set where num=$key"; break;

  case 'POST':
	//두개테이블에 insert해야하니까 쿼리를 다쓰고 변수를 하나씩 넣자욤 //inouts 먼저 넣고 last_insert_id() 가져와서 io_idx에 넣어야함. 
	$io_sql = "insert into inouts set
			
			io_date='$io_date',
			order_date='$today',
			store_idx ='$store_idx',
			io_amt='$io_amt',
			io_status ='$io_status',
			reg_date='$now_time',
			last_update='$now_time';";  
			//echo $io_sql;
			//print_r ($input[data_all]);
	$io_result =mysqli_query_log($link,$io_sql);
	
	if($io_result){
		$io_idx= mysqli_insert_id($link);

	
		//while돌면서 상품별 하나씩 넣어야함 

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

		$sql = "insert into inout_product set
				io_idx='$io_idx',
				io_date='$today',
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
	}else{
	
		echo 'io insert에러';
	}
	break;

  case 'DELETE':
	$sql = "delete FROM $table_name where num=$key"; break; 

 default : header("HTTP/1.1 405 Method Not Allowed");
	badRequestEcho(405,"Method Not Allowed");
break;
}

// excecute SQL statement
//$result = mysqli_query_log($link,$sql);

 //sql이 제대로 실행되지 않았을때 
if (!$result) {

	//echo $bad_rq;
	//die(mysqli_error());  #die(): 메세지 출력 후,종료  # exit: 그냥종료  -- 파라미터에 따라 다르지 둘다 같은 함수임. 

	sql_err();
}

//insert한 값 반환(이미지 전송 시 사용)
if($method=="POST"){

	$last_num = mysqli_insert_id($link);
	//echo $last_num;
}
	
include "./lib/reqcode.php"; //응답코드 
?>
