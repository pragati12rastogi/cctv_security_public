<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Product;

class FrontPFLProducts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'count' => 20,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $popular = Product::whereHas('invoices')->with(['photos'=>function($q){

            return $q->where('default_image',1);

        }])->whereHas('photos')->withCount('invoices')->orderBy('invoices_count', 'desc')->limit($this->config['count'])->get()->toArray();

        $featured = Product::with(['photos'=>function($q){

            return $q->where('default_image',1);

        }])->whereHas('photos')->where(['is_feature'=>1,'status'=>1])->inRandomOrder()->limit($this->config['count'])->get()->toArray();

        $latest = Product::with(['photos'=>function($q){

            return $q->where('default_image',1);

        }])->whereHas('photos')->where(['status'=>1])->orderBy('id','Desc')->limit($this->config['count'])->get()->toArray();

        return view('widgets.front_p_f_l_products', [
            'config' => $this->config,
            'popular' => $popular,
            'featured' => $featured,
            'latest' => $latest
        ]);
    }
}
