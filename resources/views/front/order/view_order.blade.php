@extends('layouts.front')
@section('title', 'View Order'.$order->order_id.' |')

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
                <h2> Order {{$order->order_id}}</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li><a href="{{route('my.orders')}}">My Orders</a></li>                   
                    <li class="active"> Order {{$order->order_id}}</li>
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
                            <h3>Order {{$order->order_id}}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <table class="table table-striped table-striped-one">
                                        <thead>
                                            <tr>
                                            <th>{{ __('Shipping Address') }}</th>
                                            <th>{{ __('Billing Address') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                            <td>
                                                <small>
                                                <p><b><i class="fa fa-user"></i> {{$order->shipping_address['first_name']}} {{$order->shipping_address['last_name']}}, {{$order->shipping_address['phone']}}</b></p>

                                                <p><i class="fa fa-mail-reply"></i> {{$order->shipping_address['email']}}</p>
                                                
                                                <p class="font-weight-normal"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{$order->shipping_address['suit_no']}} {{$order->shipping_address['address']}},</p>
                                                
                                                <p class="font-weight-normal margin-left8">
                                                    @php
                                                        $ship_country = App\Helper\CustomHelper::get_country($order->shipping_address['country_id']);
                                                        $ship_state = App\Helper\CustomHelper::get_state($order->shipping_address['state_id']);
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
                                                    @endphp

                                                    {{$ship_state}} {{$ship_country}}
                                                </p>
                                                <p class="font-weight-normal margin-left8">{{$order->shipping_address['zipcode']}}</p>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                <p><b><i class="fa fa-user"></i> {{$order->billing_address['first_name']}} {{$order->billing_address['last_name']}}, {{$order->billing_address['phone']}}</b></p>
                                                
                                                <p><i class="fa fa-mail-reply"></i> {{$order->billing_address['email']}}</p>
                                                

                                                <p class="font-weight-normal"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{$order->billing_address['suit_no']}} {{$order->billing_address['address']}},</p>
                                                
                                                <p class="font-weight-normal margin-left8">
                                                    @php
                                                        $bill_country = App\Helper\CustomHelper::get_country($order->billing_address['country']);
                                                        $bill_state = App\Helper\CustomHelper::get_state($order->billing_address['state_id']);
                                                        if(!empty($bill_country)){
                                                            $bill_country = $bill_country['name'];
                                                        }else{
                                                            $bill_country = ''; 
                                                        }
                                                        if(!empty($bill_state)){
                                                            $bill_state = ucwords(strtolower($bill_state['state_name']));
                                                        }else{
                                                            $bill_state = ''; 
                                                        }
                                                    @endphp

                                                    {{$bill_state}} {{$bill_country}}
                                                </p>
                                                <p class="font-weight-normal margin-left8">{{$order->billing_address['zipcode']}}</p>
                                                </small>
                                            </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped-one">
                                        <thead>
                                        <tr>
                                            <td>
                                            <b>{{ __('Transcation ID') }}:</b> {{ $order->transaction_id }}
                                            </td>
                                            <td>
                                            <b>{{ __('Payment Method') }}:</b> {{ $order->payment_method }}
                                            </td>
                                            <td>
                                            <b>{{ __('Order Date') }}: </b> {{ date('d-m-Y',strtotime($order->created_at)) }}
                                            </td>


                                        </tr>

                                        </thead>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <table id="invoice_list" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="table-heading-row">
                                                
                                                <th>Item Name</th>
                                                <th >Qty</th>
                                                <th width="10%">Status</th>
                                                <th width="20%">Price</th>
                                                <th width="10%">Total</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->invoices as $inv_ind => $inv_data)
                                                <tr>
                                                    
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                @if(count($inv_data->product->photos)>0 && file_exists('assets/uploads/product_photos/'.$inv_data->product->photos[0]['image']) )
                                                                    <img class="img-responsive img-thumbnail" src="{{url('assets/uploads/product_photos/'.$inv_data->product->photos[0]['image'])}}" >
                                                                @else
                                                                    <img class="img-responsive img-thumbnail" src="{{url('/front/img/no-image.jpg')}}">
                                                                @endif
                                                                
                                                            </div>
                                                            <div class="col-md-6">
                                                                <a href="{{url('user/product/'.$inv_data->product['id'])}}"><b>{{$inv_data->product['name']}}</b></a>
                                                                <br>
                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$inv_data->qty}}</td>
                                                    <td>
                                                        <div id="singleorderstatus{{ $inv_data->id }}">
                                                        @if($inv_data->order_product_status == 'delivered')
                                                            <span class="label label-success">{{ ucfirst($inv_data->order_product_status) }}</span>
                                                            @elseif($inv_data->order_product_status == 'processed')
                                                            <span class="label label-info">{{ ucfirst($inv_data->order_product_status) }}</span>
                                                            @elseif($inv_data->order_product_status == 'shipped')
                                                            <span class="label label-primary">{{ ucfirst($inv_data->order_product_status) }}</span>
                                                            @elseif($inv_data->order_product_status == 'return_request')
                                                            <span class="label label-warning">Return Requested</span>
                                                            @elseif($inv_data->order_product_status == 'returned')
                                                            <span class="label label-success">Returned</span>
                                                            @elseif($inv_data->order_product_status == 'cancel_request')
                                                            <span class="label label-warning">Cancelation Request</span>
                                                            @elseif($inv_data->order_product_status == 'cancelled')
                                                            <span class="label label-danger">Cancelled</span>
                                                            @elseif($inv_data->order_product_status == 'refunded')
                                                            <span class="label label-danger">Refunded</span>
                                                            @elseif($inv_data->order_product_status == 'ret_ref')
                                                            <span class="label label-success">Return & Refunded</span>
                                                            @else
                                                            <span class="label label-default">{{ ucfirst($inv_data->order_product_status) }}</span>
                                                        @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <small>
                                                        @if(!empty($inv_data->tax_amount))
                                                            @if(!empty($inv_data->igst))
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Price: </label>
                                                                    <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->total_amount-$inv_data->igst,2)}}</span>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    
                                                                    <label>IGST: </label>
                                                                    <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->igst,2)}}</span>
                                                                </div>
                                                            </div>
                                                            @elseif(!empty($inv_data->scgst))
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Price: </label>
                                                                    <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->total_amount-($inv_data->scgst+$inv_data->scgst),2)}}</span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>SGST: </label>
                                                                    <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->scgst,2)}}</span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>CGST: </label>
                                                                    <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->scgst,2)}}</span>
                                                                </div>
                                                            </div>
                                                            @else
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Price: </label>
                                                                    <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->total_amount-$inv_data->igst,2)}}</span>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        @else
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Price: </label>
                                                                    <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->total_amount-$inv_data->igst,2)}}</span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if( !empty($inv_data->shipping_rate))
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Shipping rate: </label>
                                                                <span><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->shipping_rate,2)}}</span>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        </small>
                                                    </td>
                                                    <td><i class="fa fa-inr"></i> {{sprintf("%.2f",$inv_data->total_amount + $inv_data->shipping_rate,2)}}</td>
                                                    <td>

                                                        @php
                                                        $cancellog =
                                                        App\Models\CancelledInvoice::where('order_id','=',$inv_data->order->id)->where('invoice_id','=',$inv_data->id)->first();
                                                        @endphp
                                                        
                                                        @if($inv_data->product->return_available == '1')
                                                            @if($inv_data->order_product_status == 'delivered')

                                                                @php

                                                                    $days = $inv_data->product->return_policy->days;
                                                                    $endOn = date("d-M-Y", strtotime("$inv_data->updated_at + $days days"));
                                                                    $today = date('d-M-Y');
                                                                    $secureInv = Crypt::encrypt($inv_data->id);
                                                                @endphp

                                                                @if(strtotime($today) < strtotime($endOn))
                                                                    <a href="{{ route('return.window',$secureInv) }}"><button
                                                                        class="m-l-8  btn btn-sm btn-warning mb-4">
                                                                        {{ __('Return') }}
                                                                    </button></a>
                                                                @endif


                                                            @endif
                                                        @endif
                                                        @if(empty($cancellog))
                                                            @if($inv_data->order_product_status != 'cancelled' && $inv_data->order_product_status != 'returned' && $inv_data->order_product_status != 'return_request' && $inv_data->order_product_status != 'delivered' && $inv_data->order_product_status !='ret_ref' && $inv_data->order_product_status !='refunded' && $inv_data->product->cancel_available !=0)
                                                                <a data-toggle="modal" data-target="#singleordercancel{{ $inv_data->id }}" title="Cancel this order?" href="#" class="btn btn-sm btn-danger" id="canbtn{{ $inv_data->id }}"> Cancel </a>
                                                            @elseif($inv_data->product->cancel_available ==0)
                                                                <a disabled class="btn btn-sm btn-danger">No Cancellation Available</a>
                                                            @endif
                                                        @else
                                                            <a disabled class="btn btn-sm btn-danger">Cancelled</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                        
                                            @endforeach
                                            <tr>
                                                <td colspan = "3">
                                                    @if(!empty($order->special_note))
                                                    <label>Special Note:</label>
                                                    <span>{{$order->special_note}}</span>
                                                    @endif
                                                </td>
                                                <td>Grand Total:</td>
                                                <td>
                                                    <i class="fa fa-inr"></i>
                                                    <span> {{sprintf("%.2f",$order->order_total + $order->shipping_total,2)}} </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                
                                    </table>
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
@foreach($order->invoices as $o)

	@if($o->order_product_status != 'cancelled' && $o->order_product_status != 'returned' && $o->order_product_status !=
							'return_request' && $o->order_product_status != 'delivered' && $o->order_product_status !='ret_ref' &&
							$o->order_product_status !='refunded' && $o->product->cancel_available != 0)
							
		<div data-backdrop="static" data-keyboard="false" class="modal fade" id="singleordercancel{{ $o->id }}" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						
						<h4 class="modal-title col-lg-11" id="myModalLabel">Cancel Item: {{$o->product->name}}
						</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					</div>

					<div class="modal-body">
						@php
						$secureid = Crypt::encrypt($o->id);
						@endphp
						@if($o->order_product_status != 'returned' && $o->order_product_status != 'return_request' && $o->order_product_status != 'delivered' &&
						$o->order_product_status !='ret_ref' && $o->order_product_status !='refunded' && $o->product->cancel_available != 0)
						<form action="{{ route('user.cancel.item',$secureid) }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">Choose Reason <span class="required">*</span></label>
								<select class="form-control" required="" name="comment" id="">
									<option value="">Please Choose Reason</option>
									<option value="Order Placed Mistakely">Order Placed Mistakely</option>
									<option value="Shipping cost is too much">Shipping cost is too much</option>
									<option value="Wrong Product Ordered">Wrong Product Ordered</option>
									<option value="Product is not match to my expectations">Product is not match to my
										expectations</option>
									<option value="Other">My Reason is not listed here</option>
								</select>
							</div>
							<div class="form-group">
                                <label>Other Reason <small>(Optional)</small></label>
                                <textarea name="other_reason" class="form-control"></textarea>
                            </div>
							
							<button type="submit" class="btn btn-md btn-primary">
								Procced...
							</button>
							<p class="help-block">This action cannot be undone !</p>
							
						</form>

						@endif

					</div>


				</div>
			</div>
		</div>
	@endif

@endforeach
@endsection