<?php
 $url = 'stkPushCallbackResponse.txt'; // path to your JSON file
 $data = file_get_contents($url); // put the contents of the file into a variable
 $json = json_decode($data,TRUE);
$results=$json['Body']['stkCallback']['ResultCode'];
if($results==1037){
print_r("failed");
}
else{
    print_r("success");
}
//print_r($results);