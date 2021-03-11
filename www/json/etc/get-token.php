<?
$method = $_SERVER['REQUEST_METHOD']; //요청방식 (post, put) 
//echo file_get_contents('php://input');
//{,"login_id":"홍길동","snsEmail":"sailer04@naver.com","persionId":"sailer0412","snsType":"kakao"}
$arr = json_decode(file_get_contents('php://input'));
$login_id = $arr->login_id; //jieun22
$sns_email = $arr->snsEmail; //1234
$p_id = $arr->persionId; //jieun22
$sns_type = $arr->snsType; //jieun22

if($login_id){
//임시 아이디 생성(_prape_12355)
$login_id='_prape_12355';
}
 
//curl -u test:pass1234 http://auth.siwooent.com/token.php -d 'grant_type=client_credentials'



$link = mysqli_connect('localhost', 'prape', '452562ab', 'prape'); 
echo 'post가 아님1';
mysqli_set_charset($link,'utf8'); // 
echo 'post가 아님2';




if($method == 'POST'){
	if($persionId=='jieun22'&& $pw=='1234'){
	$sql = "INSERT Rest_auth SET 
				num ='',
				auth_token = SUBSTR(UUID(),1,8),
				auth_id = '$id',
				auth_endtime = DATE_ADD(NOW(), INTERVAL 30 MINUTE);";  //토큰생성하고 
	$result = mysqli_query($link,$sql);//insert실행 

	$num = mysqli_insert_id($link);

	$sql_s = "select * from Rest_auth WHERE num = $num";
	$sel_result = mysqli_query($link,$sql_s);// select 실행
	$obj_result = mysqli_fetch_object($sel_result);//현재 행 반환 필드값 출력  //connect가 안되면 여기서 null로 출력됨 그래서 null로 출력되면 json_encode해서 전송함 
	
/*	if($obj_result === null){

			echo "500: servers replied with an error." //////obj가 없으면 아무것도 출력되는것 없음 오류코드 보내야지
		
		}else*/ 
			
		if($obj_result)
		{
		    echo json_encode($obj_result);

		}
	 echo '&nbsp;##요청에 따라 rest_api가 쿼리 만들어서 json으로 만들었어요';

	//{"num":"67","auth_token":"555be57a","auth_id":"jieun22","auth_endtime":"2019-02-28 12:18:31"}
	}else{ 
		echo 'id/pw와 같지않음';
	}
}else {
echo 'post가 아님';
  http_response_code(404);
  die(mysqli_error());
}
//echo $sql;

$result = mysqli_query($link,$sql);//insert실행 
mysqli_close($link);

// null이 리턴되면 안됨 / 어디서 null이 리턴되는지 찾아보고 http에러로 변환되게 하셈 

?>
