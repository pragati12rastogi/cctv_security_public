<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>Print Invoice: #Inv{{ $invoice->id }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <link rel="stylesheet" href="{{asset('theme/assets/css/style.css')}}">
	<style>
        .padding-15{
            padding : 15px;
        } 
	</style>
    <script>
        function printIT(){
            document.getElementById("hide-div").style.display = 'none';
            window.print();
        }
    </script>
</head>
<body>
    <div class="container-fluid">
		<h3 class="text-center">Invoice: #Inv{{ $invoice->id }}</h3>
		<div class="row justify-content-md-center">
			<div class="printheader padding-15">
				<br>
                <div id="hide-div">
                    <a href="{{ route('all.orders.edit',$invoice->order_id) }}" title="Go back" class="p_btn2 pull-left btn btn-md btn-default"><i class="fa fa-reply" aria-hidden="true"></i></a>
                    
                    <button title="Print Order" onclick="printIT()" class="p_btn pull-right btn btn-md btn-default"><i class="fa fa-print"></i></button>
                </div>
                <br><br>
                <table class="table table-striped">
                    <thead>
                        <th>
                            #Inv{{ $invoice->id }}
                            <br>
						    TXN ID:{{ $invoice->order->transaction_id }}
                        </th>
                        <th>

                        </th>
                        <th>
                            Ordered From {{ config('app.name') }}
                            <br>
                            <b>Payment Method: {{ $invoice->order->payment_method }}</b>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
							<td colspan="2">
								<b>{{ $store->project_name }},</b>
								<br>
								{{ $store->address }},
								<br>
                                {{ $store->email }}
                                <br>
                                {{ $store->phone }}

							</td>
                            <td>
								<b>Order ID:</b> {{  $invoice->order->order_id }}
								<br>
								<b>Date:</b> {{ date('d-m-Y',strtotime($invoice->created_at)) }}
							</td>
                        </tr>
                        <tr>
							<th>
								<b>Shipping Address</b>
							</th>

							<th></th>

							<th>
								<b>Billing Address</b>
							</th>
						</tr>
                        <tr>
                            <?php $address = $invoice->order->shipping_address;
                                $shipstate = App\Models\State::where('id',$address['state_id'])->first()->state_name;
                                $shipcountry = App\Models\Country::where('id',$address['country_id'])->first()->name;

                                $billing = $invoice->order->billing_address;
                                $billstate = App\Models\State::where('id',$billing['state_id'])->first()->state_name;
                                $billcountry = App\Models\Country::where('id',$billing['country'])->first()->name;
                            ?>
							<td colspan="2">
								<p><b>{{ $address['first_name'] }} {{ $address['last_name'] }}, {{ $address['phone'] }}</b></p>
								<p class="font-weight">{{$address['suit_no']}} {{ strip_tags($address['address']) }}</p>
								<p class="font-weight">{{ ucwords($address['city']) }}, {{ ucwords(strtolower($shipstate)) }}, {{ $shipcountry }}</p>
                                <p class="font-weight">{{ $address['zipcode'] }}</p>
							</td>
                            
							<td colspan="2">
								<p><b>{{ $billing['first_name'] }} {{ $billing['last_name'] }}, {{ $billing['phone'] }}</b></p>
								<p class="font-weight">{{$billing['suit_no']}} {{ strip_tags($billing['address']) }}</p>
								<p class="font-weight">{{ ucwords($billing['city']) }}, {{ ucwords(strtolower($billstate)) }}, {{ $billcountry }}</p>
                                <p class="font-weight">{{ $billing['zipcode'] }}</p>
							</td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
					<thead>
						<tr>
							<th>Item</th>
							<th>Qty</th>
							<th>Pricing & Shipping</th>
							<th>TAX</th>
							<th>Total</th>
						</tr>
					</thead>

					<tbody>
						<tr>
                            <td>
                                <b>{{$invoice->product->name}}</b>
                                <br>
                                <small class="tax"><b>Price:</b> <i class="fa fa-rupee-sign"></i>
									{{ number_format((float)$invoice->actual_amount-$invoice->tax_amount , 2, '.', '')}}
								</small>
                                <small class="tax"><b>Tax:</b> <i class="fa fa-rupee-sign"></i>
								{{ number_format((float)$invoice->tax_amount , 2, '.', '')}}
								</small>
								<br>
								<small class="help-block">(Displayed for single Qty.)</small>
                            </td>
                            <td valign="middle">
								{{ $invoice->qty }}
							</td>
                            <td>
                                <p><b>Price:</b> <i class="fa fa-rupee-sign"></i>
                                    
                                    {{ round($invoice->total_amount-($invoice->tax_amount*$invoice->qty),2) }}</p>
                                
                                <p><b>Shipping rate:</b> <i class="fa fa-rupee-sign"></i>
                                    
                                    {{ round($invoice->shipping_rate,2) }}</p>
                                
                                
                                <small class="help-block">(Price Multiplied with Qty.)</small>
							</td>
                            <td>

								@if(!empty($invoice->igst) )
		                          <p><i class="fa fa-rupee-sign"></i> {{ sprintf("%.2f",$invoice->igst) }} (IGST)</p>
		                        @endif
								@if(!empty($invoice->scgst))
									<p><i class="fa fa-rupee-sign"></i> {{ sprintf("%.2f",$invoice->scgst) }} (SGST)</p>
                                    <p><i class="fa fa-rupee-sign"></i> {{ sprintf("%.2f",$invoice->scgst) }} (CGST)</p>
								@endif
								<small class="help-block">(Tax Multiplied with Qty.)</small>
                            </td>
                            <td>
								<i class="fa fa-rupee-sign"></i>
								
									{{ round($invoice->total_amount + $invoice->shipping_rate,2) }}
								<br>
								<small class="help-block">(Incl. of Tax & Shipping)</small>
							</td>
                            
                        </tr>
                        <tr>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<b>Grand Total:</b>
							</td>
							<td>
                            <i class="fa fa-rupee-sign"></i>
                            {{ round($invoice->total_amount + $invoice->shipping_rate,2) }}
							</td>
						</tr>
                    </tbody>
                </table>
                <p>This is a computer generated invoice *</p>
				<table class="table">
					<tr>
						
                        <td>
                            Seal:
                            <br>
                            <div  style="border:1px solid black;height:70px"></div>
                        </td>
						
						
                        <td>
                            Sign: <br>
                            <div  style="border:1px solid black;height:70px"></div>
                        </td>
						
					</tr>
				</table>
            </div>
        </div>
    </div>
          
</body>
</html>