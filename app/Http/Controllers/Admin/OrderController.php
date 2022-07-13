<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\GeneralSetting;
use App\Models\CancelledInvoice;
use App\Models\Product;
use App\Models\ReturnProduct;
use Crypt;
use Mail;

class OrderController extends Controller
{
    public function all_orders(){

        $order = Order::with(['user','invoices'])->orderBy('id','Desc')->get();
        return view('admin.order.all_order',compact('order'));
    }

    public function all_orders_edit($orderid){
        $order = Order::findOrFail($orderid);
        return view('admin.order.all_order_edit',compact('order')); 
    }

    public function full_order_invoice_pdf($orderid){
        $order = Order::findOrFail($orderid);
        $store = GeneralSetting::first();
        return view('admin.order.print_order',compact('order','store'));
    }

    public function single_prod_invoice($inv_id){
        $invoice = Invoice::findOrFail($inv_id);
        $store = GeneralSetting::first();
        return view('admin.order.print_invoices',compact('invoice','store'));
    }

    public function cancel_product($id,Request $request){
        
        $inv_id = Crypt::decrypt($id);
        $status = 0;
        $findorder = Invoice::findOrFail($inv_id);
        DB::beginTransaction();
        if(!empty($request->comment)){


            if (empty($findorder->user->bank)) {
                notify()->error('Please add bank account first !');
                return back();
            }else{

                $cancelorderlog = new CancelledInvoice();

                if ($findorder->order->payment_method == 'COD') {
                    $cancelorderlog->pay_method = 'COD';
                    $cancelorderlog->is_refunded = 1;
                    $cancelorderlog->transaction_id = 'CODCAN' . str_random(10);
                }else{
                    
                    $cancelorderlog->pay_method = 'bank';
                    $cancelorderlog->is_refunded = 0;
                    $cancelorderlog->transaction_id = 'TXNBNK' . str_random(10);
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
                    $e = $findorder->user->email;

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

    public function updateStatus(Request $request, $id)
    {

        $inv = Invoice::findOrFail($id);
        $inv->order_product_status = $request->status;
        $inv->save();
        $status = ucfirst($request->status);
            
        $i = 0;
        $productname = $inv->product->name;

        /*Sending mail & Notifiation on specific event perform*/

        $order_id = $inv->order->order_id;

        if ($request->status == 'shipped') {

            /*Send Mail to User*/
            try {
                $e = $inv->order->shipping_address['email'];
                $status = ucfirst($request->status);
                Mail::send('emails.orderstatus', ["inv"=> $inv,"status"=> $status], function($message) use($e,$inv, $status)
                {
                    $message->to($e)->subject('Order '.$inv->order->order_id.' Product '.$inv->product->name.' status');
                });
                

            } catch (\Swift_TransportException $e) {
                //Throw exception if you want //
            }


        } elseif ($request->status == 'processed'|| $request->status == 'pending') {

        } elseif ($request->status == 'delivered' ) {

            /*Send Mail to User*/
            try {
                $e = $inv->order->shipping_address['email'];
                
                Mail::send('emails.orderstatus', ["inv"=> $inv,"status"=> $status], function($message) use($e,$inv, $status)
                {
                    $message->to($e)->subject('Order '.$inv->order->order_id.' Product '.$inv->product->name.' status');
                });
                

            } catch (\Swift_TransportException $e) {
                //Throw exception if you want //
            }

        }  

            /*end*/
        return response()->json(['proname' => $productname, 'dstatus' => $status, 'id' => $inv->id, 'status' => $request->status,'invno'=> '#Inv'.$inv->id]);


    }

    public function updatepayconfirm($order_id, Request $request){
        $order = Order::find($order_id);

        $order->payment_receive = $request->status;

        $order->save();

        if ($order) {
            return response()->json(['showstatus' => 'Updated', 'status' => true]);
        } else {
            return response()->json(['showstatus' => 'Failed', 'status' => false]);
        }
    }

    public function all_completed_order(){
        $invoice = Invoice::where('order_product_status','delivered')->get();
        return view('admin.order.completed_orders',compact('invoice'));
    }

    public function all_cancel_orders(){
        $cancel_inv = CancelledInvoice::all();
        return view('admin.order.cancel_orders',compact('cancel_inv'));
    }
    
    public function update_cancel_order_status($cancel_order_id,Request $request){
        $findCancelLog = CancelledInvoice::findOrFail($cancel_order_id);

        $findCancelLog->is_refunded = $request->refund_status;

        $findCancelLog->amount = $request->amount;

        $findCancelLog->transaction_id = $request->transaction_id;

        $findCancelLog->txn_fee = $request->txn_fee;

        $singleorder = Invoice::findOrFail($findCancelLog->invoice_id);

        $singleorder->order_product_status = $request->order_status;

        $findCancelLog->save();

        $singleorder->save();

        

        return back()
            ->with('updated', 'Order Status Updated !');
    }

    public function all_return_orders(){
        $unreadorders = ReturnProduct::where('status','initiated')->get();
        $readedorders = ReturnProduct::where('status','<>','initiated')->get();

        $countP = count($unreadorders);
        $countC = count($readedorders);

        return view('admin.order.return_orders',compact('unreadorders','readedorders','countP','countC'));
    } 

    public function show_update_return_order_detail($return_id){
        $rorder = ReturnProduct::find($return_id);
        if (isset($rorder)) {
            if ($rorder->status != 'initiated') {
                return back()->with('warning', '400 Refund already initiated !');
            }
            return view('admin.order.updreturnorder', compact('rorder'));
        } else {
            return redirect()->route('all.return.order')->with('warning', '404 Return order not found !');
        }
    }

    public function update_return_order_detail($return_id, Request $request){
        
        DB::beginTransaction();
        $returnorder = ReturnProduct::find($return_id);
        $findInvoice = Invoice::findorfail($returnorder->invoice_id);

        if (isset($returnorder)) {

            if ($returnorder->status == 'initiated') {

                if ($returnorder->pay_mode == 'bank') {

                    $returnorder->status = 'refunded';
                    $returnorder->amount = $request->amount;
                    $returnorder->txn_id = $request->txn_id;
                    $returnorder->txn_fee = $request->txn_fee;
                    $returnorder->save();

                    $findInvoice->order_product_status = $request->order_status;
                    $findInvoice->save();

                    /*Send Mail to User*/
                    $inv_cus = Invoice::first();

                    if ($request->order_status == 'ret_ref') {
                        $status = 'Returned & Amount has been refunded';
                    } else {
                        $status = $request->order_status;
                    }

                    try {

                        Mail::send('emails.orderstatus', ["inv"=> $findInvoice,"status"=> $status], function($message) use( $findInvoice, $status)
                        {
                            $message->to($findInvoice->user->email)->subject('Order '.$findInvoice->order->order_id.' Product '.$findInvoice->product->name.' status');
                        });
                        
                        


                    } catch (\Exception $e) {
                        DB::rollback();
                        return back()->with('error', 'Some error occured : '.$e);
                    }
                    /*end*/

                    DB::commit();
                    return redirect()->route('all.return.order')->with('success', 'Return Order Updated Successfully !');

                }else{
                    return back()->with('Pay mode bank not available');
                }

            } else {
                return back()->with('warning', 'Refund for this order already completed !');
            }

        } else {
            return back()->with('warning', '404 Return order not found !');
        }
    }

    public function view_return_order_detail($id){
        $rorder = ReturnProduct::find($id);
        
        if (isset($rorder)) {

            if ($rorder->status != 'initiated') {
                return view('admin.order.returnorderdetail', compact( 'rorder'));
            } else {
                return back()->with('warning', 'Order not refunded yet !');
            }

        } else {
            return redirect()->route('all.return.order')->with('warning', '404 Return order not found !');
        }
    }
}
