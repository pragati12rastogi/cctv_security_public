@extends("layouts.admin")
@section('title','Edit Faq | ')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{url('admin/faq')}}">FAQ</a></li>
<li class="breadcrumb-item active">Edit FAQ</li>
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
                    <h4 class="m-0">{{__("Edit FAQ")}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/faq/'.$faq->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Question <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input placeholder="Please enter Question" type="text" id="first-name" name="que" value="{{$faq->que}}"  class="form-control">
                        
                    </div>
                </div>
                        
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Answer <span class="required">*</span>
                    </label>
                        
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea rows="5" cols="10" placeholder="Please enter answer" type="text" name="ans"   class="form-control ckeditor">{{$faq->ans}}</textarea>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">
                        Status
                    </label>
                    <div class="col-md-10 col-sm-9 col-xs-12 pt-3 d-flex">
                        <input type="checkbox" name="status" value="1" {{ ($faq->status) ? 'checked':'' }} >
                        <small >(Active/Deactive) </small>
                    </div>
                </div>
                
                <div class="col-xs-12 ">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
     
        
@endsection
