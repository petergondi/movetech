<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//user login routes
// Route::get('home', 'HomeController@index')->name('home');
// Route::get('/home/logout', 'Auth\LoginController@userlogout')->name('user.logout');


Route::get('/', 'GuestController@index')->name('home');

//trendingproductview
Route::get('/products', 'GuestController@trendingproduct')->name('trendingproductview');
//singleitempick
Route::get('/product', 'GuestController@singleitem')->name('singleitempick');
//subcategory
Route::get('/category', 'GuestController@subcategories')->name('subcategory');
// /category
Route::get('/categories', 'GuestController@cate_gory')->name('category');
//brands
Route::get('/brands', 'GuestController@bra_nds')->name('brands');
//getloginusercapping
Route::get('/customer/{id}/account', 'GuestLoginController@loginform')->name('getloginusercapping');

Route::get('/customer/account', 'GuestLoginController@showloginform')->name('show_loginform');
//customer_login
Route::post('customer/acc', 'GuestLoginController@login')->name('customer_login');
Route::get('/customer-logout', 'GuestLoginController@logout')->name('customer_logout');
//customerlogin
Route::get('/customer-login', 'GuestLoginController@loginform')->name('customerlogin');
//customer_register
Route::get('/customer-register', 'GuestLoginController@registerform')->name('form_register');
Route::post('customer-register', 'GuestLoginController@saveregisteruser')->name('customer_register');

//customer_activateacc
Route::get('customer-activate-acc', 'GuestController@index')->name('customeractivateacchome');
Route::post('customer-activate-acc', 'GuestLoginController@customeractivateacc')->name('customer_activateacc');

//customer/acc
Route::get('customer/acc', 'GuestCustomerHomeController@customerhome')->name('customer_home');

//addproducttocart
Route::get('addproduct-tocart', 'GuestCustomerHomeController@addproduct_tocart')->name('addproducttocart');

Route::get('viewcart', 'GuestCustomerHomeController@view_cart')->name('cartview');
Route::get('view-cart', 'GuestCustomerHomeController@vi_ew_cart')->name('viewcart');
Route::get('remove', 'GuestCustomerHomeController@removeItem')->name('remove');
Route::get('check-out', 'GuestCustomerHomeController@proceedto_checkout')->name('proceedtocheckout');
Route::post('check-out', 'GuestCustomerHomeController@confirmorder')->name('confirm_order');


//admin login routes
Route::get('/adminlogin',  'Admin\LoginController@showLoginForm')->name('admlogin');
Route::post('/adminlogin', 'Admin\LoginController@login')->name('admin_login');
Route::get('/logout', ['as' => 'admin_logout', 'uses' => 'Admin\LoginController@logout']);


Route::get('/passwordreset', ['as' => 'password_reset', 'uses' => 'Admin\LoginController@showresetpassword']);
Route::post('/resetpassword', 'Admin\LoginController@resetpass')->name('submit_password_reset');
Route::get('/newpassword/{email}/{token}', 'Admin\LoginController@newpassworddd')->name('mail_resetpassword');
Route::post('/newpassword', 'Admin\LoginController@updatepassword')->name('submit_pass_reset');


