<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\Category;
use Validator;
use DB;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attr = ProductAttribute::all();

        foreach($attr as $ind => &$a){
            $attr_value = ProductAttributeValue::where('attribute_id',$a['id'])->get()->toArray();
            $category = Category::whereIn('id',$a['category_ids'])->get()->toArray();
            $cat_name = array_column($category,'name');
            $a['cat_names'] = implode(',',$cat_name);
            $attr_value = array_column($attr_value,'value');
            $a['attr_value'] =  implode(',',$attr_value);
        }

        return view('admin.product_attribute.index',compact('attr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::all();
        return view('admin.product_attribute.add',compact('cats'));
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
                'category_ids.*' => 'required',
                'attr_key.*'     => 'required',
                'value.*'        => 'required'
            ],[
                'title.required'          => 'This field is required',
                'category_ids.*.required' => 'This field is required',
                'attr_key.*.required'     => 'This field is required',
                'value.*.required'        => 'This field is required'
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $prod_attr = ProductAttribute::create($input);

            $prod_attr_id = $prod_attr->id;

            $key_value = array_combine($input['attr_key'],$input['value']);

            foreach($key_value as $key => $value){
                $attr_value = ProductAttributeValue::create([
                    'attr_key'     => $key,
                    'value'        => $value,
                    'attribute_id' => $prod_attr_id
                ]);
            }
            
        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }

        if(!empty($prod_attr_id)){
            
            notify()->success('Attribute has been created successfully.');
            DB::commit();
            return redirect('admin/attributes');
        
        }else{

            notify()->error('Some error occurred.please try again.');
            DB::rollback();
            return back()->withInput();

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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cats = Category::all();
        $attribute  = ProductAttribute::findOrFail($id);
        $attr_value = ProductAttributeValue::where('attribute_id',$id)->get();
        return view('admin.product_attribute.edit',compact('attribute','attr_value','cats'));
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
                'category_ids.*' => 'required',
                'attr_key.*'     => 'required',
                'value.*'        => 'required'
            ],[
                'title.required'          => 'This field is required',
                'category_ids.*.required' => 'This field is required',
                'attr_key.*.required'     => 'This field is required',
                'value.*.required'        => 'This field is required'
            ]);

            if($validation->fails()){
                $errors = $validation->errors();
                return back()->withErrors($errors)->withInput();
            }

            DB::beginTransaction();
            $prod_attr = ProductAttribute::findOrFail($id);
            $get_value = ProductAttributeValue::where('attribute_id',$id)->get()->toArray();

            $old_ids = array_column($get_value,'id');
            $deleted_ids = array_diff($old_ids,$input['attr_value_id']);


            if(count($deleted_ids)>0){
                ProductAttributeValue::whereIn('id',$deleted_ids)->delete();
            }

            $input['attr_key'] = array_values($input['attr_key']);
            $input['value'] = array_values($input['value']);

            foreach($input['attr_value_id'] as $index => $ids){
                
                if($ids == 0){
                    // create
                    $attr_value = ProductAttributeValue::create([
                        'attr_key'     => $input['attr_key'][$index],
                        'value'        => $input['value'][$index],
                        'attribute_id' => $id
                    ]);

                }else{
                    // update
                    $attr_value = ProductAttributeValue::where('id',$ids)->update([
                        'attr_key'     => $input['attr_key'][$index],
                        'value'        => $input['value'][$index]
                    ]);
                }
            }
            
            $prod_attr->update($input);

        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }

        notify()->success('Attribute has been updated successfully.');
        DB::commit();
        return redirect('admin/attributes');
    
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
