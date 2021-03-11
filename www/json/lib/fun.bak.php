<?php

//============= 응답코드 (클라이언트 디버깅문제로 헤더값 제외, 200코드로 전송)===================

// 401에러 ($p_token, $personid 유무 확인하고, 에러코드 출력)
function httpErrorEcho($strErr){

	//header("HTTP/1.1 401 Unauthorized");
	$array=array("error_description"=>$strErr);
	echo json_encode($array);
	exit;
}

// 400에러 
function badRequestEcho($errCode,$strErr){
	switch ($errCode) {
		
		case '400': $status = "400 Bad Request";
		break;

		case '401': $status = "401 Unauthorized";
		break;

		case '405': $status = "405 Method Not Allowed";
		break; 
	}

$array=array("meta"=>array("code"=>$status,"state"=>"error","error_description"=>$strErr));

/*
	$array=array("meta"=>array("code"=>"400 Bad Request","state"=>"error","error_description"=>$strErr));*/

	echo json_encode($array);
	exit;
}
//=================================================================================

// mysqli 실행하는 함수 // 실행하면서 쿼리 로그 쌓음. -- 개발끝나면 로그쿼리 주석처리할 것  
function mysqli_query_log($link,$sql) { 
	
	//쿼리 호출하는 페이지명 함께 삽입 
	$pageName = substr(basename($_SERVER['PHP_SELF']),0,-4); 

	mysqli_query($link,"insert into query_log(query_string,pagename) values('".addslashes($sql)."','".$pageName."')");
	Return mysqli_query($link,$sql);
}


//sql 실행 오류 시 오류응답코드 전송 // 위 함수와 합치는 작업은 다음에 하자 
function sql_err(){

	global $pageName;
	global $link;
	$err_log= mysqli_error($link);
	
	mysqli_query($link,"insert into query_log(query_string,pagename) values('".addslashes($err_log)."','SQL_ERR(".$pageName.")')");

	badRequestEcho(400,$err_log);

	/*$array=array( "sqlError_description"=>$err_log);
	echo json_encode($array);
	//header("HTTP/1.1 400 Bad Request"); 
	exit;*/
}

//=================================================================================


function CallAPI($url, $method, $api, $data) { //
    //$url = "http://beauty.siwooent.com/rest_api.php/Member/" . $api;
	$url = "http://auth.siwooent.com/".$url.$api;
    $curl = curl_init($url);



    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    switch ($method) {
        case "GET":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            break;
        case "POST":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); 
            break;
    }
    $response = curl_exec($curl);
    //$data = json_decode($response);//디코딩
	$data = $response;
    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    // Check the HTTP Status code
    switch ($httpCode) {
        case 200:
            $error_status = "200: Success";
            return ($data);
            break;
        case 404:
            $error_status = "404: API Not found";
            break;
        case 500:
            $error_status = "500: servers replied with an error.";
            break;
        case 502:
            $error_status = "502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
            break;
        case 503:
            $error_status = "503: service unavailable. Hopefully they'll be OK soon!";
            break;
        default:
            $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($curl);
            break;
    }
    curl_close($curl);
    echo $error_status;
    die;
}

function getAccess(){
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_URL            => "http://auth.siwooent.com/token.php",
                CURLOPT_POST           => TRUE,
                CURLOPT_POSTFIELDS     => http_build_query(
                    array(
                        'grant_type'    => "client_credentials",
                        'username'      => "test",
                        'password'      => "pass1234"
                    )
                )
            )
        );

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        $access_token = (isset($response->access_token) && $response->access_token != "") ? $response->access_token : die("Error - access token missing from response!");
		//$instance_url = (isset($response->instance_url) && $response->instance_url != "") ? $response->instance_url : die("Error - instance URL missing from response!");
	//, "instanceUrl" => $instance_url
    return array("accessToken" => $access_token);
}


//토큰받아오기 
function getToken($client_id,$client_secret){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,            'http://auth.siwooent.com/token.php' );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($ch, CURLOPT_POST,           1 );
	curl_setopt($ch, CURLOPT_POSTFIELDS,     'grant_type=client_credentials' ); 
	curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret))); 

	$result=curl_exec($ch);
	return $result;
}

