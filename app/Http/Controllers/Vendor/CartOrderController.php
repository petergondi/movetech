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
use App\Category;
use App\Subcategory;
use App\Company;
use Illuminate\Support\Facades\Response;
use App\CartOrder;
use App\Cart;

class CartOrderController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:vendor');

    }

    public function allvendororder()
    {
        $results=Cart::where('bussinessname',Auth::user()->bussinessaliasname)->orderBy('id','desc')->paginate(50);
        return view('report.allvendorcartorders')->with(compact('results'));

    }

    public function approvedvendororder()
    {
        $results=Cart::where('bussinessname',Auth::user()->bussinessaliasname)->where('status','confirmed')->orderBy('id','desc')->paginate(50);
        return view('report.confirmordervendor')->with(compact('results'));

    }
}
