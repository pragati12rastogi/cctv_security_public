@extends('layouts.admin')
@section('title', 'User Details|')

@section('breadcrumb')
<li class="breadcrumb-item "><a href="{{url('admin/users')}}">User Summary</a></li>
<li class="breadcrumb-item active">User Details</li>
@endsection

@section('css')
    <style>
        .width-height{
            width: 10%;
            height:10%;
        }
    </style>
@endsection
@section('js')
<script>
$(function() {
    
    $("#user_table").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
            extend:'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2,3,4 ] 
               }
            }
        ]
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
                <div class="col-md-10">
                  <h4 class="m-0">{{__("User Details")}}</h4>
                </div>
                
            </div>
        </div>  
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-3">Profile Details</h4>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive-xl">
                        <tr>
                            <th>Name :</th>
                            <td> {{$user->name}} </td>
                            <th>Email :</th>
                            <td> {{$user->email}} </td>
                        </tr>
                        <tr>
                            <th>Phone :</th>
                            <td> {{$user->phone}} </td>
                            <th>Email Verified:</th>
                            <td> {{empty($user->email_verified_at)? 'No': 'Yes'}} </td>
                        </tr>
                    </table>
                </div>
            </div>
            @if(!empty($bank))
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-3">Bank Details</h4>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive-xl">
                        <tr>
                            <th>Bank Name :</th>
                            <td>{{$bank->bankname}} </td>
                            <th>Account Number :</th>
                            <td> {{$bank->account_no}} </td>
                        </tr>
                        <tr>
                            <th>Account Name :</th>
                            <td> {{$bank->account_name}} </td>
                            <th>IFSC:</th>
                            <td> {{$bank->ifsc}} </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
            @if(!empty($address))
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-3">Address Details</h4>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive-xl">
                        <tr>
                            <th>Name :</th>
                            <td>{{$address->first_name}} {{$address->last_name}} </td>
                            <th>Email :</th>
                            <td> {{$address->email}} </td>
                        </tr>
                        <tr>
                            <th>Phone :</th>
                            <td> {{$address->phone}} </td>
                            <th rowspan="2">Address:</th>
                            <td  rowspan="2">{{$address->suit_no}} {{$address->address}} ,{{ucwords($address->city)}}, {{ucwords(strtolower($address->state->state_name))}},{{ucwords(strtolower($address->country->name))}}</td>
                        </tr>
                        <tr>
                            <th>Zipcode :</th>
                            <td>{{$address->zipcode}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
