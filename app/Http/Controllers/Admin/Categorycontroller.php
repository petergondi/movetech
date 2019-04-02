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
use App\Category;
use App\Subcategory;
use App\Company;
use Illuminate\Support\Facades\Response;

class Categorycontroller extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function category_settings(Request $request){
        $categorys=Category::orderBY('id','disc')->get();
        return view('category.allcategory')->with(compact('categorys'));
    }

    public function subcategory_settings(Request $request){
        $subcategorys=Subcategory::orderBY('id','disc')->get();
        $categorys=Category::orderBY('id','disc')->get();
        return view('category.allsubcategory')->with(compact('categorys','subcategorys'));
    }

    public function savecategory_settings(Request $request){
        $category= $request->category;
        $v= Validator::make($request->all(), [
            'category'=> 'required|unique:categories',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $post = new Category;
        $post->category = $category;
        $post->save();

        $request->session()->flash('alert-success', 'Added Successfully'); 
        return redirect()->back();

    }

    public function savesubcategory_settings(Request $request){
        $category= $request->category;
        $subcategory= $request->subcategory;
        $v= Validator::make($request->all(), [
            'category'=> 'required',
            'subcategory'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $subcategorys=Subcategory::where('category',$category)->where('subcategory',$subcategory)->first();
        if($subcategorys){

            $request->session()->flash('alert-success', 'Sub-category was found'); 
            return redirect()->back();
        }else{

            $post = new Subcategory;
            $post->category = $category;
            $post->subcategory = $subcategory;
            $post->save();

            $request->session()->flash('alert-success', 'Added Successfully'); 
            return redirect()->back();
        }


    }
    
    public function company_profile(Request $request){

        $result=Company::all()->first();
        return view('company.companyprofile')->with(compact('result'));

    }

    public function savecompany_profile(Request $request){
        $company= $request->company;
        $address= $request->address;
        $phonenumber= $request->phonenumber;
        $email= $request->email;
        $v= Validator::make($request->all(), [
            'company'=> 'required',
            'address'=> 'required',
            'phonenumber'=> 'required',
            'email'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $result=Company::all()->first();
        if($result){
            Company::truncate();
            
            $post = new Company;
            $post->company = $company;
            $post->address = $address;
            $post->phonenumber = $phonenumber;
            $post->email = $email;
            $post->save();
        }else{

            $post = new Company;
            $post->company = $company;
            $post->address = $address;
            $post->phonenumber = $phonenumber;
            $post->email = $email;
            $post->save();

        }

        $request->session()->flash('alert-success', 'Added Successfully'); 
        return redirect()->back();

    }

    public function editcategory_settings(Request $request){
        $id=$request->id;
          
        $result=Category::where('id',$id)->first();

        if($result){
            $categorys=Category::all();
        
            return view('category.editcategory')->with(compact('categorys','result'));
        }else{
            $request->session()->flash('alert-danger', 'No Category Found.');
            return redirect()->back();
        }
    }

    public function saveeditedcategory_settings(Request $request){
        $id=$request->id;
        $category=$request->category;
        $v= Validator::make($request->all(), [
            'category'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $result=Category::where('id',$id)->first();

        if($result){

            $dbcategory=$result->category;
            Subcategory::where('category',$dbcategory)->update(['category'=>$category]);
            Category::where('id',$id)->update(['category'=>$category]);

            
            $request->session()->flash('alert-success', 'Updated Successfully.');
            return redirect()->route('categorysettings');
        }else{
            $request->session()->flash('alert-danger', 'No Category Found.');
            return redirect()->route('categorysettings');
        }
    }

    public function deletecategory_settings(Request $request){
        $id=$request->id;

        $result=Category::where('id',$id)->first();

        if($result){
            $dbcategory=$result->category;
            Subcategory::where('category',$dbcategory)->delete();
            Category::where('id',$id)->delete();

          
        
            $request->session()->flash('alert-success', 'Deleted Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('alert-danger', 'No Category Found.');
            return redirect()->back();
        }
    }

    public function editesubcategory_settings(Request $request){
        $id=$request->id;
          
        $result=Subcategory::where('id',$id)->first();

        if($result){
            $subcategorys=Subcategory::all();
            return view('category.editsubcategory')->with(compact('result','subcategorys'));
        }else{
            $request->session()->flash('alert-danger', 'No Category Found.');
            return redirect()->back();
        }
    }

    public function saveeditesubcategory_settings(Request $request){
        $id=$request->id;
        $subcategory= $request->subcategory;
        $v= Validator::make($request->all(), [
            'subcategory'=> 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $result=Subcategory::where('id',$id)->first();

        if($result){
            Subcategory::where('id',$id)->update(['subcategory'=>$subcategory]);
               
            $request->session()->flash('alert-success', 'Updated Successfully.');
            return redirect()->route('subcategorysettings');
        }else{
            $request->session()->flash('alert-danger', 'No Category Found.');
            return redirect()->route('subcategorysettings');
        }
    }


    public function deletesubcategory_settings(Request $request){
        $id=$request->id;
        
        $result=Subcategory::where('id',$id)->first();

        if($result){
            Subcategory::where('id',$id)->delete();
               
            $request->session()->flash('alert-success', 'Deleted Successfully.');
            return redirect()->route('subcategorysettings');
        }else{
            $request->session()->flash('alert-danger', 'No Category Found.');
            return redirect()->route('subcategorysettings');
        }
    }

    public function categoryupdatedpriority(Request $request){
        $id=$request->id;
        $priority=$request->priority;

        if($priority==''){
            return Response::json(['error' => '1']);
         }

         Category::where('id',$id)->update([
         'priority'=>$priority]);
         return Response::json(['success' => '1']);
    }

    public function subcategoryupdatedpriority(Request $request){
        $id=$request->id;
        $priority=$request->priority;

        if($priority==''){
            return Response::json(['error' => '1']);
         }


         Subcategory::where('id',$id)->update([
         'priority'=>$priority]);
         return Response::json(['success' => '1']);
    }

}
