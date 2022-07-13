@extends('layouts.front')
@section('title',$childcat['name'].' |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
  
@endsection

@section('js')
  
@endsection

@section('content')

<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings)){
            if(!empty($banner_settings->category_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->category_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->category_banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2></h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li><a href="{{url('/user/category/'.$cat_id)}}">{{$childcat['category']['name']}}</a></li>
                    <li><a href="{{url('/user/subcategory/'.$sub_id)}}">{{$childcat['subcategory']['name']}}</a></li>
                    <li class="active">{{$childcat['name']}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Category Product section -->
<section id="aa-product-category" class="mt-16">
    <div class="container">
        @if(!empty($childcat['description']))
        <div class="row">
            <div class="col-md-12 well bg-gray-50">
                <p>{{$childcat['description']}}</p>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                
                
                <div class="aa-product-catg-content ">
                    <div class="aa-product-catg-head">
                        <div class="aa-product-catg-head-left">
                            <form action="{{url('user/childcategory/'.$childcat['id'])}}" class="aa-sort-form" method="POST">
                                @csrf
                                <label class="d-inline" >Find By <i class="fa fa-filter"></i>:</label>
                                @foreach($filter_attr as $ind => $filter)
                                <div class="dropdown d-inline p-2">
                                    <button class="dropdown-toggle" type="button" data-toggle="dropdown">{{$filter['title']}}
                                    </button>
                                    <div class="dropdown-menu filter-dropdown panel-body">
                                        @if($filter['attr_type']== "radio")
                                            @foreach($filter['attribute_value'] as $att_ind => $attr)
                                                <label class="radio-inline ml-4">
                                                    <input type="radio" name="filter[{{$filter['id']}}]" value="{{$attr['id']}}"
                                                    {{(!empty($filters_req)) ? (isset($filters_req[$filter['id']]) ? ($filters_req[$filter['id']] == $attr['id'] ) ?'checked':'' : '')  : ''}}>{{$attr['value']}}</label>
                                            @endforeach
                                        @else
                                            @if($filter['attr_type']== "checkbox")

                                                @foreach($filter['attribute_value'] as $att_ind => $attr)
                                                <label class="checkbox-inline ml-4">
                                                    <input type="checkbox" name="filter[{{$filter['id']}}][]" value="{{$attr['id']}}"
                                                    {{(!empty($filters_req)) ? (isset($filters_req[$filter['id']]) ? (in_array($attr['id'],$filters_req[$filter['id']]) ) ?'checked':'' : '')  : ''}}>{{$attr['value']}}</label>
                                                @endforeach
                                            @endif
                                        @endif

                                        
                                        
                                    </div>
                                    
                                </div>
                                
                                @endforeach
                                <button type="submit" class="btn btn-default btn-xs" style="margin-top: -5px;"><i class="fa fa-check"></i></button>
                                
                            </form>
                            @if(!empty($filters_req))
                                <form action="{{url('user/childcategory/'.$childcat['id'])}}" class="" method="GET">
                                
                                <a href="" type="submit" class="btn btn-default btn-xs" style="margin-top: -5px;">Clear All</a>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if(count($products)>0)                   
                    <div class="aa-product-catg-body">
                        <ul class="aa-product-catg ">
                            <!-- start single product item -->
                            @foreach($products as $prod_ind => $prod)
                            <li>
                            <figure>
                                <a class="aa-product-img" href="{{url('user/product/'.$prod['id'])}}">
                                @if(!empty($prod['photos']) && file_exists('assets/uploads/product_photos/'.$prod['photos'][0]['image']) )
                                    <img src="{{url('assets/uploads/product_photos/'.$prod['photos'][0]['image'])}}" alt="{{$prod['name']}}" style="height:300px">
                                @else
                                    <img style="height:300px" src="{{url('/front/img/no-image.jpg')}}">
                                @endif
                                </a>
                                <a class="aa-add-card-btn"href="{{url('user/product/'.$prod['id'])}}">
                                    <span class="fa fa-arrow-circle-right"></span>View Details
                                </a>

                                <figcaption>
                                    <h4 class="aa-product-title"><a href="{{url('user/product/'.$prod['id'])}}">{{$prod['name']}}</a></h4>
                                    <span class="aa-product-price">Rs. {{$prod['price']}}</span>
                                    @if(!empty($prod['old_price']))
                                        <span class="aa-product-price"><del>{{$prod['old_price']}}</del></span>
                                    @endif
                                    
                                </figcaption>
                            </figure> 
                                <div class="aa-product-hvr-content">
                                @auth
                                    @php
                                        $wishlist = App\Models\Wishlist::where('user_id',Auth::user()->id)->where('product_id',$prod['id'])->first();
                                    @endphp
                                    
                                    <a href="javascript:void(0)" class="wishlist_btn" data-id="{{$prod['id']}}" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                                        <span class="fa {{(empty($wishlist))?'fa-heart-o':'fa-heart'}} wishlist_span_{{$prod['id']}}"></span>
                                    </a>                      
                                @endauth                       
                            </div>
                            <!-- product badge -->
                            @if(!empty($prod['old_price']))
                            <span class="aa-badge aa-sale" href="#">SALE!</span>
                            @endif
                            </li>
                            @endforeach
                            <!-- start single product item -->       
                        </ul>
                        
                    </div>
                    <div style="display: inline-block;" class="mb-4">
                        {!!$products->links()!!}
                        
                    </div>
                    @else
                    <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                        <p>No product present in this category!!</p>
                    </div>
                    @endif
                </div>
            </div>
            @widget('category_aside',['cat_id'=>$cat_id,'sub_id'=>$sub_id])
            
        </div>
    </div>
  </section>
 <!-- / Cart view section -->

@endsection