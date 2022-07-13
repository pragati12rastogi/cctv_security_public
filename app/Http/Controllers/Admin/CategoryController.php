<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.add');
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
            $request->validate(["name" => "required"], [
                "name.required" => "Category Name is required"
            ]);
    
            $input = $request->all();
    
            $cat = new Category();
    
            if ($file = $request->file('image')) {
    
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/category/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['image'] = $image;
    
            }
    
            $cat->create($input);
            
            notify()->success('Category Has Been Added !');
            return back();

        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
        
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
        $cat = Category::findOrFail($id);
        return view('admin.category.edit',compact('cat'));
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
    
            
            $category = Category::findOrFail($id);
            $input = $request->all();
    
            
            if ($file = $request->file('image')) {
    
                if ($category->image != '' && file_exists(public_path() . '/assets/uploads/category/' . $category->image)) {
                    unlink(public_path() . '/assets/uploads/category/' . $category->image);
                }
    
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/category/';
                $name = time() .'.'. $file->getClientOriginalExtension();
                $optimizeImage->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $optimizeImage->save($optimizePath . $name, 90);
    
                $input['image'] = $name;
    
            }
    
            $category->update($input);

            notify()->success('Category has been updated');
            return back();
    
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
        $category = Category::find($id);

        if (count($category->products) > 0) {
            notify()->warning('Category cant be deleted as its linked to products !');
            return back();
        }

        if ($category->image != '' && file_exists(public_path() . '/assets/uploads/category/' . $category->image)) {
            unlink(public_path() . '/assets/uploads/category/' . $category->image);
        }

        $value = $category->delete();
        if ($value) {
            notify()->success('Category Has Been Deleted');
            return back();
        }
    }

    public function status_update($id){
        $f = Category::findorfail($id);

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
