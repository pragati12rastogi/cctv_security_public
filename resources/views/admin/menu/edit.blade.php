@extends("layouts.admin")
@section('title','Edit Menu | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/menu')}}">All Menu List</a></li>
<li class="breadcrumb-item active">{{__("Edit Menu")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    
    jQuery.validator.addMethod("url", function(value, element) {
         return this.optional(element) || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
    }, "Must be a correct url format");
    
    $('#menu_form').validate({ // initialize the plugin
        rules: {

            title: {
                required: true
            },
            link_by:{
                required:true,
            },
            menu_cat_type:{
                required:function(element){
                    return $("input[name='link_by']:checked").val() == "cat";
                }
            },
            linked_parent_cat:{
                required:function(element){
                    return $("#menu_cat_type").val() == "cat";
                }
            },

            linked_parent_sub:{
                required:function(element){
                    return $("#menu_cat_type").val() == "subcat";
                }
            },

            page_id:{
                required:function(element){
                    return $("input[name='link_by']:checked").val() == "page";
                }
            },

            url:{
                required:function(element){
                    return $("input[name='link_by']:checked").val() == "url";
                }
            },
            status:{
                required: true
            }
        }
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
                    <h4 class="m-0">{{__("Edit Menu")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="menu_form" method="post" enctype="multipart/form-data" action="{{url('admin/menu/'.$menu->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                        Menu Name <span class="required error">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input placeholder="Enter Menu Name" type="text" id="title" name="title" value="{{$menu->title}}" class="form-control">
                    </div>
                    @error('title')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">

                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                        Linked By <span class="required error">*</span>
                    </label>
                        
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        
                        <label class="radio-inline">
                            <input type="radio" class="link_by" name="link_by" value="cat" {{( $menu->link_by == 'cat' ? 'checked' : '' )}} > Category
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="link_by" name="link_by" value="page" {{( $menu->link_by == 'page' ? 'checked' : '' )}}> Page
                        </label>
                        <label class="radio-inline">
                            <input type="radio" class="link_by" name="link_by" value="url" {{( $menu->link_by == 'url' ? 'checked' : '' )}} > URL
                        </label>
                        
                    </div>

                    @error('link_by')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        Status
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 pt-3 d-flex">
                        <input type="checkbox" name="status" value="1" {{( $menu->status == '1' ? 'checked' : '' )}} >
                        <small >(Active/Deactive) </small>
                    </div>
                </div>

                <div id="cat_div" style="{{$menu->link_by == 'cat' ? '' :'display:none'}}">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                            Category Type <span class="required error">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="menu_cat_type" class="form-control" id="menu_cat_type">
                                <option value="">Select Type</option>
                                <option value="cat" {{( $menu->cat_type == 'cat' ? 'selected' : '' )}} >Category</option>
                                <option value="subcat" {{( $menu->cat_type == 'subcat' ? 'selected' : '' )}} >Sub Category</option>
                            </select>
                            <small class="txt-desc">(Please select category type)</small>
                            @error('menu_cat_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group" id="cat_type_div" style="{{$menu->cat_type == 'cat' ? '' :'display:none'}}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                            Category <span class="required error">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        
                            <select name="linked_parent_cat[]" class="form-control select2" multiple>

                                    @if($menu->cat_type == 'cat')
                                        
                                        @foreach($cat as $c)
                                            
                                            <option value="{{$c->id}}" {{ (in_array($c->id,$menu->linked_parent)) ? 'selected':''}}>{{$c->name}}</option>
                                            
                                        @endforeach
                                    @else
                                        @foreach($cat as $c)
                                            <option value="{{$c->id}}" >{{$c->name}}</option>
                                        @endforeach
                                    @endif
                               
                            </select>
                            <small class="txt-desc">(Selected categories will be shown in menu with their sub menus.)</small>
                            @error('linked_parent')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group" id="subcat_type_div" style="{{$menu->cat_type == 'subcat' ? '' :'display:none'}}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                            Sub Category <span class="required error">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="linked_parent_sub[]" class="form-control select2" multiple>
                                @foreach($subcat as $sc)
                                    @if($menu->cat_type == 'subcat')
                                        <option value="{{$sc->id}}" {{(in_array($sc->id,$menu->linked_parent)) ? 'selected':''}}>{{$sc->name}}</option>
                                    @else
                                        <option value="{{$sc->id}}" >{{$sc->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="txt-desc">(Selected sub categories will be shown in menu with their child menus.)</small>
                            @error('linked_parent')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div id="page_div" style="{{$menu->link_by == 'page' ? '' :'display:none'}}">
                    <div class="form-group"  >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                        Select Pages: <span class="required error">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="page_id[]" id="pageselector" class="form-control select2" multiple>
                                @foreach($pages as $page)
                                @if($menu->link_by == 'page')
                                
                                    <option value="{{$page->id}}" {{in_array($page->id,$menu->page_id)?'selected':''}}>{{$page->name}}</option>
                                
                                @else
                                    <option value="{{$page->id}}">{{$page->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('page_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="url_div" style="{{$menu->link_by == 'url' ? '' :'display:none'}}" >
                    <div class="form-group"  >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                            URL <span class="required error">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" type="url" placeholder="enter custom url" name="url" value="{{$menu->url}}" >
                            <small class="txt-desc">(Enter full url eg: https://www.test.com)</small>
                            @error('url')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save Menu</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection