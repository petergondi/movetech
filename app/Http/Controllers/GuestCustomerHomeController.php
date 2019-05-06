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
            // $newarray=array(
            //     [
            //         'id' => 2135,
            //         'first_name' => 'John',
            //         'last_name' => 'Doe',
            //     ],
            //    [
            //         'id' => 3245,
            //         'first_name' => 'Sally',
            //         'last_name' => 'Smith',
            //    ]
            // );
          //  $newarray=array('id'=>$id,'modelnumber'=>$modelnumber);
            $newarray=array(['id'=>$id,'modelnumber'=>$modelnumber,'productname'=>$productname,'totalcost'=>$totalcost]);

            $all_categories= json_decode (json_encode ($newarray), FALSE); //array to object

        //     $all_categories = [];
        //  $all_categories[] = $newarray;
        //  $all_categories = json_encode($all_categories);
       //  return $all_categories;
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
    //  $otherall_categories = [];
    //  $otherall_categories[] = $newarrayn;
    //  $otherall_categories = json_encode($otherall_categories);
    //  Cache::put('newproducts', $otherall_categories, 34010);
      //  $new_objectproduct = $allproducts->merge($otherall_categories);
      // Cache::put('products', $new_objectproduct, 34010);
        //Cache::put('products', $new_objectproduct, 34010);
        //  $newproducts = Cache::get('newproducts');
        // $oldproducts = Cache::get('oldproducts');
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
        $location = $request->location;
        $date=date("m/d/Y");
        $datetime=date("Y-m-d H:i:s", strtotime('+3 hours'));
        $allproducts = Cache::get('cartproducts');
        if($allproducts){
            $cachedtotalcost=array_sum(array_column($allproducts, 'totalcost'));
            $post = new CartOrder;
            $post->customername = Auth::user()->fname;
            $post->phonenumber = Auth::user()->phonenumber;
            $post->email = Auth::user()->email;
            $post->location = $location;
            $post->totalcost= $cachedtotalcost;
            $post->status= 'confirmed';
            $post->date = $date;
            $post->datetime= $datetime;
            $post->save();

            $id= $post->id;

            foreach($allproducts as $allproduct){
        
                $post = new Cart;
                $post->cartorder = $id;
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

            $cap= Auth::user()->cap;
            $balance= Auth::user()->balance;
            if($balance==''){
                $maxcap=$cap;
            }else{
                $maxcap=$balance;
            }
            $customercapbalance=$maxcap-$cachedtotalcost;
            User::where('name',Auth::user()->name)->update(['balance'=>$customercapbalance]);
            Cache::forget('cartproducts');
            $this->directmessage( Auth::user()->phonenumber, Auth::user()->fname,$id);
            $request->session()->flash('alert-success', 'Order Created Successfully');
            return redirect()->route('viewcart');

        }else{
            
            $request->session()->flash('alert-success', 'No Item Found in Your Check-ouT.');
            return redirect()->back();
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
    public function removeItem(Request $request){
        $id=$request->id;
        //pull retrives the value and removes it
        $cache = Cache::pull('cartproducts');
        $key = array_search($id, array_column($cache, 'id'));
        unset($cache[$key]);
        Cache::put('cartproducts',$cache,60);
       //$test=count(array_column($cache,'id'));
       //if($test=2){
       //    Cache::forget('cartproducts');
       //}
       //$new = Cache::get('cartproducts');
        return response(Cache::get('cartproducts'));
    }
    public function stk_push(Request $request)
    {
        //$consumerKey = 'lJA1elbLsmcRYIkHYhtsWeXxhOFgFzRH'; //Fill with your app Consumer Key
        //$consumerSecret = 'hVxLGab9DN8xqrkG'; // Fill with your app Secret
        //# define the variales
        //# provide the following details, this part is found on your test credentials on the developer account
        //$BusinessShortCode = '174379';
        //$Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
        ///*
        //  This are your info, for
        //  $PartyA should be the ACTUAL clients phone number or your phone number, format 2547********
        //  $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
        //  TransactionDesc can be anything, probably a better description of or the transaction
        //  $Amount this is the total invoiced amount, Any amount here will be 
        //  actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction. 
        //  for developer/test accounts, this money will be reversed automatically by midnight.
        //*/
        //$PartyA = 254725272888; // This is your phone number, 
        //$AccountReference = 'Cart001';
        //$TransactionDesc = 'cART PAYMENT';
        //$Amount = '1';
        //# Get the timestamp, format YYYYmmddhms -> 20181004151020
        //$Timestamp = date('YmdHis');    
        //# Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
        //$Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);
        //# header for access token
        //$headers = ['Content-Type:application/json; charset=utf8'];
        //  # M-PESA endpoint urls
        //$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        //$initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        //# callback url
        //$CallBackURL = 'http://kidonda.us/projects/MPESA_API/callback_url.php';  
        //$curl = curl_init($access_token_url);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($curl, CURLOPT_HEADER, FALSE);
        //curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
        //$result = curl_exec($curl);
        //$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //$result = json_decode($result);
        //$access_token = $result->access_token;  
        //curl_close($curl);
        //# header for stk push
        //$stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];
        //# initiating the transaction
        //$curl = curl_init();
        //curl_setopt($curl, CURLOPT_URL, $initiate_url);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header
        //$curl_post_data = array(
        //  //Fill in the request parameters with valid values
        //  'BusinessShortCode' => $BusinessShortCode,
        //  'Password' => $Password,
        //  'Timestamp' => $Timestamp,
        //  'TransactionType' => 'CustomerPayBillOnline',
        //  'Amount' => $Amount,
        //  'PartyA' => $PartyA,
        //  'PartyB' => $BusinessShortCode,
        //  'PhoneNumber' => $PartyA,
        //  'CallBackURL' => $CallBackURL,
        //  'AccountReference' => $AccountReference,
        //  'TransactionDesc' => $TransactionDesc
        //);
        //$data_string = json_encode($curl_post_data);
        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POST, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        //$curl_response = curl_exec($curl);
        //print_r($curl_response);
        //echo $curl_response;
        return "fine thanks";
    }
   
}
