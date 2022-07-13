@extends('layouts.admin')
@section('title', 'General Settings |')

@section('breadcrumb')

@endsection

@section('css')

@endsection
@section('js')
<script>
  $(function() {
    
    
    $('#general_form').validate({ // initialize the plugin
        rules: {

            project_name: {
                required: true
            },
            email:{
                required:true,
            },
            // state_id:{
            //     required:true,
            // },
            phone:{
                required:true
            },
            copyright:{
                required:true
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
                  <h4 class="m-0">{{__("General Settings")}}</h4>
                </div>
                
            </div>
        </div>  
        <form  action="{{route('admin.general.setting.save')}}" enctype="multipart/form-data" method="POST" id="general_form" >
            
            <div class="card-body">
               @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                            Project Name: <span class="required">*</span>
                            </label>

                            <input placeholder="Please enter Project name" type="text" id="a1" name="project_name"
                            value="{{ env('APP_NAME') }}" class="form-control currency-icon-picker ">
                            <small class="text-muted"><i class="fa fa-question-circle"></i> Project name is basically your Project
                            Title.</small>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Default Email:</label>
                            <input placeholder="Please Enter Email (info@example.com)" type="text" id="setting_email" name="email"
                            value="{{$setting->email ?? ''}}" class="form-control">
                            <small class="text-muted"><i class="fa fa-question-circle"></i> Default email will be used by your customer
                            for contacting you.</small>
                        </div>

                    </div>

                    <div class="col-md-6" style="display:none">

                        <div class="form-group">
                            <label>APP URL:</label>
                            <input placeholder="http://" type="text" id="app_url" name="APP_URL" value="{{ env('APP_URL') }}"
                            class="form-control">
                            <small class="text-muted"><i class="fa fa-warning"></i> Try changing domain will cause serious
                            error.</small>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Mobile:</label>

                            <input placeholder="Please enter mobile no." type="text" id="first-name" name="phone"
                            value="{{$setting->phone ?? ''}}" class="form-control">

                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter valid mobile no (it will also
                            show in your site Contact Us).</small>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Watsapp No:</label>

                            <input placeholder="Please enter watsapp no." type="text" id="watsapp_no" name="watsapp_no"
                            value="{{$setting->watsapp_no ?? ''}}" class="form-control">

                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter valid watsapp no .</small>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Copyright Text:</label>

                            <input placeholder="Please enter copyright text" type="text" id="first-name" name="copyright"
                            value="{{$setting->copyright ?? ''}}" class="form-control">

                            <small class="text-muted"><i class="fa fa-question-circle"></i> Copyright text will be shown in your site
                            footer don't put YEAR on text.</small>
                        </div>
                    </div>


                    <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-9">
                        <label>Logo:</label>
                        <input type="file" id="first-name" name="logo" class="form-control">
                        <small class="text-muted"><i class="fa fa-question-circle"></i> Please choose a site logo (supported
                            format: <b>PNG, JPG, JPEG, GIF</b>).</small>
                        </div>

                        <div class="col-custom col-md-3">
                        @if(!empty($setting))
                        <div class="well background11">

                            <img title="Current Logo" src=" {{url('/assets/uploads/general/'.$setting->logo)}}" class="width100px height-30">

                        </div>
                        @endif
                        </div>
                    </div>


                    </div>

                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Favicon:</label>
                                    <input type="file" id="first-name" name="favicon" class="form-control">
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> Please choose a site favicon (supported
                                    format: <b>PNG, JPG, JPEG</b>).</small>
                                </div>
                            </div>

                            <div class="col-custom col-md-3">
                                @if(!empty($setting))
                                <div class="well background11">
                                    <center><img class="img-responsive" title="Current Favicon"
                                        src=" {{url('/assets/uploads/general/'.$setting->favicon)}}" class="width100px height-30"></center>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>State:</label>
                            <select name="state_id" class="form-control select2">
                                <option value="">Select State</option>
                                @foreach($state as $ind => $st)
                                <option value="{{$st['id']}}" {{($setting->state_id==$st['id']) ? 'selected':''}}>{{ucwords (strtolower($st['state_name']))}}</option>
                                @endforeach
                            </select>
                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select state this will help in calculating gst/tax.</small>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Active COD Checkout:</label>
                            <select name="cod_checkout" class="form-control select2">
                                <option value="1" {{$setting->cod_checkout == 1 ? 'selected':''}}>Yes</option>
                                <option value="0" {{$setting->cod_checkout == 0 ? 'selected':''}}>No</option>
                            </select>
                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please select for cod checkout.</small>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Address:</label>

                            <textarea rows="3" cols="10" value="{{old('address' ?? '')}}" name="address"
                            class="form-control">{{$setting->address ?? ''}}</textarea>
                            <small class="text-muted"><i class="fa fa-question-circle"></i> Please enter address (it will also show in
                            your site footer).</small>
                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Show Service Section:</label>
                            <select name="service_section" class="form-control select2">
                                <option value="1" {{$setting->service_section == 1 ? 'selected':''}}>Yes</option>
                                <option value="0" {{$setting->service_section == 0 ? 'selected':''}}>No</option>
                            </select>
                            <small class="text-muted"><i class="fa fa-question-circle">Select Yes If want to show service section on home page</i></small>
                        </div>
                        <div class="form-group">
                            <label>Show Offer Section:</label>
                            <select name="offer_section" class="form-control select2">
                                <option value="1" {{$setting->offer_section == 1 ? 'selected':''}}>Yes</option>
                                <option value="0" {{$setting->offer_section == 0 ? 'selected':''}}>No</option>
                            </select>
                            <small class="text-muted"><i class="fa fa-question-circle">Select Yes If want to show offer section on home page</i></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Show Map:</label>

                            <input type="checkbox"  name="show_map" value="1" {{ ($setting->show_map == 1)?'checked':'' }} >
                            <small class="text-muted"><i class="fa fa-question-circle"></i> Select if want to display map on contact page.</small>
                        </div>
                        <div class="form-group">
                            <label>Contact Map iFrame:</label>

                            <textarea class="form-control" name="map_code"  rows="3" cols="10">{{$setting->map_code ?? ''}}</textarea>
                            <small class="text-muted"><i class="fa fa-question-circle"></i> <a target="_blank" href="https://www.embedmymap.com/">Generate embed map</a></small>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Title:</label>

                            <input placeholder="Please meta title" type="text" id="first-name" name="meta_title"
                            value="{{$setting->meta_title ?? ''}}" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Keyword:</label>

                            <textarea  type="text" id="first-name" name="meta_keyword"
                            class="form-control">{{$setting->meta_keyword ?? ''}}</textarea>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Description:</label>

                            <textarea  type="text" id="first-name" name="meta_description"
                            class="form-control">{{$setting->meta_description ?? ''}}</textarea>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group row mb-0">
                    <div class="col-md-12 ">
                        <button type="submit" class="btn btn-dark">Save Setting</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</div>
@endsection
