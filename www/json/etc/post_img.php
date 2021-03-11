<?php

echo '이건 post_img입니다.';
print_r($_POST); 

// 내용을 임시 파일로 만들어서 uploaded 폴더에 저장합니다. 
$str = base64_decode($_POST['imagefile']); 
$tmpfname = tempnam("/tmp", "test_");  
$handle = fopen($tmpfname, "wb");  
fwrite($handle, $str);  
fclose($handle);  

move_uploaded_file($tmpfname, "uploaded/test.gif"); 


?>