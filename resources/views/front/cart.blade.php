@extends('layouts.front')
@section('title','Cart |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
  
@endsection

@section('js')
    <script>
        
        function cartQuantityUpdateFn(qty_input){
            
            var input_id = $(qty_input).attr('id');
            var split_id = input_id.split('_');
            var cart_row = split_id[1];
            var qty = qty_input.value;
            if(qty <= 0){
                swal("Cart Quantity", "Quantity should be atleat 1!", "error");
            }else{
                if(qty>5){
                    swal("Cart Quantity", "Quantity cannot be more than 5!", "error");
                }else{
                    $.ajax({
                        
                        type:"GET",
                        dataType:"Json",
                        url:"{{url('user/update-qty-to-cart')}}",
                        data:{'cart_id':cart_row,'qty':qty},
                        success:function(result){
                            if(result.status == 'success'){
                                $("#cartrowtotal_"+cart_row).text('Rs.'+result.row_total_amount);
                                $("#final_old_total").text('Rs.'+result.old_amt_and_qty);
                                $("#final_total_discount").text('(-) Rs.'+result.total_discount);
                                $("#final_actual_total").text('Rs.'+result.actual_amt_and_qty);
                            }else{
                                swal("Cart", result.message , result.status);
                            }
                            
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest.responseJSON.message);
                        }

                    })
                }
            }
        }
        
    </script>
@endsection

@section('content')

<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings)){
            if(!empty($banner_settings->cart_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->cart_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->cart_banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Cart Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Cart</li>
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
                    @include('flash-message')
                    <div class="cart-view-table">
             
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $cart_old_total    = 0;
                                        $cart_actual_total = 0;
                                        $total_discount =0;
                                        $shipping = 0;
                                    @endphp
                                    @foreach($carts as $c_in => $cart)
                                        
                                    <tr>
                                        <td>
                                            <a class="remove" onclick="event.preventDefault();document.getElementById('cart-table-item-delete_{{$c_in}}').submit();"><fa class="fa fa-close"></fa></a>
                                            <form id="cart-table-item-delete_{{$c_in}}" action="{{url('user/add-to-cart/'.$cart['id'])}}" method="POST" class=" display-none">
                                                {{csrf_field()}}
                                                {{method_field("DELETE")}}
                                            </form>
                                        </td>
                                        <td><a class="aa-cartbox-img" href="{{url('user/product/'.$cart['product']['id'])}}">
                                            @if(!empty($cart['product']['photos']) && file_exists('assets/uploads/product_photos/'.$cart['product']['photos'][0]['image']) )
                                                <img src="{{url('assets/uploads/product_photos/'.$cart['product']['photos'][0]['image'])}}" alt="">
                                            @else
                                                <img class="img-responsive" src="{{url('/front/img/no-image.jpg')}}">
                                            @endif
                                            
                                        </a></td>
                                        <td><a class="aa-cart-title" href="{{url('user/product/'.$cart['product']['id'])}}">{{$cart['product']['name']}}</a></td>
                                        <td>Rs.{{$cart['actual_price']}} 
                                            @if(!empty($cart['old_amount']))
                                            <span class="aa-product-price"><del>{{$cart['old_amount']}}</del></span>
                                            @endif
                                        </td>
                                        <td><input class="aa-cart-quantity" min="1" max="5" type="number" id="cartqtyrow_{{$cart['id']}}" value="{{$cart['qty']}}" onchange="cartQuantityUpdateFn(this)"></td>
                                        <td id="cartrowtotal_{{$cart['id']}}">Rs.{{($cart['qty']*$cart['actual_price'])}}</td>
                                    </tr>
                                        @php
                                            $cart_old_total = $cart_old_total+($cart['qty']*$cart['old_amount']);
                                            $cart_actual_total = $cart_actual_total+($cart['qty']*$cart['actual_price']);

                                            if(!empty($cart['old_amount'])){
                                                $total_discount = $total_discount+(($cart['old_amount']-$cart['actual_price'])*$cart['qty']);
                                            }
                                            $shipping +=  $cart['shipping'];
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="aa-cart-view-bottom">
                                            
                                            <a href="{{url('/')}}" class="aa-cart-view-btn">Update Cart</a>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
             
                        <!-- Cart Total view -->
                        <div class="cart-view-total">
                            <h4>Cart Totals</h4>
                            <table class="aa-totals-table">
                                <tbody>
                                    @if($cart_old_total>0)
                                    <tr>
                                        <th>Total Cost</th>
                                        <td id="final_old_total">Rs.{{$cart_old_total}}</td>
                                    </tr>
                                    <tr>
                                        <th>Savings</th>
                                        <td id="final_total_discount">(-) Rs.{{$total_discount}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>
                                            Shipping Rate
                                        </th>
                                        <td>
                                            Rs. {{$shipping}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total</th>
                                        <td id="final_actual_total">Rs.{{$cart_actual_total+$shipping}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{url('user/checkout')}}" class="aa-cart-view-btn">Proced to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 <!-- / Cart view section -->

@endsection