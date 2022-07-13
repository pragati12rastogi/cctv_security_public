<div class="tab-content">
    <!-- Start men popular category -->
    <div class="tab-pane fade in active" id="popular_products">
        
        <ul class="aa-product-catg aa-popular-slider">
        <!-- start single product item -->
        @foreach($popular as $pind => $prod)
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
    <!-- / popular product category -->
    
    <!-- start featured product category -->
    <div class="tab-pane fade" id="featured_products">
        <ul class="aa-product-catg aa-featured-slider">
        <!-- start single product item -->
        @foreach($featured as $find => $prod)
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
    <!-- / featured product category -->

    <!-- start latest product category -->
    <div class="tab-pane fade" id="latest_products">
        <ul class="aa-product-catg aa-latest-slider">
        @foreach($latest as $find => $prod)
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
    <!-- / latest product category -->              
</div>