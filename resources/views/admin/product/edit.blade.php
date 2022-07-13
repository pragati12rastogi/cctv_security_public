@extends("layouts.admin")
@section('title','Edit Product | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/product')}}">Product Summary</a></li>
<li class="breadcrumb-item active">{{__("Edit Product")}}</li>
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

@php    
    $preloaded =[];
    foreach($prod_photo as $ind => $photo_data){
        $preloaded[] = ['id'=>$photo_data->id,'src'=>asset("/assets/uploads/product_photos/".$photo_data["image"])];
    }
    $preloaded_obj = json_encode($preloaded);  
    
@endphp

<script src="{{asset('/js/image-uploader.js')}}"></script>
<script>
  
  $(function () {
    

    $("#return_available").change(function(){
        var val = this.value;

        if(val == 1){
            $("#return_policy_div").show();
        }else{
            $("#return_policy_div").hide();
        }
    })

    let preloaded = @php echo $preloaded_obj; @endphp;
    
    $('#preview_images').imageUploader({
        preloaded: preloaded,
        imagesInputName: 'photos',
        preloadedInputName: 'old'
    });
    $(".delete-image").on('click',function(){
        var photo_id = $(this).attr('data-id');
        if(photo_id != 0){
            
            $.ajax({
                url : '{{url("admin/product/photo/delete/api")}}',
                data: {prod_id:'{{$prod->id}}',photo_id:photo_id},
                type : 'GET',
                dataType: "json",
                success: function(result){
                    if(result.status == 'success'){
                        $("#alert-success").append('<p>'+result.msg+'</p>').show();
                        setTimeout(function(){ $("#alert-success").hide(); }, 10000);
                    }else{
                        alert(result.msg);
                        window.location.href= result.redirect;
                    }
                },
                error: function(jq,status,message) {
                    
                    alert('A jQuery error has occurred. Error:'+ jq.responseText);
                }
            })
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
            return_policy:{
                required:function(element){
                    return $("#return_available").val()=="1";
                }
            }
        }
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
                    <h4 class="m-0">{{__("Edit Product")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="product_form" method="post" enctype="multipart/form-data" action="{{url('admin/product/'.$prod->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">
                            Product Name:<span class="required">*</span>
                        </label>
                            
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input placeholder="Enter Product Name" type="text" id="name" name="name" value="{{$prod->name}}" class="form-control">
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
                            <input type="number" id="price" name="price" value="{{$prod->price}}" min="0" step="0.01" class="form-control" onKeyPress="if(this.value.length==10) return false;" >
                            <small class="txt-desc">(Please Enter Product price with tax included)</small>
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
                            <input type="number" id="old_price" value="{{$prod->old_price}}" name="old_price" min="0" step="0.01" class="form-control" onKeyPress="if(this.value.length==10) return false;" >
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
                                <option value="{{$p->id}}" {{($prod->category_id==$p->id)?'selected':''}}>{{$p->name}}</option>
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
                            <select name="sub_category_id" class="form-control select2" id="sub_category_id">
                                <option value="">Please Choose</option>
                                @foreach($sub_cat as $sub)
                                <option value="{{$sub->id}}" {{($prod->sub_category_id==$sub->id)?'selected':''}}>{{$sub->name}}</option>
                                @endforeach
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
                                <option value="">Please Choose</option>
                                @foreach($child_cat as $cat)
                                <option value="{{$cat->id}}" {{($prod->child_category_id==$cat->id)?'selected':''}}>{{$cat->name}}</option>
                                @endforeach
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
                            <textarea rows="5" cols="10"  type="text" name="description"  class="form-control ckeditor">{{$prod->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="specification">
                            Specification : 
                        </label>
                            
                        <div class="col-md-10 col-sm-9 col-xs-12">
                            <textarea rows="5" cols="10"  type="text" name="specification" class="form-control ckeditor">{{$prod->specification}}</textarea>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Upload Datasheet:
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            @if($prod->datasheet_upload != '' && file_exists(public_path().'/assets/uploads/datasheet/'.$prod->datasheet_upload))
                                <a href="{{url('/assets/uploads/datasheet/'.$prod->datasheet_upload)}}" target='_blank'>{{$prod->datasheet_upload}}</a>
                            @endif
                            <input type="file" id="datasheet_upload" name="datasheet_upload" >
                            <small class="txt-desc">(Please Choose Datasheet)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Upload User Manual:
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            @if($prod->user_manual_upload != '' && file_exists(public_path().'/assets/uploads/user_manual/'.$prod->user_manual_upload))
                                <a href="{{url('/assets/uploads/user_manual/'.$prod->user_manual_upload)}}" target='_blank'>{{$prod->user_manual_upload}}</a>
                            @endif
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
                            <input type="number" id="qty" min="0" value="{{$prod->qty}}" placeholder="Enter product Quantity" name="qty" class="form-control" onKeyPress="if(this.value.length==10) return false;"  >
                            
                        </div>
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Tax:
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <input type="number" id="tax" min="0" value="{{$prod->tax}}" placeholder="eg. For 18% enter 18" name="tax" class="form-control" onKeyPress="if(this.value.length==10) return false;"  >
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
                                <option value="0" {{$prod->cash_on_delivery==0?'selected':''}}>No</option>
                                <option value="1" {{$prod->cash_on_delivery==1?'selected':''}}>Yes</option>
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
                                <option value="0" {{$prod->cancel_available==0?'selected':''}}>No</option>
                                <option value="1" {{$prod->cancel_available==1?'selected':''}}>Yes</option>
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
                                <option value="0" {{$prod->is_feature==0?'selected':''}}>No</option>
                                <option value="1" {{$prod->is_feature==1?'selected':''}}>Yes</option>
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
                                <option value="0" {{$prod->status==0?'selected':''}}>No</option>
                                <option value="1" {{$prod->status==1?'selected':''}}>Yes</option>
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
                                <option value="0" {{$prod->return_available==0?'selected':''}}>No</option>
                                <option value="1" {{$prod->return_available==1?'selected':''}}>Yes</option>
                            </select>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6 "  style="{{ $prod->return_available == 1 ? '' : 'display:none' }}" id="return_policy_div">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                            Select Return Policy:<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <select name="return_policy_id" class="form-control" id="return_policy_id">
                                <option value="">Please choose an option</option>
                                @foreach($policy as $p)
                                    <option value="{{$p->id}}" {{($prod->return_policy_id==$p->id)?'selected':''}}>{{$p->name}}</option>
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

                    <div class="row mt-4" id="attribute_div_append" style="">
                            
                        @foreach($attr as $i => $att)
                            @php
                                $cat = App\Models\Category::whereIn('id',$att['category_ids'])->where('id', $prod->category_id)->get();
                            @endphp
                            @if(!empty($cat))
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">
                                            Select {{$att['title']}}:<span class="required">*</span>
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            @if($att->attr_type == 'checkbox')
                                                @php
                                                    $varient_value = App\Models\ProductVariantsDetail::where('product_id',$prod->id)->where('attribute_id',$att['id'])->get()->toArray();
                                                    $varient_value = array_column($varient_value,'attribute_value');
                                                @endphp
                                            <select name="varient_attr[{{$att['id']}}][]" class="form-control select2bs4" multiple>
                                                @foreach($att->attribute_value as $in =>$v)
                                                    <option value="{{$v['attr_key']}}" {{(!empty($varient_value) &&  in_Array($v['attr_key'],$varient_value)?'selected':'')}}>{{$v['value']}}</option>
                                                @endforeach
                                            </select>
                                            @else
                                                @php
                                                    $varient_value = App\Models\ProductVariantsDetail::where('product_id',$prod->id)->where('attribute_id',$att['id'])->first();
                                                @endphp
                                            <select name="varient_attr[{{$att['id']}}]" class="form-control">
                                                <option value="">Select {{$att['title']}}</option>
                                                @foreach($att->attribute_value as $in =>$v)
                                                    <option value="{{$v['attr_key']}}" {{(!empty($varient_value) &&  ($varient_value['attribute_value'] == $v['attr_key'])?'selected':'')}}>{{$v['value']}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        
                    </div>

                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Update Product</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
