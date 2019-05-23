<?php
  $url = 'stkPushCallbackResponse.txt';
  $data = file_get_contents($url); // put the contents of the file into a variable
  $json = json_decode($data,TRUE); 
  //getting result code
  $json_status=$json['Body']['stkCallback']['ResultCode'];
  if($json_status==0)
  {
   $dbhost = "localhost";
    $dbname = "ecommerce";
    $dbusername = "root";
    $dbpassword = "";
    $Amount= $json['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $mpesareceiptcode= $json['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
    $date= date("m-d-Y", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'])); 
    $time= date("h:i:s a", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value']));
    $phone= $json['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];

    $link = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data=[
      'Amount'=>$Amount,
      'ReceiptNumber'=>$mpesareceiptcode,
      'Phonenumber'=>$phone,
      'actual_date'=>$date,
      'actual_time'=>$time,
      'status'=>'pending'
    ];
    try {
      $stm = $link->prepare('select count(*) from `test` where `ReceiptNumber`=:ReceiptNumber');
    $stm->bindParam(':ReceiptNumber', $mpesareceiptcode);
    $stm->execute();
    $res = $stm->fetchColumn();
      if(!$res>0){
         $statement ="INSERT INTO test(Amount,ReceiptNumber,Phonenumber,actual_date,actual_time,status)VALUES(:Amount,:ReceiptNumber,:Phonenumber,:actual_date,:actual_time,:status)";
         $stmt= $link->prepare($statement);
         $stmt->execute($data);
      }
        
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
  }

