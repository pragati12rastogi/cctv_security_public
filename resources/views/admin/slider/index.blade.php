@extends('layouts.admin')
@section('title', 'Slider Summary|')

@section('breadcrumb')
<li class="breadcrumb-item active">Slider Summary</li>
@endsection

@section('css')
    <style>
        .width-height{
           
            height:10%;
        }
    </style>
@endsection
@section('js')
<script>
$(function() {
    
    $("#slider_table").DataTable();
    
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
                  <h4 class="m-0">{{__("Slider Summary")}}</h4>
                </div>
                <div class="col-md-2" >
                    <a href="{{url('admin/slider/create')}}" class="btn-dark btn-sm card-btn-right">{{__("Add Slider")}}</a>
                </div>
            </div>
        </div>  
        <div class="card-body">
            <table id="slider_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Heading</th>
                    <th>Content</th>
                    <th>Button Text</th>
                    <th>Button URL</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                @foreach($sliders as $slider)
                <tr>
                    <td>{{$i++}}</td>
                    
                    <td>
                        @if($slider->photo != '' && file_exists(public_path().'/assets/uploads/slider/'.$slider->photo) )
                            <img class="margin-right-15 width-height" align="left" src="{{url('assets/uploads/slider/'.$slider->photo)}}" title="{{ $slider->heading }}">
                        @endif
                    </td>
                    <td>{{$slider->heading}}</td>
                    <td>{{substr(strip_tags($slider->content), 0, 250)}}{{strlen(strip_tags($slider->content))>250 ? '...' : ""}}</td>
                    <td>{{$slider->button_text}}</td>
                    <td>{{$slider->button_url}}</td>
                    <td>
                        <a href=" {{url('admin/slider/'.$slider->id.'/edit')}} " class="btn btn-xs btn-info">
                            <i class="fa fa-pen"></i>
                        </a>
                        &nbsp;
                        <a data-toggle="modal" data-target="#{{$slider->id}}_slider"  class="btn btn-xs btn-danger ">
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
@foreach($sliders as $slider)
    <div id="{{ $slider->id }}_slider" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this slider? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/slider/'.$slider->id)}}" class="pull-right">
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
