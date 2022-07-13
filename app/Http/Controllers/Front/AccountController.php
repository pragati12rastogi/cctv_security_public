<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\ShippingAddress;
use App\Models\Country;
use App\Models\User;
use App\Models\State;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\UserBank;
use App\Models\CancelledInvoice;
use App\Models\ReturnProduct;
use App\Models\Product;
use Mail;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function dashboard(){
        $user = Auth::user();
        
        return view('front.dashboard',compact('user'));
    }

    public function user_profile_update(Request $request){
        $input = $request->all();
        $validate = Validator::make($input,[
            'name'  => 'required',
            'phone' => 'required'
        ],[
            'name.required' => 'This is required',
            'phone.required' => 'This is required'
        ]);

        if($validate->failS()){
            $errors = $validation->errors();
            return back()->withErrors($errors);
        }

        $upd = User::findOrFail(Auth::id());
        $upd->update($input);

        notify()->success(' Personal Information updated successfully');
        return back();
    }


    public function user_password_update(Request $request){
        try {
            $user_id = Auth::id();
            $this->validate($request,[
                'current_password'=>'required',
                'new_password'=>'required|min:8',
                'confirm_password'=>'required|same:new_password'
            ],[
                'current_password.required'=> 'This is required.',
                'new_password.required'=> 'This is required.' ,  
                'new_password.min'=> 'Minimum length is 8 character.' ,  
                'confirm_password.required'=> 'This is required.',
                'confirm_password.same'=> 'Password not matched.'   
            ]);

            DB::beginTransaction();
            
            $current_pass = $request->input('current_password');
            $new_pass = $request->input('new_password');
            $confirm_pass = $request->input('confirm_password');

            $user = User::where('id',$user_id)->first();
            if(!Hash::check($current_pass,$user['password'])){
                DB::rollback();
                return back()->with('error','The specified password does not match with your old password');
            }else{
                
                $update = User::where('id',$user_id)->update([
                    'password'=>Hash::make($confirm_pass),
                ]);
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
        if($update){
            DB::commit();
            notify()->success('Password Updated Successfully');
            return back();
        }
    }

    public function my_shipping_add(){
        $shipping = ShippingAddress::where('user_id',Auth::id())->first();
        $country = Country::all();
        $states = State::all();
        
        return view('front.shipping',compact('shipping','country','states'));
    }

    public function save_shipping_address(Request $request ){
        try{
            $input = $request->all();
            $input['user_id'] = Auth::id();
            if(!empty($input['shipping_address_id'])){
                // update
                $ship = ShippingAddress::find($input['shipping_address_id']);
                $ship->update($input);
            }else{
                // insert
                $ship = ShippingAddress::create($input);
            }
            
            notify()->success('Shipping Details Updated');
            return back();
        }catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();
            notify()->error('Some error occurred '.$ex->getMessage());
            return back();
        }
    }

    public function my_bank_account(){
        $bank = UserBank::where('user_id',Auth::id())->first();
        return view('front.userbank',compact('bank'));
    }

    public function save_bank_account(Request $request){
        try{
            $input = $request->all();
            $validate = Validator::make($input,[
                'bankname'  => 'required',
                'account_no' => 'required',
                'account_name' => 'required',
                'ifsc' => 'required'
            ],[
                'bankname.required' => 'This is required',
                'account_no.required' => 'This is required',
                'ifsc.required' => 'This is required',
                'account_name.required' => 'This is required'
            ]);

            if($validate->failS()){
                $errors = $validation->errors();
                return back()->withErrors($errors);
            }

            $input['user_id'] = Auth::id();
            
            if(!empty($input['bank_id'])){
                // update
                $bank_id = Crypt::decrypt($input['bank_id']);
                $ship = UserBank::find($bank_id);
                $ship->update($input);
            }else{
                // insert
                $ship = UserBank::create($input);
            }
            
            notify()->success('Bank Details Updated Successfully');
            return back();

        }catch(\Illuminate\Database\QueryException $ex){
            
            notify()->error('Some error occurred '.$ex->getMessage());
            return back();
        }
    }

    public function my_orders(){
        $orders = Order::with(['user','invoices'])->where('user_id',Auth::id())->orderBy('id','Desc')->paginate(5);
        return view('front.order.all_order',compact('orders'));
    }

    public function view_orders($order_id){
        $order_id = Crypt::decrypt($order_id);
        $order = Order::with(['user','invoices'])->findOrFail($order_id);
        return view('front.order.view_order',compact('order'));
    }

    public function cancel_order_item($id,Request $request){
        $inv_id = Crypt::decrypt($id);
        $status = 0;
        $findorder = Invoice::findOrFail($inv_id);
        DB::beginTransaction();
        if(!empty($request->comment)){

            
            if (empty($findorder->user->bank)) {
                notify()->error('Please add bank details first !');
                return back();
            }else{

                $cancelorderlog = new CancelledInvoice();

                if ($findorder->order->payment_method == 'COD') {
                    $cancelorderlog->pay_method = 'COD';
                    $cancelorderlog->is_refunded = 1;
                    $cancelorderlog->transaction_id = 'CODCAN' . str::random(10);
                }else{
                    
                    $cancelorderlog->pay_method = 'bank';
                    $cancelorderlog->is_refunded = 0;
                    $cancelorderlog->transaction_id = 'TXNBNK' . str::random(10);
                }

                $cancelorderlog->order_id = $findorder->order->id;
                $cancelorderlog->invoice_id = $inv_id;
                $cancelorderlog->user_id = $findorder->user_id;
                $cancelorderlog->comment = $request->comment;
                
                $cancelorderlog->amount = $findorder->total_amount + $findorder->shipping_rate;
                $cancelorderlog->bank_details = null;
                
                $cancelorderlog->txn_fee = null;
                $cancelorderlog->save();

                $status = 1; 


                if ($status == 1) {

                    if ($findorder->order->payment_method == 'COD') {
                        Invoice::where('id', $inv_id)->update(['order_product_status' => 'cancelled']);
                    }else{
                        Invoice::where('id',$inv_id)->update(['order_product_status' => 'Refund Pending']);
                    }
                    
                    
                    $prod = Product::findorfail($findorder->product_id);
                    /*Adding Stock Back*/
                    $prod->increment('qty',$findorder->qty);

                    $status = ucfirst('cancelled');
                    /*Returned*/

                    /*Send Mail to User*/
                    $e = $findorder->order->shipping_address['email'];

                    if (isset($e)) {
                        try {

                            Mail::send('emails.orderstatus', ["inv"=> $findorder,"status"=> $status], function($message) use($e, $findorder, $status)
                            {
                                $message->to($e)->subject('Order '.$inv->order->order_id.' Product '.$inv->product->name.' status');
                            });

                            
                        } catch (\Swift_TransportException $e) {

                        }
                    }
                    /*End*/
                    
                }
            }
            
            notify()->success('Following Item has been cancelled successfully !');
            DB::commit();
            return back();

        }else{
            DB::rollback();
            notify()->error('Please fill required field before proceeding to cancel.');
            return back();
        }
    }

    public function returnWindow($id)
    {
        $did = Crypt::decrypt($id);
        $invoice = Invoice::findOrFail($did);
        
        
        if (isset($invoice)) {

            if ($invoice->order_product_status == 'delivered') {


                $productname = $invoice->product->name;
                $days = $invoice->product->return_policy->days;
                $endOn = date("Y-m-d", strtotime("$invoice->updated_at +$days days"));
                $today = date('Y-m-d');

                if (isset($invoice->product)) {

                    /*Check if return policy applied on product*/

                    if ($invoice->product->return_available == '1' && !empty($invoice->product->return_policy)) {

                        /*check already returned or not*/
                        if ($invoice->order_product_status != 'refunded' || $invoice->order_product_status != 'returned' || $invoice->order_product_status != 'cancelled' || $invoice->order_product_status != 'cancel_request') {

                            if ($today <= $endOn) {
                                return view('front.order.returnorderwindow', compact( 'invoice', 'productname'));
                            } else {
                                notify()->error('Return Policy ended !');
                                return back();
                            }

                        } else {
                            notify()->warning('Product returned already ! Please check once again !');
                            return back();
                        }
                        /*checked*/

                    } else {
                        notify()->error('Return policy not applicable on this product !');
                        return back();
                    }

                } else {
                    notify()->error('Product not found !');
                    return back();
                }

            } else {
                notify()->warning('Order not delivered yet or already returned !');
                return back();
            }

        } else {
            notify()->error('Order not found or already returned !');
            return back();
        }

    }

    public function returnProcessed($invoice_id, Request $request){
        DB::beginTransaction();
        if(empty($request->reason_return)){
            notify()->error('Please select valid reason');
            return back();
        }
        if(empty($request->pickupaddress)){
            notify()->error('Please select pickup address or edit address from manage shipping address');
            return back();
        }
        $invoice_id = Crypt::decrypt($invoice_id);
        $invoice = Invoice::findOrFail($invoice_id);
        $product = $invoice->product;
        $finalAmount = Crypt::decrypt($request->rf_am);

        if (Auth::user()->id == $invoice->user_id ) {

            if ($invoice->order_product_status == 'delivered') {

                $refundlog = new ReturnProduct();

                $refundlog->invoice_id = $invoice->id;
                $refundlog->qty = $invoice->qty;
                $refundlog->user_id = $invoice->user_id;
                $refundlog->reason = $request->reason_return;
                $refundlog->order_id = $invoice->order_id;
                $refundlog->pay_mode = 'bank';
                $refundlog->bank_details = $invoice->user->bank;
                $refundlog->amount = $finalAmount;
                $refundlog->pickup_location = json_decode($request->pickupaddress);
                $refundlog->status = 'initiated';
                $refundlog->txn_id = 'REFUND_' . str::random(10);
                $refundlog->txn_fee = null;
                $refundlog->save();

                /*Update status of order*/
                Invoice::where('id', $invoice_id)->update(['order_product_status' => 'return_request']);
                /*end*/

                $status = 'Return Requested';
                $inv = $invoice;
                
                $rid = $refundlog->id;

                $email = $invoice->order->shipping_address['email'];
                /*Send Mail to User*/

                if (isset($email)) {

                    Mail::send('emails.orderstatus', ["inv"=> $inv,"status"=> $status], function($message) use($email, $inv, $status)
                    {
                        $message->to($email)->subject('Order '.$inv->order->order_id.' Product '.$inv->product->name.' status');
                    });
                }

                /*End*/


                notify()->success('Return Requested Successully ! You will be notifed via email once we get the product and refund will proceed at same day !');
                DB::commit();
                return redirect()->route('order.view', Crypt::encrypt($invoice->order_id));
            

            } else {
                DB::rollback();
                notify()->warning('Product is not delivered yet !');
                return back();
            }

        } else {
            DB::rollback();
            notify()->error('401 | Unauthorized action !');
            return back();
        }
    }
}
