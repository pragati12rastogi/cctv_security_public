@extends('layouts.admin')
@section('title', 'Product Summary |')

@section('breadcrumb')
<li class="breadcrumb-item active">Product Summary</li>
@endsection

@section('css')
<style>
    .width-height{
        width: 100px;
        height: 100px;
    }
</style>
@endsection
@section('js')
<script>
$(function() {
    
    $("#product_table").DataTable({
        "processing": true,
        "serverSide": true,
        "aaSorting": [],
        "responsive": true,
        "ajax": '{{url("admin/productlistapi")}}',
        "columns": [
            { "data": "id" },
            { 
                "targets": [ -1 ],
                "data": "product_image","render": function(data,type,full,meta){
                    var str = '';
                    if(data != '' && data != null){
                        str = '<img class="margin-right-15 width-height" align="left" src="{{url("assets/uploads/product_photos/")}}/'+ data +'" title="'+full.name+'">';
                    }else{
                        str = '<img class="margin-right-15 width-height" align="left" src="{{url("assets/uploads/product_photos/noimage.png")}}" title="'+full.name+'">'
                    }

                    return str;
                } 
            },
            { "data": "name" },
            { 
                "targets": [ -1 ],
                "data": "cat","render": function(data,type,full,meta){

                    str = '<p><label>Category :</label>'+data+'</p>'+
                    '<p><label>Sub Category :</label>'+full.sub_cat+'</p>'+
                    '<p><label>Child Category :</label>'+full.child+'</p>';
                    
                    return str;
                }
            },
            {
                "targets": [ -1 ],
                "data": "status","render": function(data,type,full,meta){

                    var status = '';
                    var btn_class = '';
                    if(data == 1){
                        status = 'Active';
                        btn_class ='btn-success';
                    }else{
                        status = 'Deactive';
                        btn_class='btn-danger';
                    }
                    return '<form action="{{ url("admin/quickupdate/product/status/") }}/'+full.id+'" method="POST">'+
                      '{{csrf_field()}}'+
                      '<button type="submit" class="btn btn-xs '+btn_class+'">'
                        +status+
                      '</button>'+
                    '</form>';
                }
            },
            {
                "targets": [ -1 ],
                "data":"id", "render": function(data,type,full,meta)
                {   
                    var str ='<a href="{{url("/admin/product/")}}/'+ data +'/edit" class="btn btn-xs btn-info"><i class="fa fa-pen"></i></a>'+
                        '&nbsp;'+
                        '<a data-toggle="modal" data-target="#'+ data +'_product"  class="btn btn-xs btn-danger "><i class="fa fa-trash"></i></a>';
                
                    return str;
                },
                "orderable": false
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
            extend:'excelHtml5',
            exportOptions: {
                columns: [ 0, 2, 3, 4 ] 
               }
            }
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
                  <h4 class="m-0">{{__("Product Summary")}}</h4>
                </div>
                <div class="col-md-2" >
                    <a href="{{url('admin/product/create')}}" class="btn-dark btn-sm card-btn-right">{{__("Add Product")}}</a>
                </div>
            </div>
        </div>  
        <div class="card-body">
            <table id="product_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
               
                </tbody>
        
            </table>
        </div>
    </div>
</div>
@foreach($products as $prod)
    <div id="{{ $prod->id }}_product" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this product? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/product/'.$prod->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                                
                            
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endforeach
@endsection
