@extends('layouts.front')
@section('title','Home |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
  <style>
    .carousel-control{
      width: 0% !important;
    }
  </style>
@endsection

@section('content')

  <!-- Start slider -->
  <section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
        <div class="seq-screen">
          <ul class="seq-canvas">
            <!-- single slide item -->
            @if(count($sliders) == 1)
            <li>
              <div class="seq-model banner-image-setting" style="background-image:url('{{url('assets/uploads/slider/'.$sliders[0]->photo)}}');">
                
              </div>
              <div class="seq-title" >                
                <h3 data-seq>{{$sliders[0]->heading}}</h3>                
                <p data-seq class="text-black">{{$sliders[0]->content}}</p>
                <a data-seq href="{{$sliders[0]->button_url}}" class="aa-shop-now-btn aa-secondary-btn bg-black">{{$sliders[0]->button_text}}</a>
              </div>
            </li> 
            @else
            @foreach($sliders as $in => $slide)
            <li>
              <div class="seq-model banner-image-setting" style="background-image:url('{{url('assets/uploads/slider/'.$slide->photo)}}');">
                
              </div>
              <div class="seq-title" >                
                <h2 data-seq>{{$slide->heading}}</h2>                
                <p data-seq class="text-black">{{$slide->content}}</p>
                <a data-seq href="{{$slide->button_url}}" class="aa-shop-now-btn aa-secondary-btn bg-black">{{$slide->button_text}}</a>
              </div>
            </li> 
            @endforeach
            @endif
          </ul>
        </div>
        <!-- slider navigation btn -->
        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>
      </div>
    </div>
  </section>
  <!-- / slider -->
  <!-- Start Offer section -->
  @if($general_settings->offer_section)
  <section id="aa-promo">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-promo-area">
            <div class="row">
              @foreach($offer_chunk as $ind => $chunk)
                <!-- promo left -->
                @php 
                  $offer_col = "col-md-5";
                  if(count($chunk) == 1){
                    $offer_col = "col-md-12";
                  }
                  else if(count($chunk) == 2){
                    $offer_col = "col-md-6";
                  }
                  else if(count($chunk) == 3){
                    $offer_col = "col-md-4";
                  }
                  else if(count($chunk) == 4){
                    $offer_col = "col-md-3";
                  }
                @endphp
                @if(count($chunk)<= 4)

                  @foreach($chunk as $chunk_ind => $chunk_data)
                  <div class="{{$offer_col}} no-padding">                
                    <div class="aa-promo-left">
                      <div class="aa-promo-banner">                    
                        <img src="{{url('assets/uploads/offer/'.$chunk_data['photo'])}}" alt="img">                    
                        <div class="aa-prom-content">
                          @if(!empty($chunk_data['tag']))
                          <span>{{$chunk_data['tag']}}</span>
                          @endif
                          <p class="fa-2x">
                            @if($chunk_data['link_type'] == 'category')
                            <a class="bg-transparent-grey p-2" href="{{url('user/category/'.$chunk_data['category_id'])}}">{{$chunk_data['title']}}</a>
                            @elseif($chunk_data['link_type'] == 'product')
                            <a class="bg-transparent-grey p-2" href="{{url('user/product/'.$chunk_data['product_id'])}}">{{$chunk_data['title']}}</a>
                            @else
                            <a class="bg-transparent-grey p-2" href="{{$chunk_data['url']}}">{{$chunk_data['title']}}</a>
                            @endif
                          </p>  

                          @if($chunk_data['link_type'] == 'category')
                          <p class="bg-transparent-grey mt-2 text-base">
                            {{substr(strip_tags($chunk_data['category']['description']), 0, 100)}}{{strlen(strip_tags($chunk_data['category']['description']))>100 ? '...' : ""}}
                          </p>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                @elseif(count($chunk)== 5)
                  <div class="col-md-5 no-padding">                
                    <div class="aa-promo-left">
                      <div class="aa-promo-banner">                    
                        <img src="{{url('assets/uploads/offer/'.$chunk[0]['photo'])}}" alt="img">                    
                        <div class="aa-prom-content">
                          @if(!empty($chunk[0]['tag']))
                          <span>{{$chunk[0]['tag']}}</span>
                          @endif
                          <p class="fa-2x">
                            @if($chunk[0]['link_type'] == 'category')
                            <a class="bg-transparent-grey p-2" href="{{url('user/category/'.$chunk[0]['category_id'])}}">{{$chunk[0]['title']}}</a>
                            @elseif($chunk[0]['link_type'] == 'product')
                            <a class="bg-transparent-grey p-2" href="{{url('user/product/'.$chunk[0]['product_id'])}}">{{$chunk[0]['title']}}</a>
                            @else
                            <a class="bg-transparent-grey p-2" href="{{$chunk[0]['url']}}">{{$chunk[0]['title']}}</a>
                            @endif
                          </p>   
                          @if($chunk[0]['link_type'] == 'category')
                          <p class="bg-transparent-grey mt-2 text-base">
                            {{substr(strip_tags($chunk[0]['category']['description']), 0, 100)}}{{strlen(strip_tags($chunk[0]['category']['description']))>100 ? '...' : ""}}
                          </p>
                          @endif                   
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- promo right -->
                  <div class="col-md-7 no-padding">
                    <div class="aa-promo-right">
                      <div class="aa-single-promo-right">
                        <div class="aa-promo-banner">                      
                          <img src="{{url('assets/uploads/offer/'.$chunk[1]['photo'])}}" alt="img">                      
                          <div class="aa-prom-content">
                            @if(!empty($chunk[1]['tag']))
                            <span>{{$chunk[1]['tag']}}</span>
                            @endif
                            <p class="">
                              @if($chunk[1]['link_type'] == 'category')
                              <a class="bg-transparent-grey p-2" href="{{url('user/category/'.$chunk[1]['category_id'])}}">{{$chunk[1]['title']}}</a>
                              @elseif($chunk[1]['link_type'] == 'product')
                              <a class="bg-transparent-grey p-2" href="{{url('user/product/'.$chunk[1]['product_id'])}}">{{$chunk[1]['title']}}</a>
                              @else
                              <a class="bg-transparent-grey p-2" href="{{$chunk[1]['url']}}">{{$chunk[1]['title']}}</a>
                              @endif
                            </p>    
                            @if($chunk[1]['link_type'] == 'category')
                            <p class="bg-transparent-grey mt-2 text-base">
                              {{substr(strip_tags($chunk[1]['category']['description']), 0, 100)}}{{strlen(strip_tags($chunk[1]['category']['description']))>100 ? '...' : ""}}
                            </p>
                            @endif                    
                          </div>
                        </div>
                      </div>
                      <div class="aa-single-promo-right">
                        <div class="aa-promo-banner">                      
                          <img src="{{url('assets/uploads/offer/'.$chunk[2]['photo'])}}" alt="img">                      
                          <div class="aa-prom-content">
                            @if(!empty($chunk[2]['tag']))
                            <span>{{$chunk[2]['tag']}}</span>
                            @endif
                            <p class="">
                              @if($chunk[2]['link_type'] == 'category')
                              <a class="bg-transparent-grey p-2" href="{{url('user/category/'.$chunk[2]['category_id'])}}">{{$chunk[2]['title']}}</a>
                              @elseif($chunk[2]['link_type'] == 'product')
                              <a class="bg-transparent-grey p-2" href="{{url('user/product/'.$chunk[2]['product_id'])}}">{{$chunk[2]['title']}}</a>
                              @else
                              <a class="bg-transparent-grey p-2" href="{{$chunk[2]['url']}}">{{$chunk[2]['title']}}</a>
                              @endif
                            </p>   
                            @if($chunk[2]['link_type'] == 'category')
                            <p class="bg-transparent-grey mt-2 text-base">
                              {{substr(strip_tags($chunk[2]['category']['description']), 0, 100)}}{{strlen(strip_tags($chunk[2]['category']['description']))>100 ? '...' : ""}}
                            </p>
                            @endif                     
                          </div>
                        </div>
                      </div>
                      <div class="aa-single-promo-right">
                        <div class="aa-promo-banner">                      
                          <img src="{{url('assets/uploads/offer/'.$chunk[3]['photo'])}}" alt="img">                      
                          <div class="aa-prom-content">
                            @if(!empty($chunk[3]['tag']))
                            <span>{{$chunk[3]['tag']}}</span>
                            @endif
                            <p class="">
                              @if($chunk[3]['link_type'] == 'category')
                              <a class="bg-transparent-grey p-2" href="{{url('user/category/'.$chunk[3]['category_id'])}}">{{$chunk[3]['title']}}</a>
                              @elseif($chunk[3]['link_type'] == 'product')
                              <a class="bg-transparent-grey p-2" href="{{url('user/product/'.$chunk[3]['product_id'])}}">{{$chunk[3]['title']}}</a>
                              @else
                              <a class="bg-transparent-grey p-2" href="{{$chunk[3]['url']}}">{{$chunk[3]['title']}}</a>
                              @endif
                            </p> 
                            @if($chunk[3]['link_type'] == 'category')
                            <p class="bg-transparent-grey mt-2 text-base">
                              {{substr(strip_tags($chunk[3]['category']['description']), 0, 100)}}{{strlen(strip_tags($chunk[3]['category']['description']))>100 ? '...' : ""}}
                            </p>
                            @endif                      
                          </div>
                        </div>
                      </div>
                      <div class="aa-single-promo-right">
                        <div class="aa-promo-banner">                      
                          <img src="{{url('assets/uploads/offer/'.$chunk[4]['photo'])}}" alt="img">                      
                          <div class="aa-prom-content">
                            @if(!empty($chunk[4]['tag']))
                            <span>{{$chunk[4]['tag']}}</span>
                            @endif
                            <p class="">
                              @if($chunk[4]['link_type'] == 'category')
                              <a class="bg-transparent-grey p-2" href="{{url('user/category/'.$chunk[4]['category_id'])}}">{{$chunk[4]['title']}}</a>
                              @elseif($chunk[4]['link_type'] == 'product')
                              <a class="bg-transparent-grey p-2" href="{{url('user/product/'.$chunk[4]['product_id'])}}">{{$chunk[4]['title']}}</a>
                              @else
                              <a class="bg-transparent-grey p-2" href="{{$chunk[4]['url']}}">{{$chunk[4]['title']}}</a>
                              @endif
                            </p> 
                            @if($chunk[4]['link_type'] == 'category')
                            <p class="bg-transparent-grey mt-2 text-base">
                              {{substr(strip_tags($chunk[4]['category']['description']), 0, 100)}}{{strlen(strip_tags($chunk[4]['category']['description']))>100 ? '...' : ""}}
                            </p>
                            @endif                      
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                
                
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif
  <!-- / Offer section -->
  <!-- Products section -->
  <section id="aa-product">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-product-area">
              <div class="aa-product-inner">
                <!-- start prduct navigation -->
                <ul class="col-md-3 nav navbar-default cat-wise-prod">
                  @foreach($category as $ci =>$cd)
                  <li class="{{($ci==0)?'active':''}}"><a href="#cat_prod_{{$cd->id}}" data-toggle="tab">{{$cd->name}}</a></li>
                  @endforeach
                </ul>
                @widget('front_category_wise_product')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Products section -->
  
  <!-- popular section -->
  <section id="aa-popular-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-popular-category-area">
              <!-- start prduct navigation -->
              <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#popular_products" data-toggle="tab">Popular</a></li>
                <li><a href="#featured_products" data-toggle="tab">Featured</a></li>
                <li><a href="#latest_products" data-toggle="tab">Latest</a></li>                    
              </ul>
              <!-- Tab panes -->
              @widget('front_p_f_l_products')
            </div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  <!-- / popular section -->
  <!-- services section -->
  @if($general_settings->service_section)
  <section id="aa-support">
    <div class="container">
      <div class="row">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner" role="listbox">
            @foreach($service_chunk as $ind => $service)
            <div class="item {{$ind==0 ? 'active':''}} col-md-12">
              <div class="aa-support-area">
                @foreach($service as $s_ind => $s_data)
                <!-- single support -->
                <div class=" col-md-3 col-sm-3 col-xs-12">
                  <div class="aa-support-single">
                    <img src="{{'assets/uploads/service/'.$s_data['photo']}}" class="center-block service_imgs" >
                    <h4>{{strtoupper($s_data['title'])}}</h4>
                    <P>{{$s_data['content']}}</P>
                  </div>
                </div>
                
                @endforeach
              </div>
            </div>
            
            @endforeach
          </div>
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        
      </div>
    </div>
  </section>
  @endif
  <!-- / Service section -->

  
@endsection