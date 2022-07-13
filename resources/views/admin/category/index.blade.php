@extends('layouts.admin')
@section('title', 'Category Summary|')

@section('breadcrumb')
<li class="breadcrumb-item active">Category Summary</li>
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
                columns: [ 0, 1, 3,4 ] 
               }
            },
            {
            extend:'csvHtml5',
            exportOptions: {
                columns: [ 0, 1, 3,4 ] 
               }
            },
            {
            extend:'pdfHtml5',
            exportOptions: {
                columns: [ 0, 1, 3,4 ] //Your Column value those you want
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
                  <h4 class="m-0">{{__("Category Summary")}}</h4>
                </div>
                <div class="col-md-2" >
                    <a href="{{url('admin/topcategory/create')}}" class="btn-dark btn-sm card-btn-right">{{__("Add Category")}}</a>
                </div>
            </div>
        </div>  
        <div class="card-body">
            <table id="category_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                @foreach($categories as $category)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$category->name}}</td>
                    <td>
                        @if($category->image != '' && file_exists(public_path().'/assets/uploads/category/'.$category->image) )
                            <img class="margin-right-15 width-height" align="left" src="{{url('assets/uploads/category/'.$category->image)}}" title="{{ $category->name }}">
                        @endif
                    </td>
                    <td>{{substr(strip_tags($category->description), 0, 250)}}{{strlen(strip_tags($category->description))>250 ? '...' : ""}}</td>
                    <td>
                        <form action="{{ route('topcat.status.update',$category->id) }}" method="POST">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-xs {{$category->status?'btn-success':'btn-danger'}}">
                        {{$category->status?'Active':'Deactive'}}
                        </button>
                        </form>
                    </td>
                    <td>
                        <a href=" {{url('admin/topcategory/'.$category->id.'/edit')}} " class="btn btn-xs btn-info">
                            <i class="fa fa-pen"></i>
                        </a>
                        &nbsp;
                        <a data-toggle="modal" data-target="#{{$category->id}}_category"  class="btn btn-xs btn-danger ">
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
@foreach($categories as $category)
    <div id="{{ $category->id }}_category" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this category? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/topcategory/'.$category->id)}}" class="pull-right">
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
