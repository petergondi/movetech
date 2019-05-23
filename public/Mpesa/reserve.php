<?php
date_default_timezone_set('Africa/Nairobi');
$BusinessShortCode ='400153';
$PartyB=$BusinessShortCode;
$LipaNaMpesaPasskey = '53c4b78a6a03180c4bc923650161b2eea4ceefdd550e91d5341463cc83abbe63';     
$CallBackURL="https://9c24323b.ngrok.io/Mpesa/callback.php";
$PartyA ="254".(int)$userphone; // This is your phone number, 
$PhoneNumber ="254".(int)$userphone;
$AccountReference = $cartno;
$TransactionDesc = 'CART PAYMENT';
$Amount =$request->min;
$Timestamp = date('YmdHis');    
$Remarks="Thank You for Shopping with us";
$TransactionType="CustomerPayBillOnline";
# header for access token
$mpesa= new \Safaricom\Mpesa\Mpesa();

$stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, 
$Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks);
//print_r($stkPushSimulation);
//return $stkPushSimulation;