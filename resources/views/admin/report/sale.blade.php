@extends('layouts.admin')
@section('title', 'Sales Report|')

@section('breadcrumb')
<li class="breadcrumb-item active">Sales Report</li>
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
    var table;
$(function() {
    
    tablecreate()
    $('.date-range-filter').change(function() {
                
        table.draw();
    });
    
});

function tablecreate(){
    if(table){
        table.destroy();
    }
    table = $("#sales_table").DataTable({
        "processing": true,
        "serverSide": true,
        "aaSorting": [],
        "responsive": true,
        ajax: {
            url: '{{route("sale.report.api")}}',
            datatype: "json",
            "data": function (data,json) {
                var startDate = $('#min-date').val();
                var endDate = $('#max-date').val();
                data.startDate = startDate;
                data.endDate = endDate;
                
            }
        },
        
        "columns": [
            {   
                "targets": [ -1 ],
                "data": "id","render": function(data,type,full,meta){
                    return  meta.row + 1;
                }  
            },
            { "data": "pname" },
            { "data": "cat" },
            { "data": "sub_cat" },
            
            {   
                "targets": [ -1 ],
                "data": "total_amount","render": function(data,type,full,meta){
                    var str = data + full.shipping_rate;
                    return str;
                }  
            },
            { "data": "qty" },
            { "data": "updated" }

        ],
        dom: 'Bfrtip',
        buttons: [
            
            'excelHtml5',
            
        ]
    });
}

</script>
@endsection
@section('content')
    <div class="container-fluid">
    @include('flash-message')
        <div class="card">
            <div class="card-header">
            <div class="row">
                    <div class="col-md-10">
                    <h4 class="m-0">{{__("Sales Report")}}</h4>
                    </div>
                    
                </div>
            </div>  
            <div class="card-body">
                <div class="">
                    <div class="col-md-5 pull-right">
                        <div class="input-group input-daterange ">
                            <input autocomplete="off" name="startDate" type="date" id="min-date" class="form-control datepicker date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
                            <div class="input-group-addon">to</div>
                            <input autocomplete="off" name="endDate" type="date" id="max-date" class="form-control datepicker date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
                        </div>
                        
                    </div>
                </div>
                <table id="sales_table" class="table table-bordered table-striped ">
                    <thead>
                    <tr class="table-heading-row">
                        <th>Sr. No.</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
            
                </table>
            </div>
        </div>
    </div>

@endsection
