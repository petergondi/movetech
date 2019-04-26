<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MailSetting;
use App\User;
use App\EmailSetting;
use App\SenderId;
use App\Subuser;
use App\Resellersetting;
use App\SMSSetting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPMailer;
use phpmailerException;
use App\Terminal;
use App\Product;
use App\Vendor;
use App\Capping;
use DB;
use Illuminate\Support\Facades\Cache;

class GuestLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'customer/acc';


    public function __construct()
    {
        $this->middleware('guest')->except('logout','login');
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    public function loginform(Request $request)
    {
        $id=$request->id;
        if($id!=''){
            $id=$request->id;
        }if($id==''){
            $id='';
        }
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        return view('loginform')->with(compact('vendors','leftcategories','id'));
    }

    public function showloginform()
    {
        
            $id='';
        
        
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        
        return view('loginform')->with(compact('vendors','leftcategories','id'));
    }

    public function registerform(Request $request){
        
        $id=$request->id;
        if($id!=''){
            $id=$request->id;
        }if($id==''){
            $id='';
        }

        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        
        return view('loginform')->with(compact('vendors','leftcategories','id'));
    }


    public function login(Request $request)
    {
        $id=$request->id;
        $name=$request->username;
        $password=$request->password;

        $v= Validator::make($request->all(), [
            'username'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        
        if($id!=''){
            $id=$request->id;
        }if($id==''){
            $id='';
        }
        Cache::forget('productid');
        Cache::put('productid', $id, 10);

        $result = User::where('name', $name)->first();
        if($result){
	    
            $status = $result->status;
           if ($status != "active") {
               
            $request->session()->flash('alert-success', 'Activate You Account');
            return redirect()->back();
            }else {

		
		$newsmstoken=$this->random_str();

                $name=$request->username;
                $password=$request->password;
                $user=User::where('name',$name)->where('password',md5($password))->first();
                if($user){
                   
                    Auth::login($user);
                 
                    return redirect()->intended('customer/acc');
                }else{
                   
                    $request->session()->flash('alert-success', 'username or password is wrong');
                    return redirect()->back();
                    
                }

            }

        }else{
 
                    $request->session()->flash('alert-danger', 'No User was Found.');
                    return redirect()->back();
                    
        }


    }


    public function saveregisteruser(Request $request)
    {
        $id=$request->id;
        $name=$request->name;
        $password=$request->password;

        $fname=$request->fname;
        $name=$request->name;
        $email=$request->email;
        $phonenumber1=$request->phonenumber;
        $password=$request->password;
        $location=$request->location;
        $idno=$request->idno;

        if($id!=''){
            $id=$request->id;
        }if($id==''){
            $id='';
        }
        Cache::forget('productid');
        Cache::put('productid', $id, 10);

        $v= Validator::make($request->all(), [
            'fname'=> 'required|string|max:208',
            'name' => 'required|regex:/(^[A-Za-z0-9_]+$)+/|max:78|unique:users',
            'email' => 'required|string|email|max:150|unique:users',
            'phonenumber' => 'required|min:7|regex:/(^[0-9+]+$)+/',
            'password' => 'required|string|min:6|confirmed',
            'location'=> 'required',
            'idno'=> 'required',
        ],
        ['name.regex'=>'Avoid using special character.',
         'phonenumber.min'=>'Phone Number Format is Incorrect.']);


        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

            $pluscode=  substr($phonenumber1,0,5);
            $pluscode2= substr($phonenumber1,0,4);
            $pluscode3=  $phonenumber1[0];
        if($pluscode=='+2547'){
            $phonenumber =   substr($phonenumber1, strpos($phonenumber1, "+") + 1);  
            
        }
        if($pluscode2=='2547'){
            $phonenumber=$phonenumber1;
        }
        
        if($pluscode=='+2540'){
            $phonenumber2=substr($phonenumber1,5);
            $phonenumber='254'.$phonenumber2;
            
        }
        if($pluscode2=='2540'){
            $phonenumber2=substr($phonenumber1,4);
            $phonenumber='254'.$phonenumber2;
        }
        if($pluscode3=='0'){
            $phonenumber2=substr($phonenumber1,1);
            $phonenumber='254'.$phonenumber2;
        }

        $phonenumbersearch=User::where('phonenumber',$phonenumber)->first();
        if($phonenumbersearch){
            
            $request->session()->flash('alert-success', 'That Phone number is already in Use');
                return redirect()->back()->withInput();
        }

        $smstoken=$this->random_str();
        $emailtoken=str_random(40);
        $result=Capping::orderBy('id','desc')->first();
        if($result){
            $cap=$result->cap;
        }else{
            $cap=10000;
        }

        $post = new User;
        $post->fname = $fname;
        $post->name = $name;
        $post->email = $email;
        $post->phonenumber = $phonenumber;
        $post->password = md5($password);
        $post->token= $emailtoken;
        $post->smstoken= $smstoken;
        $post->status= "pending approval";
        $post->idno= $idno;
        $post->location= $location;
        $post->cap= $cap;
        $post->save();

        $id= $post->id;
        $this->directmessageactivate( $phonenumber, $smstoken);

        $request->session()->flash('alert-success', 'Account Created.Activate your Account Using SMS Sent to your Phone number');
           
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        return view('activateacc')->with(compact('name','id','vendors','leftcategories'));


    }

    public function customeractivateacc(Request $request){
        $id=$request->id;
        $name=$request->name;
        $smstoken=$request->smstoken;

        $v= Validator::make($request->all(), [
            'smstoken'=> 'required',
        ]);


        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $result=User::where('name',$name)->where('smstoken',$smstoken)->first();
        if($result){
            
            $smstoken=$this->random_str();
        
            User::where('id',$id)->update(['status'=>'active','smstoken'=>$smstoken]);

            $request->session()->flash('alert-success', 'Account Activated Successfully. Login');
            return redirect()->route('customerlogin');
            
        }else{
            $request->session()->flash('alert-success', 'Use Correct SMS CODE.OR Contact Admin To activate your account.');
            return redirect()->back();
        }
    }
        
public  function random_str(){
    $length=4;
    $keyspace = '0123456789';
       $str = '';
       $max = mb_strlen($keyspace, '8bit') - 1;
       for ($i = 0; $i < $length; ++$i) {
           $str .= $keyspace[random_int(0, $max)];
       }
       return $str;
   }


   public function directmessageactivate( $phonenumber, $smstoken){

        $message='Activation Code: '.$smstoken;
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

}
