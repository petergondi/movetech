<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\MailSetting;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPMailer;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login');
        //  return "yes";
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/');
    }

    public function showresetpassword()
    {
        return view('admin.resetpassword');
    }

    public function resetpass(Request $request)
    {
        $email=$request->email;


        $v = Validator::make($request->all(), [
            'email' => 'required|email'

        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $result=Admin::where('email',$email)->first();
        if($result){

            $request->session()->flash('alert-success','Password send to your Email');
            $this->sendmailtoresetpassword($email);
            return redirect()->route('password_reset');
        }else{
            $request->session()->flash('alert-danger','No such email is  found in the database');
            return redirect()->route('password_reset');
        }



    }


    public function sendmailtoresetpassword($email)
    {

        $results = Admin::where('email', $email)->first();

        $tokens = $results->token;
        $emails=$email;


        $settings=MailSetting::all()->first();
        $host=$settings->host;
        $port=$settings->port;
        $username=$settings->username;
        $password=$settings->password;
        $fromaddress=$settings->fromaddress;
        $fromname=$settings->fromname;
        $subject=$settings->subject;



        $text=view('admin.resetmail')->with(compact('emails','tokens'));

        $mail = new PHPMailer(true);
        try{



            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            $mail->SMTPAuth =true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = $host; //gmail has host > smtp.gmail.com
            $mail->Port = $port; //gmail has port > 587 . without double quotes
            $mail->Username = $username; //your username. actually your email
            $mail->Password = $password; // your password. your mail password
            //$mail->setFrom($request->email, $request->name);
            $mail->From = ($fromaddress);
            $mail->FromName = $fromname;
            // $mail->Subject = $request->subject;
            $mail->Subject = "Password Reset";
            // $mail->MsgHTML($request->text);
            $mail->MsgHTML($text);

            $mail->addAddress($email );
            set_time_limit(60);



            $mail->send();
        }catch(phpmailerException $e){
            dd($e);
        }catch(Exception $e){
            dd($e);
        }


    }

    public function newpassworddd($email,$token)
    {
        $emails=$email;
        $tokens=$token;
        return view('admin.passwordresetform')->with(compact('emails','tokens'));
    }

    public function updatepassword(Request $request)
    {
        $email=$request->email;
        $token=$request->token;
        $newpassword=$request->newpassword;
        $confirmpassword=$request->confirmpassword;
        $password=bcrypt($newpassword);
        $newtoken=str_random(40);
        $v = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'newpassword' => 'required|min:6',
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


        $result= Admin::where('email', $email)->where('token',$token)->update(['password' => $password,'token'=>$newtoken]);

        if($result){

            $request->session()->flash('alert-success','Password updated Successfully');
            return redirect()->route('admlogin');
        }else{
            $request->session()->flash('alert-danger','Your Credentials do not match');
            return redirect()->back()->withInput();
        }


    }



}
