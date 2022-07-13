@extends('layouts.front')
@section('title',$page->name .' |')

@section('meta_tags')
    <meta name="keywords" content="{{ $page->meta_keyword }}">
    <meta property="og:title" content=" {{$page->meta_title}} | {{ isset($general_settings) ? $general_settings->title : config('app.name') }}" />
    <meta property="og:description" content="{{substr(strip_tags($page->meta_description), 0, 200)}}{{strlen(strip_tags($page->meta_description))>200 ? '...' : ''}}" />
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
        if(!empty($banner_settings)){
            if(!empty($banner_settings->user_dasboard_banner)  && file_exists(public_path().'/front/img/banner/'.$banner_settings->user_dasboard_banner) ){
                $banner_image = 'url("'.url("/front/img/banner/".$banner_settings->user_dasboard_banner).'")';
            }
        }
    @endphp
    <div class="aa-catg-head-banner-area" style="background-image:{{$banner_image}}">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>{{$page->name}}</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">{{$page->name}}</li>
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
                    <div class="aa-blog-content aa-blog-details">
                        <article class="aa-blog-content-single">                        
                            {!!$page->description!!}
                        </article>
                        
                        
                    </div>
                </div>

                
            </div>           
          </div>
        </div>
      </div>
    </div>
</section>

@endsection