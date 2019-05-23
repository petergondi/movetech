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
 //require (__DIR__.'/../../callback.php');
class GuestCustomerHomeController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $cachedtotalcosts;
    protected $url;
    public function customerhome()
    {
        $this->url="ww.bbc.com";
            //return Auth::user()->name;
            $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
            $categories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC limit 5 ") );
            $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
            $productids =Cache::get('productid');

            if($productids!=''){
                
                $products=Product::where('id', $productids)->first();
                if($products){
                    $productname=$products->productname;
                    $results=Product::where('productname', 'LIKE', '%' . $productname . '%')->get();
                    return view('viewsingleproductbody')->with(compact('results','vendors','leftcategories','products'));
        
                }else{
                    return view('guestmainlayout')->with(compact('vendors','categories','leftcategories'));
                }

            }if($productids==''){
                return view('guestmainlayout')->with(compact('vendors','categories','leftcategories'));
            }

        
    }
    public function share(){
        return $this->url;//\Share::load($this->url, 'My example')->facebook();
    }

    public function addproduct_tocart(Request $request){
        $size=$request->size;
        $color=$request->color;
        $pieces=$request->pieces;
        $id=$request->idd;
        if($pieces==''){
            $noofpieces=1;
        }else{
            $noofpieces=$pieces;
        }

        $productresult=Product::where('id',$id)->first();
        if(!$productresult){

            return Response::json(['error' => 'No Product Found']);
        }
        $id=$productresult->id;
        $modelnumber=$productresult->modelnumber;
        $productname=$productresult->productname;
        $currentcost=$productresult->currentcost;
        $bussinessname=$productresult->bussinessname;

        $totalcost=($currentcost*$noofpieces);
        $newitem=array(['id'=>$id,'bussinessname'=>$bussinessname,'size'=>$size,'color'=>$color,'modelnumber'=>$modelnumber,'productname'=>$productname,'pieces'=>$noofpieces,'costperpiece'=>$currentcost,'totalcost'=>$totalcost]);
        
        $all_newitem= json_decode (json_encode ($newitem), FALSE);
        $admincharge=AdminCharge::where('id',1)->pluck('fee');
        $result=User::where('name',Auth::user()->name)->first();
        if($result){
            $cap=$result->cap;
            $balance=$result->balance;
            if($balance==''){
                $cap=$cap;
            }else{
                $cap=$balance;
            }
                    
                    $allproducts = Cache::get('cartproducts');
                    if($allproducts!=''){
                        
                        $cachedtotalcost =array_sum(array_column($allproducts, 'totalcost'));
                        
                        $currenttotalcost=$admincharge[0]+$cachedtotalcost+$totalcost;
                        if($currenttotalcost<=$cap){
                            $new_objectitem = array_merge($allproducts,$all_newitem);
                        }else{
                            $capbalance=$cap-$cachedtotalcost;
                            return Response::json(['error' => 'Your Cap Balance is: '.$capbalance]);
                        }
                        
                    }else{
                        $currenttotalcost=$totalcost;
                        if($currenttotalcost<=$cap){
                            $new_objectitem =$all_newitem;
                        }else{
                            
                            $capbalance=$cap-$currenttotalcost;
                            return Response::json(['error' => 'Your Maxmum Cap is: '.$cap]);
                        }
                        
                    }
                   //check if the user has pending payments
                   $userid=Auth::user()->id;
                   $check_existing_debt=Reminders::where('user_id',$userid)->where('status','pending')->first();
                   if($check_existing_debt){
                    return Response::json(['error' => 'You have existing unpaid items']);
                   }
                    Cache::put('cartproducts', $new_objectitem, 34010);
                    return Response::json(['error' => 'Success']);
        }else{
            return Response::json(['error' => 'Acc. Not Found.']);
        }
    }

    public function view_cart(){
         
        //  $other_collection=Product::where('id', 8)->get(['id','modelnumber','productname']);
        //  Cache::put('products', $other_collection, 34010);

        //Cache::forget('cartproducts');
         $allproducts = Cache::get('cartproducts');
       return  $allproducts;

            $collection=Product::where('id', 8)->first();
            $id=$collection->id;
            $modelnumber=$collection->modelnumber;
            $productname=$collection->productname;
            $totalcost=300;
            $newarray=array(['id'=>$id,'modelnumber'=>$modelnumber,'productname'=>$productname,'totalcost'=>$totalcost]);

            $all_categories= json_decode (json_encode ($newarray), FALSE); //array to object
         Cache::put('products', $all_categories, 34010);
         $allproducts = Cache::get('products');
     //return  $allproducts = Cache::get('products');
        
     $other_collectiondb=Product::where('id', 6)->first();
     $id=$other_collectiondb->id;
     $modelnumber=$other_collectiondb->modelnumber;
     $productname=$other_collectiondb->productname;
     $totalcost=500;
     $newarrayn=array(['id'=>$id,'modelnumber'=>$modelnumber,'productname'=>$productname,'totalcost'=>$totalcost]);
     $otherall_categories= json_decode (json_encode ($newarrayn), FALSE);
   
        $new_objectproduct = array_merge($allproducts,$otherall_categories);
        Cache::put('products', $new_objectproduct, 34010);
         $allproducts = Cache::get('products');

         foreach($allproducts as $allproduct){
            $post = new Capping;
            $post->cap = $allproduct->totalcost;
            $post->save();
         }
       return  $allproducts;
    }

    public function vi_ew_cart(Request $request){
        $admincharge=AdminCharge::where('id',1)->pluck('fee');
        $allproducts = Cache::get('cartproducts');
        if($allproducts){
            $cachedtotalcost = $admincharge[0] + array_sum(array_column($allproducts, 'totalcost'));
            $allproducts=$allproducts;
            $count=count($allproducts);
        }else{
            $cachedtotalcost=0;
            $allproducts='';
            $count=0;
        }
        

        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $categories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC limit 5 ") );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        $adminfee=$admincharge[0];

        return view('viewcart')->with(compact('vendors','categories','leftcategories','allproducts','cachedtotalcost','count','adminfee'));
         //return  $allproducts; 
    }

    public function proceedto_checkout(Request $request){
        $admincharge=AdminCharge::where('id',1)->pluck('fee');
        $allproducts = Cache::get('cartproducts');
        if($allproducts){
            $cachedtotalcost = array_sum(array_column($allproducts, 'totalcost'));
            $allproducts=$allproducts;
            $count=count($allproducts);
        }else{
            $cachedtotalcost=0;
            $allproducts='';
            $count=0;
        }
        
        $adminfee=$admincharge[0];
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $categories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC limit 5 ") );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
       
        return view('viewproceedtocheckout')->with(compact('vendors','categories','leftcategories','allproducts','cachedtotalcost','count','adminfee'));
        
    }

    public function confirmorder(Request $request){
        if($request->amount<$request->min){
            $request->session()->flash('alert-danger', 'you cannot enter less than.'.$request->min);
            return redirect()->back();
        }
        //process payment
        $allproducts = Cache::get('cartproducts');
        $now = Carbon::now();
        $now_format=$now->format('d/m/Y');
        $userphone=Auth::user()->phonenumber;
        //generating cart numbers
        $cartno="CartNo".$now_format.rand(1000,9999);
         Cache::put('cartno', $cartno, 34010);
        if( $allproducts){
            $location=$request->location;
            Cache::put('location', $location, 34010);
            date_default_timezone_set('Africa/Nairobi');
            $BusinessShortCode ='400153';
            $PartyB=$BusinessShortCode;
            $LipaNaMpesaPasskey ='53c4b78a6a03180c4bc923650161b2eea4ceefdd550e91d5341463cc83abbe63';     
            $CallBackURL="https://0cd2ed98.ngrok.io/Mpesa/callback.php";
            $PartyA ="254".(int)$userphone; // This is your phone number, 
            $PhoneNumber ="254".(int)$userphone;
            $AccountReference =$cartno;
            $TransactionDesc ='CART PAYMENT';
            $Amount =$request->min;
            $Timestamp =date('YmdHis');    
            $Remarks="Thank You for Shopping with us";
            $TransactionType="CustomerPayBillOnline";
            # header for access token
            $mpesa= new \Safaricom\Mpesa\Mpesa();
            $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, 
            $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks);
            //print_r($stkPushSimulation);
            return $stkPushSimulation;
             //$request->session()->flash('alert-success', 'Please Wait for your Payment Approval, if this takes more than 2 mins please check your account to confirm if your payment was processed!!');
            //return redirect()->route('waitapproval');
        }
        else{
            $request->session()->flash('alert-danger', 'No item in the cart');
            return redirect()->route('viewcart');
        }
    }
    public function directmessage( $phonenumber, $name,$id){
        $message='Dear '.$name.', to Confirm your order '.$id.' visit www.4paykenya.co.ke .Thank You.';
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
                'to' => $phonenumber,
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
    
    public function showapprovalForm(){
        return view('waitapproval');

    }

public function order(){
   //check if the transaction went through
    $check_transaction=test::where('Phonenumber',Auth::user()->phonenumber)->where('status',"pending")->first();
    if(!($check_transaction))
   {
        //file_put_contents($url, "");
        response()->json(['state' => 'timeout']);
   }

   else{
         $Amount=$check_transaction->Amount;//$json['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
         $mpesareceiptcode=$check_transaction->ReceiptNumber; //$json['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
         $date=$check_transaction->actual_date; //date("m-d-Y", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'])); 
         $time=$check_transaction->actual_time; //date("h:i:s a", strtotime($json['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value']));
         $phone=(int)$check_transaction->Phonenumber; //$json['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
         //update status upon confirming transaction
         test::where('Phonenumber',Auth::user()->phonenumber)->where('status',"pending")->update(['status'=>"confirmed"]);
         $user=Auth::user()->id;
       //check if there is a similar transaction in the db
         $check=Transactions::where('ReceiptNumber',$mpesareceiptcode)->first();
         if(!$check){
        $allproducts = Cache::get('cartproducts');
        $cartno=Cache::get('cartno');
        //$now = Carbon::now();
        //$now_format=$now->format('d/m/Y');
    //generating cart numbers
       //$cartno="CartNo".$now_format.rand(1000,9999);
       if($allproducts){
             $transaction= new Transactions;
             $transaction->user_id=$user;
             $transaction->Amount=$Amount;
             $transaction->CartNo=$cartno;
             $transaction->ReceiptNumber=$mpesareceiptcode;
             $transaction->Phonenumber=$phone;
             $transaction->Date=$date;
             $transaction->Time=$time;
             $transaction->save();
        //file_put_contents($url, "");
        
        ////save orders to db
               $date_today=date("m/d/Y");
               $datetime=date("Y-m-d H:i:s", strtotime('+3 hours'));
               $location=Cache::get('location');
              //posting items in cart to confiemd orders table
               $cachedtotalcost=array_sum(array_column($allproducts, 'totalcost'));
               $post = new CartOrder;
               $post->customer_id = $user;
               $post->customername =Auth::user()->name;
               $post->CartNo =$cartno;
               $post->phonenumber = Auth::user()->phonenumber;
               $post->email = Auth::user()->email;
               $post->location = $location;
               $post->totalcost= $cachedtotalcost;
               $post->status= 'confirmed';
               $post->date = $date_today;
               $post->datetime= $datetime;
               $post->save();
          //save to cart
           foreach($allproducts as $allproduct){
               $post = new Cart;
               $post->cartorder =$cartno;
               $post->user_id= $user;
               $post->customername =Auth::user()->name;
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
                   User::where('name',Auth::user()->name)->update(['balance'=>$customercapbalance]);
                   $totalcost=round(0.25*$cachedtotalcost);
                   if(!($totalcost==$cachedtotalcost)){
                       $additional=$cachedtotalcost-($totalcost*4);
                   }
                   else {
                       $additional=0;
                   }
                   $balances=[$totalcost,$totalcost,($totalcost+$additional)];
                   $Date1= date("Y-m-d");
                   $Date2=date('Y-m-d', strtotime($Date1. ' + 14days'));
                   $Date3=date('Y-m-d', strtotime($Date1. ' + 28days'));
                   $Date4=date('Y-m-d', strtotime($Date1. ' + 42days'));
                   $dates=[$Date2,$Date3,$Date4];
                   $schedules=['Second','Third','Final'];
                    $phone=Auth::user()->phonenumber;
                    $name=Auth::user()->name;
                   //inserting paid cart to remindrs table
                   foreach($balances as $key=>$balance){
                    $reminder=new Reminders;
                    $reminder->CartNo=$cartno;
                    $reminder->user_id=$user;
                    $reminder->date=$dates[$key];
                    $reminder->schedule=$schedules[$key];
                    $reminder->amount=$balance;
                    $reminder->name=$name;
                    $reminder->phonenumber=$phone;
                    $reminder->status="pending";
                    $reminder->save();
                   }
                   //Reminders::insert($data);
                   Cache::forget('cartproducts');
                   Cache::forget('location');
                   Cache::forget('cartno');
                   $this->directmessage( Auth::user()->phonenumber, Auth::user()->fname,$user);
                   return response()->json(['state' => 'success']);
          }
          else{
            response()->json(['state' => 'timeout']);
            //$request->session()->flash('alert-danger', 'An error has occured in your payment');
            //return redirect()->route('viewcart');
          }
         
             
    }
    
    
}
    
}
public function test(){
    return view('test');
}
//debug function
public function callback(){
    test::where('Phonenumber',Auth::user()->phonenumber)->where('status',"pending")->update(['status'=>"confirmed"]);
}
public function removeItem(Request $request,$id){
    //$id=$request->id;
    //pull retrives the value and removes it from the cart
    $cache = Cache::pull('cartproducts');
    $key = array_search($id, array_column($cache, 'id'));
    unset($cache[$key]);
    //if(count(array_column($cache,$id))==1){
    //    Cache::forget('cartproducts');
    //}
    Cache::put('cartproducts',$cache,60);
    $newcache = Cache::get('cartproducts');
    $data=sizeof($newcache,$id);
    if($data==1){
        Cache::forget('cartproducts');
   }
    $request->session()->flash('alert-success',"removed successfully!");
    return redirect()->back();
    //$url=request("Body.stkCallback.CallbackMetadata"); 
   
}
}
