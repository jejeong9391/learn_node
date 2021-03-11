<?php



if($token_val[0]=='success'){ 

	// mysql database 연결 
	//$link = mysqli_connect('localhost', 'beauty', '452562ab', 'beauty'); 
	$link = mysqli_connect('localhost', 'prape', '452562ab', 'prape'); 
	mysqli_set_charset($link,'utf8');


	// 경로에서 테이블명과 key 추출
	//$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	$key = array_shift($request)+0; 

// $bad_rq는 400코드 (common_rest.php)-- 안됨/include가 msg변수보다 위에서 되서그런가봄 


//put,delete일 때 보내온 key가 db에 있는 값인지 체크 
if($method=='PUT'|| $method=='DELETE'){

 	$sql_ck = "select * from $table_name WHERE num=$key"; //key가 없어도 error처리 

	$s_result = mysqli_query($link,$sql_ck);

	//echo mysqli_num_rows($s_result);
	if(mysqli_num_rows($s_result)<1){ //수정, 삭제할 row가 없다면 

		echo $bad_rq; //오류 반환하고 
		die(mysqli_error()); //끝
	}

}


	//input object에서 컬럼과 데이터값을 추출 
	$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input)); 
//	echo $columns[1];//num

	$values = array_map(function ($value) use ($link) {
	  if ($value===null) return null;

	  return mysqli_real_escape_string($link,(string)$value); //특수문자열 이스케이프 
	},array_values($input));
	// build the SET part of the SQL command

//echo $values[3];
//$columns[0]=access_token , $values[0]= 04c1ffe9cfffd6ffa00593352151763d6de90992
// 배열[2]부터 시작 
	$set = '';
	for ($i=2;$i<count($columns);$i++) {
	  $set.=($i>2?',':'').'`'.$columns[$i].'`=';
	  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
	}



	 //echo 'rest_api입니다.&nbsp;&nbsp;';
	// create SQL based on HTTP method
	switch ($method) {
	  case 'GET':
		$sql = "select * from $table_name ".($key?" WHERE num=$key":''); break;
	  case 'PUT':
		$sql = "update $table_name set $set where num=$key"; break;
	  case 'POST':
		$sql = "insert into $table_name set $set";  break;
	  case 'DELETE':
		$sql = "delete FROM $table_name where num=$key"; break; 
	}
	
	// excecute SQL statement
	$result = mysqli_query($link,$sql);


	 //sql이 제대로 실행되지 않았을때 
	if (!$result) {
		
	// echo http_response_code(404);
	echo $bad_rq;
	die(mysqli_error());

	}
	
// ======== 응답코드 =========================================

		if ($method == 'GET') { //조회

			echo '
	{ 

		"meta": {

			"code": "200",
			"state": "OK",
			"msg": "'.$table_name.' list "
		  
		},

		  "data": [
		';
				for ($i=0;$i<mysqli_num_rows($result);$i++) {
					//json형태 정렬때문에 echo 줄바꿈 
				echo ($i>0?',
				':'
				').json_encode(mysqli_fetch_object($result),JSON_UNESCAPED_UNICODE); //두번반복은 안됨 / 한글 인코딩 깨짐 

				  }
			echo '
			
			]
}';

		}elseif ($method == 'POST') { //insert
		
//echo mysqli_insert_id($link);
echo '
	{ 
		"meta": {

			"code": "201",
			"state": "OK",
			"msg": "'.$table_name.' INSERT success"
		  
		},
		  
}';

			//echo mysqli_insert_id($link);
			
		}elseif ($method == 'PUT') { //update
			//echo mysqli_affected_rows($link);
			

		  echo '
	{ 
		"meta": {

			"code": "204",
			"state": "OK",
			"msg": "'.$table_name.' UPDATE success"
		  
		},
		  
}';

		}elseif ($method == 'DELETE') { //delete 
			

		//mysql_affected_rows써볼것  //지금 실행된 행이 있으면 succ , 실행할 행이 없으면 fail던질까말까 고민중 
		/*if(mysqli_insert_id($link)==0){ //실행된 행이 없음

			echo '
			"msg": "Pet list Delete fail"
			}';
		}else{*/  //예외처리해야함 지금 모든경우 fail일때 아무것도 출력안됨 
			  echo '
			{ 
				"meta": {

					"code": "204",
					"state": "OK",
					"msg": "'.$table_name.' list DELETE success"
				  
				},
				  
		}';
		//}
			
			
		}

	// echo '&nbsp;##요청에 따라 rest_api가 쿼리 만들어서 json으로 만들었어요'.$method;
	// close mysql connection
	mysqli_close($link);




/*
//응답예제 
{   
   "access_token":"d78ef7999a1b3685dbee28c7dcbce1bf56e2858a",
	"personId":"smdfvvx",
   
    "num" : "",
    "o_num" : "15",
    "pet_name" : "시루",
    "petb_num" : "3",
    "pet_sex" : "F",
    "pet_birthday" : "2010-11-30",
    "pet_weight" : "18",
    "pet_image" : ""
    
    }



*/




?>