<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Stripe;
use Auth;
use Exception;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Http\Controllers\Front\PlaceOrderController;

class StripeController extends Controller
{
    public function stripePost(Request $request){

        try {
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


                $cart_total = $cart_total + ($cart->actual_price * $cart->qty) + $cart->shipping;
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
            
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            if (!isset($request->stripeToken)){
                throw new Exception("The Stripe Token was not generated correctly");
            }

            $response = Stripe\Charge::create ([
                    "amount" => $payout * 100,
                    "currency" => "USD",
                    "source" => $request->stripeToken,
                    'description' => "Payment For Order #ORD$order_id",
            ]);
            $transaction_id = $response->id; // Its unique charge ID
            $transaction_status = $response->status;
            if($transaction_status == "succeeded"){
                
                $txn_id = $transaction_id;

                $payment_status = 1;

                $checkout = new PlaceOrderController;

                return $checkout->placeorder($txn_id,'Stripe',$order_id,$payment_status);

            }else{
                notify()->error('Payment Failed');
                return back();
            }
            Session::flash('success', 'Payment successful!');
            
            return back();
        }
        catch (Exception $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }

    }
}
