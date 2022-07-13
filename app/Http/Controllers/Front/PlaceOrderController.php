<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\GeneralSetting;
use Auth;
use Session;
use Mail;
use DB;
use Image;

class PlaceOrderController extends Controller
{
    public function placeorder($txn_id, $payment_method, $order_id, $payment_status,$file = NULL)
    {
        
        $user = Auth::id();

        $cart_table = Cart::where('user_id', $user)->get();
        
        if(count($cart_table)<1){
            notify()->error('Fill your cart, before proceeding checkout','Empty Cart Error');
            return redirect()->route('checkout.step1');
        }

        $order_total = 0;
        $shipping_total = 0;
        
        foreach ($cart_table as $key => $cart) {
            $order_total = $order_total + ($cart->actual_price * $cart->qty);
            $shipping_total += $cart->shipping;
        }

        $address = ShippingAddress::where('user_id',$user)->first();

        $order_total = round($order_total,2);

        $neworder = new Order();
        $neworder->order_id = '#ORD'.$order_id;
        $neworder->user_id = $user;
        $neworder->shipping_address = $address;
        $neworder->billing_address = Session::get('billing_address');
        $neworder->payment_method = $payment_method;
        $neworder->payment_receive = $payment_status;
        $neworder->transaction_id = $txn_id;
        $neworder->order_total = $order_total;
        $neworder->shipping_total = $shipping_total;

        $neworder->manual_payment = $file ? '1' : '0';
        
        if (!is_dir(public_path() . '/assets/uploads/purchase_proof')) {
            mkdir(public_path() . '/assets/uploads/purchase_proof');
        }

        if($file){
            
                $image = $file;
                $img = Image::make($image->path());
                $proof = 'proof_' . $order_id . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/purchase_proof');
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
    
                $img->save($destinationPath . '/' . $proof);
                $neworder->purchase_proof = $proof;
            
        }
        $neworder->special_note = Session::get('billing_address')['special_note'];
        $neworder->save();

        $admin_data = GeneralSetting::first();

        foreach ($cart_table as $key => $cart2) {

            
            $total_amount = $cart2->actual_price * $cart2->qty;
            $single_prod_tax = ($cart2->actual_price * $cart2->tax)/100;
            $total_tax = ($total_amount * $cart2->tax)/100;
            
            $igst = 0;
            $scgst = 0;
            

            if($admin_data['state_id'] != $address['state_id']){
                // igst
                $igst = $total_tax;
            }else{
                $scgst = round($total_tax/2,2);
            }

            $newInvoice = new Invoice();
            $newInvoice->order_id        = $neworder->id;
            $newInvoice->user_id         = $user;
            $newInvoice->product_id      = $cart2->product_id;
            $newInvoice->qty             = $cart2->qty;
            $newInvoice->old_amount      = $cart2->old_amount;
            $newInvoice->actual_amount   = $cart2->actual_price;
            $newInvoice->total_amount    = $total_amount;
            $newInvoice->tax_amount      = $single_prod_tax;
            $newInvoice->igst            = $igst;
            $newInvoice->scgst           = $scgst;
            $newInvoice->shipping_rate   = $cart2->shipping;
            $newInvoice->order_product_status  = 'pending';

            $newInvoice->save();

            $product = Product::find($cart2->product_id);
            $product->decrement('qty',$cart2->qty);
        }

        Session::forget('billing_address');
        Cart::where('user_id', auth()->id())->delete();

        DB::commit();

        
        // mail to admin
        if(!empty($admin_data->email)){
            Mail::send('emails.ordermail', ['neworder'=>$neworder], function($message) use($admin_data,$neworder)
            {
                $message->to($admin_data->email)->subject('Order '.$neworder->order_id.' Placed!');
            });
        }


        // email to customer
        
        if(!empty($address)){
            Mail::send('emails.ordermail', ['neworder'=>$neworder], function($message) use($address,$neworder)
            {
                $message->to($address->email)->subject('Order '.$neworder->order_id.' Placed Successfully !');
            });
        }
        
        $status = "Order $neworder->order_id placed successfully !";
        notify()->success("$status");
        return redirect()->route('order.done', ['orderid' => $neworder->order_id]);
    }


    public function order_complete(){
        return view('front/order_thankyou');
    }
}