Route::prefix('admin')->group(function (){

    Route::get('/home', 'AdminController@index')->name('admin.home');
    //SETTINGS
    Route::get('/sms-settings', 'Admin\SMSController@smssettings')->name('sms_settings');
    Route::post('/sms-settings', 'Admin\SMSController@usersubmitsmssettings')->name('usersubmit_smssettings');

    Route::get('/email-settings', 'Admin\SMSController@emailsettings')->name('email_settings');
    Route::post('/email-settings', 'Admin\SMSController@usersubmitemailsettings')->name('usersubmit_emailsettings');

    //categorysettings
    Route::get('/category-settings', 'Admin\Categorycontroller@category_settings')->name('categorysettings');
    Route::post('/category-settings', 'Admin\Categorycontroller@savecategory_settings')->name('submit_category');
    Route::get('/sub-category-settings', 'Admin\Categorycontroller@subcategory_settings')->name('subcategorysettings');
    Route::post('/sub-category-settings', 'Admin\Categorycontroller@savesubcategory_settings')->name('submit_subcategory');
    Route::get('/category-priority', 'Admin\Categorycontroller@categoryupdatedpriority')->name('categoryupdated_priority');
    Route::get('/sub-category-priority', 'Admin\Categorycontroller@subcategoryupdatedpriority')->name('subcategoryupdated_priority');
    

    Route::get('/edit-category', 'Admin\Categorycontroller@editcategory_settings')->name('editcategory');
    Route::post('/edit-category', 'Admin\Categorycontroller@saveeditedcategory_settings')->name('submit_updatedcategory');
    
    Route::get('/delete-category', 'Admin\Categorycontroller@deletecategory_settings')->name('deletecategory');
    Route::get('/edit-sub-category', 'Admin\Categorycontroller@editesubcategory_settings')->name('editsubcategory');
    Route::post('/edit-sub-category', 'Admin\Categorycontroller@saveeditesubcategory_settings')->name('submit_updatedsubcategory');
    Route::get('/delete-sub-category', 'Admin\Categorycontroller@deletesubcategory_settings')->name('deletesubcategory');
    
    
    //companyprofile
    Route::get('/company-profile', 'Admin\Categorycontroller@company_profile')->name('companyprofile');
    Route::post('/company-profile', 'Admin\Categorycontroller@savecompany_profile')->name('submit_companysettings');

    //user_settings
    Route::get('/user-settings', 'Admin\Usercontroller@usersettings')->name('user_settings');
    Route::get('/new-user', 'Admin\Usercontroller@usernew')->name('user_new');
    Route::post('/new-user', 'Admin\Usercontroller@saveusernew')->name('submit_newuser');
    //edituser
    Route::get('/edit-user', 'Admin\Usercontroller@edit_newuser')->name('edituser');
    Route::post('/edit-user', 'Admin\Usercontroller@saveedit_newuser')->name('submit_updateduser');
    Route::get('/delete-user', 'Admin\Usercontroller@delete_newuser')->name('deleteuser');

    //all_vendors
    Route::get('/all-vendor', 'Admin\Vendorcontroller@allvendors')->name('all_vendors');
    Route::get('/new-vendor', 'Admin\Vendorcontroller@newallvendors')->name('new_vendors');
    Route::post('/new-vendor', 'Admin\Vendorcontroller@savenewallvendors')->name('submit_newvendor');
    Route::get('/edit-vendor', 'Admin\Vendorcontroller@editallvendors')->name('editvendor');
    Route::get('/delete-vendor', 'Admin\Vendorcontroller@deleteallvendors')->name('deletevendor');
    Route::get('/update-priority', 'Admin\Vendorcontroller@update_priority')->name('saveupdated_priority');
    
    //suspendvendor
    Route::get('/suspend-vendor', 'Admin\Vendorcontroller@suspendvendors')->name('suspendvendor');
    Route::get('/approve-vendor', 'Admin\Vendorcontroller@approvevendors')->name('approvevendor');

    // transactions_vendors
    Route::get('/transactions', 'Admin\Productcontroller@transactionsvendors')->name('transactions_vendors');
    Route::get('/vendor-products', 'Admin\Productcontroller@vendorproduct')->name('viewvendorproducts');
    Route::get('/edit-vendor-products', 'Admin\Productcontroller@editvendorproduct')->name('admineditproduct');
    Route::post('/edit-vendor-products', 'Admin\Productcontroller@saveeditedvendorproduct')->name('adminvendorupdate_product');
    Route::get('/get-vendor-product-details', 'Admin\Productcontroller@get_subcategory')->name('admingetsubcategory');
    Route::get('/delete-vendor-product', 'Admin\Productcontroller@admin_deleteproduct')->name('admindeleteproduct');

    Route::get('/login-vendor', 'Admin\VendorLoginController@vendor_login')->name('vend_or_login');

    //askedquestions
    Route::get('/questions', 'Admin\QuestionsController@allquestions')->name('askedquestions');
    Route::get('/reply-question', 'Admin\QuestionsController@reply_questions')->name('replyquestion');
    Route::post('/reply-question', 'Admin\QuestionsController@savereply_questions')->name('submitreplytoemailbody');

    //products_vendor
    Route::get('/all-products', 'Admin\ProductFourController@allproducts')->name('products_vendor');
    Route::get('/new-all-products', 'Admin\ProductFourController@newallproducts')->name('newproducts_vendor');
    Route::post('/new-all-products', 'Admin\ProductFourController@save4payproducts')->name('admin4payupdate_product');
    //4payadmineditproduct
    Route::get('/edit-4pay-product', 'Admin\ProductFourController@editallproducts')->name('4payadmineditproduct');
    Route::get('/4pay-delete-product', 'Admin\ProductFourController@delete4pay_product')->name('admin4paydeleteproduct');
    //saveupdated_pricecost
    Route::get('/4pay-update-cost', 'Admin\ProductFourController@saveupdatedpricecost')->name('saveupdated_pricecost');
    //newslides_vendor
    Route::get('/slides-images', 'Admin\ProductFourController@slides_images')->name('newslides_vendor');
    Route::post('/slides-images', 'Admin\ProductFourController@saveslides_images')->name('admin4slides_images');
    Route::get('/edit-slides-images', 'Admin\ProductFourController@editslides_images')->name('admineditslideproduct');
    Route::get('/delete-slides-images', 'Admin\ProductFourController@deleteslides_images')->name('admindeleteslideproduct');

    //capping_settings
    Route::get('/capping-systems', 'Admin\SMSController@cappingsettings')->name('capping_settings');
    Route::post('/capping-systems', 'Admin\SMSController@savecappingsettings')->name('adminsavecap');
    //admineditcapping
    Route::get('/edit-capping-systems', 'Admin\SMSController@editcappingsettings')->name('admineditcapping');
    Route::get('/delete-capping-systems', 'Admin\SMSController@deletecapping_record')->name('deletecappingrecord');
    //admincustomer
    Route::get('/customers', 'CustomerController@showcustomer')->name('admincustomer');
    //adminallcartorder
    Route::get('/all-order', 'CustomerController@allcartorder')->name('adminallcartorder');
    //adminapprovedorder
    Route::get('/approved-order', 'CustomerController@allapprovedorder')->name('adminapprovedorder');
    //export to pdf
    Route::get('/all-order/export', 'Admin\AdminReportController@allOrder')->name('admin.all-order.export');
    //approved orders
    Route::get('/approved-orders/export', 'Admin\AdminReportController@approvedOrders')->name('admin.approved-orders.export');
    //customers
    Route::get('/customers/export', 'Admin\AdminReportController@customers')->name('admin.customers.export');
    

});

