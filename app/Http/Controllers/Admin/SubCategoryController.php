<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Image;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::orderBy('id','DESC')->get();
        return view('admin.subcategory.index',compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $parent = Category::where('status',1)->get();
        return view('admin.subcategory.add',compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            
            "name"=>"required",
        ],[

            "name.required"=>"Subcategory Name is needed",
            
        ]);

        $data  = new Subcategory;
        $input = $request->all();

        if ($file = $request->file('image')) 
        {
            
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/assets/uploads/subcategory/';
            $image = time().'.'.$file->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath.$image, 90);

            $input['image'] = $image;

        }
        $data->create($input);

        notify()->success('Sub Category Has Been Added');
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
        $subcat = SubCategory::findOrFail($id);
        $parent = Category::where('status',1)->get();
        return view('admin.subcategory.edit',compact('subcat','parent'));
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
            
            $request->validate( 
                [
                    "name" => "required"
                ],[
                    "name.required" => "Name is needed"
                ]
            );
    
            
            $category = SubCategory::findOrFail($id);
            $input = $request->all();
    
            
            if ($file = $request->file('image')) {
    
                if ($category->image != '' && file_exists(public_path() . '/assets/uploads/subcategory/' . $category->image)) {
                    unlink(public_path() . '/assets/uploads/subcategory/' . $category->image);
                }
    
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/subcategory/';
                $name = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $name, 90);
    
                $input['image'] = $name;
    
            }
    
            $category->update($input);

            notify()->success('SubCategory has been updated');
            return redirect('admin/subcategory');
    
        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = SubCategory::find($id);

        if (count($category->products) > 0) {
            notify()->warning('Sub Category cant be deleted as its linked to products !');
            return back();
        }

        if ($category->image != '' && file_exists(public_path() . '/assets/uploads/subcategory/' . $category->image)) {
            unlink(public_path() . '/assets/uploads/subcategory/' . $category->image);
        }

        $value = $category->delete();
        if ($value) {
            notify()->success('SubCategory Has Been Deleted');
            return redirect("admin/subcategory");
        }
    }

    public function status_update($id){
        $f = SubCategory::findorfail($id);

        if($f->status==1)
        {
            $f->update(['status' => "0"]);
            notify()->success("Status changed to Deactive !");
            return back();
        }
        else
        {
            $f->update(['status' => "1"]);
            notify()->success("Status changed to Active !");
            return back();
        }
    }
}
