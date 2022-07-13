@extends("layouts.admin")
@section('title','Edit Category | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/topcategory')}}">Category Summary</a></li>
<li class="breadcrumb-item active">{{__("Edit Category")}}</li>
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
                    <h4 class="m-0">{{__("Edit Category")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/topcategory/'.$cat->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">
                        Category Name <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Enter Category Name" type="text" id="name" name="name" value="{{$cat['name']}}" class="form-control">
                    </div>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                        
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="description">
                        Description 
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea rows="5" cols="10"  type="text" name="description" class="form-control">{{$cat['description']}}</textarea>
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12"></label>
                    <div class="col-md-10 col-sm-9 col-xs-12 pt-3 d-flex">
                        @if($cat->image != '' && file_exists(public_path().'/assets/uploads/category/'.$cat->image))
                            <img width="50px" height="80px" src=" {{url('/assets/uploads/category/'.$cat->image)}}">
                        @endif
                    </div>    
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Image
                    </label>
                    <div class="col-md-10 col-sm-9 col-xs-12 pt-3 ">

                        <input type="file" id="image" name="image" accept="image/*">
                        <small class="txt-desc">(Please Choose Category image)</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Status:<span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-9 col-xs-12 pt-3 ">
                        <select name="status" class="form-control" id="status">
                            <option value="1" {{$cat['status']==1?'selected':''}}>Yes</option>
                            <option value="0" {{$cat['status']==0?'selected':''}}>No</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save Category</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
