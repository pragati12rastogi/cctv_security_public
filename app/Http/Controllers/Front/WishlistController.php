<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Auth;
use DB;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index(){
        $wishlist = Wishlist::with('product')->with(['product.photos'=>function($q){
            return $q->where('default_image',1);
        }])->where('user_id',Auth::id())->get()->toArray();
       
        return view('front.wishlist',compact('wishlist'));
    }

    public function AddtoWishlist($id){
        if (isset(Auth::user()->id)) {
            $wish = Wishlist::where('user_id', Auth::user()->id)
                    ->where('product_id', $id)->first();
            if (!empty($wish)) {
                
                Wishlist::where('user_id', Auth::user()->id)
                    ->where('product_id', $id)->delete();
                    
                return json_encode('removed');
            } else {
                $wishlist = new Wishlist;

                $wishlist->user_id = Auth::user()->id;
                $wishlist->product_id = $id;
                $wishlist->save();
                
                return json_encode('success');
            }
        } else {
            return json_encode('Please Log in to use this feature !');
        }
    }

    public function RemovetoWishlist($id){
        
        Wishlist::where('id', $id)->delete();
        
        notify()->success('Product removed from Wishlist');
        return back();
    }
}
