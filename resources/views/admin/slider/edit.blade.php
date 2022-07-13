@extends("layouts.admin")
@section('title','Edit Slider | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/slider')}}">Slider Summary</a></li>
<li class="breadcrumb-item active">{{__("Edit Slider")}}</li>
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
                    <h4 class="m-0">{{__("Add Slider")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="slider_form" method="post" enctype="multipart/form-data" action="{{url('admin/slider/'.$slider->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{method_field('PUT')}}
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">
                        Heading <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Enter heading of slider" type="text" id="heading" name="heading" value="{{$slider->heading}}" class="form-control">
                    </div>
                    @error('heading')
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
                        <textarea rows="5" cols="10"  type="text" name="content"  class="form-control">{{$slider->content}}</textarea>
                        @error('content')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="button_text">
                        Button Text <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Enter button text" type="text" id="button_text" name="button_text" value="{{$slider->button_text}}" class="form-control">
                        @error('button_text')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        Button URL <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Enter button url" type="text" id="button_url" name="button_url" value="{{$slider->button_url}}" class="form-control"> 
                        @error('button_url')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12"></label>
                    <div class="col-md-10 col-sm-9 col-xs-12 pt-3 d-flex">
                        @if($slider->photo != '' && file_exists(public_path().'/assets/uploads/slider/'.$slider->photo))
                            <img width="450px" height="100px" src=" {{url('/assets/uploads/slider/'.$slider->photo)}}">
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
                    <button type="submit" class="btn btn-dark mt-3">Update Slider</button>
                </div>
            </form>
        </div>
    </div>
     
@endsection
