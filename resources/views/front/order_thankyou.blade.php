@extends('layouts.front')
@section('title','Thank You |')

@section('meta_tags')
@include('layouts.meta.common_meta')
@endsection

@section('css')
  <style></style>
@endsection

@section('js')
  
@endsection

@section('content')
<section id="aa-catg-head-banner">

    <div class="jumbotron text-center">
        <h1 class="display-3">Thank You!</h1>
        <p class="lead"><strong>Please check your email</strong>, we send you order details. </p>
        <hr>
        <p>
            Having trouble? <a href="">Contact us</a>
        </p>
        <p class="lead">
            <a class="aa-browse-btn" href="{{url('/')}}" role="button">Continue to homepage</a>
        </p>
    </div>

</section>
@endsection