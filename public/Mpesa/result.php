<?php
date_default_timezone_set('Africa/Nairobi');
$consumerKey = 'Hg51ApysiYGs70K5MTgKGkStaRnndWuZ'; //Fill with your app Consumer Key
$consumerSecret = 'UYDncaQd2fxyFllV'; // Fill with your app Secret
# define the variales
# provide the following details, this part is found on your test credentials on the developer account
$BusinessShortCode = '174379';
$Passkey ='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
/*
  This are your info, for
  $PartyA should be the ACTUAL clients phone number or your phone number, format 2547********
  $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
  TransactionDesc can be anything, probably a better description of or the transaction
  $Amount this is the total invoiced amount, Any amount here will be 
  actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction. 
  for developer/test accounts, this money will be reversed automatically by midnight.
*/
$PartyA = 254725272888; // This is your phone number, 
$AccountReference = 'Cart001';
$TransactionDesc = 'cART PAYMENT';
$Amount = '1';
# Get the timestamp, format YYYYmmddhms -> 20181004151020
$Timestamp = date('YmdHis');    
# Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
$Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);
# header for access token
$headers = ['Content-Type:application/json; charset=utf8'];
  # M-PESA endpoint urls
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
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

//start of response
$url_query = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
$curl_init = curl_init();
curl_setopt($curl_init, CURLOPT_URL, $url_query);
curl_setopt($curl_init, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer'.$access_token)); //setting custom header
$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => base64_encode($BusinessShortCode.$Passkey.$Timestamp),
  'Timestamp' => $Timestamp,
  'CheckoutRequestID' =>'ws_CO_DMZ_335002314_09052019112745032'
);
$data_string = json_encode($curl_post_data);
curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_init, CURLOPT_POST, true);
curl_setopt($curl_init, CURLOPT_POSTFIELDS, $data_string);

$curl_responses = curl_exec($curl_init);
print_r($curl_responses);

echo $curl_responses;