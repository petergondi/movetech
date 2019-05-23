<?php
   $stkCallbackResponse = file_get_contents('php://input');
   $data = file_get_contents($stkCallbackResponse); // put the contents of the file into a variable
   $json = json_decode($stkCallbackResponse,TRUE); 
           $Amount= $json['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
            $mpesareceiptcode= $json['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $date= date("m-d-Y", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'])); 
            $time= date("h:i:s a", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value']));
            $phone= $json['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
            $results=[
              'Amount'=>$Amount,
              'ReceiptNumber'=>$mpesareceiptcode,
              'Phonenumber'=>$phone,
              'Date'=> $date,
              'Time'=>$time
            ];
   //return $results;
   $logFile = "stkPushCallbackResponse.txt";
   $log = fopen($logFile, "a");
   fwrite($log, $stkCallbackResponse);
   fclose($log);
   //$test=2;

