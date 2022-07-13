<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Shipping;
use App\Models\Product;
use App\Models\User;
use DB;
use Mail;
use Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::where('user_id',Auth::id())
            ->with(['product'=>function($query){
                return $query->where('status',1);
            }])
            ->with(['product.photos'=>function($q){
                return $q->where('default_image',1);
            }])->get()->toArray();

        return view('front.cart',compact('carts'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $input = $request->all();
            $shipping_rate = 0;
            $get_product = Product::where('id',$input['product_id'])->firstOrFail();
            $timestamp =date('Y-m-d H:i:s');

            $shipping_rate = Shipping::where('default_status',1)->first()->price;
            

            DB::beginTransaction();
            if($get_product['qty']>0){

                $check_cart = Cart::where([
                    'user_id'   =>Auth::id(),
                    'product_id'=> $input['product_id']
                ])->first();

                if(empty($check_cart)){
                    $order_qty = $input['qty'];
                }else{
                    $order_qty = $input['qty'] + $check_cart['qty'];
                }
                
                $old_qty = $get_product['qty'];

                $check_qty = $old_qty - $order_qty;
                
                if($check_qty>0){

                    if(empty($check_cart)){

                        $shopping_cart = Cart::insertGetId([
                            'qty'          => $order_qty,
                            'user_id'      => Auth::id(),
                            'product_id'   => $input['product_id'],
                            'old_amount'   => $get_product['old_price'],
                            'actual_price' => $get_product['price'],
                            'tax'          => $get_product['tax'],
                            'shipping'     => $shipping_rate,
                            'created_at'   => $timestamp,
                            'updated_at'   => $timestamp
                        ]);

                    }else{

                        $shopping_cart = Cart::where('id',$check_cart['id'])
                        ->update([
                            'qty'          => $order_qty,
                            'old_amount'   => $get_product['old_price'],
                            'actual_price' => $get_product['price'],
                            'tax'          => $get_product['tax'],
                            'shipping'     => $shipping_rate,
                            'updated_at'   => $timestamp
                        ]);
                    }
                    

                }else{
                    DB::rollback();
                    notify()->error('Sorry !! Limited Stock is left, can accept order quantity of '.$old_qty.' product only!!');
                    return back();
                }

            }else{
                DB::rollback();
                notify()->error('Quantity is not sufficient to place your order.');
                return back();
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
        
        if($shopping_cart){
            DB::commit();
            notify()->success($get_product['name'].' added successfully to your cart.');
            return back();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();

        $check_cart = Cart::find($input['cart_id']);
        $get_product = Product::where('id',$check_cart['product_id'])->firstOrFail();
        $timestamp =date('Y-m-d H:i:s');
        DB::beginTransaction();
        if($get_product['qty']>0){

            

            $order_qty = $input['qty'] ;

            $old_qty = $get_product['qty'];

            $check_qty = $old_qty - $order_qty;

            if($check_qty>0){

                $check_cart->update([
                    'qty'          => $order_qty,
                    'updated_at'   => $timestamp
                ]);

                if($check_cart){
                    DB::commit();

                    $get_latest_count = Cart::where('user_id',Auth::id())->get()->toArray();

                    $old_amt_and_qty =0;
                    $actual_amt_and_qty =0;
                    $total_discount = 0;
                    $shipping = 0;

                    foreach($get_latest_count as $ind => $cart_count){
                        $old_amt_and_qty = $old_amt_and_qty +($cart_count['qty'] * $cart_count['old_amount']);
                        $actual_amt_and_qty = $actual_amt_and_qty+($cart_count['qty'] * $cart_count['actual_price']);
                        
                        if(!empty($cart_count['old_amount'])){
                            $total_discount = $total_discount+(($cart_count['old_amount']-$cart_count['actual_price'])*$cart_count['qty']);
                        }
                        $shipping += $cart_count['shipping'];
                    }

                    $result = [
                        'status'            => 'success',
                        'message'           => 'Quantity updated',
                        'old_amt_and_qty'   => $old_amt_and_qty,
                        'actual_amt_and_qty'=> $actual_amt_and_qty + $shipping,
                        'total_discount'    => $total_discount,
                        'row_total_amount'  => ($get_product['price']*$order_qty)
                    ];
                    return json_encode($result);
                }

            }else{
                DB::rollback();
                $result = [
                    'status'=>'error',
                    'message'=> 'Sorry !! Limited Stock is left, can accept order quantity of '.$old_qty.' product only!!'
                ];
                return json_encode($result);
            }

        }else{
            DB::rollback();
            $result = [
                'status'=>'error',
                'message'=> 'Quantity is not sufficient to place your order.'
            ];
            return json_encode($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
        $cart->delete();

        notify()->success('Cart Updated Successfully');
        return back();
    }
}
