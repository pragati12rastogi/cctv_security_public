@extends('layouts.admin')
@section('title', 'Offers Summary|')

@section('breadcrumb')
<li class="breadcrumb-item active">Offers Summary</li>
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
    
    $("#offer_table").DataTable();
    
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
                  <h4 class="m-0">{{__("Offers Summary")}}</h4>
                </div>
                <div class="col-md-2" >
                    <a href="{{url('admin/offers/create')}}" class="btn-dark btn-sm card-btn-right">{{__("Add Offer")}}</a>
                </div>
            </div>
        </div>  
        <div class="card-body">
            <table id="offer_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Tag</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                @foreach($offer as $off)
                <tr>
                    <td>{{$i++}}</td>
                    
                    <td>
                        @if($off->photo != '' && file_exists(public_path().'/assets/uploads/offer/'.$off->photo) )
                            <img class="margin-right-15 width-height" align="left" src="{{url('assets/uploads/offer/'.$off->photo)}}" title="{{ $off->heading }}">
                        @endif
                    </td>
                    <td>{{$off->tag}}</td>
                    <td>{{$off->title}}</td>
                    
                    <td>
                        <a href=" {{url('admin/offers/'.$off->id.'/edit')}} " class="btn btn-xs btn-info">
                            <i class="fa fa-pen"></i>
                        </a>
                        &nbsp;
                        <a data-toggle="modal" data-target="#{{$off->id}}_offer"  class="btn btn-xs btn-danger ">
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
@foreach($offer as $off)
    <div id="{{ $off->id }}_offer" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this offer? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/offers/'.$off->id)}}" class="pull-right">
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
