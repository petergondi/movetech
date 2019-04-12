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
use App\Category;
use App\Subcategory;
use App\Company;
use App\Product;
use Illuminate\Support\Facades\Response;


class Vendorcontroller extends Controller
{  
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function allvendors(Request $request){
        $vendors=Vendor::orderBy('id','desc')->get();
        return view('adminvendor.allvendor')->with(compact('vendors'));
    }
    public function newallvendors(Request $request){
        $result='';
        return view('adminvendor.newvendor')->with(compact('result'));
    }
    public function editallvendors(Request $request){
        $id=$request->id;
        $result=Vendor::where('id',$id)->first();
        if($result){
            
            return view('adminvendor.newvendor')->with(compact('result'));
        }else{
            $request->session()->flash('alert-danger', 'No Record Found.');
            return redirect()->back();
        }
    }
    public function deleteallvendors(Request $request){
        $id=$request->id;
        $result=Vendor::where('id',$id)->first();
        if($result){
            $username=$result->name;

            Vendor::where('id',$id)->delete();
            Product::where('username',$username)->delete();

            $request->session()->flash('alert-success', 'Deleted Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-danger', 'No Record Found.');
            return redirect()->back();
        }
    }
    public function suspendvendors(Request $request){
        $id=$request->id;

        $result=Vendor::where('id',$id)->first();

        if($result){
            
            Vendor::where('id',$id)->update(['status'=>'suspended']);
            
            $request->session()->flash('alert-success', 'Suspended Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-danger', 'No Record Found.');
            return redirect()->back();
        }
    }

    public function approvevendors(Request $request){
        $id=$request->id;

        $result=Vendor::where('id',$id)->first();

        if($result){
            
            Vendor::where('id',$id)->update(['status'=>'active']);
            
            $request->session()->flash('alert-success', 'Approved Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-danger', 'No Record Found.');
            return redirect()->back();
        }
    }

    public function savenewallvendors(Request $request){
        $bussinessaddress= $request->bussinessaddress;
           $physicaladdress= $request->physicaladdress;
           $email= $request->email;
           $phonenumber1= $request->phonenumber;
           $password= $request->password;
           $name= $request->name;
           $id= $request->id;
           if($id==''){
                $v= Validator::make($request->all(), [
                    'bussinessaddress'=> 'required',
                    'physicaladdress'=> 'required',
                    'name' => 'required|regex:/(^[A-Za-z0-9_]+$)+/|max:78|unique:vendors',
                    'email' => 'required|email|max:150|unique:vendors',
                    'phonenumber' => 'required|unique:vendors|min:7|regex:/(^[0-9+]+$)+/',
                
                    'password' => 'required|min:6|confirmed',
                
                ],
                ['bussinessaddress.required'=>'Bussiness Address is required.',
                'physicaladdress.required'=>'Physical Address is required.',
                'email.required'=>'Email is required.',
                'phonenumber.required'=>'Phone Number Format is Incorrect.',
                ]);
           }if($id!=''){
                $v= Validator::make($request->all(), [
                    'bussinessaddress'=> 'required',
                    'physicaladdress'=> 'required',
                    'name' => 'required|regex:/(^[A-Za-z0-9_]+$)+/|max:78',
                    'email' => 'required|email|max:150',
                    'phonenumber' => 'required|min:7|regex:/(^[0-9+]+$)+/',
                
                
                ],
                ['bussinessaddress.required'=>'Bussiness Address is required.',
                'physicaladdress.required'=>'Physical Address is required.',
                'email.required'=>'Email is required.',
                'phonenumber.required'=>'Phone Number Format is Incorrect.',
                ]);
           }
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
            $smstoken=$this->random_str();
            $emailtoken=str_random(40);
        if($id==''){

            
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
            $post->status= "active";
            $post->save();
            $newpassword=$password;

            $request->session()->flash('alert-success', 'Account Created Successfully');
        }if($id!=''){ 
            if($password!=''){
                Vendor::where('id',$id)->update(['bussinessaddress'=>$bussinessaddress,'physicaladdress'=>$physicaladdress,
                'email'=>$email,'phonenumber'=>$phonenumber,'name'=>$name,'password'=>bcrypt($password)/*,'encyrptedpssd'=> $password*/,'emailtoken'=>$emailtoken,
                'smstoken'=>$smstoken]);
                $newpassword=$password;
            }else{
                Vendor::where('id',$id)->update(['bussinessaddress'=>$bussinessaddress,'physicaladdress'=>$physicaladdress,
                'email'=>$email,'phonenumber'=>$phonenumber,'name'=>$name,'emailtoken'=>$emailtoken,
                'smstoken'=>$smstoken]);
                $newpassword='Current Password';
            }
            $request->session()->flash('alert-success', 'Udpated Successfully');
        }

           // $this->directmessage( $phonenumber,$email, $name, $newpassword);


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


    public function directmessage( $phonenumber,$email, $name, $password){
        $message ="Dear ".$name." Account info: Username: " .$name." Password: ".$password;
        
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

         $this->directemail($email,$name,$password);
    }


    public function directemail($email,$name,$password)
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
		    $finalmessage="Dear ".$name." Account info: Username: " .$name." Password: ".$password;
        
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

    public function update_priority(Request $request){
        $id=$request->id;
        $priority=$request->priority;

        if($priority==''){
            return Response::json(['error' => '1']);
         }


         Vendor::where('id',$id)->update([
         'priority'=>$priority]);
         return Response::json(['success' => '1']);
    }


}
