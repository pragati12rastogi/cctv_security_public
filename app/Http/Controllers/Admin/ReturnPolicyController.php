<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\ReturnPolicy;

class ReturnPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $return_policy = ReturnPolicy::all();
        return view( 'admin.return_policy.index',compact('return_policy') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.return_policy.add');
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

            $validation = Validator::make($input,[
                'name'        => 'required',
                'days'        => 'required',
                'description' => 'required'
            ],[
                'name.required'       => 'This is required',
                'days.required'       => 'This is required',
                'description.required'=> 'This is required',
            ]);

            if($validation->fails()){
                $error = $validation->errors();
                return back()->withErrors()->withInput();
            }

            $return_policy = ReturnPolicy::create($input);


        } catch (\Illuminate\Database\QueryException $ex) {
           
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        notify()->success('Return Policy created successfully.');
        return back();
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
        $policy = ReturnPolicy::findOrFail($id);
        return view('admin.return_policy.edit',compact('policy'));
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
        try {

            $input = $request->all();

            $validation = Validator::make($input,[
                'name'        => 'required',
                'days'        => 'required',
                'description' => 'required'
            ],[
                'name.required'       => 'This is required',
                'days.required'       => 'This is required',
                'description.required'=> 'This is required',
            ]);

            if($validation->fails()){
                $error = $validation->errors();
                return back()->withErrors()->withInput();
            }

            $return_policy = ReturnPolicy::findOrFail($id);

            $return_policy->update($input);

        } catch (\Illuminate\Database\QueryException $ex) {
           
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        notify()->success('Return Policy updated successfully.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $return = ReturnPolicy::find($id);

        if (count($return->products) > 0) {
            notify()->warning('Policy can\'t be deleted as its linked to products !');
            return back();
        }

        $del = $return->delete();
        if ($del) {
            notify()->success('Return Policy Has Been Deleted');
            return back();
        }    
    }
}
