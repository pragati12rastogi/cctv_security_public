@extends('layouts.front')
@section('title','Login |')
@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('content')
 
<!-- catg header banner section -->
<section id="aa-catg-head-banner">

    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($banner_settings)){
            if(!empty($banner_settings->login_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->login_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->login_banner).'")';
            }
        }
    @endphp
    
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Login Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Login</li>
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
                <div class="aa-myaccount-area p-0">         
                    <div class="row">
                        <div class="col-md-6 mt-32">
                            <div class="aa-myaccount-login">
                                <h4>Login</h4>
                                <form method="POST" action="{{ route('login') }}"class="aa-login-form">
                                    @csrf
                                    
                                    <div class="form-group row">
                                        <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" placeholder="Email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                            <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 ">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="aa-browse-btn">Login</button>
                                    @if (Route::has('password.request'))
                                        <p class="aa-lost-password">    
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        </p>
                                    @endif
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
<!-- /login form -->
@endsection