//토큰유효성체크 
function chkToken($token){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,            'http://auth.siwooent.com/resource.php' ); //접속할 url주소 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($ch, CURLOPT_POST,           1 );
	curl_setopt($ch, CURLOPT_POSTFIELDS,     'access_token='.$token); 
//	curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret))); 

	$result=curl_exec($ch);
	return $result;
}

// 미가입자 사용자일 경우, 토큰발급 위한 임의 ID 생성 
function make_code($table_name, $column_name, $number_length, $first_str){
	$code_num =  1;

	//oauth db연결 
	$link_oauth = mysqli_connect('localhost', 'oauth', '452562ab', 'oauth'); 
	mysqli_set_charset($link_oauth,'utf8'); 

	$sql_code="select MAX($column_name) from $table_name WHERE $column_name like '$first_str".str_pad('', $number_length, "_")."'";
	$query_code= mysqli_query($link_oauth,$sql_code);
	
	while ($row_code = mysqli_fetch_row($query_code)) 
	{
		$code_str=$row_code[0];
		
		//echo $row_code;
		//8자리인지 체크
		if(strlen($code_str)==($number_length+strlen($first_str)))
		{
			$code_str =  substr($code_str,strlen($first_str),$number_length);
			//숫자인지 체크
			if(is_numeric($code_str))
			{
				//+1처리
				$code_num = $code_str+1;
			}
		}
	}
	//앞에 자리수만큼0 padding
	return $first_str.str_pad($code_num, $number_length, "0", STR_PAD_LEFT);
}

//=================================================================================

//put,delete일 때 보내온 key가 db에 있는 값인지 체크 
function valid_check_put_del($link,$method,$key,$table_name){ 

	if($method=='PUT'|| $method=='DELETE'){

		$sql_ck = "select * from $table_name WHERE num=$key"; //key가 없어도 error처리 //  key가 num이 아닐땐?
		$s_result = mysqli_query($link,$sql_ck);

		//echo mysqli_num_rows($s_result);
		if(mysqli_num_rows($s_result)<1){ //수정, 삭제할 row가 없다면 

			badRequestEcho(400,"No matching data found.");
		/*	A) global $bad_rq;
			echo $bad_rq; //오류 반환하고 
			die(mysqli_error()); //끝
		
			B) $array=array( "sqlError_description"=>"No matching data found.");
			echo json_encode($array);
			header("HTTP/1.1 400 Bad Request"); 
			exit;
			*/
		}
	}
}

function get_columns(){

	$arr = json_decode(file_get_contents('php://input')); //배열로 받음
	$sch_tag = $arr->sch_tag; //홍길동
	$sch_filter = $arr->sch_filter; //sailer04@naver.com
	$sch_order = $arr ->sch_order;
	//$result_arr = ['sch_tag' => $sch_tag, 'sch_filter'=> $sch_filter,'sch_order'=> $sch_order];

	return $result_arr;

}

//input object에서 컬럼과 데이터값을 추출 
function setting_set_value($link,$input,$o_num){
		
	// 컬럼, 값 
	$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input)); 
	$values = array_map(function ($value) use ($link) {
	
	  if ($value===null) return null;  
	  return mysqli_real_escape_string($link,(string)$value); //특수문자열 이스케이프 
	
	},array_values($input));
	// build the SET part of the SQL command


	$set = '';
	
	//고객num추출 
	//	global $o_num;
	if($o_num!=''){
		$set= "`o_num`= '".$o_num."'";
	}

	
	for ($i=0;$i<count($columns);$i++) {
		if(($columns[$i] == "access_token")||($columns[$i] == "personId")||($columns[$i] == "flag")){
			//echo $columns[$i];
			continue;
		}else{ 
			$set.=($set!=''?',':'').'`'.$columns[$i].'`=';
			//$set.=(count($columns[$i])>$i?',':'').'`'.$columns[$i].'`=';
			
			$set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
		}
	}//echo $set;
	return $set;
}

