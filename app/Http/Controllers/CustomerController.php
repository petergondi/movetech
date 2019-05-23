<?php

namespace App\Http\Controllers;
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

class CustomerController extends Controller
{
        
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function showcustomer(Request $request){
        $results=User::orderBY('id','desc')->paginate(50);
        return view('customer.customers')->with(compact('results'));
    }

    public function allcartorder(Request $request){
        $results=CartOrder::orderBY('id','desc')->paginate(50);
        return view('report.allorder')->with(compact('results'));
    }

    public function allapprovedorder(Request $request){
        $results=CartOrder::where('status','confirmed')->orderBY('id','desc')->paginate(50);
        return view('report.approvedorder')->with(compact('results'));
    }

}
