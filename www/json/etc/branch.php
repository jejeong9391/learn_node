<?php
 

//include 'db_con.php'; 
include "./function.php";

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD']; //요청방식 (post) 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); 

$input = json_decode(file_get_contents('php://input'),true);//JSON 배열로 변환 
	//				array_key			array_values
	//데이터 받음 {"access_token" : "06033b3c691d8b82fed674d0c6abc9078e168dca"}
	
//토큰 추출 
$p_token = preg_replace('/[^a-z0-9_]+/i','',array_values($input)); 
$p_token = $p_token[0]; //06033b3c691d8b82fed674d0c6abc9078e168dca444

//echo $p_token;
//토큰 유효성 검사 
//$p_token = $input -> access_token;
$chkToken= chkToken($p_token); 
//유효토큰 : {"success":true,"message":"You accessed my APIs!"}
//에러토큰 : {"error":"invalid_token","error_description":"The access token provided is invalid"}

//echo $chkToken;

//검사 후 반환된 값이 success이면 진행 
$result_token = json_decode($chkToken,true);
$token_val = preg_replace('/[^a-z0-9_]+/i','',array_keys($result_token)); 
//echo $token_val[0];

if($token_val[0]=='success'){

	// mysql database 연결 
	//$link = mysqli_connect('localhost', 'beauty', '452562ab', 'beauty'); 
	$link = mysqli_connect('localhost', 'prape', '452562ab', 'prape'); 
	mysqli_set_charset($link,'utf8');


	// 경로에서 테이블명과 key 추출
	//$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	$key = array_shift($request)+0; 
	 

//====================post일때 token때문에 데이터값 제대로 추출 못함 

	//input object에서 컬럼과 데이터값을 추출 
	$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input)); 
//	echo $columns[1];//num

	$values = array_map(function ($value) use ($link) {
	  if ($value===null) return null;

	  return mysqli_real_escape_string($link,(string)$value); //특수문자열 이스케이프 
	},array_values($input));
	// build the SET part of the SQL command


//$columns[0]=access_token , $values[0]= 04c1ffe9cfffd6ffa00593352151763d6de90992
// 배열[1]부터 시작 
	$set = '';
	for ($i=1;$i<count($columns);$i++) {
	  $set.=($i>1?',':'').'`'.$columns[$i].'`=';
	  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
	}



	 //echo 'rest_api입니다.&nbsp;&nbsp;';
	// create SQL based on HTTP method
	switch ($method) {
	  case 'GET':
		$sql = "select * from Branch ".($key?" WHERE num=$key":''); break;
	  case 'PUT':
		$sql = "update Branch set $set where num=$key"; break;
	  case 'POST':
		$sql = "insert into Branch set $set"; break;
	  case 'DELETE':
		$sql = "delete FROM Branch where num=$key"; break; 
	}

	// excecute SQL statement
	$result = mysqli_query($link,$sql);
	 
	// die if SQL statement failed
	if (!$result) {
	  http_response_code(404);
	  die(mysqli_error());
	}
	 
	 //if (!$key) 
		  echo '{ 
			"meta": {
			"code": "200",
			"state": "OK",';

	// print results, insert id or affected row count  RETURNING *
		if ($method == 'GET') { //조회

			echo '
			"msg": "shop list"
		  },

		  "data": [
		';
				for ($i=0;$i<mysqli_num_rows($result);$i++) {
				echo ($i>0?',':'').json_encode(mysqli_fetch_object($result)); //두번반복은 안됨 

				  }
			echo '
			
			]
}';
				
		}elseif ($method == 'POST') { //insert

echo '
			"msg": "shop list insert success"
		  }
		  
}';

			//echo mysqli_insert_id($link);
			
		}elseif ($method == 'PUT') { //update

echo '
			"msg": "shop list update success"
		  }';

			//echo mysqli_insert_id($link);
			
		}elseif ($method == 'DELETE') { //delete
			echo mysqli_insert_id($link);

//mysql_affected_rows써볼것  //지금 실행된 행이 있으면 succ , 실행할 행이 없으면 fail던질까말까 고민중 
		if(mysqli_insert_id($link)==0){ //실행된 행이 없음

			echo '
			"msg": "shop list delete fail"
			}';
		}else{
			echo '
			"msg": "shop list delete success"
			}';
		}
			
			
		}else { //update, delete

			echo mysqli_affected_rows($link);//1 (최근 MySQL 작업으로 처리된 행(row) 개수를 얻음)
			
		}
					//if (!$key) 
					 


	// echo '&nbsp;##요청에 따라 rest_api가 쿼리 만들어서 json으로 만들었어요'.$method;
	// close mysql connection
	mysqli_close($link);
}else{
	echo '{"error":"invalid_token","error_description":"The access token provided is invalid"}';
	
	}
?>