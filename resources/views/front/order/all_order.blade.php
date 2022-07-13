@extends('layouts.front')
@section('title', 'My Orders |')

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
                <h2>My Orders</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">My Orders</li>
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
                            <h3>My Orders</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    @if(count($orders)>0)
                                    @foreach($orders as  $ord)
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <a href="{{route('order.view',Crypt::encrypt($ord->id))}}" class="btn btn-md btn-warning">{{$ord->order_id}}</a>
                                                    <small class="pull-right">
                                                    <b>{{ __('Transcation ID') }}:</b> {{ $ord->transaction_id }}
                                                    <br>
                                                    <b>{{ __('Payment Method') }}:</b> {{ $ord->payment_method }}
                                                    </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row mb-4">
                                                    @foreach($ord->invoices as  $inv)
                                                
                                                    <div class="col-md-6">
                                                        <div class="border col-md-12 p-4">
                                                            <div class="col-md-2 col-sm-3 col-4 ">
                                                                <center>
                                                                    @if(count($inv->product->photos)>0 && file_exists('assets/uploads/product_photos/'.$inv->product->photos[0]['image']) )
                                                                        <img class="img-responsive img-thumbnail" src="{{url('assets/uploads/product_photos/'.$inv->product->photos[0]['image'])}}" >
                                                                    @else
                                                                        <img class="img-responsive img-thumbnail" src="{{url('/front/img/no-image.jpg')}}">
                                                                    @endif
                                                                </center>
                                                            </div>
                                                            <div class="col-md-6 col-sm-5 col-7 click-view-one">
                                                                <a target="_blank" title="Click to view"
                                                                href="{{ url('user/product/'.$inv->product['id']) }}"><b>{{$inv->product['name']}}</b>
                                                                    <br>
                                                                    <small>
                                                                    <b>{{ __('Qty') }}:</b> {{$inv->qty}}
                                                                    </small>
                                                                    &nbsp; &nbsp; &nbsp;
                                                                    <small>
                                                                        @if($inv->order_product_status == 'delivered')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-green-500">{{ ucfirst($inv->order_product_status) }}</span>
                                                                        @elseif($inv->order_product_status == 'processed')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-blue-600">{{ ucfirst($inv->order_product_status) }}</span>
                                                                        @elseif($inv->order_product_status == 'shipped')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-pink-600">{{ ucfirst($inv->order_product_status) }}</span>
                                                                        @elseif($inv->order_product_status == 'return_request')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-yellow-400">
                                                                        {{ __('Return Request') }}
                                                                        </span>
                                                                        @elseif($inv->order_product_status == 'returned')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-red-500">
                                                                        {{ __('Returned') }}
                                                                        </span>
                                                                        @elseif($inv->order_product_status == 'refunded')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-green-600">
                                                                        {{ __('Refunded') }}
                                                                        </span>
                                                                        @elseif($inv->order_product_status == 'cancel_request')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-yellow-400">
                                                                        {{ __('Cancellation Request') }}
                                                                        </span>
                                                                        @elseif($inv->order_product_status == 'cancelled')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-red-500">
                                                                        {{ __('Cancelled') }}
                                                                        </span>
                                                                        @elseif($inv->order_product_status == 'Refund Pending')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-green-600">
                                                                        {{ __('Refund in progress') }}
                                                                        </span>
                                                                        @elseif($inv->order_product_status == 'ret_ref')
                                                                        <span class="badge badge-pill font-medium  text-sm bg-pink-600">
                                                                        {{ __('Returned & Refunded') }}
                                                                        </span>
                                                                        @else
                                                                        <span class="badge badge-pill font-medium  text-sm badge-secondary">{{ ucfirst($inv->order_product_status) }}</span>
                                                                        @endif
                                                                    </small>
                                                                </a>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 offset-2 col-6 m-8-no applied-block">
                                                                <b>
                                                                    <i class="fa fa-inr"></i>
                                                                    {{sprintf("%.2f",$inv->total_amount + $inv->shipping_rate,2)}}
                                                                </b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <small ><b>Order Date: </b>{{date('d-m-Y',strtotime($ord->created_at))}}</small>
                                                    <small class="pull-right">
                                                        <b>{{ __('Order Total') }}:</b> {{ sprintf("%.2f",$ord->order_total+$ord->shipping_total,2) }}
                                                    </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="alert alert-info" role="alert">
                                        There is no order present currently!!
                                    </div>
                                    @endif
                                </div>
                                <div style="display: inline-block;" class="mb-4">
                                    {!!$orders->links()!!}
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