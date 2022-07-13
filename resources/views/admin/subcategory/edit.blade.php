@extends("layouts.admin")
@section('title','Edit Sub Category | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/subcategory')}}">Sub Category Summary</a></li>
<li class="breadcrumb-item active">{{__("Edit Sub Category")}}</li>
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
                    <h4 class="m-0">{{__("Edit Sub Category")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/subcategory/'.$subcat->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Parent Category: <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="category_id" class="form-control select2">
                        
                        @foreach($parent as $p)
                        <option value="{{$p->id}}" {{($subcat->category_id ==$p->id) ?? 'selected'}}>{{$p->name}}</option>
                        @endforeach
                        </select>
                        <small class="txt-desc">(Please Choose Parent Category)</small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Category Name <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input placeholder="Enter Category Name" type="text" id="name" name="name" value="{{$subcat['name']}}" class="form-control">
                    </div>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                        
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
                        Description 
                    </label>
                        
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea rows="5" cols="10"  type="text" name="description" class="form-control">{{$subcat['description']}}</textarea>
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-6 col-sm-6 col-xs-12 pt-3 d-flex">
                        @if($subcat->image != '' && file_exists(public_path().'/assets/uploads/subcategory/'.$subcat->image))
                            <img width="50px" height="80px" src=" {{url('/assets/uploads/subcategory/'.$subcat->image)}}">
                        @endif
                    </div>    
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Image
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 pt-3 d-flex">

                        <input type="file" id="image" name="image" accept="image/*">
                        <small class="txt-desc">(Please Choose Sub Category image)</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Status:<span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-9 col-xs-12 pt-3 ">
                        <select name="status" class="form-control" id="status">
                            <option value="1" {{$subcat['status']==1?'selected':''}} >Yes</option>
                            <option value="0" {{$subcat['status']==0?'selected':''}} >No</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Update Sub Category</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
