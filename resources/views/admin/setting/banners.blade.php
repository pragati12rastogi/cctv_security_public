@extends("layouts.admin")
@section('title','Banners | ')
@section('breadcrumb')
<li class="breadcrumb-item active">{{__("Banner Setting")}}</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    
  });

</script>
@endsection
@section("content")
<div class="container-fluid">
    @include('flash-message')
    <div class="card">
        <div class="card-header">
            
            <div class="row">
            
                <div class="col-md-10">
                    <h4 class="m-0">{{__("Banner Setting")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="banner_setting" method="post" enctype="multipart/form-data" action="{{url('admin/banners-setting')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        Login Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="login_banner" name="login_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->login_banner)  && file_exists(public_path().'/front/img/banner/'.$banner->login_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->login_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('login_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        Register Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="register_banner" name="register_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->register_banner) && file_exists(public_path().'/front/img/banner/'.$banner->register_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->register_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('register_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        Forget Password Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="forget_password_banner" name="forget_password_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->forget_password_banner) && file_exists(public_path().'/front/img/banner/'.$banner->forget_password_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->forget_password_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('forget_password_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        Category Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="category_banner" name="category_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->category_banner)  && file_exists(public_path().'/front/img/banner/'.$banner->category_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->category_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('category_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        Product Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="product_banner" name="product_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->product_banner)  && file_exists(public_path().'/front/img/banner/'.$banner->product_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->product_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('product_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        Cart Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="cart_banner" name="cart_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->cart_banner) && file_exists(public_path().'/front/img/banner/'.$banner->cart_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->cart_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('cart_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        Wishlist Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="wishlist_banner" name="wishlist_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->wishlist_banner) && file_exists(public_path().'/front/img/banner/'.$banner->wishlist_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->wishlist_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('wishlist_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class=" col-md-12 col-sm-12 col-xs-12" for="name">
                        User Dashboard Banner<span class="required">*</span>
                    </label>
                        
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input  type="file" id="user_dasboard_banner" name="user_dasboard_banner" accept="image/*" >
                    </div>
                    <div class="col-custom col-md-7">
                        @if(!empty($banner))
                        <div class="well background11">
                            @if(!empty($banner->user_dasboard_banner) && file_exists(public_path().'/front/img/banner/'.$banner->user_dasboard_banner) )
                            <img title="Current Logo" src=" {{url('/front/img/banner/'.$banner->user_dasboard_banner)}}" class="">
                            @else
                            <img title="Current Logo" src=" {{url('/front/img/banner/fashion-header-bg-8.jpg')}}" class="">
                            @endif
                        </div>
                        @endif
                    </div>
                    @error('user_dasboard_banner')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save Banners</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
