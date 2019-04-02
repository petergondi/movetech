<?php

namespace App\Http\Controllers\User;


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

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'user/home';


    public function __construct()
    {
        $this->middleware('guest')->except('logout','login');
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/userlogin');
    }

    public function loginform()
    {
        
        return view('user.login');
    }


    public function confirm_login(Request $request)
    {

   	 $name= $request->name;
   	 $password= $request->password;
   	 $result = User::where('name', $name)->first();
   	 if($result){
	   	$fname=$result->fname;
		$name1 = strtok($fname, ' ');
		$phonenumber=$result->phonenumber;
		$smstoken=$result->smstoken;
   	    $this->directmessage($name1, $phonenumber, $smstoken);
   	    
   	    return view('user.confirmphonenumber')->with(compact('name','password'));
   	 }else{
   	       $request->session()->flash('alert-warning', 'No Account Found with that Username');            
               return redirect()->back()->withInput();
   	 }
   	 
   	 
    
    }

    public function login(Request $request)
    {
   	 //$smstoken= $request->smstoken;
   	 
   	 
        ob_start();  
        system('ipconfig /all');  
        $mycomsys=ob_get_contents();  
        ob_clean();  
        $find_mac = "Physical"; 
        $pmac = strpos($mycomsys, $find_mac);
        $macaddress=substr($mycomsys,($pmac+36),17);
        $result=Terminal::where('macipaddress', $macaddress)->orderBy('id', 'desc')->first();
        if(!$result){
   	       $request->session()->flash('alert-danger', 'Un-Registered Terminal');            
           return redirect()->back()->withInput();
        }


        $result = User::where('name', $request->name)->first();
        if($result){
	    //$smstokenfromdb= $result->smstoken;
            $status = $result->status;
           /* if ($smstokenfromdb != $smstoken) {
                $request->session()->flash('alert-warning', 'Invalid SMS Token and Try Again');
                //return redirect()->back()->withInput();
               // return view('user.activateaccount');
               return redirect()->back()->withInput();
            }else*/ if ($status == "pending approval") {
                $request->session()->flash('alert-success', 'Activate your Account Using SMS Sent to your Phone number');
                //return redirect()->back()->withInput();
               // return view('user.activateaccount');
               return redirect()->back();
            } else if ($status == "suspended") {
                $request->session()->flash('alert-success', 'Contact the admin to unsuspend Your Account');
                return redirect()->back()->withInput();
            }else {

		
		$newsmstoken=$this->random_str();

             //  User::where('name', $request->name)->update(['smstoken'=>$newsmstoken]);

                //$this->validateLogin($request);
                
                $name=$request->name;
                $password=$request->password;
                $user=User::where('name',$name)->where('password',md5($password))->first();
                if($user){
                    //return redirect()->route('userhome');
                    Auth::login($user);
                  // return 'found';
                    return redirect()->intended('user/home');
                }else{
                   
                    $request->session()->flash('alert-success', 'username or password is wrong');
                    return redirect()->back();
                    
                }

                // If the class is using the ThrottlesLogins trait, we can automatically throttle
                // the login attempts for this application. We'll key this by the username and
                // the IP address of the client making these requests into this application.
          /*      if ($this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);

                    return $this->sendLockoutResponse($request);
                }

                if ($this->attemptLogin($request)) {
                    return $this->sendLoginResponse($request);
                } */

                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
            /*    $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponse($request); */
            }

        }else{
 
                    $request->session()->flash('alert-danger', 'No User Found.');
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

public  function random_strpassword(){
 $length=8;
 $keyspace = '0123456789';
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}


    public function showactivateformforpendingaccounts()
    {
        
        return view('user.activatependingaccount');
    }

    public function showactivateaccform($token)
    {
        
        $tokens=$token;
        return view('user.activateaccount')->with(compact('tokens'));
    }

    public function saveactivateformforpendingaccounts(Request $request)
    {
        $smstoken=$request->smstoken;
        $email=$request->email;

        $v= Validator::make($request->all(), [
            'smstoken'=> 'required',
            'email'=> 'required',
        ]);


        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $user=User::where('smstoken',$smstoken)->where('email',$email)->first();
        if($user){
      
          $fname=$user->fname;
          $username=$user->name;
          $email=$user->email;
          $name = strtok($fname, ' ');
          
        $smstoken=$this->random_str();
        $emailtoken=str_random(40);

            User::where('name',$username)->update(['smstoken'=>$smstoken,'token'=>$emailtoken,
                'status'=>'approved']);
                
               $mailss=EmailSetting::all()->first();
	                if($mailss){
		                $subject=$mailss->welcome_emailsubject;
		                $msg=$mailss->welcome_email;
		                $text1=str_replace(["[name]"], [$name], $msg);
	                }if(!$mailss){
		                $subject="Welcome To Movesms";
		                $msg="Hi [name],  Welcome to Movesms.";
		                $text1=str_replace(["[name]"], [$name], $msg);
	                }
        
 
        
        $text=view('user.welcomeemailtemplate')->with(compact('text1'));
               
		$this->directemail($subject,$text,$email); 
		Auth::login($user);
            
            return redirect()->intended('user/home');


        }else{
            $request->session()->flash('alert-warning', 'Invalid SMS Token. Try Again');
           // return redirect()->route('show_activate_user_acc')->with(compact('tokens'));
             return redirect()->back()->withInput();
        }

    }

    public function activateacc(Request $request)
    {
        $smstoken=$request->smstoken;
        $tokens=$request->token;


        $v= Validator::make($request->all(), [
            'smstoken'=> 'required',
            'token' => 'required',
        ]);


        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $user=User::where('smstoken',$smstoken)->where('token',$tokens)->first();
        if($user){
      
          $fname=$user->fname;
          $username=$user->name;
          $email=$user->email;
          $name = strtok($fname, ' ');
          
        $smstoken=$this->random_str();
        $emailtoken=str_random(40);

            User::where('name',$username)->update(['smstoken'=>$smstoken,'token'=>$emailtoken,
                'status'=>'approved']);
                
               $mailss=EmailSetting::all()->first();
	                if($mailss){
		                $subject=$mailss->welcome_emailsubject;
		                $msg=$mailss->welcome_email;
		                $text1=str_replace(["[name]"], [$name], $msg);
	                }if(!$mailss){
		                $subject="Welcome To Movesms";
		                $msg="Hi [name],  Welcome to Movesms.";
		                $text1=str_replace(["[name]"], [$name], $msg);
	                }
        
 
        
        $text=view('user.welcomeemailtemplate')->with(compact('text1'));
               
		$this->directemail($subject,$text,$email); 
		Auth::login($user);
            
            return redirect()->intended('user/home');


        }else{
            $request->session()->flash('alert-warning', 'Invalid SMS Token. Try Again');
           // return redirect()->route('show_activate_user_acc')->with(compact('tokens'));
             return redirect()->back()->withInput();
        }

    }
    
    
  public function directemail($subject,$text,$email)
    {

	require './phpmailer/PHPMailer_5.2.0/class.phpmailer.php';

        $settings=MailSetting::all()->first();
        $host=$settings->host;
        $username=$settings->username;
        $password=$settings->password;
        $fromaddress=$settings->fromaddress;
        $fromname=$settings->fromname;
      
			
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
		
		        $mail->Subject =  $subject;
		        //$mail->Body    ="must be a text";
		        $mail->MsgHTML($text);
	
	                 set_time_limit(600);
			if(!$mail->Send())
			{
			   $output= "Message could not be sent". $mail->ErrorInfo;
			 
			  // exit;
			}else{
			   // echo "sent";
		      }


    }
    

    public function user_reset()
    {
        return view("user.forgotpassword");
    }


    public function submit_user_reset(Request $request)
    {
        $name=$request->name;


        $v = Validator::make($request->all(), [
            'name' => 'required'

        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $result=User::where('name',$name)->first();
        if(!$result){
            session()->flash('alert-success', 'No Such User Found. Try Again');
            return redirect()->back();
        }
        $phonenumber=$result->phonenumber;
        $id=$result->id;
        return view('user.resetnewpassword')->with(compact('phonenumber','name','id'));
    }

    public function Setnepasss(Request $request){
        $id=$request->id;
        $name=$request->name;
        $phonenumber=$request->phonenumber;
        $password=$request->password;

        $v = Validator::make($request->all(), [
            'name' => 'required',
            'phonenumber' => 'required',
            'password' => 'required|integer|confirmed',
        ]);

        if ($v->fails())
        {
            $request->session()->flash('alert-success', $v->errors());
            return redirect()->back();
        }

        $result=User::where('id',$id)->first();
        if(!$result){
            session()->flash('alert-success', 'No Such User Found. Try Again');
            return redirect()->route('user_reset');
        }
        
        User::where('id',$id)->update(['password'=>md5($password)]);

        $message='New Password: '.$password;
        $settings=SMSSetting::all()->first();
        if(empty($settings)){
            $request->session()->flash('alert-success', 'Contact Manager to set SMS Settings and Try Again');
            return redirect()->back()->withInput();
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

            $request->session()->flash('alert-success', 'PIN Set Successfully. Login');
            return redirect()->route('userlogin');
        }


    }
    
    public function sendmailtoresetpasswordforsubuser($accusername,$password2,$name, $phonenumber, $smstoken,$email,$foreign_key)
    {


        $settings=MailSetting::all()->first();
        $host=$settings->host;
        $username=$settings->username;
        $password=$settings->password;
         $fromaddress=$settings->fromaddress;
         $fromname=$settings->fromname;
        $subject="New Password";
        
        
            $finalmessage= 'Welcome '.$name.', your Account details:  username: <b>'. $accusername.'</b> password: <b>'.$password2.'</b>';
         
         $text=view('user.resetmail')->with(compact('finalmessage'));


		require './phpmailer/PHPMailer_5.2.0/class.phpmailer.php';

		        $mail = new PHPMailer();
		
		
		        $mail->IsSMTP();
		        $mail->Host =$host;// "sms.movesms.co.ke";
		        $mail->SMTPAuth = true;
		        $mail->Username =$username;// "eliud@sms.movesms.co.ke";//"eliud@emailsending.bigsoftsystems.com";
		        $mail->Password =$password;//  '0702497334';//"0702497334Abcde";
		
		        $mail->setFrom($fromaddress, $fromname);
		        $mail->AddAddress($email);
		        $mail->AddReplyTo($fromaddress, $fromname);
		
		        $mail->WordWrap = 50;
		        $mail->IsHTML(true);
		
		        $mail->Subject = $subject;
		        $mail->MsgHTML($text);
	
	                 set_time_limit(600);
			if(!$mail->Send())
			{
			   $output= "Message could not be sent". $mail->ErrorInfo;
			 
			  // exit;
			}else{
			   // echo "sent";
			   
		      }
			


    }
    
    public function sendmailtoresetpasswordforresellerclient($accusername,$password2,$name, $phonenumber, $smstoken,$email,$foreign_key)
    {

        $results = User::where('email', $email)->first();

        $tokens = $results->token;

        $settings=MailSetting::all()->first();
        $host=$settings->host;
        $username=$settings->username;
        $password=$settings->password;
        // $fromaddress=$settings->fromaddress;
        // $fromname=$settings->fromname;
        $subject="New Password";
        
        $result=Resellersetting::where('name',$foreign_key)->first();
        if($result){
           
            $welcomesms=$result->welcomesms;
            $welcomeemailbody=$result->welcomeemailbody;
            $fromaddress=$result->emailsender;
            $fromname=$result->sendername;
        }if(!$result){
            
            $welcomesms='';
            $welcomeemailsubject='';
            $welcomeemailbody='';
            $fromaddress='';
            $fromname='';
        }
        
        if($welcomeemailbody==''){
            
             $finalmessage= 'Welcome '.$name.', your Account details:  username: <b>'. $accusername.'</b> password: <b>'.$password2.'</b>';
           
         }if($welcomeemailbody!=''){
           $finalmessage=   str_replace(
            array('[name]', '[username]','[password]'),
            array($name, $accusername,$password2),$welcomeemailbody);
         }


		require './phpmailer/PHPMailer_5.2.0/class.phpmailer.php';

		        $mail = new PHPMailer();
		
		
		        $mail->IsSMTP();
		        $mail->Host =$host;// "sms.movesms.co.ke";
		        $mail->SMTPAuth = true;
		        $mail->Username =$username;// "eliud@sms.movesms.co.ke";//"eliud@emailsending.bigsoftsystems.com";
		        $mail->Password =$password;//  '0702497334';//"0702497334Abcde";
		
		        $mail->setFrom($fromaddress, $fromname);
		        $mail->AddAddress($email);
		        $mail->AddReplyTo($fromaddress, $fromname);
		
		        $mail->WordWrap = 50;
		        $mail->IsHTML(true);
		
		        $mail->Subject = $subject;
		        $mail->MsgHTML($finalmessage);
	
	                 set_time_limit(600);
			if(!$mail->Send())
			{
			   $output= "Message could not be sent". $mail->ErrorInfo;
			 
			  // exit;
			}else{
			   // echo "sent";
			   $this->directmessagetoresellerclient($name, $phonenumber, $smstoken,$welcomesms,$accusername,$password2,$foreign_key);
		      }
			


    }
    
    public function directmessagetoresellerclient($name, $phonenumber, $smstoken,$welcomesms,$accusername,$password2,$foreign_key)
    {

            
            $senderinfo=SenderId::where('name',$foreign_key)->where('resetpassword','default')->first();

            if($senderinfo){
                $username = $senderinfo->name;
                $Key= $senderinfo->apikey;
                $senderId= $senderinfo->senderid;
            }if(!$senderinfo){
                $senderids = SenderId::where('name', $foreign_key)->first();
                $username = $senderids->name;
                $Key= $senderids->apikey;
                $senderId= $senderids->senderid;
                
            } 
            $msgtyp= 5;
            $dlr = 0;
            
             if($welcomesms==''){
              $finalmessage= 'Welcome '.$name.', your Account username is '. $accusername.' and password is '.$password2;
             
             }if($welcomesms!=''){
               $finalmessage=   str_replace(
                array('[name]', '[username]','[password]'),
                array($name, $accusername,$password2),$welcomesms);
             }
            
           // $url = url('/')."/API/index2.php/";
            $url=url('/')."/api/portalcompose?";
            $tophonenumber=$phonenumber;
       
        set_time_limit(1000);

        $postData = array(
           // 'action' => 'compose',
            'username' => $username,
            'api_key' => $Key,
            'sender' => $senderId,
            'to' => $tophonenumber,
            'message' => $finalmessage,
            'msgtype' => $msgtyp,
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

         

        // return $output;


    }


    public function sendmailtoresetpassword($name, $phonenumber, $smstoken,$email)
    {

        $results = User::where('email', $email)->first();

        $tokens = $results->token;

        $settings=MailSetting::all()->first();
        $host=$settings->host;
        $username=$settings->username;
        $password=$settings->password;
        $fromaddress=$settings->fromaddress;
        $fromname=$settings->fromname;
        $subject="Account Verification";
        
        $emailsettings=EmailSetting::all()->first();
        if($emailsettings){
            $password_resetemailsubject=$emailsettings->password_resetemailsubject;
            $password_resetemail=$emailsettings->password_resetemail;   
        }if(!$emailsettings){

            $password_resetemailsubject="Reset Password";
		    $password_resetemail="Dear [name],  Reset Password by Clicking this link [link].";
        }


         $text1=view('user.resetpasswordlink')->with(compact('tokens'));
         $finalmessage = $this->settingmessage($name,$text1,$password_resetemail);
         $text=view('user.resetmail')->with(compact('finalmessage'));

		require './phpmailer/PHPMailer_5.2.0/class.phpmailer.php';

		        $mail = new PHPMailer();
		
		
		        $mail->IsSMTP();
		        $mail->Host =$host;// "sms.movesms.co.ke";
		        $mail->SMTPAuth = true;
		        $mail->Username =$username;// "eliud@sms.movesms.co.ke";//"eliud@emailsending.bigsoftsystems.com";
		        $mail->Password =$password;//  '0702497334';//"0702497334Abcde";
		
		        $mail->setFrom($fromaddress, $fromname);
		        $mail->AddAddress($email);
		        $mail->AddReplyTo($fromaddress, $fromname);
		
		        $mail->WordWrap = 50;
		        $mail->IsHTML(true);
		
		        $mail->Subject = $password_resetemailsubject;
		        $mail->MsgHTML($text);
	
	                 set_time_limit(600);
			if(!$mail->Send())
			{
			   $output= "Message could not be sent". $mail->ErrorInfo;
			 
			  // exit;
			}else{
			   // echo "sent";
			   $this->directmessage($name, $phonenumber, $smstoken);
		      }
			


    }
    
  public function directmessage($name, $phonenumber, $smstoken)
    {

            $senderids = SenderId::where('id', 1)->first();
            $username = $senderids->name;
            $Key= $senderids->apikey;
            $senderId= $senderids->senderid;
            $msgtyp= 5;
            $dlr = 0;
            $finalmessage  ="Dear ".$name." Use this code to Verify your Account: " .$smstoken;
           // $url = url('/')."/API/";
           $url=url('/')."/api/portalcompose?";
            $tophonenumber=$phonenumber;
       
        set_time_limit(1000);

        $postData = array(
           // 'action' => 'compose',
            'username' => $username,
            'api_key' => $Key,
            'sender' => $senderId,
            'to' => $tophonenumber,
            'message' => $finalmessage,
            'msgtype' => $msgtyp,
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

         

        // return $output;


    }
    
    


    public function newpassworddd($token)
    {
        //$emails=$email;
        $tokens=$token;
        return view('user.passwordresetform')->with(compact('tokens'));
    }

    public function updatepassword(Request $request)
    {
       // $email=$request->email;
        $token=$request->token;
        $smstoken=$request->smstoken;
        $newpassword=$request->newpassword;
        $confirmpassword=$request->confirmpassword;
        $password=md5($newpassword);
        $newsmstoken=str_random(4);
        $newtoken=str_random(40);
        $v = Validator::make($request->all(), [
           // 'email' => 'required|email',
            'token' => 'required',
            'smstoken' => 'required',
            'newpassword' => 'required|min:8',
            'confirmpassword' => 'required|same:newpassword'

        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        /*  if($result){

              $request->session()->flash('alert-success','Password send to your Email');
              $this->sendmailtoresetpassword($email);
              return redirect()->route('password_reset');
          }else{
              $request->session()->flash('alert-danger','No such email is  found in the database');
              return redirect()->route('password_reset');
          }*/


        $result= User::where('smstoken', $smstoken)->where('token',$token)->first();

        if($result){
            $email=$result->email;
	    User::where('email', $email)->update(['password' => $password,'smstoken'=>$newsmstoken,'token'=>$newtoken]);
	    $fname=$result->fname;
	    $name = strtok($fname, ' ');
	                $mailss=EmailSetting::all()->first();
	                if($mailss){
		                $subject=$mailss->password_recoveryemailsubject;
		                $msg=$mailss->password_recoveryemail;
		                $text1=str_replace(["[name]"], [$name], $msg);
	                }if(!$mailss){
		                $subject="Your Password Has Been Recovered";
		                $msg="Dear [name],  You Have Successfully Changed your  Account Password.";
		                $text1=str_replace(["[name]"], [$name], $msg);
	                }
               
        $text=view('user.welcomeemailtemplate')->with(compact('text1'));
                
		$this->directemail($subject,$text,$email);
	    
	    
            $request->session()->flash('alert-success','Password updated Successfully');
            return redirect()->route('userlogin');
        }else{
            $request->session()->flash('alert-danger','Your Credentials do not match');
            return redirect()->back()->withInput();
        }


    }
    
    
    private function settingmessage($name,$text,$msg)
    {
        
        $result1=str_replace(["[name]", "[link]"], [$name, $text], $msg);
        return $result1;
    }
}
