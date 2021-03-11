<?php 
//CORS (크로스도메인)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers,Origin,Accept,Access-Control-Request-Headers,Authorization');
header("Access-Control-Allow-Methods: GET POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json; charset=UTF-8');
header("Cache-Control: no-cache");
header("Pragma:no-cache");

//상태코드 리턴 위해 현재 프로토콜 확인 
//echo $_SERVER['SERVER_PROTOCOL'];
//ini_set("display_errors", "1");
// mysql database 연결 
$link = mysqli_connect('db.mesoft.kr', 'oil', 'mesoft1224', 'oil_manager'); 
mysqli_set_charset($link,'utf8');

/*
//2020-01-15 conn테스트 
	if ($link->connect_error) {
		die("Connection failed: " .$link->connect_error);

	}else{
		$sql= "SELECT * FROM user_store WHERE head_idx=2";
		$result =  mysqli_query($link, $sql) or die('error =>'.mysqli_error());
	
		$row = mysqli_fetch_array($result);
		if($row){
			print_r($row);
			echo "Connected successfully!";
		}else{
			echo "fail";
		}
		die();
	}
*/


//호출된 페이지명 출력(로그에 사용_function)
$pageName = substr(basename($_SERVER['PHP_SELF']),0,-4);

//요청방식 (post) 
$method = strtoupper($_SERVER['REQUEST_METHOD']); 

//post 방식으로 변경 
$arr = json_decode(file_get_contents('php://input')); //배열로 받음

if($arr){
	$flag = $arr->flag; //get, post 
}else{
	$flag= $_POST['flag'];
}

if($flag || $flag!="")
{
	$method = strtoupper($flag); //get, post 
}
//echo $method;

//경로에서 key값 추출 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); 
//$key = array_shift($request)+0; //문자열 0으로 반환함  
$key = array_shift($request); 
 
//JSON 배열로 변환 
$input = json_decode(file_get_contents('php://input'),true);
//echo file_get_contents('php://input');



//header("HTTP/1.1 404 Not Found");

include "function.php";

//Bad Request 응답코드 변수화  
$bad_rq =  '
	{ 
			"meta": {

				"code": "400 Bad Request",
				"state": "error",
				"msg": "'.$table_name.' '.$method.' error"
			  
			},
			  
	}';	 

/*
$json = file_get_contents('php://input');
$obj = json_decode($json);
$p_token = $obj->access_token; //json이 아닐 때(이미지)
$personid = $obj->personId;*/
	
// 토큰/id 추출 
$u_token="";  //토큰 
$u_idx=""; //유저 idx 



if(isset($input)){ //json으로 받았을 때 

	$u_token = $input['u_token'];
	$u_idx =  $input['u_idx'];
	//echo'1';

}else{ //form-data로 받았을 때 또는 json으로 안넘어올때 

	$u_token = $_POST["u_token"]; //json이 아닐 때(이미지)
	$u_idx = $_POST["u_idx"];
	//echo '@@'.$u_token;

// 근데 쉽표찍는것 등으로 잘못보내면 //id,토큰을 못가져옴 

}

if($input['u_pass']){

}else{
	if($u_token && $u_idx){

	$sql = "SELECT * FROM user_common WHERE u_idx = '".$u_idx."' AND u_token ='".$u_token."'";
	$sel_result = mysqli_query_log($link,$sql);// select 실행
	$row = mysqli_affected_rows($link);//현재 행 반환 필드값 출력 
		if($row>0){

		}else{
		$str = httpErrorEcho("token or personid is invalid");
		exit;
		}

	}else{
		$str = httpErrorEcho("token or personid is null");
	}
}

?>