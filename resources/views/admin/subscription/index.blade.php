@extends('layouts.admin')
@section('title', 'Subscribers List|')

@section('breadcrumb')
<li class="breadcrumb-item active">Subscribers List</li>
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
    
    $("#service_table").DataTable();
    
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
                  <h4 class="m-0">{{__("Subscribers List")}}</h4>
                </div>
                
            </div>
        </div>  
        <div class="card-body">
            <table id="sub_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Email</th>
                    
                    
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                @foreach($subs as $sub)
                <tr>
                    <td>{{$i++}}</td>
                    
                    
                    <td>{{$sub->email}}</td>
                    
                    <td>
                        
                        <a data-toggle="modal" data-target="#{{$sub->id}}_sub"  class="btn btn-xs btn-danger ">
                            Remove
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
        
            </table>
        </div>
    </div>
</div>
@foreach($subs as $sub)
    <div id="{{ $sub->id }}_sub" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to remove user from subscription list? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/subscriptions-delete/'.$sub->id)}}" class="pull-right">
                            {{csrf_field()}}
                            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endforeach
@endsection
