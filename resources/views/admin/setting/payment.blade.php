@extends('layouts.admin')
@section('title', 'Payment Settings |')

@section('breadcrumb')

@endsection

@section('css')

@endsection
@section('js')
<script>
$(function() {

    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('#payment_tabs a[href="' + activeTab + '"]').tab('show');
    }

    
    document.querySelectorAll('.toggle-password').forEach(item => {
    
        item.addEventListener('click', function (e) {
            var toggle_id = $(this).attr('toggle');
            var ele = document.querySelector(toggle_id);
            // toggle the type attribute
            const type = ele.getAttribute('type') === 'password' ? 'text' : 'password';
            ele.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    });
    
});
</script>
@endsection
@section('content')
<div class="container-fluid">
@include('flash-message')
    <div class="card">
        <div class="card-header">
           <div class="row">
                
                <div class="col-md-8">
                  <h4 class="m-0">{{__("Payment Settings")}}</h4>
                </div>
                
            </div>
        </div>  
        <div class="card-body">
        <div class="nav-tabs-custom">

<div class="row">
    <div class="col-md-4">
        <ul id="payment_tabs" class="nav nav-stacked">
            <li class="active">
                <a href="#tab_1" data-toggle="tab" aria-expanded="false">
                    <div class="row">
                        <div class="col-md-10">
                            <i class="fab fa-paypal" aria-hidden="true"></i> Paypal Payment Settings
                        </div>
                        <div class="col-md-2">
                            <i title="{{ $general_settings->paypal_active==1 ? 'Active' : 'Deactive' }}"
                                class="fa fa-circle {{ $general_settings->paypal_active==1 ? 'text-green' : 'text-red' }}"
                                aria-hidden="true"></i>
                        </div>
                    </div>

                </a>
            </li>
            
            <!-- <li><a href="#tab_3" data-toggle="tab">
                    <div class="row">
                        <div class="col-md-10">
                            <i class="fab fa-stripe" aria-hidden="true"></i>
                            Stripe Payment Settings
                        </div>

                        <div class="col-md-2">
                            <i title="{{ $general_settings->stripe_active == 1 ? 'Active' : 'Deactive' }}"
                                class="fa fa-circle {{ $general_settings->stripe_active == 1 ? 'text-green' : 'text-red' }}"
                                aria-hidden="true"></i>
                        </div>
                    </div>
                </a>
            </li> -->

            <li>
                <a href="#tab_8" data-toggle="tab">
                    <div class="row">
                        <div class="col-md-10">
                            <i class="fab fa-connectdevelop" aria-hidden="true"></i> Razorpay Payment
                            Settings
                        </div>

                        <div class="col-md-2">
                            <i title="{{ $general_settings->razorpay_active == 1 ? 'Active' : 'Deactive' }}"
                                class="fa fa-circle {{ $general_settings->razorpay_active == 1 ? 'text-green' : 'text-red' }}"
                                aria-hidden="true"></i>
                        </div>
                    </div>
                </a>
            </li>

            <li><a href="#tab_10" data-toggle="tab"><i class="fa fa-university" aria-hidden="true"></i>
                    Bank Transfer Payment Settings </a></li>
        </ul>
    </div>

    <div class="col-md-8">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab_1">
                <form action="{{ route('paypal.setting.update') }}" method="POST">
                    @csrf
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>Paypal Payment Settings</label>
                            <div class="pull-right panel-title"><a target="__blank"
                                    title="Get Your Keys From here"
                                    href="https://developer.paypal.com/home/"><i class="fa fa-key"
                                        aria-hidden="true"></i> Get Your Keys From here</a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div id="pkey" class="form-group ">
                                <label for="PAYPAL_CLIENT_ID">PAYPAL CLIENT ID :</label>
                                <input type="text" name="PAYPAL_CLIENT_ID"
                                    value="{{env('PAYPAL_CLIENT_ID')}}" class="form-control">
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                    PAYPAL CLIENT ID</small>
                                    @error('PAYPAL_CLIENT_ID')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div id="psec"
                                class="form-group eyeCy ">
                                
                                <label for="PAYPAL_SECRET">PAYPAL SECRET ID :</label>
                                <div class="input-group">
                                    <input type="password" value="{{env('PAYPAL_SECRET')}}"
                                        name="PAYPAL_SECRET" id="pps-toggle" class="form-control col-md-11" >
                                    <div class="input-group-append">
                                        <div class="input-group-text " style="padding: 6px 17px;">
                                            <span toggle="#pps-toggle" class="fa fa-fw fa-eye field-icon toggle-password"></span> 
                                        </div>
                                    </div>
                                </div>
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                    PAYPAL SECRET ID</small>
                                    @error('PAYPAL_SECRET')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div id="pmode"
                                class="form-group ">
                                <label for="MAIL_ENCRYPTION">PAYPAL MODE :</label>
                                <input type="text" value="{{env('PAYPAL_MODE')}}" name="PAYPAL_MODE"
                                    class="form-control">
                                <small class="text-muted"><i class="fa fa-question-circle"></i> For Live use
                                    <b>live</b> and for Test use <b>test</b> as mode</small>

                                    @error('PAYPAL_MODE')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <input {{ $general_settings->paypal_active==1 ? "checked" : "" }}  name="paypal_check"
                                id="toggle" type="checkbox" class="tgl tgl-skewed">
                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                for="toggle"></label>


                            <small class="txt-desc">(Please Enable For Paypal Payment Gateway )</small>
                        </div>

                        <div class="panel-footer">
                            <button type="submit" type="submit"
                                class="btn btn-dark btn-sm">
                                <i class="fa fa-save"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- /.tab-pane -->
            <div class="tab-pane fade" id="tab_3">
                <form action="{{ route('stripe.setting.update') }}" method="POST">
                    @csrf
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>Stripe Payment Settings</label>
                            <div class="pull-right panel-title"><a target="__blank"
                                    title="Get Your Keys From here"
                                    href="https://stripe.com/docs/development"><i class="fa fa-key"
                                        aria-hidden="true"></i> Get Your Keys From here</a></div>
                        </div>

                        <div class="panel-body">

                            <div id="skey"
                                class="form-group">
                                <label for="STRIPE_KEY">STRIPE KEY :</label>
                                <input type="text" name="STRIPE_KEY" value="{{env('STRIPE_KEY')}}"
                                    class="form-control">
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                    Stripe Key</small>
                                    @error('STRIPE_KEY')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>


                            <div id="sst"class="form-group eyeCy">
                                <label for="STRIPE_SECRET">STRIPE SECRET :</label>
                                <div class="input-group">
                                    <input type="password" name="STRIPE_SECRET"
                                    value="{{env('STRIPE_SECRET')}}" class="form-control col-md-11" id="strip_toggle">
                                    <div class="input-group-append">
                                        <div class="input-group-text " style="padding: 6px 17px;">
                                            <span toggle="#strip_toggle" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>
                                    </div>

                                </div>
                                
                                <small class="text-muted"><i class="fa fa-question-circle"></i> Enter your
                                    Stripe Secret Key</small>
                                    @error('STRIPE_SECRET')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <input {{ $general_settings->stripe_active==1 ? "checked" : "" }} name="strip_check"
                                id="toggle1" type="checkbox" class="tgl tgl-skewed">
                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                for="toggle1"></label>
                            <small class="help-block">(Enable it For Strip Payment Gateway )</small>
                        </div>

                        <div class="panel-footer">
                            <button type="submit" type="submit" class="btn btn-dark btn-sm">
                                <i class="fa fa-save"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- /.tab-pane -->
            <div class="tab-pane fade" id="tab_8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label> RazorPay API Setting:</label>
                        <div class="pull-right panel-title"><a target="__blank"
                                title="Get Your Keys From here" href="https://razorpay.com/docs/"><i
                                    class="fa fa-key" aria-hidden="true"></i> Get Your Keys From here</a>
                        </div>
                    </div>
                    <form action="{{ route('rpay.setting.update') }}" method="POST">
                        @csrf
                        <div class="panel-body">

                            <div class="form-group">
                                <div class="eyeCy">
                                    <label for="RAZORPAY_KEY"> RazorPay Key: <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="password" value="{{env('RAZORPAY_KEY')}}" name="RAZORPAY_KEY" id="RAZORPAY_KEY" type="password"
                                            class="form-control col-md-11">
                                        <div class="input-group-append">
                                            <div class="input-group-text " style="padding: 6px 17px;">
                                                <span toggle="#RAZORPAY_KEY" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                        Razorpay API key</small>
                                    @error('RAZORPAY_KEY')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="eyeCy">
                                    <label for="RAZORPAY_SECRET"> RazorPay Secret Key: <span
                                            class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="password" value="{{env('RAZORPAY_SECRET')}}"
                                        name="RAZORPAY_SECRET" id="RAZORPAY_SECRET" type="password"
                                        class="form-control col-md-11">
                                        <div class="input-group-append">
                                            <div class="input-group-text " style="padding: 6px 17px;">
                                                <span toggle="#RAZORPAY_SECRET" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> Enter
                                        Razorpay secret key</small>
                                    @error('RAZORPAY_SECRET')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <p></p>

                            <input {{ $general_settings->razorpay_active ==1 ? "checked" : "" }} name="rpaycheck" id="razpay"
                                type="checkbox"
                                class="tgl tgl-skewed">
                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                for="razpay"></label>

                            <small class="txt-desc">(Enable to activate Razorpay Payment gateway )</small>
                            <br><br>

                        </div>

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-dark btn-sm"><i class="fa fa-save"></i> Save
                                Setting</button>
                        </div>

                    </form>
                </div>
            </div>

            
            <!-- /.tab-pane -->
            <div class="tab-pane fade" id="tab_10">
                <form id="demo-form2" method="post" enctype="multipart/form-data"
                    action="{{route('bank_details.setting.update')}}" data-parsley-validate>
                    {{csrf_field()}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Bank Payment Settings
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="form-group col-md-12">
                                <label class="col-md-4">Bank Name <span class="text-red">*</span>
                                </label>
                                <div class="col-md-7 col-xs-12">
                                    <input placeholder="Please enter bank name" type="text" id="first-name"
                                        name="bank_name" class="form-control "
                                        value="{{$bank->bank_name ?? ''}}">
                                    @error('bank_name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-md-4">
                                    Branch Name <span class="text-red">*</span>
                                </label>

                                <div class="col-md-7 col-xs-12">
                                    <input placeholder="Please enter branch name" type="text" id="first-name"
                                        name="branch_name" class="form-control"
                                        value="{{$bank->branch_name ?? ''}}">
                                    @error('branch_name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-4">
                                    IFSC Code <span class="text-red">*</span>
                                </label>

                                <div class="col-md-7 col-xs-12">
                                    <input placeholder="Enter IFSC code" type="text" id="first-name" name="ifsc"
                                        class="form-control" value="{{$bank->ifsc ?? ''}}">
                                    @error('ifsc')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-4">
                                    Account Number <span class="text-red">*</span>
                                </label>
                                <div class="col-md-7 col-xs-12">
                                    <input placeholder="Enter account no." type="text" id="first-name"
                                        name="account_no" class="form-control"
                                        value="{{$bank->account_no ?? ''}}">
                                    @error('account_no')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                
                                <label class="col-md-4">
                                    Account Name <span class="text-red">*</span>
                                </label>

                                <div class="col-md-7 col-xs-12">
                                    <input placeholder="Enter account name" type="text" id="first-name"
                                    value="{{$bank->account_name ?? ''}}" name="account_name"
                                    class="form-control">
                                    
                                    @error('account_name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               
                            </div>

                            <div class="form-group col-md-12">
                                
                                <label class="col-md-4">
                                    Status <span class="text-red">*</span>
                                </label>

                                <div class="col-md-7 col-xs-12">
                                    <select name="status" class="form-control">
                                        <option value="0"{{($bank->status==0) ? 'selected':''}}>No</option>
                                        <option value="1" {{($bank->status==1) ? 'selected':''}}>Yes</option>
                                    </select>
                                    
                                    @error('status')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               
                            </div>

                        </div>

                        <div class="panel-footer">
                            <button  type="submit" 
                                class="btn btn-dark btn-sm"><i class="fa fa-save"></i> Save
                                Changes</button>
                        </div>

                </form>
            </div>
        </div>
        <!-- /.tab-pane -->
    </div>
</div>
</div>
        </div>
    </div>
</div>

@endsection