Route::get('/vendorlogin',  'Vendor\VendorLoginController@loginform')->name('vendorlogin');
Route::post('/vendorlogin', 'Vendor\VendorLoginController@login')->name('submit_vendor_login');
Route::get('/vendorlogout',  'Vendor\VendorLoginController@logout')->name('vendorlogout');

Route::get('/vendor-register',  'Vendor\VendorLoginController@registerform')->name('vendorregister');
Route::post('/vendor-register', 'Vendor\VendorLoginController@save_vendor_register')->name('submit_vendor_register');;

Route::get('/vendor-activate-acc',  'Vendor\VendorLoginController@activate_vendor_acc')->name('show_activate_vendor_acc');
Route::post('/vendor-activate-acc',  'Vendor\VendorLoginController@submitactivate_vendor_acc')->name('submit_vendor_activation');

Route::get('/vendor-reset-acc',  'Vendor\VendorLoginController@reset_vendor_acc')->name('show_reset_vendor_acc');
Route::post('/vendor-reset-acc',  'Vendor\VendorLoginController@submitreset_vendor_acc')->name('submit_reset_activation');

Route::get('/vendor-update-acc',  'Vendor\VendorLoginController@show_update_vendor_form')->name('show_update_vendor_acc');
Route::post('/vendor-update-acc',  'Vendor\VendorLoginController@save_update_account')->name('submit_update_account');


Route::prefix('vendor')->group(function (){
    Route::get('/home', 'Vendor\VendorHomeController@index')->name('vendorhome');

    //vendorcompany_profile
    Route::get('/profile', 'Vendor\VendorProfileController@companyprofile')->name('vendorcompany_profile');
    Route::post('/profile', 'Vendor\VendorProfileController@savecompanyprofile')->name('submit_companyupdatedvendor');
    Route::get('/customer', 'Vendor\VendorProfileController@vendor_customer')->name('vendorcustomer');
    
    //vendorall_products
    Route::get('/all-products', 'Vendor\ProductController@vendor_product')->name('vendorall_products');
    Route::get('/new-product', 'Vendor\ProductController@vendor_new_product')->name('vendornew_product');
    Route::post('/new-product', 'Vendor\ProductController@savevendor_new_product')->name('vendorsubmit_newproduct');
    Route::get('/get-sub-category', 'Vendor\ProductController@get_subcategory')->name('getsubcategory');
    
    Route::get('/edit-product', 'Vendor\ProductController@vendor_edit_product')->name('editproduct');
    Route::post('/edit-product', 'Vendor\ProductController@savevendor_edit_product')->name('vendorupdate_product');
    Route::get('/delete-product', 'Vendor\ProductController@vendor_delete_product')->name('deleteproduct');

    //producttransactions
    Route::get('/transactions-product', 'Vendor\ProductController@product_transactions')->name('producttransactions');

    //allvendororderitem
    Route::get('/all-order', 'Vendor\CartOrderController@allvendororder')->name('allvendororderitem');
    //approvedvendororderitem
    Route::get('/approved-order', 'Vendor\CartOrderController@approvedvendororder')->name('approvedvendororderitem');
});


Route::get('/userregister',  'User\RegisterController@registerform')->name('userregister');
Route::post('/userregister', 'User\RegisterController@submit_registereduser')->name('submit_user_details');
Route::get('/userlogin',  'User\LoginController@loginform')->name('userlogin');
Route::post('/userlogin', 'User\LoginController@login')->name('submit_user_login');
Route::get('/userlogout',  'User\LoginController@logout')->name('userlogout');


Route::prefix('user')->group(function (){
    Route::get('/home', 'User\UserController@frontend_index')->name('userhome');

});
/*
Route::get('admin/editor', 'EditorController@index');
Route::get('admin/test', 'EditorController@test');

Route::get('adminn', 'HomeController@index2'); */
