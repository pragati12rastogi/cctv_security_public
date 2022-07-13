<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use Image;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = ChildCategory::orderBy('id','DESC')->get();
        return view('admin.childcategory.index', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent = Category::where('status',1)->get();
        return view('admin.childcategory.add', compact('parent'));
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

            'category_id' => 'required|not_in:0', 
            'name' => 'required|not_in:0',
            'sub_category_id' => 'required|not_in:null',

        ], [

            "name.required" => "Please enter Childcategory name",
            "category_id.required" => "Please select category.",
            "sub_category_id.required" => "Please select sub category.",

        ]);

        $input = $request->all();
        $data = new ChildCategory;

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/assets/uploads/childcategory/';
            $image = time() .'.'. $file->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 90);

            $input['image'] = $image;

        }
        
        $data->create($input);

        notify()->success('Child Category Has Been Added');
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
        $parent = Category::where('status',1)->get();
        $subcat = SubCategory::where('status',1)->get();
        $childcat = ChildCategory::find($id);
        return view("admin.childcategory.edit", compact("childcat", 'parent', 'subcat'));
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
        $cat = Childcategory::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('image')) {

            if ($cat->image != '' && file_exists(public_path() . '/assets/uploads/childcategory/' . $cat->image)) {
                unlink(public_path() . '/assets/uploads/childcategory/' . $cat->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/assets/uploads/childcategory/';
            $name = time() .".". $file->getClientOriginalExtension();

            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $name, 90);

            $input['image'] = $name;

        }

        $cat->update($input);
        notify()->success('Child Category has been updated');
        return redirect('admin/childcategory');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getdata = ChildCategory::find($id);

        if ($getdata->image != '' && file_exists(public_path() . '/assets/uploads/childcategory/' . $getdata->image)) {
            unlink(public_path() . '/assets/uploads/childcategory/' . $getdata->image);
        }

        if (count($getdata->products) > 0)
        {
            notify()->warning('Childcategory cant be deleted as its linked to products !');
            return back();
                
        }

        $value = $getdata->delete();
        
        if ($value)
        {
            notify()->success('Child Category Has Been Deleted');
            
            return redirect("admin/childcategory");
        }
    }


    public function get_subcat_api(Request $request)
    {

        $id = $request['catId'];

        $upload = SubCategory::where('category_id',$id)->where('status',1)->pluck('name','id');

        return response()->json($upload);
    }

    public function get_childcat_api(Request $request){
        $id = $request['catId'];

        $category = SubCategory::find($id);

        if (isset($category)) {

            $upload = $category->childcategory->where('status',1)->pluck('name', 'id');

        }

        return response()->json($upload);
    }

    public function status_update($id){
        $f = ChildCategory::findorfail($id);

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
