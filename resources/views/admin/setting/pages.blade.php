@extends('layouts.admin')
@section('title', 'Pages Settings |')

@section('breadcrumb')

@endsection

@section('css')

@endsection
@section('js')


<script>
  $(function() {
    
    
    $('#about_us_form,#faq_form,#contact_us_form,#term_and_condition_form').validate({ // initialize the plugin
        rules: {

            title: {
                required: true
            },
            content:{
                required:true,
            }
        }
    });

    
    
});
</script>
@endsection
@section('content')
<div class="container-fluid">
@include('flash-message')
    <div class="card">
        <div class="card-header">
           <div class="row">
                
                <div class="col-md-8">
                  <h4 class="m-0">{{__("Pages Settings")}}</h4>
                </div>
                
            </div>
        </div> 
        <div class="card-body">
            <div class="row"> 
                <div class="col-md-12">
                                    
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" id="active_cat">
                            <li class="active"><a href="#tab_1" data-toggle="tab">About Us</a></li>
                            <li><a href="#tab_2" data-toggle="tab">FAQ</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Contact Us</a></li>
                            <li><a href="#tab_4" data-toggle="tab">Term And Condition</a></li>
                            
                        </ul>
                        
                        <div class="tab-content mt-10">
                            <div class="tab-pane active" id="tab_1">
                                <form class="form-horizontal" action="{{route('admin.pages.setting.save','about_us')}}" method="post" enctype="multipart/form-data" id="about_us_form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Page Title * </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="title" value="{{$page['about_us'][0]['title']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label"> Content * </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control ckeditor" id="about_content" name="content">{{$page['about_us'][0]['content']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Existing Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                
                                                @if(!empty($page['about_us'][0]['banner']) && file_exists(public_path() . '/assets/uploads/'.$page['about_us'][0]['banner']))
                                                    <img src="{{asset('/assets/uploads/').'/'.$page['about_us'][0]['banner']}}" class="existing-photo" style="height:80px;">
                                                @else
                                                <span>No Banner Exist</span>
                                                @endif    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">New Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                    <input type="file" name="banner">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Title</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="meta_title" value="{{$page['about_us'][0]['meta_title']}}">
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="col-md-12">          
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Keyword </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_keyword" style="height:100px;">{{$page['about_us'][0]['meta_keyword']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Description </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_description" style="height:100px;">{{$page['about_us'][0]['meta_description']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">  
                                            <hr>
                                            <button type="submit" class="btn btn-dark mt-3 ">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane " id="tab_2">
                                <form class="form-horizontal" action="{{route('admin.pages.setting.save','faq')}}" method="post" enctype="multipart/form-data" id="faq_form">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Page Title * </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="title" value="{{$page['faq'][0]['title']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Existing Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                @if(!empty($page['faq'][0]['banner']) && file_exists(public_path() . '/assets/uploads/'.$page['faq'][0]['banner']))
                                                    <img src="{{asset('/assets/uploads/').'/'.$page['faq'][0]['banner']}}" class="existing-photo" style="height:80px;">
                                                @else
                                                <span>No Banner Exist</span>
                                                @endif 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">New Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                    <input type="file" name="banner">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Title</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="meta_title" value="{{$page['faq'][0]['meta_title']}}">
                                                </div>
                                            </div>             
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Keyword </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_keyword" style="height:100px;">{{$page['faq'][0]['meta_keyword']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Description </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_description" style="height:100px;">{{$page['faq'][0]['meta_description']}}</textarea>
                                                </div>
                                            </div>                
                                        </div>
                                        <div class="col-md-12">                    
                                            <hr>
                                            <button type="submit" class="btn btn-dark mt-3 " >Update</button>
                                        
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane " id="tab_3">
                                <form class="form-horizontal" action="{{route('admin.pages.setting.save','contact_us')}}" method="post" enctype="multipart/form-data" id="contact_us_form">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Page Title * </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="title" value="{{$page['contact_us'][0]['title']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Existing Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                    @if(!empty($page['contact_us'][0]['banner']) && file_exists(public_path() . '/assets/uploads/'.$page['contact_us'][0]['banner']))
                                                    <img src="{{asset('/assets/uploads/').'/'.$page['contact_us'][0]['banner']}}" class="existing-photo" style="height:80px;">
                                                    @else
                                                    <span>No Banner Exist</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">New Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                    <input type="file" name="banner">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"> 
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Title</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="meta_title" value="{{$page['contact_us'][0]['meta_title']}}">
                                                </div>
                                            </div>             
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Keyword </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_keyword" style="height:100px;">{{$page['contact_us'][0]['meta_keyword']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Description </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_description" style="height:100px;">{{$page['contact_us'][0]['meta_description']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                    
                                            <div class="col-md-12">
                                                <hr>
                                                <button type="submit" class="btn btn-dark mt-3 ">Update</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane " id="tab_4">
                                <form class="form-horizontal" action="{{route('admin.pages.setting.save','term_and_condition')}}" method="post" enctype="multipart/form-data" id="term_and_condition_form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Page Title * </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="title" value="{{$page['term_and_condition'][0]['title']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label"> Content * </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control ckeditor" id="tnc_content" name="content">{{$page['term_and_condition'][0]['content']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Existing Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                
                                                @if(!empty($page['term_and_condition'][0]['banner']) && file_exists(public_path() . '/assets/uploads/'.$page['term_and_condition'][0]['banner']))
                                                    <img src="{{asset('/assets/uploads/').'/'.$page['term_and_condition'][0]['banner']}}" class="existing-photo" style="height:80px;">
                                                @else
                                                    <span>No Banner Exist</span>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">New Banner Photo</label>
                                                <div class="col-sm-10" style="padding-top:6px;">
                                                    <input type="file" name="banner">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Title</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="meta_title" value="{{$page['term_and_condition'][0]['meta_title']}}">
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="col-md-12">           
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Keyword </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_keyword" style="height:100px;">{{$page['term_and_condition'][0]['meta_keyword']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Meta Description </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_description" style="height:100px;">{{$page['term_and_condition'][0]['meta_description']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                    
                                            
                                            <hr>
                                            <button type="submit" class="btn btn-dark mt-3 ">Update</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
