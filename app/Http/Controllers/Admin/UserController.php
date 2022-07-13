<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBank;
use App\Models\ShippingAddress;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role','user')->get();
        return view('admin.user.index',compact('users'));
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
        $user = User::findOrFail($id);
        $bank = UserBank::where('user_id',$id)->first();
        $address = ShippingAddress::where('user_id',$id)->first();
        
        return view('admin.user.show',compact('user','bank','address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $del = $user->delete();

        if ($del) {
            notify()->success('User Has Been Deleted');
            return redirect("admin/users");
        }
    }

    public function status_update($id){
        
        $f = User::findorfail($id);

        if($f->status==1)
        {
            User::where('id','=',$id)->update(['status' => "0"]);
            notify()->success("Status changed to Deactive !");
            return back();
        }
        else
        {
            User::where('id','=',$id)->update(['status' => "1"]);
            notify()->success("Status changed to Active !");
            return back();
        }
    }
}
