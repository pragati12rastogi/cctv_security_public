@extends('layouts.admin')
@section('title', 'FAQ |')

@section('breadcrumb')
<li class="breadcrumb-item active">FAQ</li>
@endsection
@section('css')
  
@endsection
@section('js')

<script>
  
  $(function () {
    $("#faq_table").DataTable();
  });


  
</script>
@endsection
@section('content')

<div class="container-fluid">
    @include('flash-message')
    <div class="card">
        <div class="card-header">
            <div class="row">
                
                    <div class="col-md-10">
                        <h4 class="m-0">{{__("FAQ Summary")}}</h4>
                    </div>
                     <div class="col-md-2" >
                        <a href="{{url('admin/faq/create')}}" class="btn-dark btn-sm card-btn-right">{{__("Add FAQ")}}</a>
                    </div>
            </div>
        </div>
        <div class="card-body">
            
          <table id="faq_table" class="table table-bordered table-striped">
            <thead>
              <tr class="table-heading-row">
                <th>ID</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php $i = 1; @endphp
              @foreach($faqs as $faq)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$faq->que}}</td>
                <td>{{substr(strip_tags($faq->ans), 0, 250)}}{{strlen(strip_tags($faq->ans))>250 ? '...' : ""}}</td>
                <td>
                  <form action="{{ route('faq.quick.update',$faq->id) }}" method="POST">
                      {{csrf_field()}}
                      <button type="submit" class="btn btn-xs {{ $faq->status==1 ? "btn-success" : "btn-danger" }}">
                        {{ $faq->status ==1 ? 'Active' : 'Deactive' }}
                      </button>
                  </form>
                </td>
                <td>
                  <a href=" {{url('admin/faq/'.$faq->id.'/edit')}} " class="btn btn-xs btn-info">
                    <i class="fa fa-pen"></i>
                  </a>
                  &nbsp;
                  <a data-toggle="modal" data-target="#{{$faq->id}}faq"  class="btn btn-xs btn-danger ">
                      <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
       
          </table>
        </div>
    </div>
</div>
@foreach($faqs as $faq)
   <div id="{{ $faq->id }}faq" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete this faq? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/faq/'.$faq->id)}}" class="pull-right">
                              {{csrf_field()}}
                               {{method_field("DELETE")}}
                                
                              
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
@endforeach
@endsection