//주소-> gps좌표변환 
function change_gps($user_addr){

	//샵의 주소를 받아 입력 ($add1.$add2)

	//$juso = urlencode("부산광역시 해운대구 센텀4로 15 센텀시티몰 B2층");
	$juso = urlencode($user_addr);//35.1804849, 129.1256070


	//계정키 포함한 주소 (xml, json두가지 방법있지만 간단하게 xml으로 함)
	$sGoogleMapApi = "https://maps.googleapis.com/maps/api/geocode/xml?address=$juso&sensor=false&key=AIzaSyCNPLW065KQicSJmJ6Q47_D7VUijx010sk" ;
	$gps = simplexml_load_file($sGoogleMapApi);


	//좌표인식 실패일 경우
	if($gps->status!='OK') die("구글맵API에서 업체 주소에 대한 좌표를 받아 오는데 실패하였습니다!");

	$lat = $gps->result->geometry->location->lat;
	$lng = $gps->result->geometry->location->lng;

	//위도 경도 출력 
	//echo "위도:".$lat;
	//echo "<br>경도:".$lng;
	return array($lat,$lng);
}

function cal_gps($lat, $long, $km){ //사용자(위도35.1804849 경도129.1256070) 반경 km 구하는 쿼리 


	$sql="SELECT * FROM (SELECT *, (((acos(sin((35.1804849*pi()/180)) * sin((`b_gpslat`*pi()/180))+cos((35.1804849*pi()/180)) * cos((`b_gpslat`*pi()/180)) * cos(((129.1256070 -
	`b_gpslong`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance 
	FROM `Branch` ) AS brn WHERE distance < '2' ORDER BY distance;";

}

function delete_img($table_name, $column, $key){
	global $link; 
	//1. 기존의 해당 컬럼에 이미지가 있으면 삭제 후, 업로드 및 업데이트 해야함 
	$s_sql="SELECT $column FROM `$table_name` WHERE num ='$key'";
	$s_result = mysqli_fetch_row(mysqli_query($link,$s_sql));
	$s_img =$s_result[0];

	//해당 row에 기존이미지가 있다면 이미지 삭제 
	if($s_img){
		 
		//db저장된 경로에서 파일명 추출 
		$file_name = basename($s_img);
		//echo $file_name."</br>";
		
		//절대경로를 상대경로로 전환 
		$filepath = './img/'.$table_name.'/'.$file_name;
		//echo $filepath;			
		//실제로 파일이 존재한다면 삭제 
		if(is_file($filepath)) {
			unlink($filepath);
		}
	}
}

function save_img($table_name, $column, $key){
	
	// 1. 이미지 전송 -formdata로 보내니까 key값으로 유효성체크하고, num받아서 해당 row에 update시켜야함 
	// 2. update시, 이미지 경로는 따야함 
	// 3. 이미지 저장 시, 파일명을 작성자id_업로드일자 로 변환해야함 

	//echo $key;
	global $link; 

	//파일이 있을경우
	if(!empty($_FILES['pet_image'])){ 
		
		
		// 2. 파일저장 
			//var_dump($_FILES['pet_image']); //파일정보 배열로 출력 
			//var_dump($_FILES['userfile']['error']); 에러메세지 출력
			//$name = basename($_FILES['pet_image']['name']); //파일명

			ini_set("display_errors", "1"); //에러뜨면 보여주기위함  
			
			//파일 저장 경로
			$uploaddir = '/home/prape_home/www/json/img/'.$table_name.'/'; 
		
			//파일명 변경(날짜.확장자) // basename()으로 파일명 추출
			$filename = date("YmdHis").".".basename($_FILES['pet_image']['type']);
			//$filename = date("YmdHis")."_".substr($name, 0, 5).".".$type;

			//저장할 경로 (경로+파일명)
			$uploadfile = $uploaddir.$filename ; 

			//tmp에 임시저장되었던 해당파일을 경로로 옮김
			if (move_uploaded_file($_FILES['pet_image']['tmp_name'], $uploadfile)) { 
				
				//db에 저장할 경로 생성 
				$up_dir ="http://www.prape.co.kr/json/img/".$table_name."/".$filename; 
			
				
				//파일 업로드 되었으면 이전의 파일은 삭제 
				//1. 기존파일이 있는지확인  
				$s_sql="SELECT $column FROM `$table_name` WHERE num ='$key'";
				$s_result = mysqli_fetch_row(mysqli_query($link,$s_sql));
				$s_img =$s_result[0];
				echo $s_img;
				//2. 기존의 파일이 있으면 동일 파일이 1개이상인지 확인 / 1개이면 파일삭제 
				if($s_img){ 
					//$sql="SELECT * FROM `$table_name` WHERE $column = (SELECT $column FROM `$table_name` WHERE num ='$key')";

					$sql="SELECT * FROM `$table_name` WHERE $column = '$s_img'";

					$row = mysqli_query($link,$sql);
					//$cnt=mysqli_affected_rows($row);
//echo $row;
					if($cnt<2){ 
						//기존 파일 삭제
						//db저장된 경로에서 파일명 추출 
						$file_name = basename($s_img);
						//echo $file_name."</br>";
						
						//절대경로를 상대경로로 전환 
						$filepath = './img/'.$table_name.'/'.$file_name;
						//echo $filepath;			
						//실제로 파일이 존재한다면 삭제 
						if(is_file($filepath)) {
							unlink($filepath);
						}

					}
		
				}


			}else {
				print "파일 업로드 실패";
			}

	}else{
		badRequestEcho(400,"No files found");	
	//global $bad_rq;
	//	$array=array( "Error_description"=>"No files found");
	//	echo json_encode($array);
	//	exit;
	}
	return $up_dir;
}


