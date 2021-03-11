<?
// mysql database 연결 
$link = mysqli_connect('localhost', 'prape', '452562ab', 'prape'); 
mysqli_set_charset($link,'utf8');
//요청방식 (post) 
$method = $_SERVER['REQUEST_METHOD']; 

//경로에서 key값 추출 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); 
//$key = array_shift($request)+0; //문자열 0으로 반환함  
$key = array_shift($request); 


include "function.php";
//include "./lib/function.php";

//Bad Request 응답코드 변수화  
$bad_rq =  '
	{ 
			"meta": {

				"code": "400 Bad Request",
				"state": "error",
				"msg": '.$table_name.' '.$method.' error"
			  
			},
			  
	}';	 

$p_token = $_POST['access_token']; //json이 아닐 때(이미지)
$personid = $_POST['personId'];


//토큰이 없을 때
if(!$p_token || !$personid){
	//echo 'form-data오류';
	echo 'token&id없음'.$bad_rq;	
	exit;
}


//토큰 유효성 체크 
$chkToken= chkToken($p_token); 

//검사 후 반환된 값이 success이면 진행 
$result_token = json_decode($chkToken,true);
$token_val = preg_replace('/[^a-z0-9_]+/i','',array_keys($result_token)); 
//echo $token_val[0];

if($token_val[0]=='success'){ //!!!

}else if($token_val[0]=='error'){ // 유효하지않은 토큰일때 
	echo '	{
		"meta": {
			"code": "401 Unauthorized",
			"state": "error"
		}
		
		"error":"invalid_token",
		"error_description":"The access token provided is invalid"
		
	}';
	exit; 
	
}else{ // 그 외 josn 형태상 잘못된 문법일경우,
	echo $bad_rq;
	exit;
}


//사용자아이디로 o_num추출 
$m_sql = "select num from Member where personId = '$personid'"; 
$m_result = mysqli_fetch_row(mysqli_query_log($link,$m_sql));
$o_num = $m_result[0];



	?>