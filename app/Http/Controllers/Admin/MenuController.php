<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Menu;
use App\Models\Page;
use Image;
use Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view("admin.menu.index", compact("menus"));
    }

    public function menu_list_api(Request $request){
        $search = $request->input('search');
        $search_value = $search['value'];
        $start = $request->input('start');
        $limit = $request->input('length');
        $offset = empty($start) ? 0 : $start ;
        $limit =  empty($limit) ? 10 : $limit ;
        
        $menu_detail = Menu::select('id','title','link_by','cat_type','status');

        if(!empty($search_value))
        {   

            $menu_detail = $menu_detail->where(function($query) use ($search_value){
                $query->where('title','LIKE',"%".$search_value."%")
                        ->orwhere('link_by','LIKE',"%".$search_value."%")
                        ->orwhere('cat_type','LIKE',"%".$search_value."%");
            });
        }

        $count = $menu_detail->count();
        $menu_detail = $menu_detail->offset($offset)->limit($limit);

        if(isset($request->input('order')[0]['column'])){
            $data = ['id','title','link_by','cat_type','status'
            ];
            $by = ($request->input('order')[0]['dir'] == 'desc')? 'desc': 'asc';
            $menu_detail->orderBy($data[$request->input('order')[0]['column']], $by);
        }
        else
        {
            $menu_detail->orderBy('id','desc');
        }
        $menu_detaildata = $menu_detail->get()->toArray();
        
        $array['recordsTotal'] = $count;
        $array['recordsFiltered'] = $count ;
        $array['data'] = $menu_detaildata; 
        return json_encode($array);
    }

    public function create()
    {
        $cat = Category::all();
        $subcat = SubCategory::all();
        $pages = Page::all();
        return view("admin.menu.add", compact("cat",'subcat','pages'));
    }

    public function store(Request $request){
        try {
            
            $validation = Validator::make($request->all(),[
                'title'=>'required',
                'link_by'=>'required',
                'menu_cat_type'=>'required_if:link_by,==,cat',
                'linked_parent_cat'=>'required_if:menu_cat_type,==,cat',
                'linked_parent_sub'=>'required_if:menu_cat_type,==,subcat',
                'page_id'=>'required_if:link_by,==,page',
                'url' => 'required_if:link_by,==,url'
            ],[
                'title.required' => 'Title is required.',
                'link_by.required' => 'Linked by is required',
                'menu_cat_type.required_if' => 'Category Type is required if link by is category',
                'linked_parent_cat.required_if' => 'Categories is required if category type is choosen category',
                'linked_parent_sub.required_if' => 'SubCategories is required if category type is sub category',
                'page_id.required_if' => 'Select Page if link by is choosed page',
                'url.required_if'=>'Enter URL if link by is choosed url'
            ]);

            if ($validation->fails()) {
                $validation_arr = $validation->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message = $message.' '.$value;
                    
                }
                
                return back()->with('error',$message);
            }

            $input = $request->all();
            
            if(!empty($input['menu_cat_type'])){
                $input['cat_type'] = $input['menu_cat_type'];
            }
            
            if(isset($input['linked_parent_cat']) && $input['menu_cat_type'] == 'cat'){
                $input['linked_parent'] = $input['linked_parent_cat'];
            }
            
            if(isset($input['linked_parent_sub']) && $input['menu_cat_type'] == 'subcat'){
                $input['linked_parent'] = $input['linked_parent_sub'];
            }
            
            $menu = new Menu;
            $menu->create($input);
            
            notify()->success('Menu is been successfully created');
            return back();

        } catch (\Illuminate\Database\QueryExceptions $e) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
    }

    public function status_update($id){
        
        $f = Menu::findorfail($id);

        if($f->status==1)
        {
            Menu::where('id','=',$id)->update(['status' => "0"]);
            notify()->success("Status changed to Deactive !");
            return back();
        }
        else
        {
            Menu::where('id','=',$id)->update(['status' => "1"]);
            notify()->success("Status changed to Active !");
            return back();
        }
    }

    public function edit($id)
    {
        $cat = Category::all();
        $subcat = SubCategory::all();
        $menu = Menu::find($id);
        $pages = Page::all();
        return view("admin.menu.edit", compact("menu", 'cat', 'subcat','pages'));
    }

    public function update(Request $request, $id){
        try {
            
            $validation = Validator::make($request->all(),[
                'title'=>'required',
                'link_by'=>'required',
                'menu_cat_type'=>'required_if:link_by,==,cat',
                'linked_parent_cat'=>'required_if:menu_cat_type,==,cat',
                'linked_parent_sub'=>'required_if:menu_cat_type,==,subcat',
                'page_id'=>'required_if:link_by,==,page',
                'url' => 'required_if:link_by,==,url'
            ],[
                'title.required' => 'Title is required.',
                'link_by.required' => 'Linked by is required',
                'menu_cat_type.required_if' => 'Category Type is required if link by is category',
                'linked_parent_cat.required_if' => 'Categories is required if category type is choosen category',
                'linked_parent_sub.required_if' => 'SubCategories is required if category type is sub category',
                'page_id.required_if' => 'Select Page if link by is choosed page',
                'url.required_if'=>'Enter URL if link by is choosed url'
            ]);

            if ($validation->fails()) {
                $validation_arr = $validation->errors();
                $message = '';
                foreach ($validation_arr->all() as $key => $value) {
                    $message = $message.' '.$value;
                    
                }
                
                return back()->with('error',$message);
            }

            $input = $request->all();
            
            $menu_update = Menu::find($id);

            if(!empty($input['menu_cat_type'])){
                $input['cat_type'] = $input['menu_cat_type'];
            }
            
            if(isset($input['linked_parent_cat']) && $input['menu_cat_type'] == 'cat'){
                $input['linked_parent'] = $input['linked_parent_cat'];
            }
            
            if(isset($input['linked_parent_sub']) && $input['menu_cat_type'] == 'subcat'){
                $input['linked_parent'] = $input['linked_parent_sub'];
            }
            
            
            $menu_update->update($input);
            $menu_update->save();
            notify()->success('Menu is been successfully updated');
            return back();

        } catch (\Illuminate\Database\QueryExceptions $e) {
            notify()->error('some error occurred'.$ex->getMessage());
            return back();
        }
       
    }

    public function destroy($id)
    {
        $getdata = Menu::find($id);

        $value = $getdata->delete();
        
        if ($value)
        {
            notify()->success('Menu Has Been Deleted');
            
            return redirect("admin/menu");
        }
    }
}