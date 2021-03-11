<?php
$table_name = 'Pet';
//include 'db_con.php'; 
include "./lib/function.php";
//include "./lib/common_rest.php";



// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD']; //요청방식 (post) 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); 

if($method=='POST'){//파일받아서 저장 

		var_dump($_FILES['pet_image']); //파일정보 배열로 출력 
		//var_dump($_FILES['userfile'][]);
		//var_dump($_FILES['userfile']['error']); 에러메세지 출력


		//exit; //종료 /아래줄 코드 실행하지않음 
		ini_set("display_errors", "1"); //에러뜨면 보여주기위함  
		//echo getcwd();
		//$uploaddir = '211.123.162:/home/prape/www/json/img/';
		$uploaddir = '/home/prape/www/json/img/'; //파일 저장 경로 
		echo'11';
		$uploadfile = $uploaddir . basename($_FILES['pet_image']['name']);  // basename()으로 파일명 추출해서 경로에 붙임 
		echo '<pre>';
		if (move_uploaded_file($_FILES['pet_image']['tmp_name'], $uploadfile)) { //tmp에 임시저장되었던 해당파일을 경로로 옮김
			echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";

		} else {
			print "파일 업로드 공격의 가능성이 있습니다!\n";
		}
		echo '자세한 디버깅 정보입니다:';
		print_r($_FILES);
		print "</pre>";


}

?>
