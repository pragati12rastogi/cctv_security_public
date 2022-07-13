@extends('layouts.front')
@section('title','Search: '.$search.' |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
    
    <style>
        .filter-dropdown{
            width: 400px;
            
        }
        
    </style>
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
                <h2>{{$search}}</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    
                    <li class="active">Search </li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Category Product section -->
<section id="aa-product-category" class="mt-16">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                
                
                <div class="aa-product-catg-content ">
                    <div class="aa-product-catg-head">
                        <div class="aa-product-catg-head-left">
                            We found <span class="text-red-600">{{count($products)}}</span> Items for : <b>{{$search}}</b>
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
                                    <img src="{{url('assets/uploads/product_photos/'.$prod['photos'][0]['image'])}}" alt="{{$prod['name']}}" style="height:300px">
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
                    
                    @endif
                </div>
            </div>
            @widget('category_aside')
            
        </div>
    </div>
  </section>
 <!-- / Cart view section -->

@endsection