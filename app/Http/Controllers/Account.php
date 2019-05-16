<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transactions;
use App\Cart;
use App\CartOrder;
use App\Reminders;

class Account extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showAccount(){
        $user=Auth::user()->name;
        $id=Auth::user()->id;
        $amounts=Transactions::where('user_id',$id)->pluck('Amount');
        $amount=$amounts[0];
        $totals_to_be_paid=CartOrder::where('user_id',$id)->pluck('totalcost');
        if(count($amounts)>0){
            $amount=$amounts[0];
        }
        else{
            $amount=0;
        }
        if(count($totals_to_be_paid)>0){
            $total=$totals_to_be_paid[0];
        }
        else{
            $total=0;
        }
        $next_payments_amounts=Reminders::where('user_id',$id)->where('status','pending')->pluck('amount');
        $next_payments=Reminders::where('user_id',$id)->where('status','pending')->get();
        if(count($next_payments)>0){
            $payment_array=json_decode(json_encode($next_payments_amounts), true);
            $total_not_paid=array_sum($payment_array);
        }
        else{
            $total_not_paid=0;
        }
        
        return view('useraccount',compact('user','amount','total','next_payments','total_not_paid'));
    }
}
