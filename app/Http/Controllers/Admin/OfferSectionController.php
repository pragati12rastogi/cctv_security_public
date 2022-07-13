<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfferSection;
use App\Models\Category;
use App\Models\Product;
use DB;
use Image;
use Validator;

class OfferSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offer = OfferSection::all();
        return view('admin.offer_section.index',compact('offer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $category = Category::where('status',1)->get();
        $product = Product::where('status',1)->get();
        return view('admin.offer_section.add',compact('category','product'));
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
                'title'          => 'required',
                'image'          => 'required|mimes:jpeg,png,jpg,gif',
                'link_type'      => 'required',
                'category_id'    => 'required_if:link_type,==,category',
                'product_id'    => 'required_if:link_type,==,product',
                'url'    => 'required_if:link_type,==,url',

            ],[
                'title.required'      => 'This field is required',
                'image.required'      => 'This field is required',
                'image.mimes'         => 'Field accept only jpeg,png,jpg,gif',
                'link_type.required'  => 'This field is required',
                'category_id.required_if'         => 'This field is required',
                'product_id.required_if'          => 'This field is required',
                'url.required_if'                 => 'This field is required'
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $offer = new OfferSection();
    
            if ($file = $request->file('image')) {
    
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/offer/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['photo'] = $image;
    
            }
    
            $offer->create($input);
            

            
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }

        notify()->success('Offer saved successfully.');
        DB::commit();
        return redirect('admin/offers');
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
        $offer = OfferSection::findOrFail($id);
        $category = Category::where('status',1)->get();
        $product = Product::where('status',1)->get();
        return view('admin.offer_section.edit',compact('offer','category','product'));
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
                'title'          => 'required',
                'image'          => 'mimes:jpeg,png,jpg,gif',
                'link_type'      => 'required',
                'category_id'    => 'required_if:link_type,==,category',
                'product_id'    => 'required_if:link_type,==,product',
                'url'    => 'required_if:link_type,==,url',

            ],[
                'title.required'      => 'This field is required',
                'image.mimes'         => 'Field accept only jpeg,png,jpg,gif',
                'link_type.required'  => 'This field is required',
                'category_id.required_if'         => 'This field is required',
                'product_id.required_if'          => 'This field is required',
                'url.required_if'                 => 'This field is required'
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $offer = OfferSection::findOrFail($id);
    
            if ($file = $request->file('image')) {
                
                if ($offer->photo != '' && file_exists(public_path() . '/assets/uploads/offer/' . $offer->photo)) {
                    unlink(public_path() . '/assets/uploads/offer/' . $offer->photo);
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/assets/uploads/offer/';
                $image = time() .'.'. $file->getClientOriginalExtension();
                
                $optimizeImage->save($optimizePath . $image, 90);
    
                $input['photo'] = $image;
    
            }
    
            $offer->update($input);
            

            
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return back()->with('error','some error occurred'.$ex->getMessage());
        }

        notify()->success('Offer saved successfully.');
        DB::commit();
        return redirect('admin/offers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = OfferSection::find($id);

        if ($offer->photo != '' && file_exists(public_path() . '/assets/uploads/offer/' . $offer->photo)) {
            unlink(public_path() . '/assets/uploads/offer/' . $offer->photo);
        }

        $value = $offer->delete();
        
        if ($value)
        {
            notify()->success('Offer Has Been Deleted');
            
            return redirect("admin/offers");
        }
    }
}
