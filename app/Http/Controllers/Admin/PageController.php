<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.page.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            "name" => "required", 
            "slug" => "required|unique:pages,slug",
            'description'=>'required'
        ], [
            "name.required" => "Name Field is Required", 
            "slug.required" => "Slug Field is Required",
            "description.required"=> "Description Field is required"
        ]);

        $input = $request->all();
        
        $page = Page::create($input);
        $page->save();

        return back()->with('success', 'Page has been successfully saved');
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
        $page = Page::findOrFail($id);

        return view("admin.page.edit", compact("page"));
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
        $data = $this->validate($request,[
            "name" => "required", 
            "slug" => "required|unique:pages,slug,".$id,
            'description'=>'required'
        ], [
            "name.required" => "Name Field is Required", 
            "slug.required" => "Slug Field is Required",
            "description.required"=> "Description Field is required"
        ]);

        $page = Page::findOrFail($id);
        $input = $request->all();
        
        $page->update($input);

        return redirect('admin/page')->with('success', 'Page has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Page::find($id);
        $value = $cat->delete();
        if ($value)
        {
            notify()->success('Page is deleted successfully');
            return redirect("admin/page");
        }
    }

    public function pageStatusUpdate($id){
        $f = Page::findorfail($id);

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
