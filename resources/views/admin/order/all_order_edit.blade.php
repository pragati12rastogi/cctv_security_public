@extends('layouts.admin')
@section('title', 'Order: '.$order->order_id.' |')

@section('breadcrumb')
<li class="breadcrumb-item "><a href="{{route('all.orders')}}">All Orders</a></li>
<li class="breadcrumb-item active">Order: {{$order->order_id}}</li>
@endsection
@section('css')
  
@endsection
@section('js')
<script>
    var order_status_url ="{{url('admin/update/orderstatus/')}}";
    var payment_recieve_url ="{{url('admin/manual/orderpayconfirm/'.$order->id)}}";
</script>
<script src="{{ url('js/order_status.js') }}"></script>

@endsection
@section('content')

<div class="container-fluid">
    @include('flash-message')
    <div class="alert alert-success alert-block" id="js_alert_success" style="display:none;">
        <strong></strong>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="m-0">Order: {{$order->order_id}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class=" mb-3">
                                Customer Details :
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <label>Name :</label>
                            <span>{{$order->user->name}}</span>
                        </div>
                        <div class="col-md-4">
                            <label>Email :</label> 
                            <span>{{$order->user->email}}</span>

                        </div>
                        <div class="col-md-4">
                            <label>Mobile No :</label> 
                            <span>{{$order->user->phone}}</span>

                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 mt-10">
                            <h4 class=" mb-3"> Address :</h4>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12">
                                Shipping Address :
                            </label>
                            <br>
                            <div class="col-md-12">
                                
                                <span>{{$order->shipping_address['first_name']}} {{$order->shipping_address['last_name']}}</span>
                            </div>
                            <div class="col-md-12">
                                
                                <span>{{$order->shipping_address['email']}}</span>
                            </div>
                            <div class="col-md-12">
                                
                                <span>{{$order->shipping_address['phone']}}</span>
                            </div>
                            <div class="col-md-12">
                                
                                <span>{{$order->shipping_address['suit_no']}} {{$order->shipping_address['address']}}</span>
                                <br>
                                <span>
                                    @php
                                        $ship_country = App\Helper\CustomHelper::get_country($order->shipping_address['country_id']);
                                        $ship_state = App\Helper\CustomHelper::get_state($order->shipping_address['state_id']);
                                        if(!empty($ship_country)){
                                            $ship_country = $ship_country['name'];
                                        }else{
                                            $ship_country = ''; 
                                        }
                                        if(!empty($ship_state)){
                                            $ship_state = ucfirst(strtolower($ship_state['state_name']));
                                        }else{
                                            $ship_state = ''; 
                                        }
                                    @endphp

                                    {{$ship_state}} {{$ship_country}}
                                </span>
                            </div>
                            <div class="col-md-12">
                                
                                <span>{{$order->shipping_address['zipcode']}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12">
                                Billing Address :
                            </label>
                            <br>
                            <div class="col-md-12">
                                <span>{{$order->billing_address['first_name']}} {{$order->billing_address['last_name']}}</span>
                            </div>
                            <div class="col-md-12">
                                <span>{{$order->billing_address['email']}}</span>
                            </div>
                            <div class="col-md-12">
                                <span>{{$order->billing_address['phone']}}</span>
                            </div>
                            <div class="col-md-12">
                                <span>{{$order->billing_address['suit_no']}} {{$order->billing_address['address']}}</span>
                                <br>
                                <span>
                                    @php
                                        $bill_country = App\Helper\CustomHelper::get_country($order->billing_address['country']);
                                        $bill_state = App\Helper\CustomHelper::get_state($order->billing_address['state_id']);
                                        if(!empty($bill_country)){
                                            $bill_country = $bill_country['name'];
                                        }else{
                                            $bill_country = ''; 
                                        }
                                        if(!empty($bill_state)){
                                            $bill_state = ucfirst(strtolower($bill_state['state_name']));
                                        }else{
                                            $bill_state = ''; 
                                        }
                                    @endphp

                                    {{$bill_state}} {{$bill_country}}
                                </span>
                            </div>
                            <div class="col-md-12">
                                <span>{{$order->shipping_address['zipcode']}}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12 mt-10">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-3"> Order Summary :</h4>
                        </div>
                        <div class="col-md-4">
                            <label>Total Qty:</label>
                            <span>
                                @php
                                    $invoice = $order->invoices;
                                    $qty = 0;
                                    foreach($invoice as $inv){
                                        $qty = $qty+$inv['qty'];
                                    }
                                @endphp
                                {{$qty}}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label>Payment Method:</label>
                            <span>
                                {{$order->payment_method}}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label>Order Date:</label>
                            <span>
                                {{date('d-m-Y @ h:i a',strtotime($order->created_at))}}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label>Order Total:</label>
                            <span>
                                <i class="fa fa-inr"></i> {{sprintf("%.2f",$order->order_total + $order->shipping_total,2)}}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label>Transaction ID:</label>
                            <span>
                                {{$order->transaction_id}}
                            </span>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($order->manual_payment ==  1)
                                        <label>Payment Recieved:</label>
                                        <select class="form-control" id="pay_recieve" >
                                            <option value="0" {{$order->payment_receive == 0 ? 'selected':''}} > No  </option>
                                            <option value="1" {{$order->payment_receive == 1 ? 'selected':''}} > Yes </option>
                                        </select>
                                    @else
                                        <p><b>Payment Recieved:</b> {{ $order->payment_receive == 1 ? 'Yes' : 'No' }}</p>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($order->payment_method ==  'BankTransfer')
                                        <b class="text-cyan"><a href="{{url('assets/uploads/purchase_proof/'.$order->purchase_proof)}}" target="blank">Click on Purchase Proof</a></b>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            <div class=" mt-16">
                <table id="invoice_list" class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-heading-row">
                            <th>Invoice No</th>
                            <th>Item Name</th>
                            <th >Qty</th>
                            <th width="15%">Status</th>
                            <th width="10%">Price</th>
                            <th width="10%">Total</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->invoices as $inv_ind => $inv_data)
                            <tr>
                                <td>#Inv{{$inv_data->id}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2">
                                            @if(count($inv_data->product->photos)>0 && file_exists('assets/uploads/product_photos/'.$inv_data->product->photos[0]['image']) )
                                                <img class="img-responsive " src="{{url('assets/uploads/product_photos/'.$inv_data->product->photos[0]['image'])}}" >
                                            @else
                                                <img class="img-responsive " src="{{url('/front/img/no-image.jpg')}}">
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{url('user/product/'.$inv_data->product['id'])}}"><b>{{$inv_data->product['name']}}</b></a>
                                            <br>
                                            <small>
                                            <label>Price : </label><span> <i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->actual_amount - $inv_data->tax_amount,2)}}</span>
                                            </small>
                                            @if(!empty($inv_data->tax_amount))
                                            <br>
                                            <small>
                                            <label>Tax : </label><span> <i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->tax_amount,2)}} </span></small>
                                            @endif
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

                                    @php
                                        $cancellog = App\Models\CancelledInvoice::where('order_id','=',$inv_data->order->id)->where('invoice_id','=',$inv_data->id)->first();
                                    @endphp

                                    @if( empty($cancellog) && $inv_data->order_product_status != 'delivered' && $inv_data->order_product_status != 'cancelled' && $inv_data->order_product_status != 'refunded' && $inv_data->order_product_status != 'returned' && $inv_data->order_product_status != 'refunded' && $inv_data->order_product_status != 'ret_ref' && $inv_data->order_product_status != 'return_request')
                                        <br>
                                        <br>
                                        <select name="status" id="status{{ $inv_data->id }}" onchange="orderChangeStatus('{{ $inv_data->id }}')" class="form-control">
                                            <option {{ $inv_data->order_product_status =="pending" ? "selected" : "" }} value="pending">Pending
                                            </option>
                                            <option {{ $inv_data->order_product_status =="processed" ? "selected" : "" }} value="processed">Processed
                                            </option>
                                            <option {{ $inv_data->order_product_status =="shipped" ? "selected" : "" }} value="shipped">Shipped
                                            </option>
                                            <option {{ $inv_data->order_product_status =="delivered" ? "selected" : "" }} value="delivered">Delivered
                                            </option>
                                        </select>

                                    @endif
                                    
                                </td>
                                <td>
                                    <small>
                                    @if(!empty($inv_data->tax_amount))
                                        @if(!empty($inv_data->igst))
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Price: </label>
                                                <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->total_amount-$inv_data->igst,2)}}</span>
                                            </div>
                                            <div class="col-md-12">
                                                
                                                <label>IGST: </label>
                                                <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->igst,2)}}</span>
                                            </div>
                                        </div>
                                        @elseif(!empty($inv_data->scgst))
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Price: </label>
                                                <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->total_amount-($inv_data->scgst+$inv_data->scgst),2)}}</span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>SGST: </label>
                                                <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->scgst,2)}}</span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>CGST: </label>
                                                <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->scgst,2)}}</span>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Price: </label>
                                                <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->total_amount-$inv_data->igst,2)}}</span>
                                            </div>
                                        </div>
                                        @endif
                                    @else
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Price: </label>
                                                <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->total_amount-$inv_data->igst,2)}}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if( !empty($inv_data->shipping_rate))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Shipping rate: </label>
                                            <span><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->shipping_rate,2)}}</span>
                                        </div>
                                    </div>
                                    @endif
                                    </small>
                                </td>
                                <td><i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$inv_data->total_amount + $inv_data->shipping_rate,2)}}</td>
                                <td>
                                    <a href="{{url('admin/order/invoice/pdf/'.$inv_data->id)}}" class="btn btn-sm btn-primary"> Invoice </a> &nbsp;&nbsp;

                                    @php
                                        $cancellog = App\Models\CancelledInvoice::where('order_id','=',$inv_data->order->id)->where('invoice_id','=',$inv_data->id)->first();
                                    @endphp

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
                            <td colspan = "4">
                                @if(!empty($order->special_note))
                                <label>Special Note:</label>
                                <span>{{$order->special_note}}</span>
                                @endif
                            </td>
                            <td>Grand Total:</td>
                            <td>
                                <i class="fa fa-rupee-sign"></i>
                                <span> {{sprintf("%.2f",$order->order_total + $order->shipping_total,2)}} </span>
                            </td>
                        </tr>
                    </tbody>
            
                </table>
            </div>
            
        </div>
    </div>
</div>
@foreach($order->invoices as $o)

	@if($o->order_product_status != 'cancelled' && $o->order_product_status != 'returned' && $o->order_product_status !=
							'return_request' && $o->order_product_status != 'delivered' && $o->order_product_status !='ret_ref' &&
							$o->order_product_status !='refunded' && $o->product->cancel_available != 0)
							
		<div data-backdrop="static" data-keyboard="false" class="modal fade" id="singleordercancel{{ $o->id }}" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						
						<h4 class="modal-title" id="myModalLabel">Cancel Item: {{$o->product->name}}
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
						<form action="{{ route('cancel.item',$secureid) }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">Choose Reason <span class="required">*</span></label>
								<select class="form-control" required="" name="comment" id="">
									<option value="">Please Choose Reason</option>
									<option value="Requested by User">Requested by User</option>
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
