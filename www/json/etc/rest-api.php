<?php
 
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD']; //요청방식 (post) 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); // 요청 경로 (json/auth-token.php) -- 기존 소스는 여기에 table까지 적어서 보내는 방식이라 테이블을 추출하기위해 이게 필요함/ 그러므로 경로에 테이블 명시하지않는 지금은 필요없음  

$input = json_decode(file_get_contents('php://input'),true);
 // json_decode는 json을 php의 배열로 변환해주는 함수 
 //
 
// connect to the mysql database
$link = mysqli_connect('localhost', 'beauty', '452562ab', 'beauty'); 
mysqli_set_charset($link,'utf8');
 
// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$key = array_shift($request)+0; 
 
// escape the columns and values from the input object
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input)); 
$values = array_map(function ($value) use ($link) {
  if ($value===null) return null;
  return mysqli_real_escape_string($link,(string)$value); //특수문자열 이스케이프 
},array_values($input));
// build the SET part of the SQL command


$set = '';
for ($i=0;$i<count($columns);$i++) {
  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}
 //echo 'rest_api입니다.&nbsp;&nbsp;';
// create SQL based on HTTP method
switch ($method) {
  case 'GET':
    $sql = "select * from `$table`".($key?" WHERE num=$key":''); break;
  case 'PUT':
    $sql = "update `$table` set $set where num=$key"; break;
  case 'POST':
    $sql = "insert into `$table` set $set"; break;
  case 'DELETE':
    $sql = "delete FROM `$table` where num=$key"; break;
}

// excecute SQL statement
$result = mysqli_query($link,$sql);
 
// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
 
// print results, insert id or affected row count
if ($method == 'GET') {
  if (!$key) echo '<br/>[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').'<br/><br/>'.$table.'<br/>'.$sql.'<br/>'.json_encode(mysqli_fetch_object($result));
  }
  if (!$key) echo ']';
} elseif ($method == 'POST') {
  echo mysqli_insert_id($link);
} else {
  echo mysqli_affected_rows($link);
}
 echo '&nbsp;##요청에 따라 rest_api가 쿼리 만들어서 json으로 만들었어요'.$method;
// close mysql connection
mysqli_close($link);

?>