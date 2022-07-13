@extends('layouts.admin')
@section('title', 'Show Return Order #inv'.$rorder->invoice_id.' |')

@section('breadcrumb')
<li class="breadcrumb-item active">Show Return Order #inv{{$rorder->invoice_id}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    
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
                    <h4 class="m-0">Invoice No: #inv{{ $rorder->invoice_id}} | Order ID: {{$rorder->order->order_id}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h4>Refund Order Summary</h4>
            <table class="table table-striped">
				<thead>
					<th>
						Item
					</th>
					<th>
						Qty
					</th>
					<th>
						Status
					</th>
					<th>
						Refund Total
					</th>
					<th>
						REF.No/Transcation ID
					</th>
				</thead>
                <tbody>
					<tr>
						<td>

							<div class="row">
								<div class="col-md-2">
                                    @if(count($rorder->invoice->product->photos)>0 && file_exists('assets/uploads/product_photos/'.$rorder->invoice->product->photos[0]['image']) )
										<img class="img-responsive img-thumbnail" src="{{url('assets/uploads/product_photos/'.$rorder->invoice->product->photos[0]['image'])}}" >
									@else
										<img class="img-responsive img-thumbnail" src="{{url('/front/img/no-image.jpg')}}">
									@endif
								</div>

								<div class="col-md-10">
									<b>{{ $rorder->invoice->product->name }}</b>
								</div>
							</div>
							
						</td>
						<td>
							{{ $rorder->qty }}
						</td>
						<td>
							<b>{{ ucfirst($rorder->status) }}</b> 
						</td>
						<td>
							<b><i class="fa fa-rupee-sign"></i>{{ round($rorder->amount,2) }}</b>
						</td>
						<td>
							<b>{{ $rorder->txn_id }}</b>
						</td>
					</tr>
				</tbody>
            </table>
            <p></p>
			<div class="reason">
				<blockquote>
					Reason for Return: <span class="font-weight600">{{ $rorder->reason }}</span>
				</blockquote>
			</div>
            <p></p>
			<div class="reason">
				<blockquote>
					Refund Method : <span class="font-weight600">Bank</span>
				</blockquote>
			</div>
            <div class="">
                <div class=" col-md-6">
					<div class="well">
                        <div class="user-header">
                            <h4>User's Payment Details</h4>

                        </div>
                        <div class="bankdetail">
                            @php
                            $bank = $rorder->bank_details;
                            @endphp	
                            <p><b>A/c Holder name: </b> {{ $bank['bankname'] }}</p>
                            <p><b>Bank Name: </b> {{ $bank['account_name'] }}</p>
                            <p><b>A/c No. </b> {{ $bank['account_no'] }}</p>
                            <p><b>IFSC Code: </b> {{ $bank['ifsc'] }}</p>
                        </div>
                        
                    </div>
				
                </div>
                <div class=" col-md-6">
					<div class="well">

						<div class="user-header">
							<h4>Pickup Location</h4>

						</div>
						<div class="bankdetail">
							
							@php
							$x = $rorder->pickup_location;
							@endphp
							<h4><b>{{$x['name']}}</b></h4>
							<p>
								{{ strip_tags($x['address']) }}
							</p>
							<p>{{ $x['city'] }},{{ $x['state'] }},{{ $x['country'] }},</p>
							<p>{{ $x['zipcode'] }}</p>
							
							
						</div>
						
					</div>
				</div>
            </div>
            <p></p>
			<div class="row">
				<h4 class="margin-15">Update Refund Details</h4>
				<form action="{{ route('return.order.update',$rorder->id) }}" method="POST">
					@csrf

					<div class="col-md-4">
						<label>UPDATE AMOUNT:</label>
						<div class="input-group">
							 <div class="input-group-addon text-sm"><i class="fa fa-rupee-sign"></i>
							 </div>
						<input readonly name="amount" id="txn_amount" type="text" class="form-control" value="{{ round($rorder->amount,2) }}"/>
						<input type="hidden" value="{{ round($rorder->amount,2) }}" id="actualAmount">

						</div>
						<small class="help-block">(Amount will be updated if transcation fee charged)</small>
					</div>

					<div class="col-md-4">
						<label>UPDATE Transaction ID:</label>
						<input type="text" class="form-control" value="{{ $rorder->txn_id }}" name="txn_id">
						<small class="help-block">(Use when, when bank transfer method is choosen)</small>
					</div>

					<div class="col-md-4">
						<label>UPDATE Transaction Fees:</label>
						<div class="input-group">
							 <div class="input-group-addon text-sm"><i class="fa fa-rupee-sign"></i>
							 </div>
					   		<input {{ $rorder->pay_mode == 'bank' ? "" : "readonly" }} placeholder="0.00" type="text" class="form-control" value="" name="txn_fee" id="txn_fee">
						</div>
						<small class="help-block">(If charging during bank transfer (eg. in NEFT,IMPS,RTGS) Enter fee).</small>
					</div>

					<div class="col-md-4">
						<label>UPDATE Refund Status:</label>
						<select name="status" class="form-control">
							<option value="refunded">Refunded</option>
							
						</select>
					</div>

					<div class="col-md-4">
						<label>UPDATE Order Status:</label>
						<select name="order_status" class="form-control">
							<option value="ret_ref">Returned & Refunded</option>
							<option value="returned">Returned</option>
							<option value="refunded">Refunded</option>
						</select>
					</div>
					<div class="col-md-12">
						<br>
						<div class="form-group">
							<button title="This action cannot be undone!" type="submit" class="btn btn-md btn-primary">
								<i class="fa fa-check-circle-o" aria-hidden="true"></i> Initiate Refund
							</button>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>




@endsection
