<?php
    $consumerKey ='6pcuMPffphYxuoyskadeSibUKzwowUdj'; //Fill with your app Consumer Key
    $consumerSecret = '2hgcoKnS9i1K40hS'; // Fill with your app Secret
    $headers = ['Content-Type:application/json; charset=utf8'];
    $urls = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $curls = curl_init($urls);
    curl_setopt($curls, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curls, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curls, CURLOPT_HEADER, FALSE);
    curl_setopt($curls, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
    $result = curl_exec($curls);
    $status = curl_getinfo($curls, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    $access_token = $result->access_token;
	$url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header
	$curl_post_data = array(
	  //Fill in the request parameters with valid values
	  'ShortCode' => "400153",
	  'ResponseType' => 'Confirmed',
	  'ConfirmationURL' => "https://callback.4paykenya.co.ke/Mpesa/confirmation.php",
	  'ValidationURL' =>"https://callback.4paykenya.co.ke/Mpesa/Mpesa/validation.php"
	);
	$data_string = json_encode($curl_post_data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	$curl_response = curl_exec($curl);
	print_r($curl_response);
	echo $curl_response;
?>