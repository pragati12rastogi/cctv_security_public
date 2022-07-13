<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\Country;
use App\Models\State;
use App\Models\BankDetail;
use App\Models\Shipping;

use Session;
use DB;
use Auth;
use Mail;


class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index(){

        $country = Country::where('status',1)->get();
        $shipping = ShippingAddress::where('user_id',Auth::id())->first();
        $cart_items = Cart::where('user_id',Auth::id())->get()->toArray();
        $bank_detail = BankDetail::first();

        $error = '';
        foreach($cart_items as $cart_index => $cart_prod){

            $get_prod = Product::where('id',$cart_prod['product_id'])->first();
            
            $check_left_qty = $get_prod['qty'] - $cart_prod['qty'];

            if($check_left_qty >= 0){
                $cart_update_price = Cart::find($cart_prod['id']);
                
                $cart_update_price->update([
                    'old_amount'=>$get_prod['old_price'],
                    'actual_price'=>$get_prod['price'],
                    'tax' => $get_prod['tax']
                ]);


            }else{
                $error .= $get_prod['name'].' quantity is not sufficient to place your order. (Left Stock : '.$get_prod['qty'].') ';
            }

        }

        if(empty($error)){
            $all_cart_data = Cart::where('user_id',Auth::id())->get();
            return view('front.checkout',compact('all_cart_data','country','shipping','bank_detail'));
        }else{
            $error_message = 'Please update your cart to proceed. '.$error;
            return redirect('user/add-to-cart')->with('error',$error_message);
        }
        
    }


    public function get_state_by_country($country_id){
        $get_state = State::where('country_id',$country_id)->get();

        $shipping = ShippingAddress::where('user_id',Auth::id())->first();
        
        $state_option = "<option value=''>Select State</option>";
        
        foreach($get_state as $st_ind => $state){
            
            $old_selected ='';
            if(!empty($shipping)){
                if($shipping['state_id'] == $state->id){
                    $old_selected = 'selected';
                }
            }

            $state_option .= '<option value="'.$state->id.'" '.$old_selected.' >'.ucwords(strtolower($state->state_name)).'</option>';
        }

        echo json_encode($state_option);
    }

    public function add_billing_address(Request $request){
        $input = $request->all();
        unset($input['_token']);
        session()->put('billing_address',$input);
        
        $cart_items = Cart::where('user_id',Auth::id())->get()->toArray();

        $error = '';
        foreach($cart_items as $cart_index => $cart_prod){

            $get_prod = Product::where('id',$cart_prod['product_id'])->first();
            
            $check_left_qty = $get_prod['qty'] - $cart_prod['qty'];

            if($check_left_qty >= 0){
                $cart_update_price = Cart::find($cart_prod['id']);
                
                $cart_update_price->update([
                    'old_amount'=>$get_prod['old_price'],
                    'actual_price'=>$get_prod['price'],
                    'tax' => $get_prod['tax']
                ]);


            }else{
                $error = $get_prod['name'].' quantity is insufficient to place your order. (Left Stock : '.$get_prod['qty'].') ';
            }

        }

        if(empty($error)){
            notify()->success('Billing Address Updated');
            return back();
            
        }else{
            $error_message = 'Please update your cart to proceed. '.$error;
            return back()->with('error',$error_message);
        }
        
    }

    
}
