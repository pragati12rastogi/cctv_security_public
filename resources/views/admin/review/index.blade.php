@extends('layouts.admin')
@section('title', 'Review Summary|')

@section('breadcrumb')
<li class="breadcrumb-item active">Review Summary</li>
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
    
    $("#review_table").DataTable();
    
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
                  <h4 class="m-0">{{__("Review Summary")}}</h4>
                </div>
                
            </div>
        </div>  
        <div class="card-body">
            <table id="review_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                @foreach($reviews as $review)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$review->product->name}}</td>
                    <td>{{$review->customer['name']}}</td>
                    <td>
                        {{$review->customer['email']}}
                    </td>
                    <td>
                        @for($i=1;$i<=$review->rating;$i++)
                           
                            <span class="fa fa-star"></span>
                            
                        @endfor
                    </td>
                    <td>
                        {{$review->review}}
                    </td>
                    <td>
                        
                        <a data-toggle="modal" data-target="#{{$review->id}}_review"  class="btn btn-xs btn-danger ">
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
@foreach($reviews as $review)
    <div id="{{ $review->id }}_review" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this Product Review? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/review-delete/'.$review->id)}}" class="pull-right">
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
