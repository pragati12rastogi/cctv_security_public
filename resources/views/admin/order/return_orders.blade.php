@extends('layouts.admin')
@section('title', 'Return Orders |')

@section('breadcrumb')
<li class="breadcrumb-item active">Return Orders</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
    $(function () {
        $("#full_detail_table2").DataTable();
        $("#full_detail_table").DataTable();
    });

    $('#refund_status').on('change', function () {
        var getval = $('#refund_status').val();
        if (getval == 'pending') {
            $("#order_status").append(new Option("Refund Pending", "Refund Pending"));
            $("#order_status option[value='refunded']").remove();
            $("#order_status option[value='returned']").remove();
        } else {
            $("#order_status option[value='Refund Pending']").remove();
            $("#order_status").append(new Option("Refunded", "refunded"));
            $("#order_status").append(new Option("Returned", "returned"));
        }
    });
    
    $('#txn_fee').on('keyup', function () {
		var amount = $('#txn_amount').val();
		var fee = $('#txn_fee').val();
		var newamount = amount - fee;
		if (fee != '') {
			$('#txn_amount').val(newamount);
		} else {
			actualAmount = $('#actualAmount').val();
			$('#txn_amount').val(actualAmount);
		}
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
                    <h4 class="m-0">{{__("Return Orders")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="ordertabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Return Completed @if($countC>0) <span class="badge">{{$countC}}</span> @endif</a></li> 
                <li role="presentation" ><a href="#pendingReturn" aria-controls="home" role="tab" data-toggle="tab">Pending Returns @if($countP>0) <span class="badge">{{$countP}}</span>@endif</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table id="allorders_table" class="table table-bordered table-striped">
                        <thead>
								
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Item</th>
                            <th>Refunded Amount</th>
                            <th>Refund Status</th>

                        </thead>
                        <tbody>
                            @foreach($readedorders as $key=> $order)
                                
                                @if(isset($order->invoice))
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td><b>{{$order->order->order_id}} > #Inv{{ $order->invoice_id}}</b>
                                        <br>
                                        <small>
                                            <a title="View Refund Detail" href="{{  route('return.order.detail',$order->id)  }}" class="text-red">View Detail</a> 
                                        </small>
                                    </td>
                                    <td>
                                        
                                        <b><a target="_blank" title="{{ $order->invoice->product->name }}"href="{{url('user/product/'.$order->invoice->product['id'])}}">{{substr($order->invoice->product->name, 0, 25)}}{{strlen($order->invoice->product->name)>25 ? '...' : ""}} </a></b>	
                                    </td>
                                    <td>
                                        <i class="fa fa-rupee-sign"></i>{{ $order->amount }}
                                    </td>
                                    <td>
                                        <label class="label label-success">
                                            {{ ucfirst($order->status) }}
                                        </label>
                                    </td>
                                </tr>
                                @endif
                                    
                                
                            @endforeach
                        </tbody>
            
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="pendingReturn">
                    <table id="allorders_table" class="table table-bordered table-striped">
                        <thead>
                            <th>#</th>
                            <th>Order TYPE</th>
                            <th>OrderID</th>
                            <th>Pending Amount</th>
                            <th>Requested By</th>
                            <th>Requested on</th>
                            
                        </thead>
                        <tbody>
                        @foreach($unreadorders as $key=> $order)
                            @if(isset($order->invoice) )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        @if($order->order->payment_method != 'COD')
                                            <label for="" class="label label-success">
                                                PREPAID
                                            </label>
                                        @else
                                            <label for="" class="label label-primary">
                                                COD
                                            </label>
                                        @endif
                                    </td>
                                    <td><b>{{$order->order->order_id}} > #Inv{{ $order->invoice_id}}</b>
                                        <br>
                                        <small>
                                            <a href="{{ route('return.order.show',$order->id) }}" class="text-red">UPDATE ORDER</a>
                                        </small>
                                    </td>
                                    <td>
                                        <i class="fa fa-rupee-sign"></i>{{ $order->amount }}
                                    </td>
                                    <td>
                                        {{ $order->user->name }}
                                    </td>
                                    <td>
                                        {{date('d-M-Y @ h:i A',strtotime($order->created_at))}}
                                    </td>
                                    
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
            
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
