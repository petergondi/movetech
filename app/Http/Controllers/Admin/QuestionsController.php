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
use App\Product;
use App\Category;
use App\Subcategory;
use App\VendorTransaction;
use Illuminate\Support\Facades\Response;
use App\QuestionTb;

class QuestionsController extends Controller
{
        
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function allquestions(Request $request){
        $results=QuestionTb::orderBy('id','desc')->paginate(50);
        return view('question.allquestion')->with(compact('results'));
    }

    public function reply_questions(Request $request){
        $id=$request->id;
        $result=QuestionTb::where('id',$id)->first();
        if($result){

            return view('question.replyquestion')->with(compact('result'));
        }else{

            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
        
        
    }

    public function savereply_questions(Request $request){
        $id=$request->id;
        $replyquestion=$request->replyquestion;
        $result=QuestionTb::where('id',$id)->first();
        if($result){
            $email=$result->email;
            $fname=$result->fname;
            $subject=$result->subject;
            QuestionTb::where('id',$id)->update(['replyquestion'=>$replyquestion,'status'=>'replied']);

            // $this->directemail($replyquestion,$email,$fname,$subject);

            $request->session()->flash('alert-success', 'Question Replied Successfully.');
            return redirect()->route('askedquestions');
        }else{

            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
    }


    public function directemail($replyquestion,$email,$fname,$subject)
    {

	require './phpmailer/PHPMailer_5.2.0/class.phpmailer.php';

        $settings=MailSetting::all()->first();
        $host=$settings->host;
        $username=$settings->username;
        $password=$settings->password;
        $fromaddress=$settings->fromaddress;
        $fromname=$settings->fromname;


            $openaccount_emailsubject=$subject;
		    $finalmessage=$replyquestion;
        
			
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

}
