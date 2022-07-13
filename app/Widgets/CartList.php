<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Auth;
use DB;
use App\Models\Cart;

class CartList extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        $user_cart_list =[];
        if(Auth::check()){
            $user_cart_list = Cart::with('user')->with(['product'=>function($q){
                return $q->where('status',1);
            }])->with(['product.photos'=>function($q){
                return $q->where('default_image',1);
            }])->where('user_id',Auth::id())->get()->toArray();
        }

        return view('widgets.cart_list', [
            'config' => $this->config,
            'user_cart_list' => $user_cart_list
        ]);
    }
}
