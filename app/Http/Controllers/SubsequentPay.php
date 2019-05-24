<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\C2B;
use App\Reminders;
use Carbon\Carbon;

class SubsequentPay extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function confirm(Request $request){
        $code=$request->code;
        $id=Auth::user()->id;
        //check if the code entered by user is valid
        $confirm=C2B::where('code',$code)->where('status','pending')->first();
        if($confirm){
         $check_next_payment=Reminders::where('user_id',$id)->where('status','pending')->first();
         if($check_next_payment){
             //update the two tables on re
            Reminders::where('user_id',$id)->where('status','pending')->first()->update(['status'=>'confirmed']);
            C2B::where('code',$code)->where('status','pending')->first()->update(['status'=>'confirmed']);
            $check_remaining_installments=Reminders::where('user_id',$id)->where('status','pending')->get();
            if(count($check_remaining_installments)==0){
                response()->json(['state' => 'you have finished paying for your items,you will receive information about delivery via text']);
            }
         }
        }
        else{
            
            response()->json(['state' => 'you have entered incorrect code']);
        }
        
    }
}

