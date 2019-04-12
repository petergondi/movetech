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
use App\Product;
use App\Category;
use App\Subcategory;
use App\VendorTransaction;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:vendor');

    }

    public function vendor_product()
    {
        $results=Product::where('username',Auth::user()->name)->orderBy('id','desc')->paginate(50);
        return view('product.allproduct')->with(compact('results'));

    }

    public function vendor_new_product(Request $request){
        $categorys=Category::all();
        return view('product.newproduct')->with(compact('categorys'));
    }

    public function get_subcategory(Request $request){
        $category=$request->category;
        $subcategory=Subcategory::where('category',$category)->pluck('subcategory')->toArray();

        return response()->json([
            'subcategorys' => $subcategory,
        ]);
    }

    public function savevendor_new_product(Request $request){
        $productname=$request->productname;
        $category=$request->category;
        $subcategory=$request->subcategory;
        $currentcost=$request->currentcost;
        $productfeatures=$request->productfeatures;
        $productdescription=$request->productdescription;
        $productcount=$request->product_count;
        $imageurl=$request->file('imageurl');
        $image = $request->get('image-data');

        $v= Validator::make($request->all(), [
            'productname'=> 'required',
            'category' => 'required',
            'currentcost'=> 'required',
            'productfeatures' => 'required',
            'product_count'=>'required',
            'productdescription'=> 'required',
           'imageurl'=>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $productresult=Product::where('id',Auth::user()->id)->where('productname',$productname)->first();
        if($productresult){
            $request->session()->flash('alert-success', 'Product Exist with that Name.');
            return redirect()->back()->withInput();
        }
        
        $result=Vendor::where('id',Auth::user()->id)->first();
        $bussinessname=$result->bussinessaliasname;

        $infor=base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$image));

        $folderName = '/imageupload/';
        $safeName = str_random(10).'.'.'png';
        $destinationPath = public_path() . $folderName;
        file_put_contents(public_path().'/imageupload/'.$safeName, $infor);

        $post = new Product;
        $post->productname = $productname;
        $post->username = Auth::user()->name;
        $post->category = $category;
        $post->bussinessname = $bussinessname;
        $post->subcategory = $subcategory;
        $post->productfeatures = $productfeatures;
        $post->productdescription=$productdescription;
        $post->productcount=$productcount;
        $post->currentcost = $currentcost;
        $post->imageurl = $safeName;
        $post->save();

        $request->session()->flash('alert-success', 'Product Added Successfully.');
        return redirect()->back();


    }

    public function vendor_edit_product(Request $request){
        $id=$request->id;
        $result=Product::where('id',$id)->first();
        if($result){
            $category=$result->category;
            $subcategorys=Subcategory::where('category',$category)->get();
            $categorys=Category::all();
            return view('product.editproduct')->with(compact('result','categorys','subcategorys'));
        }else{
            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
        
    }

    public function savevendor_edit_product(Request $request){
        $id=$request->id;
        $productname=$request->productname;
        $category=$request->category;
        $subcategory=$request->subcategory;
        $currentcost=$request->currentcost;
        $productfeatures=$request->productfeatures;
        $productdescription=$request->productdescription;
        $productcount= $request->product_count;
        $imageurl=$request->file('imageurl');
        $image = $request->get('image-data');

        $v= Validator::make($request->all(), [
            'productname'=> 'required',
            'category' => 'required',
            'currentcost'=> 'required',
            'productfeatures' => 'required',
            'product_count' => 'required',
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

                $folderName = 'imageupload/';
                $safeName = str_random(10).'.'.'png';
                $destinationPath = public_path() . $folderName;
                file_put_contents(public_path().'imageupload/'.$safeName, $infor);

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

    public function vendor_delete_product(Request $request){
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

    public function product_transactions(Request $request){
        $results=VendorTransaction::where('username',Auth::user()->name)->orderBy('id','desc')->paginate(50);
        return view('product.transaction')->with(compact('results'));
    }

}
