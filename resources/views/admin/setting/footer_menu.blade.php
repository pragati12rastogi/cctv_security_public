@extends("layouts.admin")
@section('title','Footer Menu | ')
@section('breadcrumb')
<li class="breadcrumb-item active">{{__("Footer Menu")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    
    $('#active_cat.nav-tabs > li > a').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#active_cat a[href="' + activeTab + '"]').tab('show');
    }
    
    jQuery.validator.addMethod(".url", function(value, element) {
         return this.optional(element) || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
    }, "Must be a correct url format");

    $('form').validate({ // initialize the plugin
        rules: {

            link_type: {
                required: true
            },
            "category_ids[]":{
                required:function(element){
                    return $("input[name='link_type']").val() == "category";
                }
            },
            "page_ids[]":{
                required:function(element){
                    return $("input[name='link_type']").val() == "page";
                }
            },
            "title[]":{
                required:function(element){
                    return $("input[name='link_type']").val() == "url";
                }
            },
            "url[]":{
                required:function(element){
                    return $("input[name='link_type']").val() == "url";
                }
            }
        }
    });

    $(".link_type").change(function(){
        var get_id = $(this).attr('id');
        var split_no = get_id.split("_");
        var get_no = split_no[2];

        var selected_value = this.value;

        if(selected_value == 'category'){

            $("#cat_div_"+get_no).show();
            $("#page_div_"+get_no).hide();
            $("#url_div_"+get_no).hide();

        }else if(selected_value == 'page'){
            $("#cat_div_"+get_no).hide();
            $("#page_div_"+get_no).show();
            $("#url_div_"+get_no).hide();

        }else if(selected_value == 'url'){
            $("#cat_div_"+get_no).hide();
            $("#page_div_"+get_no).hide();
            $("#url_div_"+get_no).show();
        }else{
            $("#cat_div_"+get_no).hide();
            $("#page_div_"+get_no).hide();
            $("#url_div_"+get_no).hide();
        }
    })

    $(".btn_add_more").click(function(){
        var get_input_id = $(this).attr('id');
        var split_no = get_input_id.split("_");
        var get_no = split_no[2];

        var count = $('.kv_div_count_'+get_no).length;
        var show_count = $('.kv_div_count_'+get_no).length+1;

        $(".replicate_"+get_no).append(
            '<div class="row div_tocopy_'+get_no+' kv_div_count_'+get_no+' append_content">'+
                '<div class="col-md-5">'+
                    '<div class="form-group" >'+
                        '<label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">'+
                            'Title <span class="required error">*</span>'+
                        '</label>'+
                            
                        '<div class="col-md-8 col-sm-8 col-xs-12">'+
                            '<input type="text" name="title[]" class="form-control" >'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-5">'+
                    '<div class="form-group" >'+
                        '<label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">'+
                            'Url<span class="required error">*</span>'+
                        '</label>'+
                            
                        '<div class="col-md-8 col-sm-8 col-xs-12">'+
                            '<input type="text" name="url[]" class="form-control url" >'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-1">'+
                    '<a href="javascript:void(0)" class="rm-btn btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></a>'+
                '</div>'+
            '</div>'
        );
    })

    $(document).on('click','.rm-btn',function(e){
        $(this).parents(".append_content").remove();
    });

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
                    <h4 class="m-0">{{__("Footer Menu")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" id="active_cat">
                            <li class="active"><a href="#widget1" data-toggle="tab">Widget 1</a></li>
                            <li><a href="#widget2" data-toggle="tab">Widget 2</a></li>
                            <li><a href="#widget3" data-toggle="tab">Widget 3</a></li>
                            <li><a href="#widget4" data-toggle="tab">Widget 4</a></li>
                            
                        </ul>
                        <div class="tab-content mt-10">
                            <div class="tab-pane active" id="widget1">
                                <form method="post"  enctype="multipart/form-data" action="{{url('admin/footer-menus/'.$footer_menu[0]->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                    {{csrf_field()}}
                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Link Type <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <select class="form-group select2bs4 link_type" name="link_type" id="link_type_1" style="width:100%">
                                                <option value="">Select Link Type</option>
                                                <option value="category" {{$footer_menu[0]->link_type == 'category' ? 'selected' :''}}>Category</option>
                                                <option value="page" {{$footer_menu[0]->link_type == 'page' ? 'selected' :''}}>Page</option>
                                                <option value="url"{{$footer_menu[0]->link_type == 'url' ? 'selected' :''}}>Url</option>
                                            </select>

                                        </div>
                                        @error('link_type')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Widget Name <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <input type="text" class="form-control" name="widget_name" id="widget_name" value="{{$footer_menu[0]->widget_name}}">
                                                
                                        </div>
                                        @error('widget_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-7" id="cat_div_1" style="{{$footer_menu[0]->link_type == 'category' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Category <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="category_ids[]" class="form-control select2bs4" multiple>
                                            
                                            @foreach($cat as $c)
                                                
                                                <option value="{{$c->id}}" {{ (!empty($footer_menu[0]->category_ids) && in_array($c->id,$footer_menu[0]->category_ids)) ? 'selected':''}}>{{$c->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('category_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-7" id="page_div_1" style="{{$footer_menu[0]->link_type == 'page' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Page <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="page_ids[]" class="form-control select2bs4" multiple>

                                            @foreach($page as $p)
                                                
                                                <option value="{{$p->id}}" {{ (!empty($footer_menu[0]->page_ids) && in_array($p->id,$footer_menu[0]->page_ids)) ? 'selected':''}}>{{$p->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('page_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div id="url_div_1" class="col-md-12" style="{{$footer_menu[0]->link_type == 'url' ? '' :'display:none'}}">
                                        <div class="row div_tocopy_1 kv_div_count_1">
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Title <span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="title[]" class="form-control" value="{{!empty($footer_menu[0]->title)? $footer_menu[0]->title[0]:''}}">
                                                    </div>

                                                    @error('title.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Url<span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="url[]" class="form-control url" value="{{!empty($footer_menu[0]->url)? $footer_menu[0]->url[0]:''}}">
                                                    </div>

                                                    @error('url.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" id="add_more_1" class="btn_add_more btn btn-xs btn-warning"><i class="fa fa-plus "></i></button>
                                            </div>
                                        </div>
                                        <div class="replicate_1">
                                            @php  
                                                $f_m = []; 
                                                if(!empty($footer_menu[0]->title) && count($footer_menu[0]->title) == count($footer_menu[0]->url)){
                                                    $f_m = array_combine($footer_menu[0]->title,$footer_menu[0]->url);
                                                }
                                            @endphp

                                            @if(count($f_m) > 1)
                                                @for($i=1;$i < count($f_m);$i++)
                                                    <div class="row div_tocopy_{{$i}} kv_div_count_{{$i}} append_content">
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Title <span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="title[]" class="form-control" value="{{$footer_menu[0]->title[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Url<span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="url[]" class="form-control url" value="{{$footer_menu[0]->url[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a href="javascript:void(0)" class="rm-btn btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></a>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-dark" type="submit" >Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane " id="widget2">
                                <form method="post"  enctype="multipart/form-data" action="{{url('admin/footer-menus/'.$footer_menu[1]->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                    {{csrf_field()}}
                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Link Type <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <select class="form-group select2bs4 link_type" name="link_type" id="link_type_2" style="width:100%">
                                                <option value="">Select Link Type</option>
                                                <option value="category" {{$footer_menu[1]->link_type == 'category' ? 'selected' :''}}>Category</option>
                                                <option value="page" {{$footer_menu[1]->link_type == 'page' ? 'selected' :''}}>Page</option>
                                                <option value="url"{{$footer_menu[1]->link_type == 'url' ? 'selected' :''}}>Url</option>
                                            </select>

                                        </div>
                                        @error('link_type')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Widget Name <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <input type="text" class="form-control " name="widget_name" id="widget_name" value="{{$footer_menu[1]->widget_name}}">
                                                
                                        </div>
                                        @error('widget_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-7" id="cat_div_2" style="{{$footer_menu[1]->link_type == 'category' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Category <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="category_ids[]" class="form-control select2bs4" multiple>

                                            @foreach($cat as $c)
                                                
                                                <option value="{{$c->id}}" {{ (!empty($footer_menu[1]->category_ids) && in_array($c->id,$footer_menu[1]->category_ids)) ? 'selected':''}}>{{$c->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('category_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-7" id="page_div_2" style="{{$footer_menu[1]->link_type == 'page' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Page <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="page_ids[]" class="form-control select2bs4" multiple>

                                            @foreach($page as $p)
                                                
                                                <option value="{{$p->id}}" {{ (!empty($footer_menu[1]->page_ids) && in_array($p->id,$footer_menu[1]->page_ids)) ? 'selected':''}}>{{$p->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('page_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div id="url_div_2" class="col-md-12" style="{{$footer_menu[1]->link_type == 'url' ? '' :'display:none'}}">
                                        <div class="row div_tocopy_2 kv_div_count_2">
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Title <span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="title[]" class="form-control" value="{{!empty($footer_menu[1]->title)? $footer_menu[1]->title[0]:''}}">
                                                    </div>

                                                    @error('title.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Url<span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="url[]" class="form-control url" value="{{!empty($footer_menu[1]->url)? $footer_menu[1]->url[0]:''}}">
                                                    </div>

                                                    @error('url.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" id="add_more_2" class="btn_add_more btn btn-xs btn-warning"><i class="fa fa-plus "></i></button>
                                            </div>
                                        </div>
                                        <div class="replicate_2">
                                            @php  

                                                $f_m = []; 
                                                if(!empty($footer_menu[1]->title) && count($footer_menu[1]->title) == count($footer_menu[1]->url)){
                                                    $f_m = array_combine($footer_menu[1]->title,$footer_menu[1]->url);
                                                }

                                            @endphp

                                            @if(count($f_m) > 1)
                                                @for($i=1;$i < count($f_m);$i++)
                                                    <div class="row div_tocopy_{{$i}} kv_div_count_{{$i}} append_content">
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Title <span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="title[]" class="form-control" value="{{$footer_menu[1]->title[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Url<span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="url[]" class="form-control url" value="{{$footer_menu[1]->url[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a href="javascript:void(0)" class="rm-btn btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></a>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <button class="btn btn-dark" type="submit" >Submit</button>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane " id="widget3">
                                <form method="post"  enctype="multipart/form-data" action="{{url('admin/footer-menus/'.$footer_menu[2]->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                    {{csrf_field()}}
                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Link Type <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <select class="form-group select2bs4 link_type" name="link_type" id="link_type_3" style="width:100%">
                                                <option value="">Select Link Type</option>
                                                <option value="category" {{$footer_menu[2]->link_type == 'category' ? 'selected' :''}}>Category</option>
                                                <option value="page" {{$footer_menu[2]->link_type == 'page' ? 'selected' :''}}>Page</option>
                                                <option value="url"{{$footer_menu[2]->link_type == 'url' ? 'selected' :''}}>Url</option>
                                            </select>

                                        </div>
                                        @error('link_type')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Widget Name <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <input type="text" class="form-control " name="widget_name" id="widget_name" value="{{$footer_menu[2]->widget_name}}">
                                                
                                        </div>
                                        @error('widget_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-7" id="cat_div_3" style="{{$footer_menu[2]->link_type == 'category' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Category <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="category_ids[]" class="form-control select2bs4" multiple>

                                            @foreach($cat as $c)
                                                
                                                <option value="{{$c->id}}" {{ (!empty($footer_menu[2]->category_ids) && in_array($c->id,$footer_menu[2]->category_ids)) ? 'selected':''}}>{{$c->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('category_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-7" id="page_div_3" style="{{$footer_menu[2]->link_type == 'page' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Page <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="page_ids[]" class="form-control select2bs4" multiple>

                                            @foreach($page as $p)
                                                
                                                <option value="{{$p->id}}" {{ (!empty($footer_menu[2]->page_ids) && in_array($p->id,$footer_menu[2]->page_ids)) ? 'selected':''}}>{{$p->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('page_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div id="url_div_3" class="col-md-12" style="{{$footer_menu[2]->link_type == 'url' ? '' :'display:none'}}">
                                        <div class="row div_tocopy_3 kv_div_count_3">
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Title <span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="title[]" class="form-control" value="{{!empty($footer_menu[2]->title)? $footer_menu[2]->title[0]:''}}">
                                                    </div>

                                                    @error('title.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Url<span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="url[]" class="form-control url" value="{{!empty($footer_menu[2]->url)? $footer_menu[2]->url[0]:''}}">
                                                    </div>

                                                    @error('url.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" id="add_more_3" class="btn_add_more btn btn-xs btn-warning"><i class="fa fa-plus "></i></button>
                                            </div>
                                        </div>
                                        <div class="replicate_3">
                                            @php   
                                                $f_m = []; 
                                                if(!empty($footer_menu[2]->title) && count($footer_menu[2]->title) == count($footer_menu[2]->url)){
                                                    $f_m = array_combine($footer_menu[2]->title,$footer_menu[2]->url);
                                                }
                                            @endphp

                                            @if(count($f_m) > 1)
                                                @for($i=1;$i < count($f_m);$i++)
                                                    <div class="row div_tocopy_{{$i}} kv_div_count_{{$i}} append_content">
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Title <span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="title[]" class="form-control" value="{{$footer_menu[2]->title[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Url<span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="url[]" class="form-control url" value="{{$footer_menu[2]->url[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a href="javascript:void(0)" class="rm-btn btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></a>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-dark" type="submit" >Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane " id="widget4">
                                <form method="post"  enctype="multipart/form-data" action="{{url('admin/footer-menus/'.$footer_menu[3]->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                    {{csrf_field()}}
                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Link Type <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <select class="form-group select2bs4 link_type" name="link_type" id="link_type_4" style="width:100%">
                                                <option value="">Select Link Type</option>
                                                <option value="category" {{$footer_menu[3]->link_type == 'category' ? 'selected' :''}}>Category</option>
                                                <option value="page" {{$footer_menu[3]->link_type == 'page' ? 'selected' :''}}>Page</option>
                                                <option value="url"{{$footer_menu[3]->link_type == 'url' ? 'selected' :''}}>Url</option>
                                            </select>

                                        </div>
                                        @error('link_type')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Widget Name <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12 ">
                                            
                                            <input type="text" class="form-control " name="widget_name" id="widget_name" value="{{$footer_menu[3]->widget_name}}">
                                                
                                        </div>
                                        @error('widget_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7" id="cat_div_4" style="{{$footer_menu[3]->link_type == 'category' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Category <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="category_ids[]" class="form-control select2bs4" multiple>

                                            @foreach($cat as $c)
                                                
                                                <option value="{{$c->id}}" {{ (!empty($footer_menu[3]->category_ids) && in_array($c->id,$footer_menu[3]->category_ids)) ? 'selected':''}}>{{$c->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('category_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-7" id="page_div_4" style="{{$footer_menu[3]->link_type == 'page' ? '' :'display:none'}}">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                            Page <span class="required error">*</span>
                                        </label>
                                            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        <select name="page_ids[]" class="form-control select2bs4" multiple>

                                            @foreach($page as $p)
                                                
                                                <option value="{{$p->id}}" {{ (!empty($footer_menu[3]->page_ids) && in_array($p->id,$footer_menu[3]->page_ids)) ? 'selected':''}}>{{$p->name}}</option>
                                                
                                            @endforeach

                                        </select>
                                            
                                        </div>

                                        @error('page_ids.*')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div id="url_div_4" class="col-md-12" style="{{$footer_menu[3]->link_type == 'url' ? '' :'display:none'}}">
                                        <div class="row div_tocopy_4 kv_div_count_4">
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Title <span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="title[]" class="form-control" value="{{!empty($footer_menu[3]->title)?$footer_menu[3]->title[0]:''}}">
                                                    </div>

                                                    @error('title.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group" >
                                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                        Url<span class="required error">*</span>
                                                    </label>
                                                        
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="url[]" class="form-control url" value="{{!empty($footer_menu[3]->url)?$footer_menu[3]->url[0]:''}}">
                                                    </div>

                                                    @error('url.*')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" id="add_more_4" class="btn_add_more btn btn-xs btn-warning"><i class="fa fa-plus "></i></button>
                                            </div>
                                        </div>
                                        <div class="replicate_4">
                                            @php 
                                                $f_m = []; 
                                                if(!empty($footer_menu[3]->title) && count($footer_menu[3]->title) == count($footer_menu[3]->url)){
                                                    $f_m = array_combine($footer_menu[3]->title,$footer_menu[3]->url);
                                                }  
                                                
                                            @endphp

                                            @if(count($f_m) > 1)
                                                @for($i=1;$i < count($f_m);$i++)
                                                    <div class="row div_tocopy_{{$i}} kv_div_count_{{$i}} append_content">
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Title <span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="title[]" class="form-control" value="{{$footer_menu[3]->title[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">
                                                                    Url<span class="required error">*</span>
                                                                </label>
                                                                    
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <input type="text" name="url[]" class="form-control url" value="{{$footer_menu[3]->url[$i]}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a href="javascript:void(0)" class="rm-btn btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></a>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <button class="btn btn-dark" type="submit" >Submit</button>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
        
@endsection
