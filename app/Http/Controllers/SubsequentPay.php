<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CartOrder;
use App\Reminders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\SMSSetting;

class SubsequentPay extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function initiatePay()
    {
        $userphone=Auth::user()->phonenumber;
        $id=Auth::user()->id;
    $check_next_payment=Reminders::where('user_id',$id)->where('status','pending')->first();
    if($check_next_payment){
        date_default_timezone_set('Africa/Nairobi');
            $BusinessShortCode ='400153';
            $PartyB=$BusinessShortCode;
            $LipaNaMpesaPasskey ='53c4b78a6a03180c4bc923650161b2eea4ceefdd550e91d5341463cc83abbe63';     
            $CallBackURL="https://callback.4paykenya.co.ke/Mpesa/subsequent.php";
            $PartyA ="254".(int)$userphone; // This is your phone number, 
            $PhoneNumber ="254".(int)$userphone;
            $AccountReference =$check_next_payment->CartNo.":second pay";
            $TransactionDesc ='CART PAYMENT';
            $Amount =$check_next_payment->amount;
            $Timestamp =date('YmdHis');    
            $Remarks="Thank You for Shopping with us";
            $TransactionType="CustomerPayBillOnline";
            # header for access token
            $mpesa= new \Safaricom\Mpesa\Mpesa();
            $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, 
            $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks);
            //print_r($stkPushSimulation);
            //return 
    }
    
    }
    public function confirm(Request $request){
             //include('https://callback.4paykenya.co.ke/Mpesa/subsequent.php');
             $stkCallbackResponse = $request['Body']['stkCallback']['ResultCode'];
             $json = json_decode($request['Body']['stkCallback']['CallbackMetadata'],TRUE); 
             $Amount= $json['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
             $mpesareceiptcode= $json['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
             $date= date("m-d-Y", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'])); 
             $time= date("h:i:s a", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value']));
             $phone= $json['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
             $id=Auth::user()->id;
             $name=Auth::user()->name;
             //check if the the transaction went through
             if($stkCallbackResponse==0){
              $check_next_payment=Reminders::where('user_id',$id)->where('status','pending')->first();
              if($check_next_payment){
                 $cartno=$check_next_payment->CartNo;
                 $not_paid=CartOrder::where('customer_id',$id)->where('CartNo', $cartno)->where('status','confirmed')->first();
                 
                 //subtract the new paid amount to the pending balance
                  $DueAmount=$not_paid->totalcost-$Amount;
                 Reminders::where('user_id',$id)->where('status','pending')->first()->update(['status'=>'confirmed']);
                  $DueAmount=$not_paid->totalcost-$Amount;
                 CartOrder::where('customer_id',$id)->where('CartNo', $cartno)->update(['DueAmount'=>$DueAmount]);
                 //send text once a payment is made
                 $message='Dear '.$name.', you have successfully paid your'.$check_next_payment->schedule.'payment for Cart:'.$cartno;
                 $settings=SMSSetting::all()->first();
                 if(empty($settings)){
                     $username = '';
                     $apikey =  '';
                     $senderid =  '';
            }else{
                $url="https://sms.movesms.co.ke/api/portalcompose?";
                $username = $settings->username;
                $apikey = $settings->apikey;
                $senderid = $settings->senderid;
    
                $postData = array(
                    'username' => $username,
                    'api_key' => $apikey,
                    'sender' => $senderid,
                    'to' => $check_next_payment->phonenumber,
                    'message' => $message,
                    'msgtype' => 5,
                    'dlr' => 0,
                );
    
    
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postData
    
                ));
    
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
                $output = curl_exec($ch);
    
                if (curl_errno($ch)) {
                    // echo 'error:' . curl_error($ch);
                    $output = curl_error($ch);
                }
    
                curl_close($ch);
                }
                 if($DueAmount==0){
                 CartOrder::where('customer_id',$id)->where('CartNo', $cartno)->update(['status'=>'complete']);
                 //send sms when the use completes paying cart
                 $message='Dear '.$name.', you have successfully completed paying your items'.$cartno;
                 $settings=SMSSetting::all()->first();
                 if(empty($settings)){
                     $username = '';
                     $apikey =  '';
                     $senderid =  '';
            }else{
    
                $url="https://sms.movesms.co.ke/api/portalcompose?";
                $username = $settings->username;
                $apikey = $settings->apikey;
                $senderid = $settings->senderid;
    
                $postData = array(
                    'username' => $username,
                    'api_key' => $apikey,
                    'sender' => $senderid,
                    'to' => $check_next_payment->phonenumber,
                    'message' => $message,
                    'msgtype' => 5,
                    'dlr' => 0,
                );
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postData
    
                ));
    
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
                $output = curl_exec($ch);
    
                if (curl_errno($ch)) {
                    // echo 'error:' . curl_error($ch);
                    $output = curl_error($ch);
                }
                curl_close($ch);
            }
    
            }
         }
        
    }
}
}

