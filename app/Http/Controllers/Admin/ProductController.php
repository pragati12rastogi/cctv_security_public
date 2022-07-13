<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariantsDetail;
use App\Models\ReturnPolicy;
use App\Models\Wishlist;
use App\Models\Cart;
use Image;
use Validator;
use DB;
use Rap2hpoutre\FastExcel\FastExcel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        
        return view('admin.product.index',compact('products'));
    }

    public function product_list_api(Request $request){
        $search = $request->input('search');
        $search_value = $search['value'];
        $start = $request->input('start');
        $limit = $request->input('length');
        $offset = empty($start) ? 0 : $start ;
        $limit =  empty($limit) ? 10 : $limit ;
        
        $menu_detail = Product::leftjoin('categories','categories.id','products.category_id')
            ->leftjoin('sub_categories','sub_categories.id','products.sub_category_id')
            ->leftjoin('child_categories','child_categories.id','products.child_category_id')
            ->leftjoin('product_photos', function($join)
            {
                $join->on('product_photos.product_id', '=', 'products.id')
                    ->where('product_photos.default_image', '=', '1');
            })
            ->select('products.*','sub_categories.name as sub_cat','categories.name as cat','child_categories.name as child','product_photos.image as product_image');

        if(!empty($search_value))
        {   
            $menu_detail = $menu_detail->where(function($query) use ($search_value){
                $query->where('products.name','LIKE',"%".$search_value."%")
                        ->orwhere('categories.name','LIKE',"%".$search_value."%")
                        ->orwhere('sub_categories.name','LIKE',"%".$search_value."%")
                        ->orwhere('child_categories.name','LIKE',"%".$search_value."%")
                        ;
            });
        }

        $count = $menu_detail->count();
        $menu_detail = $menu_detail->offset($offset)->limit($limit);

        if(isset($request->input('order')[0]['column'])){
            $data = ['products.id','product_photos.image','products.name','categories.name','sub_categories.name','child_categories.name','products.status'
            ];
            $by = ($request->input('order')[0]['dir'] == 'desc')? 'desc': 'asc';
            $menu_detail->orderBy($data[$request->input('order')[0]['column']], $by);
        }
        else
        {
            $menu_detail->orderBy('products.id','desc');
        }
        $menu_detaildata = $menu_detail->get()->toArray();
        
        $array['recordsTotal'] = $count;
        $array['recordsFiltered'] = $count ;
        $array['data'] = $menu_detaildata; 
        return json_encode($array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status',1)->get();
        $policy = ReturnPolicy::all();
        return view('admin.product.add',compact('category','policy'));
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
            $validation = Validator::make($request->all(),[
                'name'=>'required',
                'price'=>'required',
                'category_id'=>'required',
                'sub_category_id'=>'required',
                'photos'=>'required',
                'return_policy_id'=>'required_if:return_available,==,1'
            ],[
                'name.required'=>'This field is required',
                'price.required'=>'This field is required',
                'category_id.required'=>'This field is required',
                'sub_category_id.required'=>'This field is required',
                'photos.required'=>'This field is required',
                'return_policy_id.required_if'=>'This field is required'
            ]);
            $errors = $validation->errors();
            if ($validation->fails()) {
                
                return back()->withErrors($errors)->withInput();
            }
            $input = $request->all();
            
            DB::beginTransaction();
            if(empty($input['tax'])){
                $input['tax'] = 0;
            }
            
            if(!empty($request->file('datasheet_upload'))){
                if($datasheet = $request->file('datasheet_upload')){

                    $destinationPath = public_path().'/assets/uploads/datasheet/';
                    $filenameWithExt = $datasheet->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $datasheet->getClientOriginalExtension();
                    $image = $filename.'_'.time().'.'.$extension;
                    $path = $datasheet->move($destinationPath, $image);

                    $input['datasheet_upload'] = $image;
                }
            }

            if(!empty($request->file('user_manual_upload'))){
                if($user_manual = $request->file('user_manual_upload')){

                    $destinationPath = public_path().'/assets/uploads/user_manual/';
                    $filenameWithExt = $user_manual->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $user_manual->getClientOriginalExtension();
                    $image = $filename.'_'.time().'.'.$extension;
                    $path = $user_manual->move($destinationPath, $image);

                    $input['user_manual_upload'] = $image;
                }
            }

            $product = Product::create($input);

            $prod_id = $product->id;
            
            $path = public_path('/assets/uploads/product_photos/');

              
            foreach($input['photos'] as $ind => $photo){

                $name = 'product_' . time() . rand(10,10000) . '.' . $photo->getClientOriginalExtension();
                $img = Image::make($photo->path());
                
                $img->save($path .'/'. $name, 95);
                
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $prod_image = ProductPhoto::insertGetId([
                    'product_id'=>$prod_id,
                    'image' => $name,
                    'default_image'=> ($ind == 0)?'1':'0'
                ]);
            }

            foreach($input['varient_attr'] as $attr_id => $attr_value){
                if(is_array($attr_value)){
                    $get_value = ProductAttributeValue::where('attribute_id',$attr_id)->whereIn('attr_key',$attr_value)->get()->toArray();
                }else{
                    $get_value = ProductAttributeValue::where('attribute_id',$attr_id)->where('attr_key',$attr_value)->get()->toArray();
                }
                
                foreach($get_value as $at_ind => $at_val){
                    $add_varient = ProductVariantsDetail::create([
                        'product_id'=>$prod_id,
                        'attribute_id'=> $attr_id,
                        'attribute_value_id'=>$at_val['id'],
                        'attribute_value'=>$at_val['attr_key']
                    ]);
                }

            }
            
        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }

        if(!empty($prod_id)){

            notify()->success('Product has been created successfully.');
            DB::commit();
            return back();

        }else{

            notify()->error('Some error occurred.please try again.');
            DB::rollback();
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
        $prod = Product::find($id);
        $prod_photo = ProductPhoto::where('product_id',$id)->get();
        $category = Category::all();
        $sub_cat = SubCategory::all();
        $child_cat = ChildCategory::all();

        $attr = ProductAttribute::all();
        $policy = ReturnPolicy::all();
        return view('admin.product.edit',compact('prod','prod_photo','sub_cat','child_cat','category','attr','policy'));
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
            
            $validation = Validator::make($request->all(),[
                'name'=>'required',
                'price'=>'required',
                'category_id'=>'required',
                'sub_category_id'=>'required',
                'return_policy_id'=>'required_if:return_available,==,1'
            ],[
                'name.required'=>'This field is required',
                'price.required'=>'This field is required',
                'category_id.required'=>'This field is required',
                'sub_category_id.required'=>'This field is required',
                'return_policy_id.required_if'=>'This field is required'
            ]);
            $errors = $validation->errors();

            if ($validation->fails()) {
                
                return back()->withErrors($errors)->withInput();
            }

            $product_data = Product::findorfail($id);

            $product_photo = ProductPhoto::where('product_id',$id)->get()->toArray();
            
            $input = $request->all();


            if(!isset($input['photos'])){
                if(count($product_photo)<0){
                    return back()->with('error','Product Photo can not be null')->withInput();
                }
            }

            DB::beginTransaction();

            if(empty($input['tax'])){
                $input['tax'] = 0;
            }
            
            if(isset($input['datasheet_upload'])){
                if($datasheet = $request->file('datasheet_upload')){

                    if ($product_data->datasheet_upload != '' && file_exists(public_path() . '/assets/uploads/datasheet/' . $product_data->datasheet_upload)) {
                        unlink(public_path() . '/assets/uploads/datasheet/' . $product_data->datasheet_upload);
                    }
                    
                    $destinationPath = public_path().'/assets/uploads/datasheet/';
                    $filenameWithExt = $datasheet->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $datasheet->getClientOriginalExtension();
                    $image = $filename.'_'.time().'.'.$extension;
                    $path = $datasheet->move($destinationPath, $image);

                    $input['datasheet_upload'] = $image;

                }
            }

            if(isset($input['user_manual_upload'])){
                if($user_manual = $request->file('user_manual_upload')){

                    if ($product_data->user_manual_upload != '' && file_exists(public_path() . '/assets/uploads/user_manual/' . $product_data->user_manual_upload)) {
                        unlink(public_path() . '/assets/uploads/user_manual/' . $product_data->user_manual_upload);
                    }

                    $destinationPath = public_path().'/assets/uploads/user_manual/';
                    $filenameWithExt = $user_manual->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $user_manual->getClientOriginalExtension();
                    $image = $filename.'_'.time().'.'.$extension;
                    $path = $user_manual->move($destinationPath, $image);

                    $input['user_manual_upload'] = $image;

                }
            }

            $product_data->update($input);

            $path = public_path('/assets/uploads/product_photos/');

            if(isset($input['photos'])){
                foreach($input['photos'] as $ind => $photo){

                    $name = 'product_' . time() . rand(10,10000) . '.' . $photo->getClientOriginalExtension();
                    $img = Image::make($photo->path());
                    
                    $img->save($path .'/'. $name, 95);
                    
                    $prod_image = ProductPhoto::insertGetId([
                        'product_id'=>$id,
                        'image' => $name,
                        'default_image'=> '0'
                    ]);
                }
            }
            
            foreach($input['varient_attr'] as $attr_id => $attr_value){
                
                // checking Product Varients 
                $check_old_variant = ProductVariantsDetail::where('product_id',$id)->where('attribute_id',$attr_id)->get()->toArray();
                if(is_array($attr_value)){
                    $get_value = ProductAttributeValue::where('attribute_id',$attr_id)->whereIn('attr_key',$attr_value)->get()->toArray();
                }else{
                    $get_value = ProductAttributeValue::where('attribute_id',$attr_id)->where('attr_key',$attr_value)->get()->toArray();
                }
                
                if(!empty($check_old_variant)){
                    ProductVariantsDetail::where('product_id',$id)->where('attribute_id',$attr_id)->delete();
                    foreach($get_value as $at_ind => $at_val){
                        
                        $add_varient = ProductVariantsDetail::create([
                            'product_id'=>$id,
                            'attribute_id'=> $attr_id,
                            'attribute_value_id'=>$at_val['id'],
                            'attribute_value'=>$at_val['attr_key']
                        ]);
                        
                        
                    }   

                }else{
                    
                    if(!empty($get_value)){

                        foreach($get_value as $at_ind => $at_val){
                            $add_varient = ProductVariantsDetail::create([
                                'product_id'=>$id,
                                'attribute_id'=> $attr_id,
                                'attribute_value_id'=>$at_val['id'],
                                'attribute_value'=>$at_val['attr_key']
                            ]);
                        }
                        
                    }

                }
            }

            $get_all_variant_of_product = ProductVariantsDetail::where('product_id',$id)->get()->toArray();
            
            $get_variant_ids = array_keys($input['varient_attr']);
            
            $ids_from_product_wise = array_column($get_all_variant_of_product,'attribute_id');
            $deleting_ids_array = array_diff($ids_from_product_wise,$get_variant_ids);
            
            if(count($deleting_ids_array)>0){
                ProductVariantsDetail::whereIn('id',$deleting_ids_array)->delete();
            }
            
            // update default image 
            $prod_photo = ProductPhoto::where('product_id',$id)->first();
            $prod_photo->update(['default_image'=>1]);

        } catch (\Illuminate\Database\QueryException $ex) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }

        notify()->success('Product has been updated successfully.');
        DB::commit();
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
        $getdata = Product::find($id);

        if ($getdata->datasheet_upload != '' && file_exists(public_path() . '/assets/uploads/datasheet/' . $getdata->datasheet_upload)) {
            unlink(public_path() . '/assets/uploads/datasheet/' . $getdata->datasheet_upload);
        }

        if ($getdata->user_manual_upload != '' && file_exists(public_path() . '/assets/uploads/user_manual/' . $getdata->user_manual_upload)) {
            unlink(public_path() . '/assets/uploads/user_manual/' . $getdata->user_manual_upload);
        }

        $value = $getdata->delete();
        
        $photo = ProductPhoto::where('product_id',$id)->get();
        $wishlist = Wishlist::where('product_id',$id)->delete();
        $cart = Cart::where('product_id',$id)->delete();

        foreach($photo as $ind => $p){
            
            if ($p->image != '' && file_exists(public_path() . '/assets/uploads/product_photos/' . $p->image)) {
                unlink(public_path() . '/assets/uploads/product_photos/' . $p->image);
            }
            ProductPhoto::find($p->id)->delete();
        }

        if ($value)
        {
            notify()->success('Product Has Been Deleted');
            
            return redirect("admin/product");
        }
    }

    public function product_photo_delete_api(Request $request){
        $input = $request->all();

        $photo = ProductPhoto::find($input['photo_id']);

        if ($photo->image != '' && file_exists(public_path() . '/assets/uploads/product_photos/' . $photo->image)) {
            unlink(public_path() . '/assets/uploads/product_photos/' . $photo->image);
        }

        $photo->delete();

        return json_encode(['status'=>'success','msg'=>'Photo deleted successfully']);
    }

    public function status_update($id){
        $f = Product::findorfail($id);

        if($f->status==1)
        {
            Product::where('id','=',$id)->update(['status' => "0"]);
            notify()->success("Status changed to Deactive !");
            return back();
        }
        else
        {
            Product::where('id','=',$id)->update(['status' => "1"]);
            notify()->success("Status changed to Active !");
            return back();
        }
    }

    public function product_cat_attribute_api(Request $request){

        $atribute = ProductAttribute::all();
        $input = $request->all();
        
        $filter_attr = [];
        $attr_value = [];
        
        foreach($atribute as $i => $attr){
            
            $cat = Category::whereIn('id',$attr['category_ids'])->where('id', $input['cat'])->get();
            
            if(!empty($cat)){
                $filter_attr[] = $attr;
                $value = ProductAttributeValue::where('attribute_id',$attr['id'])->get()->toArray();
                
                $attr_value[$attr['id']] = $value;
            }

        }

        echo json_encode(['attr'=>$filter_attr,'attr_value'=>$attr_value]);
    }

    public function product_import()
    {
        return view('admin.product.import');
    }

    public function product_import_db(Request $request){
        $validator = Validator::make(
            [
                'file' => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls,csv',
            ]

        );

        if ($validator->fails()) {
            return back()->withErrors('Invalid file !');
        }

        if (!$request->has('file')) {
            notify()->warning('Please choose a file !');
            return back();
        }

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);
        
        $productfile = (new FastExcel)->import($request->file('file'));
        
        $error = 0;
        DB::beginTransaction();
        if(count($productfile)>0){
            foreach($productfile as $key => $line){

                $rowno = $key + 1;
                $productname = trim($line['product_name']);
                $catname = trim($line['category_name']);

                $catid = Category::where("name",$catname)->first();

                if (!isset($catid)) {
                    $catid = new Category;
                    $catid->name = $catname;
                    $catid->save();
                }

                $subcatname = trim($line['subcategory_name']);
                $subcatid = SubCategory::where('name',$subcatname)->first();

                if (!isset($subcatid)) {

                    $subcatid = new SubCategory;
                    $subcatid->name = $line['subcategory_name'];
                    $subcatid->category_id = $catid->id;
                    $subcatid->save();
                }

                if ($line['return_available'] != 0 && $line['return_available'] != '0' && !empty($line['return_available']) ) {
                    
                    $p = ReturnPolicy::where('name', $line['return_policy'])->first();
                    
                    if (!isset($p)) {

                        
                        $error++;
                        DB::rollback();

                        notify()->error("Invalid Return Policy name at Row no $rowno Return Policy not found ! Please create it and than try to import this file again !");

                        return back();
                        break;
                    }

                    $policy = $p->id;

                } else {

                    $policy = 0;

                }

                $childcatname = trim($line['childcategory_name']);
                if (!empty($childcatname) ) {
                    
                    $c = ChildCategory::where("name",$childcatname)->first();

                    if (!isset($c)) {

                        $child = new ChildCategory;
                        $child->name = $childcatname;
                        $child->category_id = $catid->id;
                        $child->sub_category_id = $subcatid->id;
                        $child->save();

                        $childid = $child->id;

                    } else {
                        $childid = $c->id;
                    }

                } else {
                    $childid = '0';
                }

                if(empty($line['price'])){
                    $error++;
                    DB::rollback();

                    notify()->error("Price is empty at Row no $rowno ! Please enter Price !");

                    return back();
                    break;
                }

                if(empty($line['qty'])){
                    $error++;
                    DB::rollback();

                    notify()->error("Quantity is empty or 0 at Row no $rowno ! Please enter Quantity !");

                    return back();
                    break;
                }

                if ($line['featured'] == 0) {
                    $featured = '0';
                } else {
                    $featured = '1';
                }

                if ($line['status'] == 0) {
                    $pstatus = '0';
                } else {
                    $pstatus = '1';
                }

                if ($line['cancel_available'] == 0) {
                    $cancel_available = '0';
                } else {
                    $cancel_available = '1';
                }

                $tax = trim($line['tax']);

                if(empty($tax)){
                    $tax = 0;
                }
                // if($line['cash_on_delivery'] == 0){
                //     $cash_on_delivery= 0;
                // }else{
                //     $cash_on_delivery= 1;
                // }
                
                $prod = Product::create([
                    "name"                 => $productname,
                    "category_id"          => $catid->id,
                    "sub_category_id"      => $subcatid->id,
                    "child_category_id"    => $childid,
                    "description"          => $line['description'],
                    "specification"        => $line['specification'],
                    "price"                => $line['price'],
                    'old_price'            => empty($line['old_price'])?0:$line['old_price'],
                    'qty'                  => $line['qty'],
                    "tax"                  => $tax,
                    // "cash_on_delivery"     => $cash_on_delivery,
                    "cancel_available"     => $cancel_available,
                    "return_available"     => $line['return_available'],
                    "return_policy_id"     => $policy,
                    "status"               => $pstatus,
                    "is_feature"           => $featured
                ]);


                if($error == 0){
                    notify()->success('Products Imported Successfully !', $productfile->count() . ' Imported !');
                    
                    DB::commit();
                    return back();
                }

            }    
        }else {
            notify()->warning('Your excel file is empty !');
            
            $error++;
            DB::rollback();

            return back();
        }

    }

}
