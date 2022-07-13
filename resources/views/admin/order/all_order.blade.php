@extends('layouts.admin')
@section('title', 'All Orders |')

@section('breadcrumb')
<li class="breadcrumb-item active">All Orders</li>
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
                    <h4 class="m-0">{{__("All Orders")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            
          <table id="allorders_table" class="table table-bordered table-striped">
            <thead>
              <tr class="table-heading-row">
                <th>Order Id</th>
                <th>Users</th>
                <th>Payment Method</th>
                <th>Order Total</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
              @foreach($order as $ord)
              <tr>
                <td>{{$ord->order_id}}</td>
                <td>{{$ord->user['name']}}</td>
                <td>{{$ord->payment_method}}</td>
                <td>
                    <i class="fa fa-rupee-sign"></i> {{sprintf("%.2f",$ord->order_total + $ord->shipping_total,2)}}
                </td>
                <td>
                    @php
                        $invoice =  $ord->invoices;
                        $qty = 0;
                        foreach($invoice as $inv){
                            $qty = $qty+$inv['qty'];
                        }

                    @endphp
                    {{$qty}}
                </td>
                <td>
                    {{date('d-m-Y',strtotime($ord->created_at))}}
                </td>
                <td>
                    <a href=" {{url('admin/all/orders/edit/'.$ord->id)}} " class="btn btn-xs btn-success">
                        Edit
                    </a>
                    <a href=" {{url('admin/fullorder/generate/invoice/'.$ord->id)}} " class="btn btn-xs btn-dark">
                        Invoice
                    </a>
                </td>
              </tr>
              @endforeach
            </tbody>
       
          </table>
        </div>
    </div>
</div>

@endsection
