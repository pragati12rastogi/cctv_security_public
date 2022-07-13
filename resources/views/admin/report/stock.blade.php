@extends('layouts.admin')
@section('title', 'Stock Report|')

@section('breadcrumb')
<li class="breadcrumb-item active">Stock Report</li>
@endsection

@section('css')
    <style>
        .width-height{
            width: 10%;
            height:10%;
        }
    </style>
@endsection
@section('js')
<script>
$(function() {
    
    $("#stock_table").DataTable({
        dom: 'Bfrtip',
        buttons: [
            
            'excelHtml5',
            
        ]
    });
    
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
                  <h4 class="m-0">{{__("Stock Report")}}</h4>
                </div>
                
            </div>
        </div>  
        <div class="card-body">
            <table id="stock_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>Sr. No.</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Stock</th>
                    
                </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                @foreach($stock as $s)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$s->name}}</td>
                    <td>
                        {{$s->category->name}}
                    </td>
                    <td>
                        {{$s->subcategory->name}}
                    </td>
                    <td>
                        {{$s->qty}}
                    </td>
                    
                </tr>
                @endforeach
                </tbody>
        
            </table>
        </div>
    </div>
</div>

@endsection
