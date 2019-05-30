<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CartOrder;
use App\Reminders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        include('https://callback.4paykenya.co.ke/Mpesa/subsequent.php');
        $id=Auth::user()->id;
        //check if the the transaction went through
        if($mpesareceiptcode){
         $check_next_payment=Reminders::where('user_id',$id)->where('status','pending')->first();
         if($check_next_payment){
            $cartno=$check_next_payment->CartNo;
            $not_paid=CartOrder::where('customer_id',$id)->where('CartNo', $cartno)->where('status','confirmed')->first();
             //update the two tables on re
            //subtract the new paid amount to the pending balance
             $DueAmount=$not_paid->totalcost-$Amount;
            Reminders::where('user_id',$id)->where('status','pending')->first()->update(['status'=>'confirmed']);
             $DueAmount=$not_paid->totalcost-$Amount;
            CartOrder::where('customer_id',$id)->where('CartNo', $cartno)->update(['DueAmount'=>$DueAmount]);
            if($DueAmount==0){
            CartOrder::where('customer_id',$id)->where('CartNo', $cartno)->update(['status'=>'complete']);
            }
            $check_remaining_installments=Reminders::where('user_id',$id)->where('status','pending')->get();
            if(count($check_remaining_installments)==0){
                response()->json(['state' => 'you have finished paying for your items,you will receive information about delivery via text']);
            }
         }
        
    }
}
}

