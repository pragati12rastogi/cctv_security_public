@extends("layouts.admin")
@section('title','Add Child Category | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/childcategory')}}">Child Category Summary</a></li>
<li class="breadcrumb-item active">{{__("Add Child Category")}}</li>
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
                    <h4 class="m-0">{{__("Add Child Category")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/childcategory')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Parent Category: <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="category_id" class="form-control select2" id="category_id">
                            <option value="">Please Choose</option>
                            @foreach($parent as $p)
                            <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                        <small class="txt-desc">(Please Choose Parent Category)</small>
                        @error('category_id')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Subcategory: <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="sub_category_id" class="form-control select2" id="sub_category_id">
                        </select>
                        <small class="txt-desc">(Please Choose Subcategory) </small>
                        @error('sub_category_id')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Child Category Name <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input placeholder="Enter Sub Category Name" type="text" id="name" name="name" value="{{old('name')}}" class="form-control">
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>
                        
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
                        Description 
                    </label>
                        
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea rows="5" cols="10"  type="text" name="description" value="{{old('description')}}" class="form-control"></textarea>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Image
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 pt-3 d-flex">
                        <input type="file" id="image" name="image" accept="image/*">
                        <small class="txt-desc">(Please Choose Category image)</small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Status:<span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-9 col-xs-12 pt-3 ">
                        <select name="status" class="form-control" id="status">
                            <option value="1" >Yes</option>
                            <option value="0" >No</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save Child Category</button>
                </div>
            </form>
        </div>
    </div> 
@endsection
