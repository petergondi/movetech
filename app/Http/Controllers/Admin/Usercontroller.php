<?php

namespace App\Http\Controllers\Admin;


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
use App\Admin;

class Usercontroller extends Controller
{
       
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function usersettings(){
        $results=Admin::all();
        return view('adminuser.user')->with(compact('results'));
    }

    public function usernew(Request $request){
        return view('adminuser.usernew');
    }

    public function saveusernew(Request $request){
        $fname= $request->fname;
        $name= $request->name;
        $password= $request->password;
        $email= $request->email;
        $phonenumber1= $request->phonenumber;
        $v= Validator::make($request->all(), [
            'fname'=> 'required',
            'name'=> 'required|unique:admins',
            'password'=> 'required|min:6|confirmed',
            'email'=> 'required|unique:admins',
            'phonenumber'=> 'required',
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
   
  
        $phonenumbersearch=Admin::where('phonenumber',$phonenumber)->first();

        if($phonenumbersearch){
        
        $request->session()->flash('alert-danger', 'Phone number is Exists in our database.Use a different phone number or contact admin');
                return redirect()->back()->withInput();
        }

        $smstoken=$this->random_str();
        $emailtoken=str_random(40);
        $post = new Admin;
        $post->fname = $fname;
        $post->name = $name;
        $post->email = $email;
        $post->phonenumber = $phonenumber;
        $post->password = bcrypt($password);
        $post->token= $emailtoken;
        $post->smstoken= $smstoken;
        $post->status= "active";
        $post->save();

      // $this->directmessage( $phonenumber,$email, $password,$fname, $name);


      $request->session()->flash('alert-warning', 'Account Created.');
     
     return redirect()->back();

    }
    public function directmessage( $phonenumber,$email, $password,$fname, $name){
        $message ="Dear ".$fname." Account info: Username: " .$name." Password: ".$password;
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

         $this->directemail($fname,$email,$name,$password);
    }


    public function directemail($fname,$email,$name,$password)
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

            $openaccount_emailsubject=" Account Information";
		    $finalmessage="Dear ".$fname." Account info: Username: " .$name." Password: ".$password;
        
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

    public function edit_newuser(Request $request){
        $id=$request->id;
        $result=Admin::where('id',$id)->first();

        if($result){
        
        return view('adminuser.edituser')->with(compact('result'));
        }else{
            $request->session()->flash('alert-danger', 'No Account Found.');
            return redirect()->back()->withInput();
        }

    }

    public function saveedit_newuser(Request $request){
        $id=$request->id;
        $fname= $request->fname;
        $name= $request->name;
        $password= $request->password;
        $email= $request->email;
        $phonenumber1= $request->phonenumber;
        $v= Validator::make($request->all(), [
            'fname'=> 'required',
            'name'=> 'required',
            'email'=> 'required',
            'phonenumber'=> 'required',
            'password'=> 'min:6|confirmed',
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
        
        $result=Admin::where('id',$id)->first();

        if($result){
            if($password==''){
                Admin::where('id',$id)->update(['fname'=>$fname,'name'=>$name,'email'=>$email,'phonenumber'=>$phonenumber]);
                $newpassword='Current password';
            }
            if($password!=''){
                Admin::where('id',$id)->update(['fname'=>$fname,'name'=>$name,'email'=>$email,
                'phonenumber'=>$phonenumber,'password'=>bcrypt($password)]);
                $newpassword=$password;
            }
         //   $this->directmessage( $phonenumber,$email, $newpassword,$fname, $name);

            $request->session()->flash('alert-success', 'Updated Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-danger', 'No Account Found.');
            return redirect()->back()->withInput();
        }
    }

    public function delete_newuser(Request $request){
        $id=$request->id;
          
        $result=Admin::where('id',$id)->first();

        if($result){
            Admin::where('id',$id)->delete();
            $request->session()->flash('alert-success', 'Deleted Successfully');
            return redirect()->back();

        }else{
            $request->session()->flash('alert-danger', 'No Account Found.');
            return redirect()->back();
        }
    }

}
