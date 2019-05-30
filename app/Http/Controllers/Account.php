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
        $cartno=Reminders::where('user_id',$id)->pluck('CartNo')->first();
        if(!$cartno){
            return view('useraccount-nocart');
            }
        //amount paid
        $amounts=Transactions::where('user_id',$id)->where('CartNo', $cartno)->pluck('Amount');
        $amount=$amounts[0];
        //remaining amount
        $not_paid=CartOrder::where('customer_id',$id)->where('CartNo', $cartno)->where('status','confirmed')->first();
        $total=$not_paid->totalcost;
        //next payment details
        $next_payments_amounts=Reminders::where('user_id',$id)->where('status','pending')->pluck('amount');
        $next_payments=Reminders::where('user_id',$id)->where('status','pending')->get();
        $total_not_paid=$not_paid->DueAmount;
         
        return view('useraccount',compact('user','amount','total','next_payments','total_not_paid'));
       
    }
}
