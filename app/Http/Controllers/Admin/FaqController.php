<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::all();
        return view("admin.faq.index", compact("faqs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faq = Faq::all();
        return view("admin.faq.add", compact("faq"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, ["ans" => "required", "que" => "required",

        ], [

        "ans.required" => "Answer Fild is Required", "que.required" => "Question Fild is Required",

        ]);

        $input = $request->all();
        $faq = Faq::create($input);
        $faq->save();
        notify()->success("Faq has been Created");
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
        $faq = Faq::findOrFail($id);

        return view("admin.faq.edit", compact("faq"));
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
        $data = $this->validate($request, ["ans" => "required", "que" => "required",

        ], [

        "ans.required" => "Answer Fild is Required", "que.required" => "Question Fild is Required",

        ]);

        $faq = Faq::findOrFail($id);
        $input = $request->all();
        
        if(!isset($input['status'])){
            $input['status'] =0;
        }

        $faq->update($input);
        notify()->success("Faq has been updated");
        return redirect('admin/faq');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Faq::find($id);
        $value = $cat->delete();
        if ($value)
        {
            notify()->success("Faq Has Been Deleted");
            return redirect("admin/faq");
        }
    }

    public function faqUpdate($id)
    {

         $f = Faq::findorfail($id);

        if($f->status==1)
        {
            Faq::where('id','=',$id)->update(['status' => "0"]);
            notify()->success("Status changed to Deactive !");
            return back();
        }
        else
        {
            Faq::where('id','=',$id)->update(['status' => "1"]);
            notify()->success("Status changed to Active !");
            return back();
        }
    }
}
