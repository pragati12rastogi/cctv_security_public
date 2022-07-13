@extends('layouts.front')
@section('title','Confirm Password |')
@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection
@section('content')
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
                <h2>Confirm Password Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Confirm Password</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id="aa-myaccount">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-myaccount-area ">         
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="aa-myaccount-login">
                                <h4>{{ __('Confirm Password') }}</h4>
                                {{ __('Please confirm your password before continuing.') }}

                                <form method="POST" action="{{ route('password.confirm') }}" class="aa-login-form">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="aa-browse-btn">
                                                {{ __('Confirm Password') }}
                                            </button>

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
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

@endsection
