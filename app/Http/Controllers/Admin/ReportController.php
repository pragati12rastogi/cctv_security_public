<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use DB;

class ReportController extends Controller
{
    public function stock_report(){
        $stock = Product::all();
        return view('admin.report.stock',compact('stock'));
    }

    public function sale_report(){
        return view('admin.report.sale');
    }

    public function sale_report_api(Request $request){
        $search = $request->input('search');
        $search_value = $search['value'];
        $start = $request->input('start');
        $limit = $request->input('length');
        $offset = empty($start) ? 0 : $start ;
        $limit =  empty($limit) ? 10 : $limit ;
        $from = $request->startDate;
        $to = $request->endDate;

        $menu_detail = Invoice::leftjoin('products','products.id','invoices.product_id')
            ->leftjoin('categories','categories.id','products.category_id')
            ->leftjoin('sub_categories','sub_categories.id','products.sub_category_id')
            ->leftjoin('child_categories','child_categories.id','products.child_category_id')
            ->leftjoin('product_photos', function($join)
            {
                $join->on('product_photos.product_id', '=', 'products.id')
                    ->where('product_photos.default_image', '=', '1');
            })
            ->select('products.name as pname','sub_categories.name as sub_cat','categories.name as cat','child_categories.name as child','product_photos.image as product_image','invoices.qty','invoices.total_amount','invoices.shipping_rate',DB::raw('DATE_FORMAT(tbl_invoices.updated_at,"%d-%m-%Y")as  updated'))->where('order_product_status', '=', 'delivered');

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

        if(!empty($from) && !empty($to)){
            $menu_detail = $menu_detail->whereBetween(DB::raw('DATE_FORMAT(tbl_invoices.updated_at,"%Y-%m-%d")'), [$from,$to]);
        }elseif(!empty($from)){
            $menu_detail = $menu_detail->whereDate('invoices.updated_at','>=',$from);
        }elseif(!empty($to)){
            $menu_detail = $menu_detail->whereDate('invoices.updated_at','<=',$to);
        }

        $count = $menu_detail->count();
        $menu_detail = $menu_detail->offset($offset)->limit($limit);

        if(isset($request->input('order')[0]['column'])){
            $data = ['products.id','product_photos.image','pname','categories.name','sub_categories.name','child_categories.name','products.status','invoices.qty','invoices.total_amount','invoices.shipping_rate','updated'
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
}
