@extends('layouts.front')
@section('title', 'My Account |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
    <style>
        
    </style>
@endsection

@section('js')
  
@endsection

@section('content')

<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings)){
            if(!empty($banner_settings->user_dasboard_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->user_dasboard_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->user_dasboard_banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>My Account</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">My Account</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section id="aa-product-category" class="modal-dialog">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                @include('flash-message')
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>My Account</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <h4><i class="fa fa-caret-right"></i> Personal Information</h4>
                                </div>
                                <div class="col-md-12">
                                    <form action="{{route('profile.update')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold" for="first-name">
                                                {{ __('User Name') }}:<span class="text-red-600">*</span>
                                                </label>
                                                <input autofocus type="text" id="name" name="name" value="{{$user->name}}"
                                                class="form-control" placeholder="Please enter User name">
                                                <span class="text-red-600">{{$errors->first('name')}}</span>
                                                <small class="txt-desc">({{ __('Please Enter User Name') }})</small>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold" for="first-name">
                                                {{ __('User Email') }}:<span class="text-red-600">*</span>
                                                </label>
                                                <input disabled="disabled" autofocus type="email" id="email" value="{{$user->email}}"
                                                class="form-control" placeholder="Please enter User email">
                                                <span class="text-red-600">{{$errors->first('email')}}</span>
                                                <small class="txt-desc">({{ __('Please Enter User Email') }})</small>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold" for="first-name">
                                                {{ __('Mobile') }}:<span class="text-red-600">*</span>
                                                </label>
                                                <input autofocus type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10"  name="phone" value="{{$user->phone}}" class="form-control" placeholder="Please enter mobile number">
                                                <span class="text-red-600">{{$errors->first('phone')}}</span>
                                                <small class="txt-desc">({{ __('Please Enter mobile number') }})</small>
                                            </div>
                                            
                                            <div class="col-md-12 form-group text-right">
                                                <button type="submit" class="btn btn-md btn-primary">{{ __('Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 mb-4 mt-8">
                                    <h4><i class="fa fa-caret-right"></i> Update Password </h4>
                                </div>
                                <div class="col-md-12">
                                    <form action="{{route('profile.pass.upd')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold" for="first-name">
                                                {{ __('Current Password') }}:<span class="text-red-600">*</span>
                                                </label>
                                                <input  type="password" id="current_password" name="current_password" class="form-control" placeholder="*****">
                                                <span class="text-red-600">{{$errors->first('current_password')}}</span>
                                                
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold" for="first-name">
                                                {{ __('New Password') }}:<span class="text-red-600">*</span>
                                                </label>
                                                <input  type="password" id="new_password" name="new_password" class="form-control" placeholder="*****">
                                                <span class="text-red-600">{{$errors->first('new_password')}}</span>
                                                
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="font-weight-bold" for="first-name">
                                                {{ __('Confirm Password') }}:<span class="text-red-600">*</span>
                                                </label>
                                                <input  type="password" name="confirm_password"  class="form-control" placeholder="*****">
                                                <span class="text-red-600">{{$errors->first('confirm_password')}}</span>
                                                
                                            </div>
                                            
                                            <div class="col-md-12  text-right">
                                                <button type="submit" class="btn btn-md btn-primary">{{ __('Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('front.sidenavbar')
        </div>

    </div>
</section>

@endsection