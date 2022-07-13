@extends("layouts.admin")
@section('title','Edit Product Attribute | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/attributes')}}">Product Attribute Summary</a></li>
<li class="breadcrumb-item active">{{__("Edit Product Attribute")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
    
    $(function () {
        $('#attribute_form').validate({ // initialize the plugin
            rules: {

                title: {
                    required: true
                },
                'category_ids[]':{
                    required:true,
                },
                'attr_key[]':{
                    required:true,
                },
                'value[]':{
                    required:true,
                }
            }
        });

        
        $(".key_addOther").click(function(){
                var count = $('.kv_div_count').length;
                var show_count = $('.kv_div_count').length+1;
            $(".replicate_div").append(
                '<div class="row div_tocopy kv_div_count appended-content">'+
                    '<input type="hidden" value="0" name="attr_value_id[]">'+
                    '<div class="col-md-5">'+
                        '<div class="form-group ">'+
                            '<label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">'+
                                'Keys:<span class="required">*</span>'+
                            '</label>'+
                            
                            '<div class="col-md-8 col-sm-8 col-xs-12">'+
                                '<input type="text" name="attr_key[]" class="form-control attr_key" id="attr_key_'+show_count+'">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-5">'+   
                        '<div class="form-group">'+
                            '<label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">'+
                                'Value:<span class="required">*</span>'+
                            '</label>'+
                            
                            '<div class="col-md-8 col-sm-8 col-xs-12">'+
                                '<input type="text" name="value[]"  class="form-control value" id="value_'+show_count+'">'+
                                
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<a href="javascript:void(0)" class="rm-btn"><i class="fa fa-trash-alt"></i></a>'+
                    '</div>'+
                '</div>'
            );
            
        })
    });

    $(document).on('click','.rm-btn',function(e){
        $(this).parents(".appended-content").remove();
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
                    <h4 class="m-0">{{__("Edit Product Attribute")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="attribute_form" method="post" enctype="multipart/form-data" action="{{url('admin/attributes/'.$attribute->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{method_field('PUT')}}
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                            Attribute Name:<span class="required">*</span>
                        </label>
                            
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input placeholder="Enter Attribute Name" type="text" id="title" name="title" value="{{$attribute->title}}" class="form-control">
                            @error('title')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                            Categories:<span class="required">*</span>
                        </label>
                            
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="category_ids[]" class="form-control select2" multiple>
                                <option value="">Select Category</option>
                                @foreach($cats as $ind => $cat)
                                    <option value="{{$cat->id}}" {{ (in_array($cat->id,$attribute->category_ids)) ? 'selected':''}} >{{$cat->name}}</option>
                                @endforeach
                            </select>
                            @error('category_ids.*')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                            Filter Type:<span class="required">*</span>
                        </label>
                            
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="attr_type" class="form-control select2" >
                                <option value="radio" {{$attribute->attr_type == 'radio'?'selected':''}}>Radio</option>
                                <option value="checkbox" {{$attribute->attr_type == 'checkbox'?'selected':''}}>Checkbox</option>
                                
                            </select>
                            @error('attr_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-12 text-left" for="title">
                            Keys and Values:<span class="required">*</span>
                        </label>
                    </div>
                    <hr><br>
                    <div class="row div_tocopy kv_div_count">
                        <input type="hidden" value="{{$attr_value[0]->id}}" name="attr_value_id[]">
                        <div class="col-md-5">
                            <div class="form-group ">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                    Keys:<span class="required">*</span>
                                </label>
                                
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="attr_key[]" value="{{$attr_value[0]->attr_key}}" class="form-control attr_key" id="attr_key_0" >
                                    @error('attr_key.0')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">   
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                    Value:<span class="required">*</span>
                                </label>
                                
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="value[]" value="{{$attr_value[0]->value}}" class="form-control value" id="value_0" >
                                    @error('value.0')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="replicate_div">
                        
                        @if(count($attr_value) > 1)
                            @for($i=1;$i < count($attr_value);$i++)
                            <div class="row div_tocopy kv_div_count appended-content">
                                <input type="hidden" value="{{$attr_value[$i]->id}}" name="attr_value_id[]">
                                <div class="col-md-5">
                                    <div class="form-group ">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                            Keys:<span class="required">*</span>
                                        </label>
                                        
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <input type="text" name="attr_key[{{$i}}]" value="{{$attr_value[$i]->attr_key}}" class="form-control attr_key" id="attr_key_{{$i}}">
                                            @error('attr_key.*')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">   
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                            Value:<span class="required">*</span>
                                        </label>
                                        
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <input type="text" name="value[{{$i}}]" value="{{$attr_value[$i]->value}}"  class="form-control value" id="value_{{$i}}">
                                            @error('value.*')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:void(0)" class="rm-btn"><i class="fa fa-trash-alt"></i></a>
                                </div>
                            </div>
                            @endfor
                        @endif
                        
                    </div>
                    <div class="row">
                        <div class="col-md-11"></div>
                        <div class="col-md-1"><button type="button" class="key_addOther btn btn-outline-danger btn-xs"><i class="fa fa-plus " style="cursor:pointer;">Add More</i></button></div>
                    </div><br>
                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Update Attribute</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
