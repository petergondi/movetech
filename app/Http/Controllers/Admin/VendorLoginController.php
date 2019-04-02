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

class VendorLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'vendor/home';

    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout');
    }


    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect('/');
    }

    public function loginform()
    {
        return view('vendor.login');
    }
    public function vendor_login(Request $request){
        $name=$request->name;
        
        $user=Vendor::where('name',$name)->first();
        if($user){
            $encyrptedpssd=$request->encyrptedpssd;
            Auth::login($user);
        //    if(Auth::loginUsingId($user->id))
        //         {     
                     return redirect()->intended('vendor/home'); 
        //         }
        //         $request->session()->flash('alert-success', 'No User with that username found');
        //         return redirect()->back();
        //if session exists remove it and return login to original user 
        }else{
            $request->session()->flash('alert-success', 'No User with that username found');
            return redirect()->back();
        }
    }
}
