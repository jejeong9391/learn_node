<?php

// ======== 응답코드 =========================================
#참고) 
//mysqli_num_rows() : 전체 데이터 수 반환 
//mysqli_affected_rows() : 변경된 row수 반환 (upd->이전테이터와 차이 없을경우, 해당데이터 없을경우 0반환)
//mysqli_fetch_object : 쿼리결과를 객체로 만듦 

if ($method == 'GET') { //조회
header("HTTP/1.1 200 OK");
			echo '
	{ 

		"meta": {
			
			"msg": "'.$table_name.' list ",
			"rows": "'.mysqli_num_rows($result).'"';
		//전체 데이터 개수필요한 경우 (샵리스트)
		if($cnt_row){
			echo ',
			"total": "'.$cnt_row[cnt].'"';
		}

		echo '
			
		  
		},

		  "data": [
		';
				for ($i=0;$i<mysqli_num_rows($result);$i++) {

					$obj = mysqli_fetch_object($result); //row를 하면 pro_list가 나오는데 object라서 안나옴?
					//echo $obj[0];
					foreach ($obj as $k=>$v){
				
						if($k=='wn_contents'){ // 공지사항 내용 출력 시
						//$v=html_entity_decode($v);
						//echo $v;
					
						}

					if (strlen($v)>2){// value 길이가 2이상이면 

						$val = strstr($v,'['); //찾을 문자열이 나온 처음 위치부터 끝까지 반환
						//if (is_string($val)) $val= '"'.addslashes($val).'"'; 
						if($val!='') { // '['문자열이 있으면 json을 임의로 만든것이기때문에 디코드한다음, 제대로 인코드해야함 

						//echo json_decode($val,JSON_UNESCAPED_UNICODE);  //기본적으로 json형태 
						$obj->$k = json_decode($val,JSON_UNESCAPED_UNICODE); //해당 key값에 디코드한 val값 대입 ==string
						}
					}
				}
					//json형태 정렬때문에 echo 줄바꿈 
				echo ($i>0?',':'').json_encode($obj,JSON_UNESCAPED_UNICODE); //두번반복은 안됨 / 한글 인코딩 깨짐 


				  }
			echo '
			
			]
}';

}elseif ($method == 'POST') { //insert
		
		
	header("HTTP/1.1 201 OK");
	/*echo '
		{ 
			"meta": {

				"msg": "'.$table_name.' INSERT success"
				
			}';
			//마지막 insert num이 필요한경우 (img업로드)
			if($last_num){
				echo ',

			 "data": 

				{ "num" : "'.$last_num.'" }

				
				';
			}

			  
	echo '
		}';
	*/
	$array=array(
		meta=>array(msg=>$table_name.' INSERT success'),
		data=>array(row=>mysqli_affected_rows($link))
	);

	echo json_encode($array,JSON_UNESCAPED_UNICODE); 
		
			
}elseif ($method == 'PUT') { //update
	
	//header("HTTP/1.1 204 OK");
	$array=array(
		meta=>array(msg=>$table_name.' UPDATE success'),
		data=>array(row=>mysqli_affected_rows($link))
	);

	echo json_encode($array,JSON_UNESCAPED_UNICODE); 

}elseif ($method == 'DELETE') { //delete 
			
		//header("HTTP/1.1 204 OK");
		//mysql_affected_rows써볼것  //지금 실행된 행이 있으면 succ , 실행할 행이 없으면 fail던질까말까 고민중 
		/*if(mysqli_insert_id($link)==0){ //실행된 행이 없음

			echo '
			"msg": "Pet list Delete fail"
			}';
		}else{ //예외처리해야함 지금 모든경우 fail일때 아무것도 출력안됨 
			  echo '
			{ 
				"meta": {
					"msg": "'.$table_name.' list DELETE success"
				}
		}';
		//}*/ 
			
	$array=array(
		meta=>array(msg=>$table_name.' list DELETE success'),
		data=>array(row=>$last_num)
	);

	echo json_encode($array,JSON_UNESCAPED_UNICODE); 
}

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
