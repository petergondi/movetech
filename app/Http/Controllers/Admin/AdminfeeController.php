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
use App\AdminCharge;

class AdminfeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

    }
    public function adminCharge(Request $request){
        $results=AdminCharge::orderBy('id','desc')->get();
        $result='';
        return view('settings.admincharge')->with(compact('results','result'));
    }

    public function saveCharge(Request $request){
        
        $id= $request->id;
        $fee= $request->fee;
        $v= Validator::make($request->all(), [
            'fee'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        if($id==''){
            $post = new AdminCharge;
            $post->fee = $fee;
            $post->save();
            $request->session()->flash('alert-success', 'Added Successfully');
        }if($id!=''){
            $results=AdminCharge::where('id',$id)->first();
            if($results){
                AdminCharge::where('id',$id)->update(['fee'=>$fee]);
                $request->session()->flash('alert-success', 'Updated Successfully');
          
            }else{
                $request->session()->flash('alert-success', 'No Record Found');
          
            }
        }
        
        return redirect()->route('capping_settings');

    }

    public function editCharge(Request $request){
        $id= $request->id;
        $result=AdminCharge::where('id',$id)->first();
        if($result){
            $results=AdminCharge::orderBy('id','desc')->get();
            return view('settings.admincharge')->with(compact('results','result'));
        }else{
            $request->session()->flash('alert-success', 'No Record Found');
            return redirect()->back();
        }
    }

    public function deleteCharge(Request $request){
        $id= $request->id;
        $result=AdminCharge::where('id',$id)->first();
        if($result){
            AdminCharge::where('id',$id)->delete();
            $request->session()->flash('alert-success', 'Record Deleted Successfully');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-success', 'No Record Found');
            return redirect()->back();
        }
    }
}
