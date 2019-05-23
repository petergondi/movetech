<?php
date_default_timezone_set('Africa/Nairobi');
# access token
$consumerKey = env("MPESA_CONSUMER_KEY"); //Fill with your app Consumer Key
$consumerSecret = env("MPESA_CONSUMER_SECRET"); // Fill with your app Secret
$BusinessShortCode = '400153';
$Passkey = '53c4b78a6a03180c4bc923650161b2eea4ceefdd550e91d5341463cc83abbe63';  
$PartyA = "254".(int)$userphone;; // This is your phone number, 
$AccountReference =  $cartno;
$TransactionDesc = 'CART PAYMENT';
$Amount =$request->min;

# Get the timestamp, format YYYYmmddhms -> 20181004151020
$Timestamp = date('YmdHis');    
# Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
$Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);
# header for access token
$headers = ['Content-Type:application/json; charset=utf8'];
  # M-PESA endpoint urls
$access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$initiate_url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
# callback url
$CallBackURL = 'https://9c24323b.ngrok.io/Mpesa/callback.php';  
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = json_decode($result);
$access_token = $result->access_token;  
curl_close($curl);
# header for stk push
$stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];
# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $initiate_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header
$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $Amount,
  'PartyA' => $PartyA,
  'PartyB' => $BusinessShortCode,
  'PhoneNumber' => $PartyA,
  'CallBackURL' => $CallBackURL,
  'AccountReference' => $AccountReference,
  'TransactionDesc' => $TransactionDesc
);
$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
print_r($curl_response);
echo $curl_response;