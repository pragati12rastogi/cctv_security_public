@extends("layouts.admin")
@section('title','Add Product Attribute | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/attributes')}}">Product Attribute Summary</a></li>
<li class="breadcrumb-item active">{{__("Add Product Attribute")}}</li>
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
                    <h4 class="m-0">{{__("Add Product Attribute")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="attribute_form" method="post" enctype="multipart/form-data" action="{{url('admin/attributes')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                            Attribute Name:<span class="required">*</span>
                        </label>
                            
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input placeholder="Enter Attribute Name" type="text" id="title" name="title" value="{{old('title')}}" class="form-control">
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
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
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
                                <option value="radio">Radio</option>
                                <option value="checkbox">Checkbox</option>
                                
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
                        <div class="col-md-5">
                            <div class="form-group ">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                    Keys:<span class="required">*</span>
                                </label>
                                
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="attr_key[]" value="{{old('attr_key.0')}}" class="form-control attr_key" id="attr_key_0" >
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
                                    <input type="text" name="value[]" value="{{old('value.0')}}" class="form-control value" id="value_0" >
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
                        @if(old('attr_key'))
                            @if(count(old('attr_key')) > 1)
                                @for($i=1;$i < count(old('attr_key'));$i++)
                                <div class="row div_tocopy kv_div_count appended-content">
                                    <div class="col-md-5">
                                        <div class="form-group ">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                Keys:<span class="required">*</span>
                                            </label>
                                            
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" name="attr_key[{{$i}}]" value="{{old('attr_key')[$i]}}" class="form-control attr_key" id="attr_key_{{$i}}">
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
                                                <input type="text" name="value[{{$i}}]" value="{{old('value')[$i]}}"  class="form-control value" id="value_{{$i}}">
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
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-11"></div>
                        <div class="col-md-1"><button type="button" class="key_addOther btn btn-outline-danger btn-xs"><i class="fa fa-plus " style="cursor:pointer;">Add More</i></button></div>
                    </div><br>
                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save Attribute</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
