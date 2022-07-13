<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Order;
use App\Models\CancelledInvoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Service;
use App\Models\Subscription;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('role','user')->count();
        $order = Order::with(['user','invoices'])->whereHas('invoices')->whereHas('user')->count();
        $totalcancelorder = CancelledInvoice::whereHas('user')->whereHas('invoice')->count();
        $totalproducts = Product::whereHas('category')->whereHas('subcategory')->count();
        $category = Category::count();
        $subcategory = SubCategory::count();
        $childcategory = ChildCategory::count();
        $faqs = faq::count();
        $total_pages = Page::where('status',1)->count();
        $total_services = Service::count();
        $total_subs = Subscription::where('active',1)->count();

        return view('admin.home',compact('user','order','totalcancelorder','totalproducts','category','subcategory','childcategory','faqs','total_pages','total_services','total_subs'));
    }
}
