<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Category;
use DB;
class FrontCategoryWiseProduct extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
     
    protected $config = [
        'count'=> 6
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        
        $category = Category::with(['products'=> function($q){
            return $q->with(['photos'=>function($q){
                return $q->where('default_image',1);
            }])->whereHas('photos')->where('status',1)->orderBy('id','desc')->limit($this->config['count']);
        }])->where('status',1)->get()->toArray();

        return view('widgets.front_category_wise_product', [
            'config'   => $this->config,
            'category' => $category,
        ]);
    }
}