function param_ck($arr,$param,$link){

	//print_r($param);
	//0. 앱에서 받은 인자값 확인용 
	$pageName = substr(basename($_SERVER['PHP_SELF']),0,-4); 								
	//shop-list일때, 앱에서 전송하는 인자값 로그저장
	if($pageName=='pet'){//shop-list			//style-list										 //배열을 저장
		mysqli_query($link,"insert into query_log(query_string,pagename) values('".addslashes(json_encode($arr))."','PARAM(".$pageName.")')");
	}

	//1. 받은 배열 foreach 돌면서 key만으로 구성된 배열생성  -- 이거  array_keys로 바꿀수 있지않을까 
	$keys=[];
	foreach($arr as $key=>$val) {
	
		if($pageName=='login-json'){
			array_push($keys,$key);// keys배열에 넣기
			$insertkey.=($insertkey!=''?', ':'').$key;	

		}else if($key=="access_token"||$key=="personId"||$key=="flag") {
			continue;
		}else{
			array_push($keys,$key);// keys배열에 넣기
			$insertkey.=($insertkey!=''?', ':'').$key;	
		}
	}	//print_r($keys);
	//2.변수명 배열과 인자값 배열 두 배열요소를 비교하여 불일치값 추출 (왼쪽이 기준)
	$result=array_diff($param,$keys);
	
	/*//1.  array_keys로 변경했을때 -- 객체를 받는다면 쓸 수없음.(로그인 등)
	$result=array_diff($param,array_keys($arr));
	*/
	//필수항목이 모두 존재하면 true 리턴
	if(empty($result)){
		Return true;
	}
	//불일치값이 있다면 배열형태로 출력됨.
	//print_r($result);
		/* Array(
		[1] => sch_pb_num
		[2] => sch_tag
		)*/

	// header("HTTP/1.1 400 Bad Request");
	// 불일치값이 있으면 exit
	foreach($result as $val){
	$vals.=($vals!=''?', ':'').$val;	
	}

	badRequestEcho(400,"'".$vals."' is invalid");
	
	/*$array=array("meta"=>array("code"=>"400 Bad Request","state"=>"error","error_description"=>"'".$vals."' is invalid"));
	echo json_encode($array);
	header("HTTP/1.1 400 Bad Request"); 
	exit;*/
}




//태그입력
function write_tag($tag,$style_num){

	if($tag!=''){
		
		$count=substr_count($tag, ",");
	//	echo $count;

		for($i=0;$i<=$count;$i++){
			$tag_title=explode(',',$tag)[$i];

			if($tag_title!=''){

				$query_insert_tag="INSERT INTO Tag_style (`style_num`,`tag_title`) 
									SELECT '".$style_num."','".$tag_title."' FROM DUAL
									WHERE NOT EXISTS
									(SELECT * FROM Tag_style 
										WHERE `style_num` = '".$style_num."'
										AND `tag_title` = '".$tag_title."'
									);";
				global $link; 
				$result_insert_tag=mysqli_query_log($link,$query_insert_tag);
				//echo $query_insert_tag;
			}
		}
	}
}
?>