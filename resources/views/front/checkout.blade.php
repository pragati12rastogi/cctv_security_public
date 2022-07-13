@extends('layouts.front')
@section('title','Checkout |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
  
@endsection

@section('js')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>
<script>
    
    
    $(function () {

        
        $(".panel").on("show.bs.collapse hide.bs.collapse", function(e) {
            if (e.type=='show'){
                localStorage.setItem('activePanel', e.target.id);
            }
        });
        var activeTab = localStorage.getItem('activePanel');
        
        if(activeTab){
            $(".panel-collapse").removeClass('in');
            $('#'+activeTab).addClass('in');
        }

        $('#shipping_address_form').validate({ // initialize the plugin
            rules: {

                first_name: {
                    required: true,
                    maxlength: 100
                },
                last_name:{
                    required:true,
                    maxlength:100
                },
                email:{
                    required:true
                },
                phone:{
                    required:true
                },
                address: {
                    required:true
                },
                country_id:{
                    required:true
                },
                state_id:{
                    required:true
                },
                city:{
                    required:true
                },
                zipcode:{
                    required:true
                }

            }
        });

        $('#billing_address_form').validate({ // initialize the plugin
            rules: {

                first_name: {
                    required: true,
                    maxlength: 100
                },
                last_name:{
                    required:true,
                    maxlength:100
                },
                email:{
                    required:true
                },
                phone:{
                    required:true
                },
                address: {
                    required:true
                },
                country_id:{
                    required:true
                },
                state_id:{
                    required:true
                },
                city:{
                    required:true
                },
                zipcode:{
                    required:true
                }

            }
        });

        <?php
            if(!empty(Session::get('billing_address'))){
        ?>
            $('#billing_country_id').trigger('change');
        <?php
            }
        ?>
        $('#shipping_country_id').trigger('change');
    });
    
    $('.country_state').change(function(){
        var country_value = this.value;
        var get_id = $(this).attr('id');
        var split_id = get_id.split('_');
        var get_type = split_id[0];
        var append_id ='';
        if(get_type == "shipping"){
            append_id = "#shipping_state_id";
        }else if(get_type == "billing"){
            append_id = "#billing_state_id";
        }

        if(append_id != ''){
            $(append_id).empty();
            $.ajax({
                type:"GET",
                url:"{{url('user/get/country/state/')}}"+"/"+country_value,
                dataType:"JSON",
                success:function(result){
                    $(append_id).append(result);
                },
                error:function(XMLHttpRequest){
                    console.log(XMLHttpRequest.responseJSON.message);
                }
            });
        }
    })

    function AppendShippingDetail(same){

        $("#billing_error_msg").empty();
        var check = $(same).is(':checked');
        if(check == true){
            if(same.value == ''){
                
                $("#billing_error_msg").text('Please fill shipping details first');
            
            }else{

                $("#billing_first_name").val($("#shipping_first_name").val());
                $("#billing_last_name").val($("#shipping_last_name").val());
                $("#billing_email").val($("#shipping_email").val());
                $("#billing_phone").val($("#shipping_phone").val());
                $("#billing_address").val($("#shipping_address").val());
                $("#billing_country_id").val($("#shipping_country_id").val());
                $('#billing_country_id').trigger('change');

                $("#billing_state_id").val($("#shipping_state_id").val());
                $("#billing_suit_no").val($("#shipping_suit_no").val());
                $("#billing_city").val($("#shipping_city").val());
                $("#billing_zipcode").val($("#shipping_zipcode").val());

            }

        }else{

            if(same.value == ''){
                
                $("#billing_error_msg").text('Please fill shipping details first');
            
            }
            $("#billing_first_name").val('');
            $("#billing_last_name").val('');
            $("#billing_email").val('');
            $("#billing_phone").val('');
            $("#billing_address").val('');
            $("#billing_country_id").val('');
            $('#billing_country_id').trigger('change');

            $("#billing_state_id").val('');
            $("#billing_suit_no").val('');
            $("#billing_city").val('');
            $("#billing_zipcode").val('');
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
                <h2>Checkout Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Checkout</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section id="checkout">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="checkout-area">
                @include('flash-message')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="checkout-left">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default aa-checkout-login">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                Client Login 
                                            </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in ">
                                            <div class="panel-body">
                                                <p class="font-size14">
                                                <b><i class="text-green fa fa-check-square-o" aria-hidden="true"></i>
                                                    {{ Auth::user()->name }}</b> </p>
                                                <p class="font-weight500"><i class="text-green fa fa-check-square-o" aria-hidden="true"></i>
                                                {{ Auth::user()->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Shipping Address -->
                                    <div class="panel panel-default aa-checkout-billaddress">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                Shippping Address
                                            </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse ">
                                            <form id="shipping_address_form" action="{{url('user/checkout-user-shipping-address')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="shipping_address_id" value="{{isset($shipping) ? $shipping['id'] :''}}">
                                                
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="aa-checkout-single-bill">
                                                                <label>First Name *</label>
                                                                <input type="text" id="shipping_first_name" name="first_name" onKeyPress="this.value = this.value.replace(/\s/g,'');" placeholder="First Name*" value="{{isset($shipping) ? $shipping['first_name']:''}}">
                                                            </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="aa-checkout-single-bill">
                                                                <label>Last Name *</label>
                                                                <input type="text" id="shipping_last_name" name="last_name" onKeyPress="this.value = this.value.replace(/\s/g,'');" placeholder="Last Name*" value="{{isset($shipping) ? $shipping['last_name']:''}}">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Email *</label>
                                                            <input type="email" name="email" id="shipping_email" placeholder="Email Address*" value="{{isset($shipping) ? $shipping['email']:''}}">
                                                        </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Phone *</label>
                                                            <input type="text" id="shipping_phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" placeholder="Phone*" value="{{isset($shipping) ? $shipping['phone']:''}}">
                                                        </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Address *</label>
                                                            <textarea cols="8" id="shipping_address" name="address" rows="3" placeholder="Address*">{{isset($shipping) ? $shipping['address']:''}}</textarea>
                                                        </div>                             
                                                        </div>                            
                                                    </div>   
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Country *</label>
                                                            <select name="country_id" id="shipping_country_id" class="country_state">
                                                                <option value="">Select Your Country</option>
                                                                @foreach($country as $c_ind => $c)
                                                                    <option value="{{$c->id}}" {{isset($shipping) ? (($shipping['country_id'] == $c->id)? 'selected':'' ):''}} >{{$c->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>                             
                                                        </div>                            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>State *</label>
                                                            <select type="text" name="state_id" id="shipping_state_id">
                                                                <option value="">Select State</option>
                                                            </select>
                                                        </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Appartment </label>
                                                            <input type="text" id="shipping_suit_no" value="{{isset($shipping) ? $shipping['suit_no']:''}}" name="suit_no" maxlength="200" placeholder="Appartment, Suite etc.">
                                                        </div>                             
                                                        </div>
                                                        
                                                    </div>   
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>City *</label>
                                                            <input type="text" id="shipping_city" name="city" value="{{isset($shipping) ? $shipping['city']:''}}" maxlength="240" placeholder="City / Town*">
                                                        </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Zipcode *</label>
                                                            <input type="text" id="shipping_zipcode" name="zipcode" value="{{isset($shipping) ? $shipping['zipcode']:''}}" minlength="6" maxlegth ="6" placeholder="Postcode / ZIP*">
                                                        </div>
                                                        </div>
                                                    </div> 
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <input type="submit" class="aa-browse-btn">
                                                        </div>                             
                                                        </div>                            
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Billing Details -->
                                    <div class="panel panel-default aa-checkout-billaddress">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                Billing Details
                                            </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse ">
                                            <form action="{{url('user/add/billing/address')}}" method="post" id="billing_address_form">
                                                @csrf
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">
                                                                <label class="checkbox-inline"><input style="height: auto;width: auto;" type="checkbox" onclick="AppendShippingDetail(this)" name="is_same" value="{{isset($shipping) ? $shipping['id'] :''}}"
                                                                {{( !empty(Session::get('billing_address')) ? ( !empty(Session::get('billing_address')['is_same']) ? 'checked' : '' ) : '' )}}> Same as Shipping Address</label>
                                                            </div> 
                                                            <span class="text-red-600" id="billing_error_msg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>First Name *</label>
                                                            <input type="text" name="first_name" id="billing_first_name" placeholder="First Name*" value="{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['first_name']  : '') }}">
                                                        </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Last Name *</label>
                                                            <input type="text" name="last_name" id="billing_last_name" value="{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['last_name']  : '') }}"  placeholder="Last Name*">
                                                        </div>
                                                        </div>
                                                    </div> 
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Email Address *</label>
                                                            <input type="email" name="email" id="billing_email" placeholder="Email Address*" value="{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['email']  : '') }}">
                                                        </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Phone *</label>
                                                            <input type="text" id="billing_phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" placeholder="Phone*" value="{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['phone']  : '') }}">
                                                        </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <lable>Address *</lable>
                                                            <textarea cols="8" rows="3" name="address" id="billing_address" placeholder="Address*">{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['address']  : '') }}</textarea>
                                                        </div>                             
                                                        </div>                            
                                                    </div>   
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Country *</label>
                                                            <select name="country" id="billing_country_id" class="country_state">
                                                                <option value="">Select Your Country</option>
                                                                @foreach($country as $c_ind => $c)
                                                                    <option value="{{$c->id}}" {{!empty(Session::get('billing_address')) ? ((Session::get('billing_address')['country'] == $c->id)? 'selected':'' ):''}} >{{$c->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>                             
                                                        </div>                            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>State *</label>
                                                            <select type="text" name="state_id" id="billing_state_id">
                                                                <option value="">Select State</option>
                                                            </select>
                                                        </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Appartment</label>
                                                            <input type="text" name="suit_no" id="billing_suit_no" placeholder="Appartment, Suite etc." value="{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['suit_no']  : '') }}">
                                                        </div>                             
                                                        </div>
                                                    </div>   
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>City *</label>
                                                            <input type="text" name="city" id="billing_city" placeholder="City / Town*" value="{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['city']  : '') }}">
                                                        </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Zipcode *</label>
                                                            <input type="text" name="zipcode" id="billing_zipcode" placeholder="Postcode / ZIP*" value="{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['zipcode']  : '') }}">
                                                        </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <label>Special Notes </label>
                                                            <textarea cols="8" name="special_note" id="billing_special_note" rows="3" placeholder ="Special Notes">{{ (!empty(Session::get('billing_address')) ? Session::get('billing_address')['special_note']  : '') }}</textarea>
                                                        </div>                             
                                                        </div>                            
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <input type="submit" class="aa-browse-btn">
                                                        </div>                             
                                                        </div>                            
                                                    </div>                                   
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="checkout-right">
                                <h4>Order Summary</h4>
                                <div class="aa-order-summary-area">
                                    <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $tax_calculation = 0;
                                            $without_tax_product_total = 0;
                                            $final_total = 0;
                                            $shipping_rate = 0;
                                        @endphp
                                        @foreach($all_cart_data as $car_ind => $cart_prod)
                                            @php 
                                                $product_row_total = $cart_prod->actual_price*$cart_prod->qty;
                                                $tax_in_product = ($product_row_total * $cart_prod->tax)/100;
                                                $product_without_tax = $product_row_total - $tax_in_product;

                                                $tax_calculation = $tax_calculation + $tax_in_product;
                                                $without_tax_product_total = $without_tax_product_total + $product_without_tax;
                                                
                                                $final_total = $final_total+$product_row_total;

                                                $shipping_rate += $cart_prod['shipping'];
                                            @endphp
                                            <tr>
                                                <td>{{$cart_prod->product['name']}} <strong> x  {{$cart_prod->qty}}</strong></td>
                                                <td><span class="fa fa-inr"></span> 
                                                {{$product_without_tax}}</td>
                                            </tr>
                                            
                                        @endforeach
                                    
                                    </tbody>
                                    <tfoot>
                                        @php 
                                            $final_total = $final_total+$shipping_rate;
                                        @endphp
                                        @if($tax_calculation > 0)
                                        <tr>
                                        <th>Sub Total</th>
                                        <td><span class="fa fa-inr"></span> {{ sprintf("%.2f",$without_tax_product_total,2) }}</td>
                                        </tr>
                                        <tr>
                                        <th>Tax</th>
                                        <td><span class="fa fa-inr"></span> {{ sprintf("%.2f",$tax_calculation,2) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                        <th>Shipping rate</th>
                                        <td><span class="fa fa-inr"></span> {{ sprintf("%.2f",$shipping_rate,2) }}</td>
                                        </tr>
                                        <tr>
                                        <th>Total</th>
                                        <td><span class="fa fa-inr"></span> {{ sprintf("%.2f",$final_total,2) }}</td>
                                        </tr>
                                    </tfoot>
                                    </table>
                                </div>
                                <h4>Payment Method</h4>
                                <div class="aa-payment-method">

                                    <div class="panel-group checkout-steps" id="accordion_payment">
                        
                                        <div class="panel panel-default checkout-step-01">
                                            <div class="modal-header">
                                                <h4 class="unicase-checkout-title">
                                                    <a data-toggle="collapse" data-parent="#accordion_payment" href="#cod">
                                                        <b>Via COD</b>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="cod" class="panel-collapse collapse ">
                                            @if( $general_settings->cod_checkout == 1)
                                                <div class="panel-body">
                                                    <form method="POST" id="cod-form" action="{{route('cod.checkout')}}">

                                                        {{ csrf_field() }}
                                                        <input type="hidden" value="{{isset($shipping) ? $shipping['id'] :''}}" name="shipping_id">
                                                        <input type="hidden" value="{{!empty(Session::get('billing_address')) ? 1 :''}}" name="billing_data">
                                                        <input class="w3-input w3-border" id="actualtotal" type="hidden" name="actualtotal" value="{{$final_total}}">
                                                        <button type="submit" class="btn btn-block btn-success d-flex">
                                                            <span>{{ __('Proceed With COD...') }}</span>
                                                            
                                                        </button>

                                                    </form>
                                                    
                                                    
                                                </div>

                                            </div>
                                            @endif

                                            @if( $general_settings->paypal_active == 1)
                                                <div class="modal-header">
                                                    <h4 class="unicase-checkout-title">
                                                        <a data-toggle="collapse" data-parent="#accordion_payment" href="#paypal">
                                                            <b>Via Paypal</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="paypal" class="panel-collapse collapse ">

                                                    <div class="panel-body">
                                                    <h3>Pay<i class="fa fa-inr"></i>
                                                        {{ sprintf("%.2f",$final_total,2) }}
                                                        </h3>
                                                        <hr class="mb-4">
                                                        <form method="POST" id="paypal-form" action="{!! URL::to('user\paypal') !!}">

                                                            {{ csrf_field() }}
                                                            <input type="hidden" value="{{isset($shipping) ? $shipping['id'] :''}}" name="shipping_id">
                                                            <input type="hidden" value="{{!empty(Session::get('billing_address')) ? 1 :''}}" name="billing_data">
                                                            <input class="w3-input w3-border" id="actualtotal" type="hidden" name="actualtotal" value="{{$final_total}}">
                                                            <button type="submit" class="btn btn-block btn-warning  d-flex">
                                                                <span>{{ __('Express Checkout with') }}</span>
                                                                <svg aria-label="PayPal" xmlns="http://www.w3.org/2000/svg" width="50" height="23" class="ml-2"
                                                                viewBox="34.417 0 90 33">
                                                                <path fill="#253B80"
                                                                    d="M46.211 6.749h-6.839a.95.95 0 0 0-.939.802l-2.766 17.537a.57.57 0 0 0 .564.658h3.265a.95.95 0 0 0 .939-.803l.746-4.73a.95.95 0 0 1 .938-.803h2.165c4.505 0 7.105-2.18 7.784-6.5.306-1.89.013-3.375-.872-4.415-.972-1.142-2.696-1.746-4.985-1.746zM47 13.154c-.374 2.454-2.249 2.454-4.062 2.454h-1.032l.724-4.583a.57.57 0 0 1 .563-.481h.473c1.235 0 2.4 0 3.002.704.359.42.469 1.044.332 1.906zM66.654 13.075h-3.275a.57.57 0 0 0-.563.481l-.146.916-.229-.332c-.709-1.029-2.29-1.373-3.868-1.373-3.619 0-6.71 2.741-7.312 6.586-.313 1.918.132 3.752 1.22 5.03.998 1.177 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91a.57.57 0 0 0 .562.66h2.95a.95.95 0 0 0 .939-.804l1.77-11.208a.566.566 0 0 0-.56-.657zm-4.565 6.374c-.316 1.871-1.801 3.127-3.695 3.127-.951 0-1.711-.305-2.199-.883-.484-.574-.668-1.392-.514-2.301.295-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.499.589.697 1.411.554 2.317zM84.096 13.075h-3.291a.955.955 0 0 0-.787.417l-4.539 6.686-1.924-6.425a.953.953 0 0 0-.912-.678H69.41a.57.57 0 0 0-.541.754l3.625 10.638-3.408 4.811a.57.57 0 0 0 .465.9h3.287a.949.949 0 0 0 .781-.408l10.946-15.8a.57.57 0 0 0-.469-.895z">
                                                                </path>
                                                                <path fill="#179BD7"
                                                                    d="M94.992 6.749h-6.84a.95.95 0 0 0-.938.802l-2.767 17.537a.57.57 0 0 0 .563.658h3.51a.665.665 0 0 0 .656-.563l.785-4.971a.95.95 0 0 1 .938-.803h2.164c4.506 0 7.105-2.18 7.785-6.5.307-1.89.012-3.375-.873-4.415-.971-1.141-2.694-1.745-4.983-1.745zm.789 6.405c-.373 2.454-2.248 2.454-4.063 2.454h-1.031l.726-4.583a.567.567 0 0 1 .562-.481h.474c1.233 0 2.399 0 3.002.704.358.42.467 1.044.33 1.906zM115.434 13.075h-3.272a.566.566 0 0 0-.562.481l-.146.916-.229-.332c-.709-1.029-2.289-1.373-3.867-1.373-3.619 0-6.709 2.741-7.312 6.586-.312 1.918.131 3.752 1.22 5.03 1 1.177 2.426 1.666 4.125 1.666 2.916 0 4.532-1.875 4.532-1.875l-.146.91a.57.57 0 0 0 .563.66h2.949a.95.95 0 0 0 .938-.804l1.771-11.208a.57.57 0 0 0-.564-.657zm-4.565 6.374c-.314 1.871-1.801 3.127-3.695 3.127-.949 0-1.711-.305-2.199-.883-.483-.574-.666-1.392-.514-2.301.297-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.501.589.699 1.411.554 2.317zM119.295 7.23l-2.807 17.858a.569.569 0 0 0 .562.658h2.822c.469 0 .866-.34.938-.803l2.769-17.536a.57.57 0 0 0-.562-.659h-3.16a.571.571 0 0 0-.562.482z">
                                                                </path>
                                                                </svg>
                                                            </button>

                                                        </form>
                                                        <hr>
                                                        <p class="text-muted"><i class="fa fa-lock"></i>
                                                        {{ __('Your transcation is secured with Paypal 128 bit encryption') }}.</p>
                                                    </div>

                                                </div>
                                            @endif

                                            @if( $general_settings->stripe_active == 1)
                                                <div class="modal-header">
                                                    <h4 class="unicase-checkout-title">
                                                        <a data-toggle="collapse" data-parent="#accordion_payment" href="#stripe">
                                                            <b>Via Stripe</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="stripe" class="panel-collapse collapse ">

                                                    <div class="panel-body">

                                                        <h3>Pay<i class="fa fa-inr"></i>
                                                        {{ sprintf("%.2f",$final_total,2) }}
                                                        </h3>
                                                        <hr class="mb-4">
                                                        <form  role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="stripe-form">
                                                            @csrf
                                                            <input type="hidden" value="{{isset($shipping) ? $shipping['id'] :''}}" name="shipping_id">
                                                            <input type="hidden" value="{{!empty(Session::get('billing_address')) ? 1 :''}}" name="billing_data">
                                                            <input class="w3-input w3-border" id="actualtotal" type="hidden" name="actualtotal" value="{{$final_total}}">
                                                            <div class='form-row row'>
                                                                <div class='col-xs-12 form-group required'>
                                                                    <label class='control-label'>Name on Card</label> <input
                                                                        class='form-control' size='4' type='text'>
                                                                </div>
                                                            </div>
    
                                                            <div class='form-row row'>
                                                                <div class='col-xs-12 form-group card required'>
                                                                    <label class='control-label'>Card Number</label> <input
                                                                        autocomplete='off' class='form-control card-number' size='20'
                                                                        type='text'>
                                                                </div>
                                                            </div>
                                    
                                                            <div class='form-row row'>
                                                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                                    <label class='control-label'>CVC</label> <input autocomplete='off'
                                                                        class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                                        type='text'>
                                                                </div>
                                                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                                    <label class='control-label'>Month</label> <input
                                                                        class='form-control card-expiry-month' placeholder='MM' size='2'
                                                                        type='text'>
                                                                </div>
                                                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                                    <label class='control-label'> Year</label> <input
                                                                        class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                                        type='text'>
                                                                </div>
                                                            </div>
    
                                                            <div class='form-row row'>
                                                                <div class='col-md-12 error form-group hide'>
                                                                    <div class='alert-danger alert'>Please correct the errors and try
                                                                        again.</div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now </button>
                                                                </div>
                                                            </div>
                                                            
                                                        </form>
                                                    </div>

                                                </div>
                                            @endif
                                            @if($general_settings->razorpay_active == 1)
                                                <div class="modal-header">
                                                    <h4 class="unicase-checkout-title">
                                                        <a data-toggle="collapse" data-parent="#accordion_payment" href="#razorpay">
                                                            <b>Via Razorpay</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="razorpay" class="panel-collapse collapse ">

                                                    <div class="panel-body">
                                                        <h3>Pay<i class="fa fa-inr"></i>
                                                        {{ sprintf("%.2f",$final_total,2) }}
                                                        </h3>
                                                        <hr class="mb-4">
                                                        <form action="{{ route('razorpay.payment.store') }}" method="POST" >
                                                            @csrf

                                                            @if(isset($shipping) && !empty(Session::get('billing_address')))
                                                            <input type="hidden" value="{{isset($shipping) ? $shipping['id'] :''}}" name="shipping_id">
                                                            <input type="hidden" value="{{!empty(Session::get('billing_address')) ? 1 :''}}" name="billing_data">
                                                            <input class="w3-input w3-border" id="actualtotal" type="hidden" name="actualtotal" value="{{$final_total}}">
                                                            @php
                                                            $order = uniqid();
                                                            Session::put('order_id',$order);
                                                            @endphp
                                                            <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                                    data-key="{{ env('RAZORPAY_KEY') }}"
                                                                    data-amount="{{(round($final_total,2))*100}}"
                                                                    data-buttontext="Pay {{round($final_total,2)}} INR"
                                                                    data-name="{{ env('APP_NAME') }}"
                                                                    data-description="Payment For Order #ORD{{ Session::get('order_id') }}"
                                                                    data-image="{{asset('/assets/uploads/general/'.$general_settings->logo)}}"
                                                                    data-prefill.name="{{isset($shipping) ? $shipping['full_name'].' '.$shipping['last_name']:''}}"
                                                                    data-prefill.email="{{isset($shipping) ? $shipping['email']:''}}"
                                                                    data-theme.color="#ff7529">
                                                            </script>
                                                            @else
                                                                <h4>{{ __('RazorPay') }} {{__('Check Out Not Available')}}.</h4>
                                                                <p>Fill Shipping and Billing Details First!!</p>
                                                            @endif
                                                        </form>
                                                    </div>

                                                </div>
                                            @endif
                                            @if($bank_detail->status == 1)
                                                <div class="modal-header">
                                                    <h4 class="unicase-checkout-title">
                                                        <a data-toggle="collapse" data-parent="#accordion_payment" href="#bank_transfer">
                                                            <b>Via Bank Transfer</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="bank_transfer" class="panel-collapse collapse ">

                                                    <div class="panel-body">

                                                        <form action="{{ route('bank.transfer.process') }}" method="POST" enctype="multipart/form-data" >
                                                            @csrf
                                                            @php
                                                            $order = uniqid();
                                                            Session::put('order_id',$order);
                                                            @endphp
                                                            <input type="hidden" value="{{isset($shipping) ? $shipping['id'] :''}}" name="shipping_id">
                                                            <input type="hidden" value="{{!empty(Session::get('billing_address')) ? 1 :''}}" name="billing_data">
                                                            <input class="w3-input w3-border" id="actualtotal" type="hidden" name="actualtotal" value="{{$final_total}}">

                                                            <div class="form-group">
                                                            <label for="">Attach Purchase Proof <span class="text-red">*</span> </label>
                                                            <input required title="Please attach a purchase proof !" type="file" class="@error('purchase_proof') is-invalid @enderror form-control" name="purchase_proof"/>
                                                            
                                                            @error('purchase_proof')
                                                                <span class="invalid-feedback text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror

                                                            </div>

                                                            <button title="{{__('Bank Transfer')}}" type="submit" class="btn btn-block btn-warning">
                                                            <span>{{__('Bank Transfer')}}</span> <i class="fa fa-money"></i>
                                                            </button>
                                                        </form>
                                                        <hr class="mb-4">
                                                        <p class="text-muted"><i class="fa fa-money"></i> Bank Details</p>

                                                        <div >
                                                            <div >
                                                                
                                                                
                                                                <p>{{__('Account Name')}}: {{ $bank_detail->account_name }}</p>
                                                                <p>{{ __('A/c No') }}: {{ $bank_detail->account_no }}</p>
                                                                <p>{{__('Bank Name')}}: {{ $bank_detail->bank_name }}</p>
                                                                <p>{{ __('IFSC Code') }}: {{ $bank_detail->ifsc }}</p>
                                                                

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <br>
                                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">    
                                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection