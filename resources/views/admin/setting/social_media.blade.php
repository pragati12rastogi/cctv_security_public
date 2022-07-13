@extends('layouts.admin')
@section('title', 'Social Media Settings |')

@section('breadcrumb')

@endsection

@section('css')

@endsection
@section('js')
<script>
$(function() {
    
    
    
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
                  <h4 class="m-0">{{__("Social Media Settings")}}</h4>
                </div>
                
            </div>
        </div>  
        <div class="card-body">
            <form action="{{ route('admin.social.setting.save') }}" method="POST" id="mail_form">
                
                @csrf
                <div class="row">
                @foreach($social_media as $social)
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">{{ucfirst($social->name)}} </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="{{$social->name}}" value="{{$social->path}}">
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
