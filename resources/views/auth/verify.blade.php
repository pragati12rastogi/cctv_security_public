@extends('layouts.front')
@section('title','Email Verification |')
@section('meta_tags')
    @include('layouts.meta.common_meta')
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
                <h2>Email Verification</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">Verify Email</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->

<section id="aa-myaccount">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-myaccount-area ">         
                    <div class="row">
                        <div class="col-md-12">
                            <div class="aa-myaccount-login text-center border p-4">
                                <h4>{{ __('Verify Your Email Address') }}</h4>
                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif
                                {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
