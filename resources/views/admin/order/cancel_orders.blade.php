@extends('layouts.admin')
@section('title', 'Cancelled Orders |')

@section('breadcrumb')
<li class="breadcrumb-item active">Cancelled Orders</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
	$(function () {
		$("#allorders_table").DataTable();
	});

  	function singlerefundstatus(id) {
		var getval = $('#refund_status' + id).val();
		if (getval == '0') {
			$("#order_status" + id).append(new Option("Refund Pending", "Refund Pending"));
			$('#order_status' + id + ' option[value="refunded"]').remove();
			$('#order_status' + id + ' option[value="returned"]').remove();
		} else {
			$('#order_status' + id + ' option[value="Refund Pending"]').remove();
			$("#order_status" + id).append(new Option("Refunded", "refunded"));
			$("#order_status" + id).append(new Option("Returned", "returned"));
		}
	}
	
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
                    <h4 class="m-0">{{__("Cancelled Orders")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            
            <table id="allorders_table" class="table table-bordered table-striped">
                <thead>
                    <tr class="table-heading-row">
                        <th>#</th>
                        <th>Order Type</th>
						<th>Invoice ID</th>
						<th>Order ID</th>
                        <th>Reason for Cancellation</th>
                        <th>Refund Method</th>
                        <th>Customer</th>
                        <th>Refund Status</th>

					</tr>
                </thead>
                <tbody>
                    @foreach($cancel_inv as $key=> $order)
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
                            <td>
                                <b>#Inv{{$order->id}} </b>
                                <br>
                                <small class="text-center">
									@if($order->is_refunded == 0)
                                        <a onclick="readorder('{{ $order->id }}')" title="UPDATE Order" class="text-red-600" data-toggle="modal" data-target="#orderupdate{{ $order->id }}">UPDATE ORDER</a>
									@else
										<a onclick="readorder('{{ $order->id }}')" title="UPDATE Order" class="text-red-600" data-toggle="modal" data-target="#orderupdate{{ $order->id }}">CHECK ORDER</a>
                                    @endif
                                </small>
                            </td>
							<td>
                                <b>{{$order->order->order_id}} </b>
							</td>
                            <td>
                                {{ $order->comment }}
                            </td>
                            <td>
								@if($order->pay_method == 'bank')
								{{ ucfirst($order->pay_method) }}
								@else
								No need for COD Orders
								@endif
                            </td>
                            <td>
                                {{$order->user->name}}
                            </td>

                            <td>
                                @if($order->is_refunded == '0')
                                    <label class="label label-primary">Pending</label>
                                @else
                                    <label class="label label-success">Completed</label>
                                @endif
                            </td>

                            <!--trackmodel-->
                        </tr>
                    @endforeach
                </tbody>
       
          </table>
        </div>
    </div>
</div>

@foreach($cancel_inv as $key=> $order)
<!-- UPDATE ORDER Modal -->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="orderupdate{{ $order->id }}" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel">
	<div class="width90 modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				
				<h4 class="modal-title" id="myModalLabel">UPDATE ORDER
					<b>{{ $order->order->order_id }} > #Inv{{$order->id}}</b></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<h4><b>Order Summary</b></h4>
				<hr>
				<div class="row">
					<div class="col-md-3">
						<b>Customer name</b>
						<br>
						<span>{{ $order->user->name }}</span>
					</div>
					<div class="col-md-3">
						<b>Cancel Order Date</b>
						<br>
						<span>{{ date('d-m-Y @ h:i A',strtotime($order->created_at)) }}</span>
					</div>
					<div class="col-md-3">
						<b>Cancel Order Total</b>
						<p>Order Total: <i class="fa fa-rupee-sign"></i>{{ $realamount = $order->invoice->total_amount + $order->invoice->shipping_rate }} </p>
						@if($order->amount != $realamount)
						<p>Refunded Amount : <i class="{{ $order->order->paid_in }}"></i> {{$order->amount}}</p>
						@endif
						
					</div>
					<div class="col-md-3">
						<b>REFUND Transcation ID /REF. ID</b>
						<br>
  						<span>{{ $order->transaction_id }}</span>
					</div>

					<div class="margin-top-15 col-md-4">
						<p><b>Refund Method:</b></p>
  						<br>
						<span>
							@if($order->pay_method == 'COD')
								No Need for COD Orders
							@else
								{{ ucfirst($order->pay_method) }}
							@endif
						</span>
						<p><b>Cancelation Reason:</b></p>
						<blockquote class="panel-primary">
							{{ $order->comment }}
						</blockquote>
					</div>

					

					@if(!empty($order->user->bank))
						 
						<div class="col-md-8">
							@php
  								$bank = $order->user->bank;
							@endphp
							<label>Refund {{ ($order->is_refunded == 1)? 'Compeleted':'Pending' }} In {{ $order->user->name }}'s Account Following
								are details:</label>


							<div class="well">

								<p><b>A/C Holder Name: </b>{{$bank->account_name}}</p>
								<p><b>Bank Name: </b>{{ $bank->bankname }}</p>
								<p><b>Account No: </b>{{ $bank->account_no }}</p>
								<p><b>IFSC Code: </b>{{ $bank->ifsc }}</p>


							</div>
							
						</div>
					@else
						<p>User Bank Details are not filled.</p>
					@endif



				</div>
				
				<hr>
				<h4><b>Items</b></h4>
				<br>

				@if(isset($order->invoice->product))
					<div class="row">
						<div class="col-md-6">

							<div class="row">
								<div class="col-md-3">
									@if(count($order->invoice->product->photos)>0 && file_exists('assets/uploads/product_photos/'.$order->invoice->product->photos[0]['image']) )
										<img class="img-responsive img-thumbnail" src="{{url('assets/uploads/product_photos/'.$order->invoice->product->photos[0]['image'])}}" >
									@else
										<img class="img-responsive img-thumbnail" src="{{url('/front/img/no-image.jpg')}}">
									@endif
								</div>
								<div class="col-md-9">
									<a class="color111 margin-top-15" target="_blank" href="{{url('user/product/'.$order->invoice->product['id'])}}"
										title="Click to view"><b>{{$order->invoice->product->name}}</b>

									</a>
									
									<br>
									<small class="margin-left-15"><b>Qty:</b> {{ $order->invoice->qty }}
									</small>
								</div>
							</div>

						</div>
  						<div class="col-md-6">
							<form id="singleorderform" action="{{ route('single.can.order',$order->id) }}" method="POST">
								<div class="row">	

									<div class="col-md-6">
										<label for="">UPDATE TXN ID OR REF. NO:</label>
										<input type="text" id="txn_fee" name="transaction_id" class="form-control"
											value="{{ $order->transaction_id }}" class="form-control">
										<br>

										<label>Amount :</label>
										<div class="input-group">
											<div class="input-group-addon text-sm"><i class="fa fa-rupee-sign"></i></div>
											<input placeholder="0.00" type="text" name="amount" {{ $order->pay_method == 'bank' ? "" : "readonly" }} class="form-control"
												value="{{ $order->amount }}" class="form-control" id="txn_amount">
										</div>
										<small class="help-block">

											(UPDATE AMOUNT IF CHANGES OR TRANSCATION FEE IS CHARGED)

										</small>

									</div>

									@csrf
									<div class="col-md-6">

										<label for="">UPDATE REFUND STATUS:</label>
										@if($order->order->payment_method != 'COD')
										<select name="refund_status" id="refund_status{{ $order->id }}" class="form-control"
											onchange="singlerefundstatus('{{ $order->id }}')">
											<option {{ $order->is_refunded == '1' ? "selected" : ""}} value="1">
												Completed</option>
											<option {{ $order->is_refunded == '0' ? "selected" : "" }} value="0">Pending
											</option>
										</select>
										@else
										<select readonly name="refund_status" class="form-control">

											<option {{ $order->is_refunded == 'completed' ? "selected" : ""}} value="completed">
												Completed</option>

										</select>
										@endif

										<br>

										<label>Transcation Fee:</label>
										<div class="input-group">
											<div class="input-group-addon text-sm"><i class="fa fa-rupee-sign"></i></div>
											<input {{ $order->pay_method == 'bank' ? "" : "readonly" }} placeholder="0.00"
												type="text" name="txn_fee" class="form-control" value="{{ $order->txn_fee }}"
												class="form-control">
										</div>
										<small class="help-block">

											(UPDATE TRANSCATION FEE IF CHARGED)

										</small>

									</div>

									<div class="col-md-6">
										<label>
											(UPDATE ORDER STATUS)
										</label>
										@if($order->order->payment_method !='COD')
										<select name="order_status" id="order_status{{ $order->id }}" class="form-control">
											@if($order->invoice->order_product_status == 'Refund Pending')
											<option selected value="Refund Pending">Refund Pending</option>
											@elseif($order->invoice->order_product_status == 'refunded' || $order->invoice->order_product_status ==
											'returned')
											<option {{ $order->invoice->order_product_status == 'refunded' ? "selected" : "" }}
												value="refunded">Refunded</option>
											<option {{ $order->invoice->order_product_status == 'returned' ? "selected" : "" }}
												value="returned">Returned</option>
											@endif
										</select>
										@else

										<select name="order_status" id="order_status{{ $order->id }}"
											class="order_status form-control">
											<option {{ $order->invoice->order_product_status == 'cancelled' ? "selected" : "" }}
												value="cancelled">Cancelled</option>
												
											<option {{ $order->invoice->order_product_status == 'returned' ? "selected" : "" }}
												value="returned">Returned</option>
										</select>

										@endif

									</div>

								</div>
								<br>
						</div>
					</div>
				@endif
				<div class="modal-footer">
					@if($order->is_refunded == 0)
					<button type="submit" class="btn btn-primary">Save Changes</button>
					@else
					<b>Amount Refunded On {{date('d-m-Y',strtotime($order->updated_at))}}</b> &nbsp;&nbsp;&nbsp;
					@endif
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
@endforeach


@endsection
