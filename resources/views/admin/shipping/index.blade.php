@extends("layouts.admin")
@section('title','Shipping Master |')

@section('breadcrumb')
<li class="breadcrumb-item active">Shipping Master</li>
@endsection
@section('css')
    
@endsection
@section('js')
<script>
 $(function () {

    "use strict";

    $('.kk').on('click',function () {
        var shiping_id  = $(this).attr("id");
        $.ajax({

            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"GET",
        url:"{{url('admin/shipping_update')}}",
        data: {catId: shiping_id},
        dataType: 'html',
        success:function(data){
            
            $('#flash-message').html(data).slideDown(500);

        }

        });
        
        setTimeout(function() {
            $("#flash-message").slideUp(500);
        }, 2000); 
    });
});
</script>
@endsection
@section("content")
<div class="container-fluid">
    @include('flash-message')
    <div id="flash-message" class="display-none flash-message">
                    
    </div>
    <div class="card">
        <div class="card-header">
           <div class="row">
                <div class="col-md-10">
                  <h4 class="m-0">{{__("Shipping Master")}}</h4>
                </div>
                
            </div>
        </div>  
        <div class="card-body">
            <table id="service_table" class="table table-bordered table-striped ">
                <thead>
                <tr>
                    <th>Default</th>
                    <th>Shipping Title</th>
                    <th>Price</th>
                    
                    <th>Action</th>
                    
                </tr>
                </thead>
                <tbody>
                    @foreach($shippings as $shipping)
                  
                    <tr>
                        <td><input type="radio" class="kk" id="{{$shipping->id}}" {{$shipping->default_status=='1'?'checked':''}} name="radio"></td>
                        <td>{{$shipping->name}}</td>
                        <td>{{$shipping->price ?? '---'}}</td>
                        
                        <td>
                            @if($shipping->name == 'Flat Rate')
                                <a  href=" {{url('admin/shipping/'.$shipping->id.'/edit')}} " class="btn btn-info btn-sm">Edit
                                </a>
                            @endif
                            
                        </td>
                        
                    </tr>
                    @endforeach
                
                </tbody>
        
            </table>
        </div>
    </div>
</div>     
  
@endsection

