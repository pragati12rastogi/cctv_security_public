@extends('layouts.front')
@section('title','Reset Password |')
@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection
@section('content')
<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings)){
            if(!empty($banner_settings->forget_password_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->forget_password_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->forget_password_banner).'")';
            }
        }
    @endphp
    
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
    
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Reset Password Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Reset Password</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->

<!-- Login form -->
<section id="aa-myaccount">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-myaccount-area ">         
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="aa-myaccount-login">
                                <h4>{{ __('Reset Password') }}</h4>
                                <form method="POST" action="{{ route('password.update') }}" class="aa-login-form">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group row">
                                        <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
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

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-12 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-12">
                                            <input id="password-confirm" type="password" class="" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="aa-browse-btn">
                                                {{ __('Reset Password') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="{{url('/front/img/resetpass.jpg')}}">
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /login form -->

@endsection
