<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Http\Controllers\Front\PlaceOrderController;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    
    public function payment(Request $request)
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

        $data = [];
        

        $error = '';
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

        if(env('PAYPAL_CURRENCY') == 'INR' && env('PAYPAL_MODE') == 'sandbox'){

            notify()->error('INR is not supported in paypal sandbox mode try with other currency !','Currency not supported !');
            return back();

        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();      // To use express checkout(used by default).
        
        
        $order_id = uniqid();
        
        $data['intent'] = "CAPTURE";
        
        $data['description'] = "Payment For Order #ORD".$order_id;
        $data['application_context']['return_url'] = route('paypal.success');
        $data['application_context']['cancel_url'] = route('paypal.cancel');
        $data['purchase_units'][0]['amount']['value'] = $payout;
        $data['purchase_units'][0]['amount']['currency_code'] = env('PAYPAL_CURRENCY');
        
        $response = $provider->createOrder($data);
        

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return back()->with('error', 'Something went wrong.');

        } else {
            return back()->with('error', $response['message'] ?? 'Something went wrong.');
        }

    }

    public function cancel(Request $request){
        return redirect()
            ->route('checkout.step1')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function success(Request $request)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $order_id = uniqid();
            $transactions = $response['id'];
            
            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($transactions,'Paypal',$order_id,$payment_status);

            /*End*/

        } else {
            notify()->error("Payment Failed !");
            
            return redirect(route('order.review'));
        }

    }

}
