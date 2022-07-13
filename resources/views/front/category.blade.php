@extends('layouts.front')
@section('title',$category["name"].' |')

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
                    <li class="active">{{$category['name']}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Category Product section -->
<section id="aa-product-category" class="mt-16">
    <div class="container">
        @if(!empty($category['description']))
        <div class="row">
            <div class="col-md-12 well bg-gray-50">
                <p>{{$category['description']}}</p>
            </div>
        </div>
        @endif
      <div class="row">
        
        <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
          @foreach($category['subcategory'] as $sub_index => $sub)
          @if(count($sub['products'])>0)
          <div class="aa-product-catg-content border-b">
            <div class="col-md-12 ">
                <h2 style="display:inline">{{$sub['name']}}</h2>
                <a class="aa-browse-btn" href="{{url('user/subcategory/'.$sub['id'])}}" style="float:right" >Show All<span class="fa fa-long-arrow-right"></span></a>
            </div>
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg ">
                <!-- start single product item -->
                @foreach($sub['products'] as $pro_id => $prod)
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
            
          </div>
          @endif
          @endforeach
        </div>
        @widget('category_aside',['cat_id'=>$cat_id])
        
      </div>
    </div>
  </section>
 <!-- / Cart view section -->

@endsection