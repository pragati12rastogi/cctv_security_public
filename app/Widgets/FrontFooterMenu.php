<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use DB;
use App\Models\FooterMenu;
use App\Models\Category;
use App\Models\Page;

class FrontFooterMenu extends AbstractWidget
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
        $footer = FooterMenu::where('widget_name','<>','')->whereNotNull('widget_name')->get()->toArray();
        
        $footer_new_arr = [];
        foreach($footer as $ind => $widget){
            $foot['widget'] = $widget['widget_name'];
            $foot['link_type'] = $widget['link_type'];

            if($widget['link_type'] == 'url'){

                $foot['links'] = array_combine($widget['title'],$widget['url']);

            }else if($widget['link_type'] == 'page'){

                $get_page = Page::whereIn('id',$widget['page_ids'])->where('status',1)->get()->toArray();
                $foot['page'] = $get_page;

            }else if($widget['link_type'] == 'category'){

                $get_category = Category::whereIn('id',$widget['category_ids'])->where('status',1)->get()->toArray();
                $foot['category'] = $get_category;
            }

            $footer_new_arr[] = $foot;
        }

        return view('widgets.front_footer_menu', [
            'config' => $this->config,
            'footer' => $footer_new_arr,
        ]);
    }
}
