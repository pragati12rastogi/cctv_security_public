<!-- Tab panes -->
<div class="tab-content col-md-9">
    <!-- Start product category -->
    @foreach( $category  as $cin => $cd)
    
    <div class=" tab-pane fade {{($cin==0)?'in active':''}}" id="cat_prod_{{$cd['id']}}">
        <div class="col-md-12 p-0 mb-4 mt-2">
            <a class="aa-browse-btn" style="float:right" href="{{url('user/category/'.$cd['id'])}}">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
        </div>
        <ul class="aa-product-catg">
            <!-- start single product item -->
            @if(count($cd['products'])>0)
            @foreach($cd['products'] as $ind  => $prod)
            
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
            <!-- start single product item -->
            @endforeach
            @else
            <div style="margin-left: 80px;"><p>No products present.</p></div> 
            @endif                       
        </ul>
    </div>
    @endforeach
    <!-- / product category -->
</div>
    <!-- quick view modal --> 