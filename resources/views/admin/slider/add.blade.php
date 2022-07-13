@extends("layouts.admin")
@section('title','Add Slider | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/slider')}}">Slider Summary</a></li>
<li class="breadcrumb-item active">{{__("Add Slider")}}</li>
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
            <form id="slider_form" method="post" enctype="multipart/form-data" action="{{url('admin/slider')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">
                        Heading <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Enter heading of slider" type="text" id="heading" name="heading" value="{{old('heading')}}" class="form-control">
                        @error('heading')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>
                        
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        Content 
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea rows="5" cols="10"  type="text" name="content" value="{{old('content')}}" class="form-control"></textarea>
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
                        <input placeholder="Enter button text" type="text" id="button_text" name="button_text" value="{{old('button_text')}}" class="form-control">
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
                        <input placeholder="Enter button url" type="text" id="button_url" name="button_url" value="{{old('button_url')}}" class="form-control"> 
                        @error('button_url')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Image<span class="required">*</span>
                    </label>
                    <div class="col-md-10 col-sm-9 col-xs-12 pt-3 d-flex">
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
                    <button type="submit" class="btn btn-dark mt-3">Save Slider</button>
                </div>
            </form>
        </div>
    </div>
     
@endsection
