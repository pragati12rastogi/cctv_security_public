<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use DB;
use Image;
use Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.add');
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
                'heading'          => 'required',
                
                'button_text'      => 'required',
                'button_url'       => 'required',
                'image'            => 'required|mimes:jpeg,png,jpg,gif'
            ],[
                'heading.required'         => 'This field is required',
                'content.required'         => 'This field is required',
                'button_text.required'     => 'This field is required',
                'button_url.required'      => 'This field is required',
                'image.required'           => 'This field is required',
                'image.mimes'              => 'Field accept only jpeg,png,jpg,gif',
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $slider = new Slider();
    
            if ($file = $request->file('image')) {
    
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/slider/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->fit(1247, 520, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $image, 72);
    
                $input['photo'] = $image;
    
            }
    
            $slider->create($input);
            
           

        }catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        notify()->success('Slider saved successfully.');
        DB::commit();
        return redirect('admin/slider');
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
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit',compact('slider'));
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
                'heading'          => 'required',
                
                'button_text'      => 'required',
                'button_url'       => 'required',
                'image'            => 'mimes:jpeg,png,jpg,gif'
            ],[
                'heading.required'         => 'This field is required',
                'content.required'         => 'This field is required',
                'button_text.required'     => 'This field is required',
                'button_url.required'      => 'This field is required',
               
                'image.mimes'              => 'Field accept only jpeg,png,jpg,gif',
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $slider = Slider::findOrFail($id);
    
            if ($file = $request->file('image')) {
                
                if ($slider->photo != '' && file_exists(public_path() . '/assets/uploads/slider/' . $slider->photo)) {
                    unlink(public_path() . '/assets/uploads/slider/' . $slider->photo);
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/slider/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->fit(1247, 520, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $image, 72);
    
                $input['photo'] = $image;
    
            }
    
            $slider->update($input);
            
           

        }catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }
        notify()->success('Slider updated successfully.');
        DB::commit();
        return redirect('admin/slider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);

        if ($slider->photo != '' && file_exists(public_path() . '/assets/uploads/slider/' . $slider->photo)) {
            unlink(public_path() . '/assets/uploads/slider/' . $slider->photo);
        }

        $del = $slider->delete();
        if ($del) {
            notify()->success('Slider Has Been Deleted');
            return redirect("admin/slider");
        }
    }
}
