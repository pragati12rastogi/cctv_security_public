<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferSection;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariantsDetail;
use App\Models\PageSetting;
use App\Models\Page;
use App\Models\GeneralSetting;
use App\Models\Faq;
use App\Models\Subscription;
use App\Models\Review;
use Mail;
use Validator;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = Slider::all();
        $services = Service::get()->toArray();
        $offer_sections = OfferSection::with('category')->get()->toArray();
        $offer_chunk = array_chunk($offer_sections,5);
        
        $category = Category::where('status',1)->get();
        $service_chunk = array_chunk($services,4);
        return view('front.index',compact('sliders','offer_sections','offer_chunk','category','service_chunk'));
    }


    public function category_wise_product($id){
        $category = Category::where('id',$id)->where('status',1)
        ->with(['subcategory'=>function($q){
            return $q->with(['products'=>function($q1){
                return $q1->with(['photos'=>function($q2){
                        return $q2->where('default_image',1);
                    }])->where('status',1)->whereHas('photos');
            }])->where('status',1);
        }])->firstOrFail();
        
        $cat_id = $id;

        return view('front.category',compact('category','cat_id'));
    }

    public function subcategory_wise_product($id,Request $request){
        $subcat = SubCategory::where('id',$id)
        ->with(['category'=>function($q){
            return $q->where('status',1);
        }])->where('status',1)->firstOrFail();

        

        $products = Product::where('status',1)
        ->where('sub_category_id',$id)
        ->with(['photos'=>function($q){
            return $q->where('default_image',1);
        }])->whereHas('photos');

        $filters_req = [];
        
        if(isset($request['filter'])){
            $filters_req = $request['filter'];
            $attr_key = array_keys($filters_req);
            $attr_value = array_values($filters_req);
            
            $filter_attr_value = [];
            
            foreach($filters_req as $attr_key => $attr_value){
                if(is_array($attr_value)){
                    $var_pro = ProductVariantsDetail::select('product_id')->where('attribute_id',$attr_key)->whereIn('attribute_value_id',$attr_value)->groupBy('product_id')->get()->toArray();
                }else{
                    $var_pro = ProductVariantsDetail::where('attribute_id',$attr_key)->where('attribute_value_id',$attr_value)->get()->toArray();
                }

                if(empty($filter_attr_value)){

                    $filter_attr_value = array_column($var_pro, 'product_id');
                }else{
                    $var_pro = array_column($var_pro, 'product_id');
                    
                    $filter_attr_value = array_intersect($filter_attr_value,$var_pro);
                }
            }

            $products->whereIn('id',$filter_attr_value);
        }

        $products = $products->paginate(20);
        
        $subcat_id = $id;
        $cat_id = $subcat['category']['id'];
        $filter_attr = ProductAttribute::whereRaw('category_ids LIKE "%'.$cat_id.'%"')
        ->with('attribute_value')
        ->get()->toArray();
        // dd($filters_req);
        return view('front.subcategory',compact('subcat','subcat_id','cat_id','filter_attr','products','filters_req'));
    }
    
    public function childcategory_wise_product($id,Request $request){
        $childcat = ChildCategory::where('id',$id)
        ->with(['category'=>function($q){
            return $q->where('status',1);
        }])
        ->with(['subcategory'=>function($q){
            return $q->where('status',1);
        }])->where('status',1)->firstOrFail();

        
        $products = Product::where('status',1)
        ->where('child_category_id',$id)
        ->with(['photos'=>function($q){
            return $q->where('default_image',1);
        }])->whereHas('photos');

        $filters_req = [];
        
        
        if(isset($request['filter'])){
            $filters_req = $request['filter'];
            $attr_key = array_keys($filters_req);
            $attr_value = array_values($filters_req);
            
            $filter_attr_value = [];
            
            foreach($filters_req as $attr_key => $attr_value){
                if(is_array($attr_value)){
                    $var_pro = ProductVariantsDetail::select('product_id')->where('attribute_id',$attr_key)->whereIn('attribute_value_id',$attr_value)->groupBy('product_id')->get()->toArray();
                }else{
                    $var_pro = ProductVariantsDetail::where('attribute_id',$attr_key)->where('attribute_value_id',$attr_value)->get()->toArray();
                }

                if(empty($filter_attr_value)){

                    $filter_attr_value = array_column($var_pro, 'product_id');
                }else{
                    $var_pro = array_column($var_pro, 'product_id');
                    
                    $filter_attr_value = array_intersect($filter_attr_value,$var_pro);
                }
            }

            $products->whereIn('id',$filter_attr_value);
        }

        $products = $products->paginate(20);
        
        $childcat_id = $id;
        $cat_id = $childcat['category']['id'];
        $sub_id = $childcat['subcategory']['id'];
        $filter_attr = ProductAttribute::whereRaw('category_ids LIKE "%'.$cat_id.'%"')
        ->with('attribute_value')
        ->get()->toArray();
        
        return view('front.childcategory',compact('childcat','childcat_id','cat_id','sub_id','filter_attr','products','filters_req'));
    }

    public function get_product_page($id){
        $products = Product::where('status',1)->where('id',$id)->whereHas('photos')->firstOrFail();
        $related_prod = Product::where('status',1)->whereHas('photos')->where('sub_category_id',$products['sub_category_id'])
        ->with('photos',function($q){
            $q->where('default_image',1);
        })->get()->toArray();

        $reviews = Review::where('product_id',$id)->get();

        return view('front.product_details',compact('products','related_prod','reviews'));
    }

    public function get_pages_byslug($slug){
        $page = Page::where(['slug'=>$slug,'status'=>1])->firstOrFail();
        return view('front.page',compact('page'));
    }


    public function contactus_page(){
        $contact = PageSetting::where('page_name','contact_us')->first();
        return view('front.contact_us',compact('contact'));
    }

    public function getConnect(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'message' => 'required|max:10000',
            'subject' => 'required'
        ]);
        
        try{

            $mail = GeneralSetting::first();
            
            Mail::send('emails.contactus', ['content'=>$request], function($message) use($request,$mail)
            {
                $message->to($mail->email)->from($request->email)->subject('New message from '.$request->name);
            });

            
            notify()->success('Message sent successfully !');
            return back();

        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }

    }

    public function aboutus(){
        $about = PageSetting::where('page_name','about_us')->first();
        return view('front.about_us',compact('about'));
    }

    public function tnc_page(){
        $tnc = PageSetting::where('page_name','term_and_condition')->first();
        return view('front.tnc',compact('tnc'));
    }

    public function faq_page(){
        $faq_meta = PageSetting::where('page_name','faq')->first();
        $faqs = Faq::where('status',1)->get();
        return view('front.faq',compact('faq_meta','faqs'));
    }

    public function subscription(Request $request){
        $validate = Validator::make($request->all(),[
            'email'=>'required|email'
        ],[
            'email.required'=>'Email is required'
        ]);

        if ($validate->fails()) {
            $validation_arr = $validate->errors();
            $message = '';
            foreach ($validation_arr->all() as $key => $value) {
                $message = $message.' '.$value;
            }
            notify()->error($message);
            return back();
        }
        $input = $request->all();
        $check = Subscription::where('email',$input['email'])->first();
        if(!empty($check)){
            $check->update([
                'active'=>1
            ]);
        }else{
            $subscription = Subscription::insertGetId([
                'email'=>$input['email'],
                'active'=>1
            ]);
        }
        notify()->success("Thank you for subscribing, We will connect soon.");
        return back();
        
    }

    public function save_user_rating(Request $request){
        $input = $request->all();
        
        if(empty($input['rating'])){
            notify()->error('Rating is mendatory for review');
            return back();
        }

        $rev = Review::create($input);

        if(!empty($rev->id)){
            notify()->success('Rating done successfully');
            return back();
        }else{
            notify()->error('Some error occur try again');
            return back();
        }
    }

    public function update_user_rating($id,Request $request){
        $input = $request->all();
        
        if(empty($input['rating'])){
            notify()->error('Rating is mendatory for review');
            return back();
        }

        $rev = Review::find($id);
        $rev->update($input);

        
        notify()->success('Rating updated successfully');
        return back();
        
    }

    public function search_products(Request $request){
        $search = $request->find;
        
        $products = Product::where('status',1)
        ->whereRaw('name LIKE "%'.$search.'%"')
        ->with(['photos'=>function($q){
            return $q->where('default_image',1);
        }])->whereHas('photos');

        $products = $products->paginate(20);
        
        return view('front.searchproduct',compact('products','search'));
    
    }
}
