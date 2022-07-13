@extends('layouts.admin')
@section('title', 'All Completed Orders |')

@section('breadcrumb')
<li class="breadcrumb-item active">All Completed Orders</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    $("#allorders_table").DataTable();
  });


  
</script>
@endsection
@section('content')

<div class="container-fluid">
    @include('flash-message')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="m-0">{{__("All Completed Orders")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            
          <table id="allorders_table" class="table table-bordered table-striped">
            <thead>
              <tr class="table-heading-row">
                <th>Invoice Id</th>
                <th>Users</th>
                <th>Item Name</th>
                <th> Qty </th>
                <th>Status</th>
                <th>Price</th>
                <th>Total</th>
                
              </tr>
            </thead>
            <tbody>
              
              @foreach($invoice as $inv)
              <tr>
                <td>
                    #Inv{{$inv->id}} <small><label>Order of </label>{{$inv->order->orderId}}</small>
                </td>
                <td>{{$inv->user->name}}</td>
                <td>
                    <div class="row">
                        <div class="col-md-2">
                            
                            @if(count($inv->product->photos)>0 && file_exists('assets/uploads/product_photos/'.$inv->product->photos[0]['image']) )
                                <img class="img-responsive " src="{{url('assets/uploads/product_photos/'.$inv->product->photos[0]['image'])}}" >
                            @else
                                <img class="img-responsive " src="{{url('/front/img/no-image.jpg')}}">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <a href="{{url('user/product/'.$inv->product['id'])}}"><b>{{$inv->product['name']}}</b></a>
                        </div>
                    </div>
                </td>
                <td>
                    {{$inv->qty}}
                </td>
                <td>
                    @if($inv->order_product_status == 'delivered')
                        <span class="label label-success">{{ ucfirst($inv->order_product_status) }}</span>
                        @elseif($inv->order_product_status == 'processed')
                        <span class="label label-info">{{ ucfirst($inv->order_product_status) }}</span>
                        @elseif($inv->order_product_status == 'shipped')
                        <span class="label label-primary">{{ ucfirst($inv->order_product_status) }}</span>
                        @elseif($inv->order_product_status == 'return_request')
                        <span class="label label-warning">Return Requested</span>
                        @elseif($inv->order_product_status == 'returned')
                        <span class="label label-success">Returned</span>
                        @elseif($inv->order_product_status == 'cancel_request')
                        <span class="label label-warning">Cancelation Request</span>
                        @elseif($inv->order_product_status == 'cancelled')
                        <span class="label label-danger">Cancelled</span>
                        @elseif($inv->order_product_status == 'refunded')
                        <span class="label label-danger">Refunded</span>
                        @elseif($inv->order_product_status == 'ret_ref')
                        <span class="label label-success">Return & Refunded</span>
                        @else
                        <span class="label label-default">{{ ucfirst($inv->order_product_status) }}</span>
                    @endif
                </td>
                <td>
                    @if(!empty($inv->tax_amount))
                        @if(!empty($inv->igst))
                        <div class="row">
                            <div class="col-md-12">
                                <label>Price: </label>
                                <span><i class="fa fa-rupee-sign"></i> {{round($inv->total_amount-$inv->igst,2)}}</span>
                            </div>
                            <div class="col-md-12">
                                
                                <label>IGST: </label>
                                <span><i class="fa fa-rupee-sign"></i> {{round($inv->igst,2)}}</span>
                            </div>
                        </div>
                        @elseif(!empty($inv->scgst))
                        <div class="row">
                            <div class="col-md-12">
                                <label>Price: </label>
                                <span><i class="fa fa-rupee-sign"></i> {{round($inv->total_amount-($inv->scgst+$inv->scgst),2)}}</span>
                            </div>
                            <div class="col-md-12">
                                <label>SGST: </label>
                                <span><i class="fa fa-rupee-sign"></i> {{round($inv->scgst,2)}}</span>
                            </div>
                            <div class="col-md-12">
                                <label>CGST: </label>
                                <span><i class="fa fa-rupee-sign"></i> {{round($inv->scgst,2)}}</span>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-md-12">
                                <label>Price: </label>
                                <span><i class="fa fa-rupee-sign"></i> {{round($inv->total_amount-$inv->igst,2)}}</span>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <label>Price: </label>
                                <span><i class="fa fa-rupee-sign"></i> {{round($inv->total_amount-$inv->igst,2)}}</span>
                            </div>
                        </div>
                    @endif
                </td>
                <td>
                    {{round($inv->total_amount,2)}}
                </td>
              </tr>
              @endforeach
            </tbody>
       
          </table>
        </div>
    </div>
</div>

@endsection
