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
use App\Capping;

class SMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function smssettings(Request $request){
        $result=SMSSetting::all()->first();
        return view('settings.smssettings')->with(compact('result'));
    }

    public function usersubmitsmssettings(Request $request){

        $senderid= $request->senderid;
        $username= $request->username;
        $apikey= $request->apikey;
        $v= Validator::make($request->all(), [
            'senderid'=> 'required',
            'username'=> 'required',
            'apikey'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $result=SMSSetting::all()->first();
        if($result){
            SMSSetting::truncate();
            $post = new SMSSetting;
            $post->senderid = $senderid;
            $post->username = $username;
            $post->apikey = $apikey;
            $post->save();
        }else{

            $post = new SMSSetting;
            $post->senderid = $senderid;
            $post->username = $username;
            $post->apikey = $apikey;
            $post->save();
        }

        $request->session()->flash('alert-success', 'Updated Successfully');
           
        return redirect()->back();

    }

    public function emailsettings(Request $request){
        $result=MailSetting::all()->first();
        return view('settings.emailsettings')->with(compact('result'));
    }

    public function usersubmitemailsettings(Request $request){

        $host= $request->host;
        $username= $request->username;
        $password= $request->password;
        $fromaddress= $request->fromaddress;
        $fromname= $request->fromname;
        $v= Validator::make($request->all(), [
            'host'=> 'required',
            'username'=> 'required',
            'password'=> 'required',
            'fromaddress'=> 'required',
            'fromname'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $result=MailSetting::all()->first();
        if($result){
            MailSetting::truncate();
            $post = new MailSetting;
            $post->host = $host;
            $post->username = $username;
            $post->password = $password;
            $post->fromaddress = $fromaddress;
            $post->fromname = $fromname;
            $post->save();
        }else{

            $post = new MailSetting;
            $post->host = $host;
            $post->username = $username;
            $post->password = $password;
            $post->fromaddress = $fromaddress;
            $post->fromname = $fromname;
            $post->save();
        }

        $request->session()->flash('alert-success', 'Updated Successfully');
           
        return redirect()->back();

    }


    public function cappingsettings(Request $request){
        $results=Capping::orderBy('id','desc')->get();
        $result='';
        return view('settings.capping')->with(compact('results','result'));
    }

    public function savecappingsettings(Request $request){
        
        $id= $request->id;
        $cap= $request->cap;
        $v= Validator::make($request->all(), [
            'cap'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        if($id==''){
            $post = new Capping;
            $post->cap = $cap;
            $post->save();
            $request->session()->flash('alert-success', 'Added Successfully');
        }if($id!=''){
            $results=Capping::where('id',$id)->first();
            if($results){
                Capping::where('id',$id)->update(['cap'=>$cap]);
                $request->session()->flash('alert-success', 'Updated Successfully');
          
            }else{
                $request->session()->flash('alert-success', 'No Record Found');
          
            }
        }
        
        return redirect()->route('capping_settings');

    }

    public function editcappingsettings(Request $request){
        $id= $request->id;
        $result=Capping::where('id',$id)->first();
        if($result){
            $results=Capping::orderBy('id','desc')->get();
            return view('settings.capping')->with(compact('results','result'));
        }else{
            $request->session()->flash('alert-success', 'No Record Found');
            return redirect()->back();
        }
    }

    public function deletecapping_record(Request $request){
        $id= $request->id;
        $result=Capping::where('id',$id)->first();
        if($result){
            Capping::where('id',$id)->delete();
            $request->session()->flash('alert-success', 'Record Deleted Successfully');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-success', 'No Record Found');
            return redirect()->back();
        }
    }

}
