@extends('layouts.front')
@section('title','Forget Password |')
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
                <h2>Forget Password Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('login')}}">Login</a></li>                   
                    <li class="active">Forget Password</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->

<!-- send reset email form -->
<section id="aa-myaccount">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-myaccount-area ">         
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="aa-myaccount-login">
                                <h4>{{ __('Reset Password') }}</h4>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}" class="aa-login-form">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-8">
                                            <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="aa-browse-btn">
                                                {{ __('Send Password Reset Link') }}
                                            </button>
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
</section>
<!-- /send email form -->
@endsection
