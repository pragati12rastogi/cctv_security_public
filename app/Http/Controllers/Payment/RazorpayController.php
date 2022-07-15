<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Exception;
use Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Http\Controllers\Front\PlaceOrderController;

class RazorpayController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        
        
        if(empty($input['shipping_id'])){
            return back()->with('error','Please fill Shipping details');
        }
        if(empty($input['billing_data'])){
            return back()->with('error','Please fill Billing details');
        }

        $payout = $request->actualtotal;
        $payout = round($payout, 2);
        
        $cart_table = Cart::where('user_id',Auth::id())->get();
        
        $cart_total = 0;

        $error = '';

        $order_id = uniqid();
        foreach ($cart_table as $key => $cart) {
            
            $get_prod = Product::where('id',$cart->product_id)->first();
            
            $check_left_qty = $get_prod['qty'] - $cart->qty;

            if($check_left_qty < 0){

                $error .= $get_prod['name'].' quantity is not sufficient to place your order. (Left Stock : '.$get_prod['qty'].') ';
            }

            $cart_total = $cart_total + ($cart->actual_price * $cart->qty)  + $cart->shipping;
        }

        if(!empty($error)){
            $error_message = 'Please update your cart to proceed. '.$error;
            return back()->with('error',$error_message);
        }

        $cart_total = sprintf("%.2f",$cart_total);

        if ($payout != $cart_total) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('checkout.step1'));

        }
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                
                $txn_id = $payment->id;

                $payment_status = 1;

                $checkout = new PlaceOrderController;

                return $checkout->placeorder($txn_id,'Razorpay',session()->get('order_id'),$payment_status);
                
            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
          
        Session::put('success', 'Payment successful');
        return redirect()->back();
    }
}
