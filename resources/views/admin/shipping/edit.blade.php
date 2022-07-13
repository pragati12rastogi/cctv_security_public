@extends("layouts.admin")
@section('title','Edit Shipping '.$shipping->name. ' | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/shipping')}}">Shipping Master</a></li>
<li class="breadcrumb-item active">Edit Shipping {{$shipping->name}}</li>
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
                    <h4 class="m-0">Edit Shipping {{$shipping->name}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/shipping/'.$shipping->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                    Shipping Title <span class="required">*</span>
                </label>
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input disabled="disabled" placeholder="Please enter shipping title" type="text" name="name" class="form-control col-md-7 col-xs-12" value="{{$shipping->name}}">
                    
                </div>
                </div>
                @if($shipping->id != 1)
                <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                    Price <span class="required">*</span>
                </label>
                
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input placeholder="Please enter price" type="text" name="price" class="form-control col-md-7 col-xs-12" value="{{$shipping->price}}">
                </div>
                </div>
                @endif

                
                <div class="ln_solid"></div>
                <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </div>

            </form>
        </div>
    </div>
     
@endsection
