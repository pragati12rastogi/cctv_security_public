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
                <div class="col-md-1">
                    <a title="Back" onclick="window.location = '{{ route('all.return.order') }}'" class="back btn btn-md btn-default">
                        <i class="fa fa-reply"></i>
                    </a>
                </div>
                <div class="col-md-10">
                    <h4 class="my-sm-3">Return & Refund Detail for Item {{$rorder->invoice->product->name}}</h4>
                </div>
                <div class="col-md-1">
                <a title="Print Slip" onclick="window.print()" class="back btn btn-md btn-default">
					<i class="fa fa-print"></i>
				</a>
                </div>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
				<div class="col-md-4 mb-3">
					<h5 class="margin-15">Order <b>{{ $rorder->order->order_id }} > #Inv{{$rorder->invoice_id}}</b>
					</h5>
				</div>
				<div class="col-md-4 mb-3">
					<h5 class="margin-15">TXN ID: <b>{{ $rorder->txn_id }}</b>
					</h5>
				</div>
				<div class="col-md-4 mb-3">
					<h5 class="margin-15">Refunded On: <b>{{ date('d-m-Y @ h:i A',strtotime($rorder->updated_at)) }}</b></h5>
				</div>

				<div class="col-md-4 mb-3">
					<h4 class="margin-15">Customer Name:
					<b>{{ ucfirst($rorder->user->name) }}</b></h4>
				</div>

				<div class="col-md-4 mb-3">
					<h4 class="margin-15">Refund Method : <b>{{ ucfirst($rorder->pay_mode) }}</b></h4>
				</div>

				@if($rorder->pay_mode == 'bank')
                    @php 
                        $bank = $rorder->bank_details;
                    @endphp
					<div class="col-md-4 mb-3">
						<h4 class="margin-15">Refunded To {{ ucfirst($rorder->user->name) }}'s Bank A/C <b>XXXX{{ substr($bank['account_no'], -4) }}</b></h4>
					</div>
				@endif

			</div>
            <hr>
			<table class="font-size-14 width100 table table-striped">
				<thead>
					<th>
						Item
					</th>

					<th>
						Qty
					</th>

					<th>
						Refunded Amount
					</th>

					<th>
						Additional Info.
					</th>
				</thead>
                <tbody>
                    <tr>
						<td width="40%">
                            <div class="row">
                                <div class="col-md-2">
                                    @if(count($rorder->invoice->product->photos)>0 && file_exists('assets/uploads/product_photos/'.$rorder->invoice->product->photos[0]['image']) )
                                        <img class="img-responsive img-thumbnail" src="{{url('assets/uploads/product_photos/'.$rorder->invoice->product->photos[0]['image'])}}" >
                                    @else
                                        <img class="img-responsive img-thumbnail" src="{{url('/front/img/no-image.jpg')}}">
                                    @endif
                                </div>
                                <div class=" col-md-8">
                                    <a ><b>{{$rorder->invoice->product->name}}</b></a>
                                </div>
                            </div>
						</td>
						<td>
							{{$rorder->invoice->qty}}
						</td>

						<td><b><i class="fa fa-rupee-sign"></i>{{ $rorder->amount }} </b><br>
                         
                        </td>

                        <td>
							
							@if($rorder->txn_fee !='')
								<p><b>Transcation FEE:</b> &nbsp;<i class="fa fa-rupee-sign"></i>{{ $rorder->txn_fee }} (During Bank Transfer)</p>
							@endif
                        	
                        </td>
					</tr>
				</tbody>
			</table>
            
        </div>
    </div>
</div>




@endsection
