@extends('layouts.front')
@section('title', 'My Bank Accounts |')

@section('meta_tags')
    @include('layouts.meta.common_meta')
@endsection

@section('css')
    <style>
        .error{
            color:red;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function(){
            $('#bank_form').validate({ // initialize the plugin
                rules: {

                    bankname: {
                        required: true,
                        maxlength: 100
                    },
                    account_no:{
                        required:true,
                        maxlength:100
                    },
                    account_name:{
                        required:true
                    },
                    ifsc:{
                        required:true
                    }
                    

                }
            });
            
        });

        
    </script>
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
                <h2>My Bank Accounts</h2>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>                   
                    <li class="active">My Bank Accounts</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section id="aa-product-category" class="modal-dialog">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                @include('flash-message')
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>My Bank Accounts</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <form id="bank_form" action="{{route('save.bank.detail')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="bank_id" value="{{isset($bank) ? Crypt::encrypt($bank['id']) :''}}">
                                        
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Bank Name *</label>
                                                <input type="text" id="bankname" class="form-control "name="bankname"  placeholder="Bank Name*" value="{{isset($bank) ? $bank['bankname']:''}}">                            
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Account Number *</label>
                                                <input type="text" id="account_no" class="form-control" name="account_no"  placeholder="Account Number*" value="{{isset($bank) ? $bank['account_no']:''}}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Account Name *</label>
                                                <input type="text" name="account_name" id="account_name" placeholder="Account Name*" value="{{isset($bank) ? $bank['account_name']:''}}" class="form-control">                             
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>IFSC *</label>
                                                <input type="text" id="ifsc" name="ifsc" placeholder="IFSC*" value="{{isset($bank) ? $bank['ifsc']:''}}" class="form-control">
                                            </div>
                                            
                                            <div class="col-md-12  text-right">
                                                <button type="submit" class="btn btn-md btn-primary">{{ __('Save') }}</button>
                                            </div>
                                        </div> 
                                         
                                        
                                    </form>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            @include('front.sidenavbar')
        </div>

    </div>
</section>

@endsection