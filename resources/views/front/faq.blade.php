@extends('layouts.front')
@section('title',$faq_meta->title .' |')

@section('meta_tags')
    <meta name="keywords" content="{{ $faq_meta->meta_keyword }}">
    <meta property="og:title" content=" {{$faq_meta->meta_title}} | {{ isset($general_settings) ? $general_settings->title : config('app.name') }}" />
    <meta property="og:description" content="{{substr(strip_tags($faq_meta->meta_description), 0, 200)}}{{strlen(strip_tags($faq_meta->meta_description))>200 ? '...' : ''}}" />
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
        if(!empty($faq_meta->banner)){
            if(!empty($faq_meta->banner)  && file_exists(public_path().'/assets/uploads/'.$faq_meta->banner) ){
                $banner_image = 'url("'.url("/assets/uploads/".$faq_meta->banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>{{$faq_meta->title}}</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">{{$faq_meta->title}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section id="aa-blog-archive">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-blog-archive-area">
                <div class="row">
                <div class="col-md-12">
                    <!-- Blog details -->
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->

                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">
                        @foreach($faqs as $key=> $faq)

                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#faq{{ $faq->id }}">
                                        <b>Q {{ $key+1 }}. {{ $faq->que }}</b>
                                    </a>
                                </h4>
                            </div>

                            <div id="faq{{ $faq->id }}" class="panel-collapse collapse ">

                                <div class="panel-body">

                                    {!! $faq->ans !!}

                                </div>

                            </div>

                        @endforeach
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