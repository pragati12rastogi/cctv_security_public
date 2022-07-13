@extends("layouts.admin")
@section('title','Add Return Policy | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/return-policy')}}">Return Policy Summary</a></li>
<li class="breadcrumb-item active">{{__("Add Return Policy")}}</li>
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
                    <h4 class="m-0">{{__("Add Return Policy")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/return-policy')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">
                        Policy Name <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Enter Policy Name" type="text" id="name" name="name" value="{{old('name')}}" class="form-control">
                    </div>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Days <span class="required">*</span>
                    </label>
                    <div class="col-md-10 col-sm-9 col-xs-12 ">
                        <input placeholder="15" type="text" id="days" name="days" value="{{old('days')}}" class="form-control">
                        <small class="txt-desc">(Please enter days user can apply for return)</small>
                        @error('days')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="description">
                        Description <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea rows="5" cols="10"  type="text" name="description"  class="form-control ckeditor">{{old('description')}}</textarea>
                        @error('description')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                
                
                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save Policy</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
