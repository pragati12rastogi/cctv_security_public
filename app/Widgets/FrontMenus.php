<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Menu;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Page;

class FrontMenus extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */

    
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $getmenu = Menu::where('status',1)->orderBy('id','ASC')->get()->toArray();

        // form new arrary according menu type

        $new_menu_arr = [];
        $final_menu_arr = [];
        foreach($getmenu as $ind => $menu){
            $new_menu_arr['title'] = $menu['title'];
            $new_menu_arr['menu_type'] = $menu['link_by'];
            if( $menu['link_by'] == "cat"){
                $new_menu_arr['cat_type'] = $menu['cat_type'];
                if($menu['cat_type'] == "cat"){

                    $get_cat = Category::with(['subcategory'=>function($q){
                        return $q->where('status',1);
                    }])->whereIn('id',$menu['linked_parent'])
                    ->where('status',1)->get()->toArray();

                    $new_menu_arr['parent_cat'] = $get_cat;

                }else if($menu['cat_type'] == "subcat"){

                    $get_subcat = SubCategory::with(['childcategory'=>function($q){
                        return $q->where('status',1);
                    }])->whereIn('id',$menu['linked_parent'])
                    ->where('status',1)->get()->toArray();
                    
                    $new_menu_arr['parent_cat'] = $get_cat;

                }

            }elseif($menu['link_by'] == "url"){

                $new_menu_arr['link'] = $menu['url'];

            }elseif($menu['link_by'] == "page"){

                $get_page = Page::whereIn('id',$menu['page_id'])->where('status',1)->get()->toArray();
                $new_menu_arr['pages'] = $get_page;

            }

            $final_menu_arr[] = $new_menu_arr;
        }

        return view('widgets.front_menus', [
            'config' => $this->config,
            'main_menus'=> $final_menu_arr,
        ]);
    }
}
