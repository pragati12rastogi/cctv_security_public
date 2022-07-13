@extends('layouts.front')
@section('title',"Return Product |")
@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
    
@endsection

@section('js')
    <script>
        $(function(){
            
            
        });

        
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
                <h2> Order {{$invoice->order->order_id}} > #Inv{{$invoice->id}}</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li><a href="{{route('my.orders')}}">My Orders</a></li>                   
                    <li ><a href="{{route('order.view',Crypt::encrypt($invoice->order_id))}}"> Order {{$invoice->order->order_id}}</a></li>
                    <li class="active"> Order {{$invoice->order->order_id}} > {{ $productname }}</li>
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
                        <div class="panel-body border-b">
                            <h3>{{ __('Return Product') }} {{ $productname }} </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4 class="margin-15">{{ __('Order') }} {{ $invoice->order->order_id }} > #Inv{{$invoice->id}}
                                            </h4>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="margin-15">{{ __('TXN ID:') }} {{ $invoice->order->transaction_id }}
                                            </h4>
                                        </div>
                                        <div class="col-md-4">
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-striped table-responsive">
                                            <thead>
                                                <th>
                                                    {{ __('Item') }}
                                                </th>

                                                <th>
                                                    {{ __('Quantity') }}
                                                </th>

                                                <th>
                                                    {{ __('Price') }}
                                                </th>

                                                <th>{{ __('Shipping Charge') }}</th>

                                                <th>
                                                    {{ __('Total') }}
                                                </th>

                                                <th>
                                                    {{ __('Delivery Date') }}
                                                </th>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                @if(count($invoice->product->photos)>0  && file_exists('assets/uploads/product_photos/'.$invoice->product->photos[0]['image']) )
                                                                    <img class="img-responsive img-thumbnail" src="{{url('assets/uploads/product_photos/'.$invoice->product->photos[0]['image'])}}" >
                                                                @else
                                                                    <img class="img-responsive img-thumbnail" src="{{url('/front/img/no-image.jpg')}}">
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <a title="{{ __('Click to view') }}" ><b>{{$invoice->product->name}}</b></a>
                                                            
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{$invoice->qty}}
                                                    </td>

                                                    <td><b><i class="fa fa-inr"></i>
                                                        
                                                            {{sprintf("%.2f",$invoice->total_amount,2)}}
                                                    </b>
                                                    
                                                    </td>
                                                    <td>
                                                        <b><i class="fa fa-inr"></i> {{ sprintf("%.2f",$invoice->shipping_rate,2) }}</b>
                                                    </td>
                                                    
                                                    <td>
                                                        <b><i class="fa fa-inr"></i> 
                                                            {{sprintf("%.2f",$invoice->total_amount + $invoice->shipping_rate,2)}} 
                                                        </b>
                                                    </td>
                                                    <td>
                                                    @php
                                                        $days = $invoice->product->return_policy->days;
                                                        $endOn = date("d-M-Y", strtotime("$invoice->updated_at +$days days"));
                                                    @endphp
                                                        <span class="font-weight600">{{ date('d-M-Y @ h:i A',strtotime($invoice->updated_at)) }}</span>
                                                        <br>
                                                        <small class="font-weight600">({{ __('Return Policy Ends On :') }} {{ $endOn }})</small>
                                                        
                                                    </td>



                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12">

                                        @php
                                            $orderId = Crypt::encrypt($invoice->id);
                                        @endphp
                                        <!--return form-->
                                        <form action="{{ route('return.process',$orderId) }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    

                                                        <label class="font-weight-bold">{{ __('Choose reason for returning the product') }}: <span class="required">*</span></label>
                                                
                                                        
                                                        <select required name="reason_return" id="" class=" form-control margin-left-0">
                                                            <option value="">{{ __('Please Choose Reason') }}</option>

                                                                <option value="Order Placed Mistakely">
                                                                {{ __('Order Placed Mistakely') }}
                                                                </option>
                                                                <option value="Shipping cost is too much">
                                                                {{ __('Shipping cost is too much') }}
                                                                </option>
                                                                <option value="Wrong Product Ordered">
                                                                {{ __('Wrong Product Ordered') }}
                                                                </option>
                                                                <option value="Product is not match to my expectations">
                                                                {{ __('Product is not match to my expectations') }}
                                                                </option>
                                                                <option value="Other">
                                                                {{ __('My Reason is not listed here') }}
                                                                </option>
                                                        </select>
                                                        
                                                    
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">{{ __('Refund Amount') }}:</label>
                                                        <input required type="text" class="form-control" readonly value="{{round($invoice->total_amount + $invoice->shipping_rate,2) }}">
                                                        @php
                                                            $rfm = Crypt::encrypt(round($invoice->total_amount + $invoice->shipping_rate,2));
                                                        @endphp

                                                        <input type="hidden" value="{{ $rfm }}" name="rf_am">
                                                    </div>

                                                </div>
                                                
                                            </div>
                                                
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class=" text-2xl font-extrabold">{{ __('Pickup Location') }}:</label>

                                                    @php
                                                        $ship_country = App\Helper\CustomHelper::get_country($invoice->order->shipping_address['country_id']);
                                                        $ship_state = App\Helper\CustomHelper::get_state($invoice->order->shipping_address['state_id']);
                                                        
                                                        if(!empty($ship_country)){
                                                            $ship_country = $ship_country['name'];
                                                        }else{
                                                            $ship_country = ''; 
                                                        }
                                                        if(!empty($ship_state)){
                                                            $ship_state = ucwords(strtolower($ship_state['state_name']));
                                                        }else{
                                                            $ship_state = ''; 
                                                        }

                                                        $address = $invoice->order->shipping_address;
                                                        $addressA = array();

                                                        $addressA = [

                                                            'name' => $address['first_name'].' '.$address['last_name'],
                                                            'address' => $address['suit_no'].' '.strip_tags($address['address']),
                                                            'city' 	=> $address['city'],
                                                            'state' => $ship_state,
                                                            'country' => $ship_country,
                                                            'zipcode' => $address['zipcode']

                                                        ];

                                                    


                                                    @endphp

                                                    <div class="form-group">
 
                                                        <div class="well">
                                                            <input checked type="checkbox" name="pickupaddress" value="{{ json_encode($addressA,TRUE)}}" class="custom-control-input" id="customCheck1">
                                                            <label class="text-2xl font-extrabold" for="customCheck1">
                                                                {{$address['first_name'].' '.$address['last_name']}}


                                                                <p class="p-2 font-semibold">
                                                                
                                                                {{ $address['suit_no'].' '.strip_tags($address['address']) }}<br>{{ $address['city'] }},{{ $ship_state }},{{ $ship_country }} <br> {{ $address['zipcode'] }}
                                                                </p>
                                                            </label>
                                                        </div>
                                                            
                                                        
                                                    </div>

                                                
                                                </div>

                                                <div class="col-md-6">
                                                        <label class=" text-2xl font-extrabold ">{{ __('Refund Method') }}:</label>
                                                        @if(!empty($invoice->user->bank))
                                                    
                                                        
                                                            @php
                                                                $bank = $invoice->user->bank;
                                                            @endphp
                                                            <div class="well">

                                                                <p><b>A/C Holder Name: </b>{{$bank->account_name}}</p>
                                                                <p><b>Bank Name: </b>{{ $bank->bankname }}</p>
                                                                <p><b>Account No: </b>{{ $bank->account_no }}</p>
                                                                <p><b>IFSC Code: </b>{{ $bank->ifsc }}</p>

                                                            </div>
                                                        
                                                        @else
                                                            <p>User Bank Details are not filled.</p>
                                                        @endif
                                                </div>


                                            </div>
                                            <hr>
                                            <div class="form-control-static">
                                                <button type="submit" class="btn btn-primary">{{ __('Proceed') }}...</button>
                                            </div>
                                            
                                        </form>
                                        
                                    <!--end-->
                                    </div>
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
