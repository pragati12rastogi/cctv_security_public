@extends('layouts.front')
@section('title', 'Manage Shipping Address |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
    <style>
        .error{
            color:red;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function(){
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
    </script>
@endsection

@section('content')

<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings)){
            if(!empty($banner_settings->user_dasboard_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->user_dasboard_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->user_dasboard_banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Manage Shipping Address</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Manage Shipping Address</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section id="aa-product-category" class="modal-dialog">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                @include('flash-message')
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Manage Shipping Address</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <form id="shipping_address_form" action="{{url('user/checkout-user-shipping-address')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="shipping_address_id" value="{{isset($shipping) ? $shipping['id'] :''}}">
                                        
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>First Name *</label>
                                                <input type="text" id="shipping_first_name" class="form-control "name="first_name" onKeyPress="this.value = this.value.replace(/\s/g,'');" placeholder="First Name*" value="{{isset($shipping) ? $shipping['first_name']:''}}">                            
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Last Name *</label>
                                                <input type="text" id="shipping_last_name" class="form-control" name="last_name" onKeyPress="this.value = this.value.replace(/\s/g,'');" placeholder="Last Name*" value="{{isset($shipping) ? $shipping['last_name']:''}}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Email *</label>
                                                <input type="email" name="email" id="shipping_email" placeholder="Email Address*" value="{{isset($shipping) ? $shipping['email']:''}}" class="form-control">                             
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Phone *</label>
                                                <input type="text" id="shipping_phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" placeholder="Phone*" value="{{isset($shipping) ? $shipping['phone']:''}}" class="form-control">
                                            </div>
                                            
                                            <div class="col-md-6 form-group">
                                            
                                                <label>Country *</label>
                                                <select name="country_id" id="shipping_country_id" class="country_state form-control">
                                                    <option value="">Select Your Country</option>
                                                    @foreach($country as $c_ind => $c)
                                                        <option value="{{$c->id}}" {{isset($shipping) ? (($shipping['country_id'] == $c->id)? 'selected':'' ):''}} >{{$c->name}}</option>
                                                    @endforeach
                                                </select>
                                                                        
                                            </div> 
                                            <div class="col-md-6 form-group">
                                            
                                                <label>State *</label>
                                                <select type="text" name="state_id" id="shipping_state_id" class="form-control">
                                                    <option value="">Select State</option>
                                                </select>
                                                                        
                                            </div>
                                            <div class="col-md-6 form-group">
                                            
                                                <label>Appartment </label>
                                                <input type="text" id="shipping_suit_no" value="{{isset($shipping) ? $shipping['suit_no']:''}}" name="suit_no" maxlength="200" placeholder="Appartment, Suite etc." class="form-control">
                                                                        
                                            </div>
                                            <div class="col-md-6 form-group">
                                            
                                                <label>City *</label>
                                                <input type="text" id="shipping_city" name="city" value="{{isset($shipping) ? $shipping['city']:''}}" maxlength="240" placeholder="City / Town*" class="form-control">
                                            
                                            </div>
                                            <div class="col-md-6 form-group">
                                            
                                                <label>Zipcode *</label>
                                                <input type="text" id="shipping_zipcode" name="zipcode" value="{{isset($shipping) ? $shipping['zipcode']:''}}" minlength="6" maxlegth ="6" placeholder="Postcode / ZIP*" class="form-control">
                                            
                                            </div>
                                            <div class="col-md-6 form-group">
                                            
                                                <label>Address *</label>
                                                <textarea cols="8" id="shipping_address" name="address" rows="3" placeholder="Address*" class="form-control">{{isset($shipping) ? $shipping['address']:''}}</textarea>
                                                                        
                                            </div>
                                            <div class="col-md-12  text-right">
                                                <button type="submit" class="btn btn-md btn-primary">{{ __('Save') }}</button>
                                            </div>
                                        </div> 
                                         
                                        
                                    </form>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            @include('front.sidenavbar')
        </div>

    </div>
</section>

@endsection