@extends('layouts.admin')
@section('title', 'Sub Category Summary|')

@section('breadcrumb')
<li class="breadcrumb-item active">Sub Category Summary</li>
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
    
    $("#category_table").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
            extend:'excelHtml5',
            exportOptions: {
                columns: [ 0, 1,2, 4 ,5] 
               }
            },
            {
            extend:'csvHtml5',
            exportOptions: {
                columns: [ 0, 1,2, 4 ,5] 
               }
            },
            {
            extend:'pdfHtml5',
            exportOptions: {
                columns: [ 0, 1,2, 4,5 ] //Your Column value those you want
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
                  <h4 class="m-0">{{__("Sub Category Summary")}}</h4>
                </div>
                <div class="col-md-2" >
                    <a href="{{url('admin/subcategory/create')}}" class="btn-dark btn-sm card-btn-right">{{__("Add Sub Category")}}</a>
                </div>
            </div>
        </div>  
        <div class="card-body">
            <table id="category_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Subcategory Name</th>
                    <th>Category Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                @foreach($subcategories as $subcat)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$subcat->name}}</td>
                    <td>{{$subcat->category['name']}}</td>
                    
                    <td>
                        @if($subcat->image != '' && file_exists(public_path().'/assets/uploads/subcategory/'.$subcat->image) )
                            <img class="margin-right-15 width-height" align="left" src="{{url('assets/uploads/subcategory/'.$subcat->image)}}" title="{{ $subcat->name }}">
                        @endif
                    </td>
                    <td>{{substr(strip_tags($subcat->description), 0, 250)}}{{strlen(strip_tags($subcat->description))>250 ? '...' : ""}}</td>
                    <td>
                        <form action="{{ route('subcat.status.update',$subcat->id) }}" method="POST">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-xs {{$subcat->status?'btn-success':'btn-danger'}}">
                        {{$subcat->status?'Active':'Deactive'}}
                        </button>
                        </form>
                    </td>
                    <td>
                        <a href=" {{url('admin/subcategory/'.$subcat->id.'/edit')}} " class="btn btn-xs btn-info">
                            <i class="fa fa-pen"></i>
                        </a>
                        &nbsp;
                        <a data-toggle="modal" data-target="#{{$subcat->id}}_subcategory"  class="btn btn-xs btn-danger ">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
        
            </table>
        </div>
    </div>
</div>
@foreach($subcategories as $subcat)
    <div id="{{ $subcat->id }}_subcategory" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this sub-category? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/subcategory/'.$subcat->id)}}" class="pull-right">
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
