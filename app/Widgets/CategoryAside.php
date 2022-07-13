<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Category;

class CategoryAside extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'cat_id' => 0,
        'sub_id' => 0
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $all_cat = Category::with(['subcategory'=>function($q){
            return $q->where('status',1);
        }])->with(['subcategory.childcategory'=>function($q){
            return $q->where('status',1);
        }])->where('status',1)->get();

        return view('widgets.category_aside', [
            'config' => $this->config,
            'all_cat'=>$all_cat,
        ]);
    }
}
