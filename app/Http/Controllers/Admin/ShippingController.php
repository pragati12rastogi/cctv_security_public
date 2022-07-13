<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;
use DB;
use Auth;
use Session;
use View;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Shipping::all();
        return view("admin.shipping.index",compact("shippings"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipping = Shipping::findOrFail($id);

        return view("admin.shipping.edit",compact("shipping"));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shipping = shipping::findOrFail($id);
        $input = $request->all();  
        $shipping->update($input);

        return redirect('admin/shipping')->with('success', 'Shipping has been updated');

    }

    
    public function shipping(Request $request){
       
        $id = $request['catId'];
        DB::table('shippings')->update(['default_status' => '0']);
      
        $UpdateDetails = Shipping::where('id', '=',  $id)->first();


        $UpdateDetails->default_status = "1";
        $UpdateDetails->save();

        
        Session::flash('success', 'Default shipping method has been changed now.');
        return View::make('admin.shipping.message');
   }
}
