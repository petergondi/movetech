<?php

namespace App\Http\Controllers;
use App\Credit;
use App\User;
use App\Checking;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Product;
use App\Vendor;
use App\Cart;
use App\CartOrder;
use App\Capping;
use DB;
use Illuminate\Support\Facades\Response;
use App\SMSSetting;
use App\AdminCharge;
use Carbon\Carbon;
use App\Transactions;
use App\Reminders;
use App\test;
use Samerior\MobileMoney\Mpesa\Events\StkPushPaymentSuccessEvent;
use App\Providers\EventServiceProvider;
use Samerior\MobileMoney\Mpesa;
use App\C2B;
use App\STKpush;


class MpesaController extends Controller
{
   
    public function callback(Request $request)
{
    
    $stkCallbackResponses = $request['Body']['stkCallback']['ResultCode'];
   // $json = json_decode($response['Body']['stkCallback']['CallbackMetadata'],TRUE); 
     $cartno=Cache::get('cartno');
     $phonenumber=Auth::user()->phonenumber;
     $name=Auth::user()->name;
   if($stkCallbackResponses==0){
       $validate=STKpush::where('MerchantRequestID',$request['Body']['stkCallback']['MerchantRequestID'])->first();
      if($validate){
    $Amount=  $request['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $mpesareceiptcode= $request['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
    $date= date("m-d-Y", strtotime($request['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'])); 
    $time= date("h:i:s a", strtotime( $request['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value']));
    $phone=$request['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
         $user=Auth::user()->id;
       //check if there is a similar transaction in the db
         $check=Transactions::where('ReceiptNumber',$mpesareceiptcode)->first();
         if(!$check){
        $allproducts = Cache::get('cartproducts');
        
          if($allproducts)
          {
                $transaction= new Transactions;
                $transaction->user_id=$user;
                $transaction->Amount=$Amount;
                $transaction->CartNo=$cartno;
                $transaction->ReceiptNumber=$mpesareceiptcode;
                $transaction->Phonenumber=$phone;
                $transaction->Date=$date;
                $transaction->Time=$time;
                $transaction->save();
        
        ////save orders to db
               $date_today=date("m/d/Y");
               $datetime=date("Y-m-d H:i:s", strtotime('+3 hours'));
               $location=Cache::get('location');
              //posting items in cart to confiemd orders table
               $cachedtotalcost=array_sum(array_column($allproducts, 'totalcost'));
               $post = new CartOrder;
               $post->customer_id = $user;
               $post->customername =$name;
               $post->CartNo =$cartno;
               $post->phonenumber = $phonenumber;
               $post->email = Auth::user()->email;
               $post->location = $location;
               $post->totalcost= $cachedtotalcost;
               $post->DueAmount= $cachedtotalcost-$Amount;
               $post->status= 'confirmed';
               $post->date = $date_today;
               $post->datetime= $datetime;
               $post->save();
          //save to cart
           foreach($allproducts as $allproduct){
               $post = new Cart;
               $post->cartorder =$cartno;
               $post->user_id= $user;
               $post->customername =$name;
               $post->bussinessname = $allproduct->bussinessname;
               $post->productid = $allproduct->id;
               $post->modelnumber = $allproduct->modelnumber;
               $post->productname = $allproduct->productname;
               $post->size= $allproduct->size;
               $post->color= $allproduct->color;
               $post->pieces = $allproduct->pieces;
               $post->costperpiece = $allproduct->costperpiece;
               $post->totalcost= $allproduct->totalcost;
               $post->status= 'confirmed';
               $post->date = $date;
               $post->datetime= $datetime;
               $post->save();
                   }
                   //
                   $cap= Auth::user()->cap;
                   $balance= Auth::user()->balance;
                   if($balance==''){
                       $maxcap=$cap;
                   }else{
                       $maxcap=$balance;
                   }
                   $customercapbalance=$maxcap-$cachedtotalcost;
                  User::where('name',$name)->update(['balance'=>$customercapbalance]);
                   $totalcost=round(0.25*$cachedtotalcost);
                   if(!($totalcost==$cachedtotalcost)){
                       $additional=$cachedtotalcost-($totalcost*4);
                   }
                   else {
                       $additional=0;
                   }
                $balances=[$Amount,$totalcost,$totalcost,($totalcost+$additional)];
                $Date1= date("Y-m-d");
                $Date2=date('Y-m-d', strtotime($Date1. ' + 14days'));
                $Date3=date('Y-m-d', strtotime($Date1. ' + 28days'));
                $Date4=date('Y-m-d', strtotime($Date1. ' + 42days'));
                $dates=[$Date1,$Date2,$Date3,$Date4];
                $schedules=['First','Second','Third','Final'];
                $status=['Confirmed','pending','pending','pending'];
                
                //inserting paid cart to remindrs table
                foreach($balances as $key=>$balance)
                {
                 $reminder=new Reminders;
                 $reminder->CartNo=$cartno;
                 $reminder->user_id=$user;
                 $reminder->date=$dates[$key];
                 $reminder->schedule=$schedules[$key];
                 $reminder->amount=$balance;
                 $reminder->name=$name;
                 $reminder->phonenumber=$phonenumber;
                 $reminder->status=$status[$key];
                 $reminder->save();
                }
                   //Reminders::insert($data);
                Cache::forget('cartproducts');
                Cache::forget('location');
                Cache::forget('cartno');
                $due=$cachedtotalcost-$Amount;
                 //send text once a payment is made
                 $message='Dear '.$name.', you have successfully paid Kshs:'.$Amount.',for your first payment for Cart: 4567, Remaining Amount:'.$due;
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
                    'to' => "254".(int)$phonenumber,
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
                return response()->json(['state' => 'success']);
          }
                
    }  
} 
}
 else{
               response()->json(['state' => 'timeout']);
               //$request->session()->flash('alert-danger', 'An error has occured in your payment');
               $message='Dear,'.$name.'Your Payment for'.$cartno.' has failed';
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
                    'to' => "254".(int)$phonenumber,
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
               //return redirect()->route('viewcart');
          }  
    
}
   
}
