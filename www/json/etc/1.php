<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
</head>   
<body>
<?php //

var_dump($_FILES['userfile']); //파일정보 배열로 출력 
//var_dump($_FILES['userfile'][]);
//var_dump($_FILES['userfile']['error']); 에러메세지 출력


ini_set("display_errors", "1"); //에러뜨면 보여주기위함  
//echo getcwd();

$uploaddir = '/home/prape/www/json/img/'; //파일 저장 경로 
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);  // basename()으로 파일명 추출해서 경로에 붙임 
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) { //tmp에 임시저장되었던 해당파일을 경로로 옮김
    echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";
/*
// curl로 파일전송  
	try {
	 $upload_file_path = '/home/prape/www/json/img/aaaa.png'; # 업로드할 파일
	 $url = "http://prape.co.kr/json/post_img.php"; # 업로드 수신측 URL
	 $data = array(
	  'file' => "@{$upload_file_path};type=text/plain", # type=<MIME Type>
	 );
	 if(!file_exists($upload_file_path)) throw new Exception('Data does not exists');
	 $ch = curl_init($url);
	 if($ch === FALSE) throw new Exception('Fail to initialize curl session');
	 curl_setopt($ch, CURLOPT_HEADER, FALSE); # 결과에 헤더 정보를 출력하지 않음  
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); # 응답 내용을 반환
	 curl_setopt($ch, CURLOPT_POST, TRUE); # POST 방식
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $data); # POST 데이터
	 $result = curl_exec($ch);
	 if($result === FALSE) throw new Exception('Fail to execute curl session');
	 curl_close($ch);
	 echo $result."\n";


	} catch(Exception $e) {
	 echo $e->getMessage()."\n";
	}
*/
/*
if($_FILES) 
{	
    $filename = $_FILES['userfile']['tmp_name']; //  /tmp/phpHUD8Vf


	echo '@@'.$filename; 

    $handle = fopen($filename, "r"); //해당파일 열기(읽기)
		//Warning:  fopen(/tmp/phpZpbouh): failed to open stream: No such file or directory in /home/prape/www/json/1.php on line 55
    $data = base64_encode(fread($handle, filesize($filename))); //fread(파일위치, 불러올 크기) //서버에 저장된 파일을 정한크기만큼 읽어옴 
	
    // $data is file data 
    $post   = array('imagefile' => $data); 
    $timeout = 30; 
    $curl    = curl_init(); 

    curl_setopt($curl, CURLOPT_URL, 'http://beauty.siwooent.com/uploaded/post_img.php'); 
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); 
    curl_setopt($curl, CURLOPT_POST, 1); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post); 

    $str = curl_exec($curl); 

    curl_close ($curl); 
    print_r($str); 
    /* 
    결과: 
    Array ( 
        [imagefile] => /9j/4AAQSkZJRgABAgEAYABgAAD/7gAOQWRv.... 
    )  
    
} */




} else {
    print "파일 업로드 공격의 가능성이 있습니다!\n";
}
echo '자세한 디버깅 정보입니다:';
print_r($_FILES);
print "</pre>";
?>
</body>
</html>