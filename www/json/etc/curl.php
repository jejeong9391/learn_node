<?
include "./function.php";
$data_return = array(
'token' => '80784939a2ee6bd4417fadd17889f7109c6c2b4d'
);
//CallAPI("token.php","POST","", $data_return, "test","pass1234");

//echo $data_return -> access_token;

//echo getAccess();
//echo getToken("test","pass1234");

echo chkToken("80784939a2ee6bd4417fadd17889f7109c6c2b4d");
//CallAPI("http://auth.siwooent.com/check_token.php","POST","", $data_return);

?>