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

class VendorProfileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:vendor');

    }

    public function companyprofile()
    {
        $result=Vendor::where('name',Auth::user()->name)->first();
        return view('company.vendorprofile')->with(compact('result'));

    }

    public function savecompanyprofile(Request $request){
        $phonenumber1=$request->phonenumber;
        $krapin= $request->krapin;
        $bussinessname=$request->bussinessname;
        $bussinessaliasname= $request->bussinessaliasname;
        $bussinessaddress=$request->bussinessaddress;
        $physicaladdress= $request->physicaladdress;
        $bankaccount= $request->bankaccount;
        $v= Validator::make($request->all(), [
            'phonenumber'=> 'required',
            'bussinessaliasname'=> 'required',
            'bussinessname'=> 'required',
            'bussinessaddress'=> 'required',
            'physicaladdress'=> 'required',
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

        $result=Vendor::where('name',Auth::user()->name)->first();

        if($result){
            Vendor::where('name',Auth::user()->name)->update(['phonenumber'=>$phonenumber,'krapin'=>$krapin,
            'bussinessname'=>$bussinessname,'bussinessaliasname'=>$bussinessaliasname,'bussinessaddress'=>$bussinessaddress,
            'physicaladdress'=>$physicaladdress,'bankaccount'=>$bankaccount]);
               
            $request->session()->flash('alert-success', 'Updated Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-danger', 'No Record Found.');
            return redirect()->back();
        }
    }

    public function vendor_customer(Request $request){

        $results=User::where('vendorname',Auth::user()->name)->orderBy('id','desc')->paginate(50);
        return view('customer.vendorcustomer')->with(compact('results'));
    }

}
