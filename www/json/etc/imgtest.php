<?


$apiUrl="http://prape.co.kr/json";
$apiUrl.="/media";
//$apiUrl.="?key_identity=XXX&key_credential=YYY";

$data = [];
$itemId=7;
$array=[
    "o:ingester"=> "upload",
    "file_index"=> "0",
    "o:item"=> ["o:id" => $itemId] 
    ];
$data['data']=json_encode($array);
$data['file[0]'] = new CURLFile('test.txt','text/plain','newFileName');
// Note that the value must be a string, not an array (CURLFile objects are
//automatically parsed into String) so you must set the key as 'file[0]'

$options=[
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => ['Content-Type: multipart/form-data']
    ];

$ch = curl_init($apiUrl);
curl_setopt_array($ch, $options);
$result=curl_exec($ch);
curl_close($ch);

var_dump($result);
?>