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

class VendorHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');

    }

  
    public function index()
    {
        return view('vendor.home');
    }

}
