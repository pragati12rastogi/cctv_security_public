<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index(){
        $subs = Subscription::where('active',1)->get();

        return view('admin.subscription.index',compact('subs'));
    }


    public function delete($id){
        $sub = Subscription::find($id);

        $sub->update([
            'active'=>0
        ]);

        notify()->success('Subscribed User Deleted');
        return back();
    }
}
