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
use App\Product;
use App\Category;
use App\Subcategory;
use App\VendorTransaction;
use Illuminate\Support\Facades\Response;

class Productcontroller extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function transactionsvendors(Request $request){
        $results=VendorTransaction::orderBy('id','desc')->paginate(50);
        return view('adminproduct.transaction')->with(compact('results'));
    }

    public function vendorproduct(Request $request){
        $id=$request->id;
        $vendorid=$id;
        $vendor=Vendor::where('id',$id)->first();
        if($vendor){
            $name=$vendor->name;
            $bussinessname=$vendor->bussinessname;

            $results=Product::where('username',$name)->orderBy('id','desc')->paginate(50)->setPath ( '' );

            $pagination = $results->appends ( array (
                'name' => $name,'id'=>$id,'vendorid'=>$vendorid
            ) );

            
            return view('adminproduct.allproduct')->with(compact('results','bussinessname','vendorid'))->withQuery ( $name )->withQuery ( $id )->withQuery ( $vendorid );
            
        }else{
            $request->session()->flash('alert-success', 'No User with that username found');
            return redirect()->back();
        }
    }

    public function editvendorproduct(Request $request){
        $id=$request->id;
        $vendorid=$request->vendorid;
        $result=Product::where('id',$id)->first();
        if($result){
            $category=$result->category;
            $subcategorys=Subcategory::where('category',$category)->get();
            $categorys=Category::all();

            return view('adminproduct.editproduct')->with(compact('result','vendorid','categorys','subcategorys'));
            
        }else{
            $request->session()->flash('alert-success', 'No User with that username found');
            return redirect()->back();
        }
    }

    public function saveeditedvendorproduct(Request $request){
        $id=$request->id;
        $productname=$request->productname;
        $category=$request->category;
        $subcategory=$request->subcategory;
        $currentcost=$request->currentcost;
        $productfeatures=$request->productfeatures;
        $productdescription=$request->productdescription;
        $imageurl=$request->file('imageurl');
        $image = $request->get('image-data');

        $v= Validator::make($request->all(), [
            'productname'=> 'required',
            'category' => 'required',
            'currentcost'=> 'required',
            'productfeatures' => 'required',
            'productdescription'=> 'required',
           'imageurl'=>'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $result=Product::where('id',$id)->first();
        if($result){
            if($request->hasFile('imageurl') ) {
                
                $infor=base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$image));

                $folderName = '/imageupload/';
                $safeName = str_random(10).'.'.'png';
                $destinationPath = public_path() . $folderName;
                file_put_contents(public_path().'/imageupload/'.$safeName, $infor);

                Product::where('id',$id)->update(['productname'=>$productname,'category'=>$category,
                'subcategory'=>$subcategory,'productfeatures'=>$productfeatures,'productdescription'=>$productdescription,
                'currentcost'=>$currentcost,'imageurl'=>$safeName]);

            }else{

                Product::where('id',$id)->update(['productname'=>$productname,'category'=>$category,
                'subcategory'=>$subcategory,'productfeatures'=>$productfeatures,'productdescription'=>$productdescription,
                'currentcost'=>$currentcost]);
            }

            $request->session()->flash('alert-success', 'Product Updated Successfully.');
            return redirect()->back();

        }else{
            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
    }

    public function get_subcategory(Request $request){
        $category=$request->category;
        $subcategory=Subcategory::where('category',$category)->pluck('subcategory')->toArray();

        return response()->json([
            'subcategorys' => $subcategory,
        ]);
    }
    
    public function admin_deleteproduct(Request $request){
        $id=$request->id;
        $result=Product::where('id',$id)->first();
        if($result){
            Product::where('id',$id)->delete();
            
            $request->session()->flash('alert-success', 'Product Deleted Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
    }



}
