<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Vendor;
use DB;
use Illuminate\Support\Facades\Cache;

class GuestController extends Controller
{
    public function index()
    {
       
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $categories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC limit 5 ") );
       // $subcategories=DB::select( DB::raw( "SELECT * FROM subcategories ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
       
        return view('guestmainlayout')->with(compact('vendors','categories','leftcategories'));
    }

    public function trendingproduct(Request $request){
        $productname=urldecode($request->productname);
        $id=$request->id;
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        // $products=Product::where('id', $id)->first();
        // if($products){
        //     $category=$products->category;
        //     $subcategory=$products->subcategory;
            
        //     $results=Product::where('productname', 'LIKE', '%' . $productname . '%')->get();
        //     return view('viewproductbody')->with(compact('results','vendors','leftcategories'));

        // }else{
           
            $results=Product::where('productname', 'LIKE', '%' . $productname . '%')->get();
            return view('viewproductbody')->with(compact('results','vendors','leftcategories'));
        // }
        
    }
    
    public function singleitem(Request $request){
        $productname=urldecode($request->productname);
        $id=$request->id;
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        $products=Product::where('id', $id)->first();
        if($products){
            
            $results=Product::where('productname', 'LIKE', '%' . $productname . '%')->get();
            return view('viewsingleproductbody')->with(compact('results','vendors','leftcategories','products'));

        }else{
            
            $results=Product::where('productname', 'LIKE', '%' . $productname . '%')->get();
            return view('viewproductbody')->with(compact('results','vendors','leftcategories'));
        }
        
    }

    public function subcategories(Request $request){
        $category=urldecode($request->category);
        $subcategory=urldecode($request->subcategory);
        $results=Product::where('category',  $category)->where('subcategory',  $subcategory)->get();
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        return view('viewproductbody')->with(compact('results','vendors','leftcategories'));
        
    }

    public function bra_nds(Request $request){

        $bussinessaliasname=urldecode($request->bussinessaliasname);
        $results=Product::where('bussinessname',  $bussinessaliasname)->orderBy('id','desc')->get();
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        return view('viewproductbody')->with(compact('results','vendors','leftcategories'));
        
    }

    public function cate_gory(Request $request){
        $category=urldecode($request->category);
        $results=Product::where('category',  $category)->get();
        $vendors=DB::select( DB::raw( "SELECT * FROM vendors ORDER BY priority  + 0 DESC" ) );
        $leftcategories=DB::select( DB::raw("SELECT * FROM categories ORDER BY priority  + 0 DESC") );
        return view('viewproductbody')->with(compact('results','vendors','leftcategories'));
        
    }

}
