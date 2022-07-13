<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use DB;
use Image;
use Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $input = $request->all();
                
            $validation = Validator::make($input,[
                'title'          => 'required',
                'image'          => 'required|mimes:jpeg,png,jpg,gif'
            ],[
                'title.required'      => 'This field is required',
                'image.required'      => 'This field is required',
                'image.mimes'         => 'Field accept only jpeg,png,jpg,gif',
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $service = new Service();
    
            if ($file = $request->file('image')) {
    
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/service/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['photo'] = $image;
    
            }
    
            $service->create($input);
            

        }catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        notify()->success('Service saved successfully.');
        DB::commit();
        return redirect('admin/service');
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
        $service = Service::findOrFail($id);
        return view('admin.service.edit',compact('service'));
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
        try{
            $input = $request->all();
                
            $validation = Validator::make($input,[
                'title'          => 'required',
                'image'          => 'mimes:jpeg,png,jpg,gif'
            ],[
                'title.required'         => 'This field is required',
                'image.mimes'              => 'Field accept only jpeg,png,jpg,gif',
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $service = Service::findOrFail($id);
    
            if ($file = $request->file('image')) {
                
                if ($service->photo != '' && file_exists(public_path() . '/assets/uploads/service/' . $service->photo)) {
                    unlink(public_path() . '/assets/uploads/service/' . $service->photo);
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/service/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->fit(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $image, 72);
    
                $input['photo'] = $image;
    
            }
    
            $service->update($input);
            
           

        }catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        notify()->success('Service updated successfully.');
        DB::commit();
        return redirect('admin/service');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if ($service->photo != '' && file_exists(public_path() . '/assets/uploads/service/' . $service->photo)) {
            unlink(public_path() . '/assets/uploads/service/' . $service->photo);
        }

        $del = $service->delete();
        if ($del) {
            notify()->success('Service Has Been Deleted');
            return redirect("admin/service");
        }
    }
}
