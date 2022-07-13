@extends("layouts.admin")
@section('title','Add Product | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/product')}}">Product Summary</a></li>
<li class="breadcrumb-item active">{{__("Add Product")}}</li>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('/css/image-uploader.css')}}">

<style>
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0; 
    }
</style>
@endsection
@section('js')
<script src="{{asset('/js/image-uploader.js')}}"></script>
<script>
  
  $(function () {
    $('#preview_images').imageUploader();

    $("#return_available").change(function(){
        var val = this.value;

        if(val == 1){
            $("#return_policy_div").show();
        }else{
            $("#return_policy_div").hide();
        }
    })
  });

    $('#product_form').validate({ // initialize the plugin
        rules: {

            name: {
                required: true
            },
            price:{
                required:true,
            },
            category_id:{
                required:true
            },
            sub_category_id:{
                required:true
            },
            'photos[]': {
                required:true
            },
            return_policy:{
                required:function(element){
                    return $("#return_available").val()=="1";
                }
            }
        }
    });

    $("#category_id").change(function(){
        var cat = this.value;
        
        $("#attribute_div_append").empty();
        $.ajax({
            type: 'GET',
            dataType: "json",
            data: {'cat':cat},
            url : '{{url("admin/product/cat/attributes")}}',
            success: function(result){
                
                if(result.attr != '' ){
                    $("#attribute_div_append").show();
                    $str ='';
                    $.each(result.attr, function(key,value){
                        if(value.attr_type=="checkbox"){
                            $input = '';
                        
                            $.each(result.attr_value[value.id], function(k,v){
                                $input += '<option value="'+v.attr_key+'">'+v.value+'</option>';
                            })
                            $str += '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">'+
                                            'Select '+value.title+':<span class="required">*</span>'+
                                        '</label>'+
                                        '<div class="col-md-8 col-sm-8 col-xs-12">'+
                                            '<select name="varient_attr['+value.id+'][]" class="form-control select2bs4" multiple>'+
                                                $input+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                        }else{
                            $input = '<option value="">Select '+value.title+'</option>';
                        
                            $.each(result.attr_value[value.id], function(k,v){
                                $input += '<option value="'+v.attr_key+'">'+v.value+'</option>';
                            })

                            $str += '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">'+
                                            'Select '+value.title+':<span class="required">*</span>'+
                                        '</label>'+
                                        '<div class="col-md-8 col-sm-8 col-xs-12">'+
                                            '<select name="varient_attr['+value.id+']" class="form-control">'+
                                                $input+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                        }
                    });
                    
                    $("#attribute_div_append").append($str);
                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    })
                }

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
                    <h4 class="m-0">{{__("Add Product")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="product_form" method="post" enctype="multipart/form-data" action="{{url('admin/product')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
            
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">
                            Product Name:<span class="required">*</span>
                        </label>
                            
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input placeholder="Enter Product Name" type="text" id="name" name="name" value="{{old('name')}}" class="form-control">
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Product Price:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" id="price" name="price" value="{{old('price')}}" min="0" step="0.01" class="form-control" onKeyPress="if(this.value.length==10) return false;" >
                            <small class="txt-desc">(Please Enter Product price with tax)</small>
                            @error('price')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Old Price:
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="number" id="old_price" name="old_price" min="0" step="0.01" class="form-control" onKeyPress="if(this.value.length==10) return false;" >
                            <small class="txt-desc">(Enter Old price to show offer on products)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Category:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="category_id" class="form-control select2" id="category_id">
                                <option value="">Please Choose</option>
                                @foreach($category as $p)
                                <option value="{{$p->id}}" >{{$p->name}}</option>
                                @endforeach
                            </select>
                            <small class="txt-desc">(Please Choose Category) </small>
                            @error('category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Subcategory:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="sub_category_id" class="form-control select2 " id="sub_category_id">
                            </select>
                            <small class="txt-desc">(Please Choose Subcategory) </small>
                            @error('sub_category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Childcategory: 
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="child_category_id" class="form-control select2" id="child_category_id">
                            </select>
                            <small class="txt-desc">(Please Choose Childcategory) </small>
                            @error('child_category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="description">
                            Product Images : <span class="required">*</span>
                        </label>
                        <div class="col-md-10 col-sm-9 col-xs-12">
                            <div id="preview_images" style="padding-top: .5rem;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="description">
                            Description : 
                        </label>
                            
                        <div class="col-md-10 col-sm-9 col-xs-12">
                            <textarea rows="5" cols="10"  type="text" name="description"  class="form-control ckeditor">{{old('description')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="specification">
                            Specification : 
                        </label>
                            
                        <div class="col-md-10 col-sm-9 col-xs-12">
                            <textarea rows="5" cols="10"  type="text" name="specification" class="form-control ckeditor">{{old('specification')}}</textarea>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Upload Datasheet:
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <input type="file" id="datasheet_upload" name="datasheet_upload" >
                            <small class="txt-desc">(Please Choose Datasheet)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Upload User Manual:
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <input type="file" id="user_manual_upload" name="user_manual_upload" >
                            <small class="txt-desc">(Please Choose User manual file)</small>
                        </div>
                    </div>
                </div>   
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Product Quantity: <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <input type="number" id="qty" min="0" value="{{old('tax')??0}}" placeholder="Enter product Quantity" name="qty" class="form-control" onKeyPress="if(this.value.length==10) return false;"  >
                            
                        </div>
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Tax:
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <input type="number" id="tax" min="0" value="{{old('tax')}}" placeholder="eg. For 18% enter 18" name="tax" class="form-control" onKeyPress="if(this.value.length==10) return false;"  >
                            <small class="txt-desc">(Add 0 for blank and Tax will be in percentage)</small>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Cash On Delivery:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <select name="cash_on_delivery" class="form-control" id="cash_on_delivery">
                                <option value="0" {{old('cash_on_delivery')==0?'selected':''}}>No</option>
                                <option value="1" {{old('cash_on_delivery')==1?'selected':''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div> -->
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                        	Cancel Available:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <select name="cancel_available" class="form-control" id="cancel_available">
                                <option value="0" {{old('cancel_available')==0?'selected':''}}>No</option>
                                <option value="1" {{old('cancel_available')==1?'selected':''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                        	Featured:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <select name="is_feature" class="form-control" id="is_feature">
                                <option value="0" {{old('is_feature')==0?'selected':''}}>No</option>
                                <option value="1" {{old('is_feature')==1?'selected':''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                        	Status:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <select name="status" class="form-control" id="status">
                                <option value="0" {{old('status')==0?'selected':''}}>No</option>
                                <option value="1" {{old('status')==1?'selected':''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                        	Return Available:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <select name="return_available" class="form-control" id="return_available">
                                <option value="0" {{old('return_available')==0?'selected':''}}>No</option>
                                <option value="1" {{old('return_available')==1?'selected':''}}>Yes</option>
                            </select>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6 "  style="{{ old('return_policy') == 1 ? '' : 'display:none' }}" id="return_policy_div">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Select Return Policy:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <select name="return_policy_id" class="form-control" id="return_policy_id">
                                <option value="">Please choose an option</option>
                                @foreach($policy as $p)
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                            @error('return_policy_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>

                    <div class="row mt-4" id="attribute_div_append"  style="display:none">
                        
                    </div>

                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save Product</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
