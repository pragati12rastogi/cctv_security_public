@extends('layouts.front')
@section('title','Register |')
@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection
@section('css')
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
@section('content')
<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings)){
            if(!empty($banner_settings->register_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->register_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->register_banner).'")';
            }
        }
    @endphp
    
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Register User</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Register</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->

<!-- Cart view section -->
<section id="aa-myaccount">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-myaccount-area p-0">         
                    <div class="row">
                        <div class="col-md-6 mt-32">
                            <div class="aa-myaccount-login">
                                <h4>Register</h4>
                                <form method="POST" action="{{ route('register') }}" class="aa-login-form pb-10">
                                    @csrf

                                    <div class=" row">
                                        <label for="name" class="col-md-12 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-12">
                                            <input id="name" type="text" class=" @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" row">
                                        <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" row">
                                        <label for="phone" class="col-md-12 col-form-label text-md-right">{{ __('Mobile') }}</label>

                                        <div class="col-md-12">
                                            <input id="phone" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" class=" @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" row">
                                        <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-12">
                                            <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" row">
                                        <label for="password-confirm" class="col-md-12 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-12">
                                            <input id="password-confirm" type="password" class="" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class=" row mb-0">
                                        <div class="col-md-6 ">
                                            <button type="submit" class="aa-browse-btn">{{ __('Register') }}</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 mt-5">
                            <img src="{{url('front/img/loginpage.jpg')}}" width="100%">
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
