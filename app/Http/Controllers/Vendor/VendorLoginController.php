<?php

namespace App\Http\Controllers\Vendor;


use App\Http\Controllers\Controller;
use App\MailSetting;
use App\User;
use App\EmailSetting;
use App\SenderId;
use App\Subuser;
use App\Resellersetting;
use App\Vendor;
use App\SMSSetting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPMailer;
use phpmailerException;

class VendorLoginController extends Controller
{
    
    use AuthenticatesUsers;

    protected $redirectTo = 'vendor/home';


    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout','login');
    }


    protected function guard()
    {
        return Auth::guard('vendor');
    }

    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect('/vendorlogin');
    }

    public function loginform()
    {
        return view('vendor.login');
    }

    public function login(Request $request)
    {
           $name= $request->name;
           $password= $request->password;
           $result = Vendor::where('name', $name)->first();
           if($result){
                $status= $result->status;

                if( $status=='active'){
                    $this->validateLogin($request);

                    if ($this->hasTooManyLoginAttempts($request)) {
                        $this->fireLockoutEvent($request);
            
                        return $this->sendLockoutResponse($request);
                    }
            
                    if ($this->attemptLogin($request)) {
                        return $this->sendLoginResponse($request);
                    }
            
                    // If the login attempt was unsuccessful we will increment the number of attempts
                    // to login and redirect the user back to the login form. Of course, when this
                    // user surpasses their maximum number of attempts they will get locked out.
                    $this->incrementLoginAttempts($request);
            
                    return $this->sendFailedLoginResponse($request);
                }else{
                    $request->session()->flash('alert-success', 'Contact Admin To Activate Your Account.');
                    return redirect()->back();
                }
                
           }else{
                $request->session()->flash('alert-success', 'User Not Found With That Username. TRY AGAIN');
                return redirect()->back();
           }
    }

    public function registerform(Request $request){
        return view('vendor.register');
    }

    public function save_vendor_register(Request $request){
           $bussinessaddress= $request->bussinessaddress;
           $physicaladdress= $request->physicaladdress;
           $email= $request->email;
           $phonenumber1= $request->phonenumber;
           $password= $request->password;
           $name= $request->name;
                $v= Validator::make($request->all(), [
                    'bussinessaddress'=> 'required',
                    'physicaladdress'=> 'required',
                    'name' => 'required|regex:/(^[A-Za-z0-9_]+$)+/|max:78|unique:vendors',
                    'email' => 'required|email|max:150|unique:vendors',
                    'phonenumber' => 'required|unique:vendors|min:7|regex:/(^[0-9+]+$)+/',
                // 'county'=> 'required',
                    'password' => 'required|min:6|confirmed',
                // 'captcha' => 'required|captcha',
                // 'termsandcondations' =>'required'
                ],
                ['bussinessaddress.required'=>'Bussiness Address is required.',
                'physicaladdress.required'=>'Physical Address is required.',
                'email.required'=>'Email is required.',
                'phonenumber.required'=>'Phone Number Format is Incorrect.',
                ]);


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
             //  $phonenumber =   substr($phonenumber1, strpos($phonenumber1, "+") + 1);  
               $phonenumber2=substr($phonenumber1,5);
               $phonenumber='254'.$phonenumber2;
              
            }
            if($pluscode2=='2540'){
               //$phonenumber=$phonenumber1;
               $phonenumber2=substr($phonenumber1,4);
               $phonenumber='254'.$phonenumber2;
            }
             if($pluscode3=='0'){
               //$phonenumber=$phonenumber1;
               $phonenumber2=substr($phonenumber1,1);
               $phonenumber='254'.$phonenumber2;
            }
     	
        
   $phonenumbersearch=Vendor::where('phonenumber',$phonenumber)->first();
   
    if($phonenumbersearch){
        
        $request->session()->flash('alert-danger', 'Your Phone number is Exists in our database.Use a different phone number or contact admin');
               return redirect()->back()->withInput();
    }
 
        $smstoken=$this->random_str();
        $emailtoken=str_random(40);
        $post = new Vendor;
        $post->bussinessaddress = $bussinessaddress;
        $post->physicaladdress = $physicaladdress;
        $post->email = $email;
        $post->phonenumber = $phonenumber;
        $post->name = $name;
        $post->password = bcrypt($password);
       // $post->encyrptedpssd= $password;
        $post->emailtoken= $emailtoken;
        $post->smstoken= $smstoken;
        $post->status= "pending approval";
        $post->save();

        $id= $post->id;
            $this->directmessage( $phonenumber,$email, $smstoken,$emailtoken, $name, $id);
            $request->session()->flash('alert-warning', 'Account Created.Activate your Account Using SMS Code sent to your Phone number and Email');
           
           return redirect()->back();
        
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

    public function directmessage( $phonenumber,$email, $smstoken,$emailtoken, $name, $id){
        $message ="Dear ".$name." Use this code to activate your Account: " .$smstoken;
        
            $senderids = SMSSetting::where('id', 1)->first();
            $senderid = $senderids->senderid;
            $apikey = $senderids->apikey;
            $username = $senderids->username;
            $msgtype = 5;
            $dlr = 0;
        
            set_time_limit(10000);

            $url="https://sms.movesms.co.ke/api/portalcompose?";
            $postData = array(
            //  'action' => 'compose',
                'username' => $username,
                'api_key' => $apikey,
                'sender' => $senderid,
                'to' => $phonenumber,
                'message' => $message,
                'msgtype' => $msgtype,
                'dlr' => $dlr,
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

         $this->directemail($emailtoken,$email,$name);
    }


    public function directemail($emailtoken,$email,$name)
    {

	require './phpmailer/PHPMailer_5.2.0/class.phpmailer.php';

        $settings=MailSetting::all()->first();
        $host=$settings->host;
        $username=$settings->username;
        $password=$settings->password;
        $fromaddress=$settings->fromaddress;
        $fromname=$settings->fromname;

        $toemail=$email;
        $tokens=$emailtoken;

            $openaccount_emailsubject="Activate your Account";
		    $openaccount_email="Dear [name],  Activate Your Account By Clicking this link [link].";
        
         $text=view('vendor.activationlink')->with(compact('tokens'));
         $finalmessage = $this->settingmessage($name,$text,$openaccount_email);
        //  $text1=view('user.tokenformsendtoemail')->with(compact('finalmessage'));

			
		        $mail = new PHPMailer();
		        $mail->IsSMTP();
		        $mail->Host =$host;
		        $mail->SMTPAuth = true;
		        $mail->Username =$username;
		        $mail->Password =$password;	
		        $mail->setFrom($fromaddress, $fromname);
		        $mail->AddAddress($email);
		        $mail->AddReplyTo($fromaddress, $fromname);
		
		        $mail->WordWrap = 100;
		        $mail->IsHTML(true);
		
		        $mail->Subject =  $openaccount_emailsubject;
		        //$mail->Body    ="must be a text";
		        $mail->MsgHTML($finalmessage);
	
	                 set_time_limit(600);
			if(!$mail->Send())
			{
			   $output= "Message could not be sent". $mail->ErrorInfo;
			 
			  // exit;
			}else{
			   // echo "sent";
		      }


    }
    
    public function settingmessage($name,$text,$msg)
    {
        
        $result1=str_replace(["[name]", "[link]"], [$name, $text], $msg);
        return $result1;
    }

    public function activate_vendor_acc(Request $request){
        $token= $request->token;
        return view('vendor.activationform')->with(compact('token'));
    }

    public function submitactivate_vendor_acc(Request $request){
        $token= $request->token;
        $smstoken= $request->smstoken;
        $newsmstoken=$this->random_str();    
        $emailtoken=str_random(40);

        $result=Vendor::where('emailtoken',$token)->where('smstoken',$smstoken)->first();
        
        if($result){

                $id= $result->id;
                Vendor::where('id',$id)->update(['status'=>'active','smstoken'=>$newsmstoken,'emailtoken'=>$emailtoken]);
                $request->session()->flash('alert-warning', ' Account Activated.');
                $user=Vendor::where('id',$id)->first(); 
                    Auth::login($user);
                   
                    return redirect()->intended('vendor/home');
           
        }else{

            $request->session()->flash('alert-warning', 'NO Account Found');
            return redirect()->back();
        }

    }

    public function  reset_vendor_acc(){

        return view('vendor.resetform');
    }

    public function  submitreset_vendor_acc(Request $request){

        $email= $request->email;
        $result=Vendor::where('email',$email)->first();
        
        if($result){

                $emailtoken= $result->emailtoken;
                $this->resetdirectemail($emailtoken,$email);

                $request->session()->flash('alert-success', 'Update account using mail Sent to your Email');
                return redirect()->back();
           
        }else{

            $request->session()->flash('alert-warning', 'NO Account Found');
            return redirect()->back();
        }
    }


public function resetdirectemail($emailtoken,$email)
{

require './phpmailer/PHPMailer_5.2.0/class.phpmailer.php';

    $settings=MailSetting::all()->first();
    $host=$settings->host;
    $username=$settings->username;
    $password=$settings->password;
    $fromaddress=$settings->fromaddress;
    $fromname=$settings->fromname;

    $toemail=$email;
    $tokens=$emailtoken;
    $name='Customer';
        $openaccount_emailsubject="Update  Account";
        $openaccount_email="Dear [name],  Update Your Account By Clicking this link [link].";
    
     $text=view('vendor.updatelink')->with(compact('tokens'));
     $finalmessage = $this->resetsettingmessage($name,$text,$openaccount_email);
    
        
            $mail = new PHPMailer();

            $mail->IsSMTP();
            $mail->Host =$host;
            $mail->SMTPAuth = true;
            $mail->Username =$username;
            $mail->Password =$password;	
            $mail->setFrom($fromaddress, $fromname);
            $mail->AddAddress($email);
            $mail->AddReplyTo($fromaddress, $fromname);
    
            $mail->WordWrap = 100;
            $mail->IsHTML(true);
    
            $mail->Subject =  $openaccount_emailsubject;
            //$mail->Body    ="must be a text";
            $mail->MsgHTML($finalmessage);

                 set_time_limit(600);
        if(!$mail->Send())
        {
           $output= "Message could not be sent". $mail->ErrorInfo;
         
          // exit;
        }else{
           // echo "sent";
          }


    }

    public function resetsettingmessage($name,$text,$msg)
    {
        
        $result1=str_replace(["[name]", "[link]"], [$name, $text], $msg);
        return $result1;
    }
    public function show_update_vendor_form(Request $request){
        $token= $request->token;
        return view('vendor.updateform')->with(compact('token'));
    }

    public function save_update_account(Request $request){
        $token= $request->token; 
        $password= $request->password;

             $v= Validator::make($request->all(), [
                 'password' => 'required|string|min:6|confirmed',
             ]);
             if ($v->fails())
             {
                 return redirect()->back()->withInput()->withErrors($v->errors());
             }
        $newsmstoken=$this->random_str();    
        $emailtoken=str_random(40);

        $result=Vendor::where('emailtoken',$token)->first();
        
        if($result){

                $id= $result->id;
                Vendor::where('id',$id)->update(['smstoken'=>$newsmstoken,'emailtoken'=>$emailtoken,'password'=> bcrypt($password)/*,'encyrptedpssd'=> $password*/]);
                $request->session()->flash('alert-warning', ' Password Updated.');
                $user=Vendor::where('id',$id)->first(); 
                    Auth::login($user);
                   
                    return redirect()->intended('vendor/home');
           
        }else{

            $request->session()->flash('alert-warning', 'NO Account Found');
            return redirect()->back();
        }

    }

}
