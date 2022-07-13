@extends("layouts.admin")
@section('title','Edit Service | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/service')}}">Service Summary</a></li>
<li class="breadcrumb-item active">{{__("Edit Service")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    
  });


  
</script>
@endsection
@section("content")
<div class="container-fluid">
    @include('flash-message')
    <div class="card">
        <div class="card-header">
            
            <div class="row">
            
                <div class="col-md-10">
                    <h4 class="m-0">{{__("Add Service")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="service_form" method="post" enctype="multipart/form-data" action="{{url('admin/service/'.$service->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{method_field('PUT')}}
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">
                        Title <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Enter title" type="text" id="title" name="title" value="{{$service->title}}" class="form-control">
                    </div>
                    @error('title')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                        
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        Content 
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea rows="5" cols="10"  type="text" name="content"  class="form-control">{{$service->content}}</textarea>
                        @error('content')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12"></label>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        @if($service->photo != '' && file_exists(public_path().'/assets/uploads/service/'.$service->photo))
                            <img  src=" {{url('/assets/uploads/service/'.$service->photo)}}">
                        @endif
                    </div>    
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Image<span class="required">*</span>
                    </label>
                    <div class="col-md-10 col-sm-9 col-xs-12 ">
                        <input type="file" id="image" name="image" accept="image/*">
                        <small class="txt-desc">(Please Choose slider image)</small>
                        @error('image')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>
                </div>
                
                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Update Service</button>
                </div>
            </form>
        </div>
    </div>
     
@endsection
