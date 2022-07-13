@extends('layouts.front')
@section('title','Wishlist |')

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
            if(!empty($banner_settings->wishlist_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->wishlist_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->wishlist_banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Wishlist Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Wishlist</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Cart view section -->
<section id="cart-view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-view-area">
                    <div class="cart-view-table aa-wishlist-table">
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Stock Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($wishlist) >0)
                                    @foreach($wishlist as $in => $wish)
                                    <tr>
                                        <td><a href="#"><img src="{{url('assets/uploads/product_photos/'.$wish['product']['photos'][0]['image'])}}" alt="img"></a></td>
                                        <td><a class="aa-cart-title" href="{{url('user/product/'.$wish['id'])}}">{{$wish['product']['name']}}</a></td>
                                        <td>{{$wish['product']['price']}}</td>
                                        <td>{{($wish['product']['qty']>0)?'In Stock':'Out Of Stock'}}</td>
                                        <td>
                                            <a onclick="event.preventDefault();document.getElementById('wishlist-add-to-cart_{{$in}}').submit();" class="aa-add-to-cart-btn">Add To Cart</a> &nbsp; 
                                            <a class=" aa-add-to-cart-btn" href="{{url('user/remove-to-wishlist/'.$wish['id'])}}" >
                                            <fa class="fa fa-close " ></fa></a>
                                            <form id="wishlist-add-to-cart_{{$in}}" action="{{url('user/add-to-cart')}}" class="display-none" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$wish['product_id']}}">
                                                <input type="hidden" name="qty" value="1">
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" >Nothing in your Wishlist</td>
                                        </tr>
                                    @endif                    
                                </tbody>
                            </table>
                        </div>
                                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 <!-- / Cart view section -->

@endsection