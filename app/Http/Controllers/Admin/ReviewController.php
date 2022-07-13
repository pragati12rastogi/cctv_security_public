<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::whereHas('product')->whereHas('customer')->get();
        return view('admin.review.index',compact('reviews'));
    }

    public function delete($id){

        $rev = Review::find($id);
        $rev->delete();

        notify()->success('Review is deleted sucessfully');
        return back();
    }
}
