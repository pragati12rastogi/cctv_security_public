@extends('layouts.front')
@section('title',$products->name .' |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
    <style>
        .rating-scroll{
            max-height: 530px;
            overflow: auto;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css



">
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
  <script>
        var $star_rating = $('.aa-your-rating .fa');

        var SetRatingStar = function() {
        return $star_rating.each(function() {
            
            if (parseInt($('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
        };

        $star_rating.on('click', function() {
        $('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
        });

   
        SetRatingStar();
        
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                loop: true,
                autoplay: true,
                margin: 15,
                dots: false,
                animateIn: true,
                responsiveClass: true,
                navText: [
                    '<i class="fa fa-angle-left btn btn-default btn-xs"></i>',
                    '<i class="fa fa-angle-right btn btn-default btn-xs "></i>'
                ],
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 3,
                        nav: true
                    },
                    1000: {
                        items: 6,
                        nav: true,
                        loop: true
                    }
                }
            });
        });
        
  </script>
@endsection

@section('content')

<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings->product_banner)){
            if(!empty($banner_settings->product_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->product_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->product_banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>{{$products->name}}</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li> 
                    <li><a href="{{url('/user/category/'.$products->category_id)}}">{{$products->category->name}}</a></li>
                    <li><a href="{{url('/user/subcategory/'.$products->sub_category_id)}}">{{$products->subcategory->name}}</a></li>                  
                    @if(!empty($products->child_category_id))
                    <li><a href="{{url('/user/childcategory/'.$products->child_category_id)}}">{{$products->childcategory->name}}</a></li>  
                    @endif
                    <li class="active">{{$products->name}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section id="aa-product-details">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-product-details-area">
                    <div class="aa-product-details-content">
                        <div class="row">
                            <!-- Modal view slider -->
                            <div class="col-md-5 col-sm-5 col-xs-12">                              
                            <div class="aa-product-view-slider">                                
                                <div id="demo-1" class="simpleLens-gallery-container">
                                <div class="simpleLens-container">
                                    <div class="simpleLens-big-image-container"><a data-lens-image="{{url('assets/uploads/product_photos/'.$products['photos'][0]['image'])}}" class="simpleLens-lens-image">
                                        <img src="{{url('assets/uploads/product_photos/'.$products['photos'][0]['image'])}}" class="simpleLens-big-image">
                                    </a></div>
                                </div>
                                
                                <div class="simpleLens-thumbnails-container owl-carousel">
                                    @foreach($products->photos as $ind => $photo)
                                    <a data-big-image="{{url('assets/uploads/product_photos/'.$photo['image'])}}" data-lens-image="{{url('assets/uploads/product_photos/'.$photo['image'])}}" class="item simpleLens-thumbnail-wrapper" href="#">
                                        <img src="{{url('assets/uploads/product_photos/'.$photo['image'])}}" style="height: 50px;width: 50px;">
                                    </a> 
                                    @endforeach                                   
                                    
                                </div>
                                </div>
                            </div>
                            </div>
                            <!-- Modal view content -->
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="aa-product-view-content">
                                    <h3 class="mb-4">{{$products['name']}}</h3>
                                    <div class="aa-price-block">
                                        <span class="aa-product-view-price">Rs. {{$products['price']}}</span>
                                        @if(!empty($products['old_price']))
                                            <span class="aa-product-price"><del>{{$products['old_price']}}</del></span>
                                        @endif
                                        <p class="aa-product-avilability"><b>Avilability: </b> <span class="text-red-600">{{($products['qty']>0) ? (($products['qty']<=5 && $products['qty']>0 )? 'Hurry !! Only '.$products['qty'].' left in stock. ' : 'In stock' ):'Out of stock'}}</span></p>
                                        
                                    </div>
                                    <div class="mt-10">
                                        <h4 class="border-b border-l-4 p-2">Description:</h4>
                                        
                                        <div class=" mt-2">
                                            {!!$products['description']!!}
                                        </div>
                                    </div>
                                    @auth
                                        @if($products['qty']>0)
                                        <div class="aa-prod-quantity">
                                            <div class="row">
                                                <form action="{{url('user/add-to-cart')}}" class="col-md-12 mt-10 " method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$products->id}}">
                                                    <div class="form-group">
                                                        <label>Quantity:</label>
                                                        <select id="order_qty" name="qty" class="border border-l-4 ml-2" style="width: 60px;">
                                                            @for($order_qty=1;$order_qty<=5;$order_qty++)
                                                                @if($order_qty<= $products['qty'])
                                                                <option value="{{$order_qty}}">{{$order_qty}}</option>
                                                                @endif
                                                            @endfor
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" class="aa-add-to-cart-btn" value="Add To Cart">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @endif

                                    @endauth
                                    <div class="aa-prod-view-bottom">
                                        @auth
                                            
                                            @php
                                                $wishlist = App\Models\Wishlist::where('user_id',Auth::user()->id)->where('product_id',$products['id'])->first();
                                            @endphp
                                            
                                            <a href="javascript:void(0)" class="aa-add-to-cart-btn wishlist_btn" data-id="{{$products['id']}}" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                                                <span class="fa {{(empty($wishlist))?'fa-heart-o':'fa-heart'}} wishlist_span_{{$products['id']}}"></span>
                                                Wishlist
                                            </a>                      
                                        @endauth 
                                        @if(!empty($products['datasheet_upload']) || !empty($products['user_manual_upload']))
                                            
                                            @if(!empty($products['datasheet_upload']))
                                                <a href="{{url('assets/uploads/datasheet/'.$products['datasheet_upload'])}}" class="aa-add-to-cart-btn" download>
                                                    Download Datasheet <i class="fa fa-download"></i>
                                                </a>
                                            @endif
                                            
                                            @if(!empty($products['user_manual_upload']))
                                                <a href="{{url('assets/uploads/datasheet/'.$products['user_manual_upload'])}}" class="aa-add-to-cart-btn" download>
                                                    Download User Manual <i class="fa fa-download"></i>
                                                </a>
                                            @endif

                                        @endif
                                    </div>
                                    <div class="aa-prod-view-bottom">
                                    
                                        @if($products['return_available'] == 1)
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#return-policy-view-modal" title="Return Available" class="product-extra-info"><i class="fa fa-retweet"></i></a>
                                        @endif

                                        @if($products['cancel_available'] == 1)
                                        <a href="javascript:void(0)" title="Cancel Available" class="product-extra-info"><i class="fa fa-remove"></i></a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aa-product-details-bottom">
                        <ul class="nav nav-tabs" id="myTab2">
                            <li><a href="#specification" data-toggle="tab">Specification</a></li>
                            <li><a href="#review" data-toggle="tab">Reviews</a></li>                
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="specification">
                                @php
                                    $attr_array = [];
                                    foreach($products->varients_attribute as $att_id => $attr){
                                        $attr_array[$attr->attribute->title][] = $attr->attributeValue->value;
                                    }
                                @endphp
                                @foreach($attr_array as $attr_name => $att_values)
                                    <p><label>{{$attr_name}} : </label> <span> {{implode(',',$att_values)}}</span></p>
                                @endforeach
                                {!!$products['specification']!!}
                            </div>
                            <div class="tab-pane fade " id="review">
                                <div class="aa-product-review-area">
                                    <h4>{{count($reviews)}} Reviews for {{$products['name']}}</h4> 
                                    <ul class="aa-review-nav">
                                        @foreach($reviews as $r_ind => $review)
                                        <li>
                                            <div class="media">
                                                
                                                <div class="media-body">
                                                    <div class="row">
                                                        <div class="col-xs-11">
                                                        <h4 class="media-heading"><strong>{{$review->customer['name']}}</strong> - <span>{{date('F d, Y',strtotime($review->updated_at))}}</span></h4></div>
                                                        @auth
                                                            @if($review->customer_id == Auth::id())
                                                            <div class="col-xs-1 text-right">
                                                                <a href="javascript:void(0)" onclick="$('div#update_review_div').toggle();" ><i class="fa fa-edit"></i></a>
                                                            </div>
                                                            @endif
                                                        @endauth
                                                    </div>
                                                    <div class="aa-product-rating">
                                                        @for($i=1;$i<=5;$i++)
                                                            @if($i>$review['rating'])
                                                            <span class="fa fa-star-o"></span>
                                                            @else
                                                            <span class="fa fa-star"></span>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <p>{{$review->review}}</p>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @auth
                                        @php
                                            $user_rev = App\Models\Review::where(['product_id'=>$products->id,'customer_id'=>Auth::id()])->first();
                                            $placed_order = App\Models\Invoice::where(['product_id'=>$products->id,'user_id'=>Auth::id()])->first();
                                        @endphp
                                        @if(empty($user_rev))
                                            @if(!empty($placed_order))
                                            <h4>Add a review</h4>
                                            <div class="aa-your-rating">
                                                <p>Your Rating</p>
                                                <span class="fa fa-star-o" data-rating="1"></span>
                                                <span class="fa fa-star-o" data-rating="2"></span>
                                                <span class="fa fa-star-o" data-rating="3"></span>
                                                <span class="fa fa-star-o" data-rating="4"></span>
                                                <span class="fa fa-star-o" data-rating="5"></span>

                                            </div>
                                            <!-- review form -->
                                            <form action="{{route('save.rating')}}" class="aa-review-form" method="post">
                                                @csrf

                                                
                                                <input type="hidden" name="rating" class="rating-value" value="5">
                                                <input type="hidden" name="product_id" value="{{$products->id}}">
                                                <input type="hidden" name="customer_id" value="{{Auth::id()}}">

                                                <div class="form-group">
                                                    <label for="message">Your Review</label>
                                                    <textarea class="form-control" name="review" rows="3" id="message"></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-default aa-review-submit">Submit</button>
                                            </form>
                                            @endif
                                        @else
                                        <div id="update_review_div" style="display:none">
                                            <h4><u>Edit a review</u></h4>
                                            <div class="aa-your-rating mt-4">
                                                <p>Your Rating</p>
                                                <span class="fa fa-star-o" data-rating="1"></span>
                                                <span class="fa fa-star-o" data-rating="2"></span>
                                                <span class="fa fa-star-o" data-rating="3"></span>
                                                <span class="fa fa-star-o" data-rating="4"></span>
                                                <span class="fa fa-star-o" data-rating="5"></span>

                                            </div>
                                            <!-- review form -->
                                            <form action="{{route('update.rating',$user_rev->id)}}" class="aa-review-form" method="post">
                                                @csrf

                                                <input type="hidden" name="rating" class="rating-value" value="{{$user_rev->rating}}">
                                                <input type="hidden" name="product_id" value="{{$products->id}}">
                                                <input type="hidden" name="customer_id" value="{{Auth::id()}}">

                                                <div class="form-group">
                                                    <label for="message">Your Review</label>
                                                    <textarea class="form-control" name="review" rows="3" id="message">{{$user_rev->review}}</textarea>
                                                </div>

                                                <button type="submit" class="btn btn-default aa-review-submit">Update</button>
                                            </form>
                                        </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>            
                        </div>
                    </div>
                    <!-- Related product -->
                    <div class="aa-product-related-item mt-12">
                        <h3>Related Products</h3>
                        <ul class="aa-product-catg aa-related-item-slider">
                            <!-- start single product item -->
                            @foreach($related_prod as $ind =>$prod)
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
                        </ul>
                    
                    </div>  
                </div>
                @if($products['return_available'] == 1)
                <!-- return-policy-view-modal -->                  
                <div class="modal fade" id="return-policy-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Return Policy</h4>
                            </div>                      
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Modal view slider -->
                                    <div class="col-md-12 col-sm-6 col-xs-12">                              
                                        {!!$products->return_policy['description']!!}
                                    </div>
                                    
                                </div>
                            </div>                        
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- / return-policy-view-modal --> 
                @endif 
            </div>
        </div>
    </div>
  </section>

@endsection