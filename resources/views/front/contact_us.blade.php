@extends('layouts.front')
@section('title',$contact->title .' |')

@section('meta_tags')
    <meta name="keywords" content="{{ $contact->meta_keyword }}">
    <meta property="og:title" content=" {{$contact->meta_title}} | {{ isset($general_settings) ? $general_settings->title : config('app.name') }}" />
    <meta property="og:description" content="{{substr(strip_tags($contact->meta_description), 0, 200)}}{{strlen(strip_tags($contact->meta_description))>200 ? '...' : ''}}" />
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{asset('/assets/uploads/general/'.$general_settings->favicon)}}" />
@endsection

@section('css')
  
@endsection

@section('js')
  
@endsection

@section('content')

<section id="aa-catg-head-banner">
    @php
        $banner_image = 'url("'.url("/front/img/banner/fashion-header-bg-8.jpg").'")';
        if(!empty($contact->banner)){
            if(!empty($contact->banner)  && file_exists(public_path().'/assets/uploads/'.$contact->banner) ){
                $banner_image = 'url("'.url("/assets/uploads/".$contact->banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>{{$contact->title}}</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">{{$contact->title}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section id="aa-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-contact-area">
                    <div class="aa-contact-top">
                        <h2>We are wating to assist you..</h2>
                    </div>
                    <!-- contact map -->
                    @if($general_settings->show_map == 1)
                    <div class="aa-contact-map">
                        {!!$general_settings->map_code!!}
                    </div>
                    @endif
                    <!-- Contact address -->
                    <div class="aa-contact-address">
                    @include('flash-message')
                        <div class="row">
                        <div class="col-md-8">
                            <div class="aa-contact-address-left">
                            <form class="comments-form contact-form" action="{{url('user\contact-us')}}" method="post">
                                @csrf
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">                        
                                    <input type="text" name="name" placeholder="Your Name" class="form-control" required>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">                        
                                    <input type="email" required name="email" placeholder="Email" class="form-control">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">                        
                                        <input required name="subject" type="text" placeholder="Subject" class="form-control">
                                        @error('subject')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">                        
                                        <input type="text" name="company" placeholder="Company" class="form-control">
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">                        
                                    <textarea class="form-control" required name="message" rows="3" placeholder="Message"></textarea>
                                    @error('message')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button class="aa-secondary-btn">Send</button>
                            </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="aa-contact-address-right">
                            <address>
                                <h4>{{$general_settings->project_name}}</h4>
                                <p class="mt-10"></p>
                                <p><span class="fa fa-home"></span>{{$general_settings->address}}</p>
                                <p><span class="fa fa-phone"></span>{{$general_settings->phone}}</p>
                                <p><span class="fa fa-envelope"></span>Email: {{$general_settings->email}}</p>
                            </address>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection