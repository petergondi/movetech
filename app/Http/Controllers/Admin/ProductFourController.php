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
use App\Slide;
use Illuminate\Support\Facades\Response;
use App\Capping;

class ProductFourController extends Controller
{
        
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function allproducts(Request $request){
        $results=Product::where('username','4PAY')->orderBy('id','desc')->paginate(50);
        return view('adminproduct.4payproducts')->with(compact('results'));
    }

    public function newallproducts(Request $request){
        $categorys=Category::all();
        $result='';
        return view('adminproduct.newpayproducts')->with(compact('categorys','result'));
    }

    public function save4payproducts(Request $request){
        $id=$request->id;
        $productname=$request->productname;
        $category=$request->category;
        $subcategory=$request->subcategory;
        $currentcost=$request->currentcost;
        $productfeatures=$request->productfeatures;
        $productdescription=$request->productdescription;
        $modelnumber=$request->modelnumber;
        $imageurl=$request->file('imageurl');
        $image = $request->get('image-data');

        if($id==''){

            $v= Validator::make($request->all(), [
                'modelnumber'=> 'required',
                'productname'=> 'required',
                'category' => 'required',
                'currentcost'=> 'required',
                'productfeatures' => 'required',
                'productdescription'=> 'required',
            'imageurl'=>'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v->errors());
            }

        }
        if($id!=''){

            $v= Validator::make($request->all(), [
                'modelnumber'=> 'required',
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

        }

        $bussinessname='4-PAY';
        if($id==''){
         

        $productresult=Product::where('username','4PAY')->where('modelnumber',$modelnumber)->first();
        if($productresult){
            $request->session()->flash('alert-success', 'Model No. Exist.');
            return redirect()->back()->withInput();
        }
        
            $infor=base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$image));

            $folderName = '/imageupload/';
            $safeName = str_random(10).'.'.'png';
            $destinationPath = public_path() . $folderName;
            file_put_contents(public_path().'/imageupload/'.$safeName, $infor);

            $post = new Product;
            $post->productname = $productname;
            $post->modelnumber = $modelnumber;
            $post->username = '4PAY';
            $post->category = $category;
            $post->bussinessname = $bussinessname;
            $post->subcategory = $subcategory;
            $post->productfeatures = $productfeatures;
            $post->productdescription=$productdescription;
            $post->currentcost = $currentcost;
            $post->imageurl = $safeName;
            $post->save();

            $request->session()->flash('alert-success', 'Product Added Successfully.');
            
        }else{ 

            $result=Product::where('id',$id)->first();
            if($result){
                if($request->hasFile('imageurl') ) {
                    
                    $infor=base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$image));

                    $folderName = '/imageupload/';
                    $safeName = str_random(10).'.'.'png';
                    $destinationPath = public_path() . $folderName;
                    file_put_contents(public_path().'/imageupload/'.$safeName, $infor);

                    Product::where('id',$id)->update(['modelnumber'=>$modelnumber,'productname'=>$productname,'category'=>$category,
                    'subcategory'=>$subcategory,'productfeatures'=>$productfeatures,'productdescription'=>$productdescription,
                    'currentcost'=>$currentcost,'imageurl'=>$safeName]);

                }else{

                    Product::where('id',$id)->update(['modelnumber'=>$modelnumber,'productname'=>$productname,'category'=>$category,
                    'subcategory'=>$subcategory,'productfeatures'=>$productfeatures,'productdescription'=>$productdescription,
                    'currentcost'=>$currentcost]);
                }
                $request->session()->flash('alert-success', 'Product Updated Successfully.');
            }else{

                $request->session()->flash('alert-success', 'No Record Found.');
            }

           
        }

        return redirect()->back();

    }

    public function editallproducts(Request $request){
        $id=$request->id;
        $result=Product::where('id',$id)->first();
        if($result){
            $category=$result->category;
            $subcategorys=Subcategory::where('category',$category)->get();
            $categorys=Category::all();
            return view('adminproduct.newpayproducts')->with(compact('result','categorys','subcategorys'));
        }else{
            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
    }


    public function delete4pay_product(Request $request){
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

    public function saveupdatedpricecost(Request $request){
        $id=$request->id;
        $cost=$request->cost;

        if($cost==''){
            return Response::json(['errorcost' => '1']);
         }

        $result=Product::where('id',$id)->first();
        if($result){
            $currentcost=$result->currentcost;

            Product::where('id',$id)->update([
                'previuscost'=>$currentcost,'currentcost'=>$cost]);
                return Response::json(['success' => '1']);
        }else{
            return Response::json(['norecorderror' => '1']);
        }

         
    }

    public function slides_images(Request $request){
        $results=Slide::all();
        $result='';
        return view('adminproduct.slideproducts')->with(compact('results','result'));
    }

    public function saveslides_images(Request $request){
        $id=$request->id;
        $title=$request->title;
        $description=$request->description;
        $image=$request->file('imageurl');
        $productname=$request->productname;

        if($id==''){

            $v= Validator::make($request->all(), [
                'title'=> 'required',
                'productname'=> 'required',
                'description'=> 'required',
                'imageurl'=>'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v->errors());
            }

        }
        if($id!=''){

            $v= Validator::make($request->all(), [
                'title'=> 'required',
                'productname'=> 'required',
                'description'=> 'required',
                'imageurl'=>'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v->errors());
            }

        }

        if($id==''){
         
            
            $imagefile=time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/imageupload/'),$imagefile);

            $post = new Slide;
            $post->productname = $productname;
            $post->title = $title;
            $post->description = $description;
            $post->imageurl = $imagefile;
            $post->save();

            $request->session()->flash('alert-success', 'Product Added Successfully.');
            
        }else{ 

            $result=Slide::where('id',$id)->first();
            if($result){
                if($request->hasFile('imageurl') ) {
                    
                    $imagefile=time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('/imageupload/'),$imagefile);

                    Slide::where('id',$id)->update(['productname'=>$productname,'title'=>$title,'description'=>$description,'imageurl'=>$imagefile]);

                }else{

                    Slide::where('id',$id)->update(['productname'=>$productname,'title'=>$title,'description'=>$description]);

                }
                $request->session()->flash('alert-success', 'Product Updated Successfully.');
            }else{

                $request->session()->flash('alert-success', 'No Record Found.');
            }

           
        }

        return redirect()->route('newslides_vendor');

    }

    public function editslides_images(Request $request){
        $id=$request->id;
        $result=Slide::where('id',$id)->first();
        if($result){
            $results=Slide::all();
            return view('adminproduct.slideproducts')->with(compact('results','result'));
        }else{
            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
    } 

    public function deleteslides_images(Request $request){
        $id=$request->id;
        $result=Slide::where('id',$id)->first();
        if($result){
            Slide::where('id',$id)->delete();
            $request->session()->flash('alert-success', 'Deleted Successfully.');
            return redirect()->route('newslides_vendor');
        }else{
            $request->session()->flash('alert-success', 'No Record Found.');
            return redirect()->back();
        }
    }


}
