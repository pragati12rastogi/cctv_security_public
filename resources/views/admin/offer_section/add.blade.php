@extends("layouts.admin")
@section('title','Add Offer | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/offers')}}">Offer Summary</a></li>
<li class="breadcrumb-item active">{{__("Add Offer")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
    $(function () {
        $('#offer_form').validate({ // initialize the plugin
            rules: {

                title: {
                    required: true
                },
                link_type:{
                    required:true,
                },
                image:{
                    required: true,
                },
                category_id:{
                    required:function(element){
                        return $("input[name='link_type']").val() == "category";
                    }
                },
                product_id:{
                    required:function(element){
                        return $("input[name='link_type']").val() == "product";
                    }
                },

                url:{
                    required:function(element){
                        return $("input[name='link_type']").val() == "url";
                    }
                }
            }
        });

        $("#link_type").change(function(){
            var value = this.value;
            if(value == 'category'){
                $('#cat_div').show('slow');
                $('#prod_div').hide('slow');
                $('#url_div').hide('slow');
            }else if(value == 'product'){
                $('#cat_div').hide('slow');
                $('#prod_div').show('slow');
                $('#url_div').hide('slow');
            }else if(value == 'url'){
                $('#cat_div').hide('slow');
                $('#prod_div').hide('slow');
                $('#url_div').show('slow');
            }else{
                $('#cat_div').hide('slow');
                $('#prod_div').hide('slow');
                $('#url_div').hide('slow');
            }
        })
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
                    <h4 class="m-0">{{__("Add Offer")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="offer_form" method="post" enctype="multipart/form-data" action="{{url('admin/offers')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">
                        Title <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        <input placeholder="Enter Title" type="text" id="title" name="title" value="{{old('title')}}" class="form-control">
                    </div>
                    @error('title')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="name">
                        Image <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    @error('title')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        Tag 
                    </label>
                        
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        <input placeholder="Enter tag" type="text" id="tag" name="tag" value="{{old('tag')}}" class="form-control">
                        @error('tag')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        Link Type <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        <select name="link_type" class="form-control" id="link_type">
                            <option value="">Select link type</option>
                            <option value="category">Category</option>
                            <option value="product">Product</option>
                            <option value="url">URL</option>
                        </select>
                        @error('link_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" id="cat_div" style="display:none">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        Category <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        
                        <select name="category_id" class="form-control select2">
                            <option value="">Select Category</option>
                            @foreach($category as $i => $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group" id="prod_div" style="display:none">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        Products <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        <select name="product_id" class="form-control select2">
                            <option value="">Select Product</option>
                            @foreach($product as $i => $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group" id="url_div" style="display:none">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="content">
                        URL <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        <input placeholder="Enter url" type="text" id="url" name="url" value="{{old('url')}}" class="form-control">
                        @error('url')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save </button>
                </div>
            </form>
        </div>
    </div>
     
@endsection
