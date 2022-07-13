@extends("layouts.admin")
@section('title','Add Page | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/page')}}">Page Summary</a></li>
<li class="breadcrumb-item active">{{__("Add Page")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
    $(function () {
        $('#page_form').validate({ // initialize the plugin
            rules: {

                name: {
                    required: true,
                },
                slug:{
                    required:true,
                },
                description:{
                    required:true,
                },
                status:{
                    required:true,
                },
                description:{
                    required:true
                }
            }
        });

        $("#name").on('keyup change',function(){
            var value = this.value;
            var slug = convertToSlug(value);

            $("#slug").val(slug);
        })
    });

    function convertToSlug(Text) {
        return Text
                    .toLowerCase()
                    .replace(/ /g, '-')
                    .replace(/[^\w-]+/g, '');
    }
  
</script>
@endsection
@section("content")
<div class="container-fluid">
    @include('flash-message')
    <div class="card">
        <div class="card-header">
            
            <div class="row">
            
                <div class="col-md-10">
                    <h4 class="m-0">{{__("Add Page")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/page')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Page Name <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-5 col-sm-9 col-xs-12">
                        <input placeholder="Enter Page Name" type="text" id="name" name="name" value="{{old('name')}}" class="form-control">
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Page Slug <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-5 col-sm-9 col-xs-12">
                        <input placeholder="Enter Page Slug" type="text" id="slug" name="slug" value="{{old('slug')}}" class="form-control" onkeypress="return event.charCode != 32">
                        @error('slug')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
                        Description <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea rows="5" cols="10"  type="text" name="description" class="form-control ckeditor">{{old('description')}}</textarea>
                        @error('description')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Page Meta Title 
                    </label>
                        
                    <div class="col-md-5 col-sm-9 col-xs-12">
                        <input placeholder="Enter Meta Title" type="text" maxlength="255" id="meta_title" name="meta_title" value="{{old('meta_title')}}" class="form-control">
                        @error('meta_title')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Page Meta Keyword 
                    </label>
                        
                    <div class="col-md-5 col-sm-9 col-xs-12">
                        <input placeholder="Enter Meta Keyword" type="text" maxlength="255" id="meta_keyword" name="meta_keyword" value="{{old('meta_keyword')}}" class="form-control">
                        @error('meta_keyword')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        Page Meta Description 
                    </label>
                        
                    <div class="col-md-5 col-sm-9 col-xs-12">
                        <textarea rows="5" cols="5"  type="text" name="meta_description" class="form-control">{{old('meta_description')}}</textarea>
                        @error('meta_description')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Status:<span class="required">*</span>
                    </label>
                    <div class="col-md-5 col-sm-9 col-xs-12">
                        <select name="status" class="form-control" id="status">
                            <option value="0" {{old('status')==0?'selected':''}}>No</option>
                            <option value="1" {{old('status')==1?'selected':''}}>Yes</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
