<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use DotenvEditor;
use App\Models\PageSetting;
use App\Models\SocialMediaSetting;
use App\Models\BankDetail;
use App\Models\FooterMenu;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Page;
use App\Models\State;
use Image;
use Validator;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $setting = GeneralSetting::first();
        $state = State::all();
        return view('admin.setting.general',compact('setting','state'));
    }

    public function general_store(Request $request){
        try {

            $this->validate($request,[
                'project_name'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'copyright'=>'required',
                'address'=>'required'
            ],[
                'project_name.required'=> 'This is required.',
                'email.required'=> 'This is required.',
                'phone.required'=>'This is required.',   
                'copyright.required'=>'This is required.',   
                'address.required'=>'This is required.',   
            ]);
            
            $input = $request->all();
            $input['show_map'] = isset($input['show_map'])?1:0;
            $general = GeneralSetting::first();

            if ($request->logo) {

                $image = $request->file('logo');
                $input['logo'] = 'logo_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/general');
                $img = Image::make($image->path());
    
                if ($general->logo != '' && file_exists(public_path() . '/assets/uploads/general/' . $general->logo)) {
                    unlink(public_path() . '/assets/uploads/general/' . $general->logo);
                }
    
                $img->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['logo']);
    
            }
    
            if ($file = $request->file('favicon')) {
    
                $image = $request->file('favicon');
                $input['favicon'] = 'favicon_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/general');
                $img = Image::make($image->path());
    
                if ($general->favicon != null) {
    
                    if ($general->favicon != '' && file_exists(public_path() . '/assets/uploads/general/' . $general->favicon)) {
                        unlink(public_path() . '/assets/uploads/general/' . $general->favicon);
                    }
    
                }
    
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['favicon']);
    
            }

            $general->update($input);

            $env_keys_save = DotenvEditor::setKeys([
                'APP_NAME' => $request->project_name,
                'APP_URL' => $request->APP_URL
            ]);

            $env_keys_save->save();

            notify()->success("General Setting Has Been Updated !");
            return back();

        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
    }

    public function pages_index(){

        $get_page = PageSetting::all();
        
        $page = [];
        
        foreach($get_page as $ind => $pages){
            
            $page[$pages['page_name']][] = $pages; 
        }
        
        return view('admin.setting.pages',compact('page'));
    }

    public function pages_store(Request $request,$page_name){
        try {

            $get_page = PageSetting::where('page_name',$page_name)->first();
            $input = $request->all();

            if(empty($input['title'])){
                notify()->error("Title is required field !");
                return back();
            }

            if(isset($input['content']) && empty($input['content'])){
                notify()->error("content is required !");
                return back();
            }

            if ($image = $request->file('banner')) {

                $input['banner'] = $page_name.'_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads');
                $img = Image::make($image->path());
    
                if ($get_page->banner != null) {
    
                    if ($get_page->banner != '' && file_exists(public_path() . '/assets/uploads/' . $get_page->banner)) {
                        unlink(public_path() . '/assets/uploads/' . $get_page->banner);
                    }
    
                }

                $img->save($destinationPath . '/' . $input['banner']);
            }

            $get_page->update($input);

            notify()->success('Page Setting Updated Successfully');
            return back();

        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
    }

    public function email_setting_index(){
        $env_files = ['MAIL_FROM_NAME' => env('MAIL_FROM_NAME') , 'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS') , 'MAIL_MAILER' => env('MAIL_MAILER') , 'MAIL_HOST' => env('MAIL_HOST') , 'MAIL_PORT' => env('MAIL_PORT') , 'MAIL_USERNAME' => env('MAIL_USERNAME') , 'MAIL_PASSWORD' => env('MAIL_PASSWORD') , 'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION') ,

        ];

        return view('admin.setting.mail', compact('env_files'));
    }

    public function email_setting_store(Request $request){
        $env_keys_save =  DotenvEditor::setKeys([

            'MAIL_FROM_NAME' => $request->MAIL_FROM_NAME, 
            'MAIL_MAILER' => $request->MAIL_MAILER, 
            'MAIL_HOST' => $request->MAIL_HOST, 
            'MAIL_PORT' => $request->MAIL_PORT, 
            'MAIL_USERNAME' => $request->MAIL_USERNAME, 
            'MAIL_FROM_ADDRESS' => preg_replace('/\s+/', '', $request->MAIL_FROM_ADDRESS) , 
            'MAIL_PASSWORD' => $request->MAIL_PASSWORD, 
            'MAIL_ENCRYPTION' => $request->MAIL_ENCRYPTION

        ]);

        $env_keys_save->save();

        notify()->success('Mail settings saved !');

        return back();
    }

    public function social_setting_index(){
        $social_media = SocialMediaSetting::all();

        return view('admin.setting.social_media',compact('social_media'));
    }

    public function social_setting_store(Request $request){
        $input = $request->all();
        unset($input['_token']);
        
        foreach($input as $name => $path){
            $update = SocialMediaSetting::where('name',$name)->update([
                'path'=>$path]);
        }

        notify()->success('Social settings updated !');

        return back();

    }

    public function payment_index(){
        $bank = BankDetail::first();
        return view('admin.setting.payment',compact('bank'));
    }

    public function paypal_setting(Request $request){
        $input = $request->all();
        
        if(isset($input['paypal_check'])){
            $this->validate($request,[
                'PAYPAL_CLIENT_ID'=>'required',
                'PAYPAL_SECRET'=>'required',
                'PAYPAL_MODE'=>'required'
            ],[
                'PAYPAL_CLIENT_ID.required'=>'This field is required', 
                'PAYPAL_SECRET.required'=>'This field is required' ,
                'PAYPAL_MODE.required'=>'This field is required' ,
            ]);
        }

        $env_keys_save = DotenvEditor::setKeys([

            'PAYPAL_CLIENT_ID' => $input['PAYPAL_CLIENT_ID'], 
            'PAYPAL_SECRET' => $input['PAYPAL_SECRET'], 
            'PAYPAL_MODE' => $input['PAYPAL_MODE']
        ]);

        $env_keys_save->save();
        GeneralSetting::where('id',1)->update(['paypal_active'=> isset($input['paypal_check']) ? 1 : 0]);
        notify()->success('Paypal settings has been updated !');

        return back();
    }

    public function stripe_setting(Request $request){
        $input = $request->all();
        
        if(isset($input['strip_check'])){
            $this->validate($request,[
                'STRIPE_KEY'=>'required',
                'STRIPE_SECRET'=>'required'
            ],[
                'STRIPE_KEY.required'=>'This field is required', 
                'STRIPE_SECRET.required'=>'This field is required' 
            ]);
        }

        $env_keys_save = DotenvEditor::setKeys([

            'STRIPE_KEY' => $input['STRIPE_KEY'], 
            'STRIPE_SECRET' => $input['STRIPE_SECRET']
        ]);

        $env_keys_save->save();
        GeneralSetting::where('id',1)->update(['stripe_active'=> isset($input['strip_check']) ? 1 : 0]);
        notify()->success('Strip settings has been updated !');

        return back();
    }

    public function razorpay_setting(Request $request){
        
        $input = $request->all();
        if(isset($input['rpaycheck'])){
            $this->validate($request,[
                'RAZORPAY_KEY'=>'required',
                'RAZORPAY_SECRET'=>'required'
            ],[
                'RAZORPAY_KEY.required'=>'This field is required', 
                'RAZORPAY_SECRET.required'=>'This field is required' 
            ]);
        }
        

        $env_keys_save = DotenvEditor::setKeys([

            'RAZORPAY_KEY' => $input['RAZORPAY_KEY'], 
            'RAZORPAY_SECRET' => $input['RAZORPAY_SECRET']

        ]);

        $env_keys_save->save();

        GeneralSetting::where('id',1)->update(['razorpay_active'=> isset($input['rpaycheck']) ? 1 : 0]);
        notify()->success('Razorpay settings has been updated !');

        return back();
    }

    public function bank_details_setting(Request $request){
        $input = $request->all();

        $this->validate($request,[
            'bank_name'=>'required',
            'branch_name'=>'required',
            'ifsc'=>'required',
            'account_no'=>'required',
            'account_name'=>'required'
        ],
        [
            'bank_name.required'=>'This field is required',
            'branch_name.required'=>'This field is required',
            'ifsc.required'=>'This field is required',
            'account_no.required'=>'This field is required',
            'account_name.required'=>'This field is required',
        ]);
        
        
        $bank = BankDetail::first();
        $bank->update($input);
        $bank->save();

        notify()->success('Bank settings has been updated !');

        return back();
    }

    public function footer_menu_setting(){
        $footer_menu = FooterMenu::all();
        $cat = Category::all();
        $page = Page::all();
        
        return view('admin.setting.footer_menu',compact('footer_menu','cat','page'));
    }

    public function footer_menu_setting_db(Request $request, $id){
        try{
            $input = $request->all();
            
            Validator::extend('german_url', function($attribute, $value, $parameters)  {
                $url = str_replace(["ä","ö","ü"], ["ae", "oe", "ue"], $value);
                return filter_var($url, FILTER_VALIDATE_URL);
            });
            
            $validation = Validator::make($input,[
                'link_type' => 'required',
                'category_ids.*' => 'required_if:link_type,==,category',
                'page_ids.*' => 'required_if:link_type,==,page',
                'title.*' => 'required_if:link_type,==,url',
                'url.*' => 'required_if:link_type,==,url|german_url|nullable'
            ],[
                'link_type.required' => 'Link Type is required',
                'category_ids.*.required_if' => 'Category is required',
                'page_ids.*.required_if' => 'Page is required',
                'title.*.required_if' => 'Title is required',
                'url.*.required_if'  => 'URL is required',
                'url.*.german_url'  => 'Please enter correct URL'
            ]);

            if ($validation->fails()) {
                $validation_arr = $validation->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message = $message.' '.$value;
                }
                return back()->with('error',$message)->withInput();
            }

            $foot = FooterMenu::findOrFail($id);
            $foot->update($input);

        }catch(\Illuminate\Database\QueryException $ex){
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }

        notify()->success('Footer Menu is been successfully updated');
        return back();

    }

    public function banners_setting(){
        $banner = Banner::first();
        return view('admin.setting.banners',compact('banner'));
    }

    public function banners_setting_db(Request $request){
        try {

            $input = $request->all();
            
            $validation = Validator::make($input,[
                
                'login_banner'               => 'mimes:jpeg,png,jpg',
                'register_banner'            => 'mimes:jpeg,png,jpg',
                'forget_password_banner'     => 'mimes:jpeg,png,jpg',
                'category_banner'            => 'mimes:jpeg,png,jpg',
                'product_banner'             => 'mimes:jpeg,png,jpg',
                'cart_banner'                => 'mimes:jpeg,png,jpg',
                'wishlist_banner'            => 'mimes:jpeg,png,jpg',

            ],[
                
                'login_banner.mimes'                 => 'Field accept only jpeg,png,jpg',
                'register_banner.mimes'              => 'Field accept only jpeg,png,jpg',
                'forget_password_banner.mimes'       => 'Field accept only jpeg,png,jpg',
                'category_banner.mimes'              => 'Field accept only jpeg,png,jpg',
                'product_banner.mimes'               => 'Field accept only jpeg,png,jpg',
                'cart_banner.mimes'                  => 'Field accept only jpeg,png,jpg',
                'wishlist_banner.mimes'              => 'Field accept only jpeg,png,jpg',
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors);
            }

            $banner = Banner::first();

            if ($request->file('login_banner')) {
    
                $image = $request->file('login_banner');
                $input['login_banner'] = 'login_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->login_banner != null) {
    
                    if ($banner->login_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->login_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->login_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['login_banner']);
    
            }

            if ($request->file('register_banner')) {
    
                $image = $request->file('register_banner');
                $input['register_banner'] = 'register_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->register_banner != null) {
    
                    if ($banner->register_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->register_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->register_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['register_banner']);
    
            }

            if ($request->file('forget_password_banner')) {
    
                $image = $request->file('forget_password_banner');
                $input['forget_password_banner'] = 'forget_password_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->forget_password_banner != null) {
    
                    if ($banner->forget_password_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->forget_password_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->forget_password_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['forget_password_banner']);
    
            }

            if ($request->file('category_banner')) {
    
                $image = $request->file('category_banner');
                $input['category_banner'] = 'category_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->category_banner != null) {
    
                    if ($banner->category_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->category_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->category_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['category_banner']);
    
            }

            if ($request->file('product_banner')) {
    
                $image = $request->file('product_banner');
                $input['product_banner'] = 'product_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->product_banner != null) {
    
                    if ($banner->product_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->product_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->product_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['product_banner']);
    
            }

            if ($request->file('cart_banner')) {
    
                $image = $request->file('cart_banner');
                $input['cart_banner'] = 'cart_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->cart_banner != null) {
    
                    if ($banner->cart_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->cart_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->cart_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['cart_banner']);
    
            }

            if ($request->file('wishlist_banner')) {
    
                $image = $request->file('wishlist_banner');
                $input['wishlist_banner'] = 'wishlist_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->wishlist_banner != null) {
    
                    if ($banner->wishlist_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->wishlist_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->wishlist_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['wishlist_banner']);
    
            }

            if ($request->file('user_dasboard_banner')) {
    
                $image = $request->file('user_dasboard_banner');
                $input['user_dasboard_banner'] = 'wishlist_banner_'.uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/front/img/banner');
                $img = Image::make($image->path());
    
                if ($banner->user_dasboard_banner != null) {
    
                    if ($banner->user_dasboard_banner != '' && file_exists(public_path() . '/front/img/banner/' . $banner->user_dasboard_banner)) {
                        unlink(public_path() . '/front/img/banner/' . $banner->user_dasboard_banner);
                    }
    
                }
    
                $img->resize(1920, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $input['user_dasboard_banner']);
    
            }

            $banner->update($input);

        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }

        notify()->success('Banner is been successfully updated');
        return back();
    }
    
}
