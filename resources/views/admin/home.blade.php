@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            <div class="db row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-gradient-cyan">
                        <div class="inner">
                        <h3>{{$user}}</h3>

                        <p>Total Users</p>
                        </div>

                        <div class="icon">
                        <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{url('/admin/users')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                        <h3>{{$order}}<sup class="font-size-20"></sup></h3>

                        <p>Total Orders</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-bag" aria-hidden="true"></i>

                        </div>
                        <a href="{{url('admin/all/orders')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                        <h3>{{ $totalcancelorder }}<sup class="font-size-20"></sup></h3>

                        <p>Total Cancelled Orders</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-thumbsdown" aria-hidden="true"></i>

                        </div>
                        <a href="{{url('admin/all/cancel/orders')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                        <h3>{{ $totalproducts }}<sup class="font-size-20"></sup></h3>

                        <p>Total Products</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-social-dropbox" aria-hidden="true"></i>

                        </div>
                        <a href="{{url('admin/product')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                        <h3>{{$category}}</h3>

                        <p>Total Categories</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{url('admin/topcategory')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                        <h3>{{$subcategory}}</h3>

                        <p>Total Sub-Categories</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-podium"></i>
                        </div>
                        <a href="{{url('admin/subcategory')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-pink">
                        <div class="inner">
                        <h3>{{$childcategory}}</h3>

                        <p>Total Child-Categories</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-android-apps"></i>
                        </div>
                        <a href="{{url('admin/childcategory')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                        <h3>{{$faqs}}</h3>

                        <p>Total FAQ's</p>
                        </div>
                        <div class="icon">

                        <i class="ion ion-ios-flower" aria-hidden="true"></i>


                        </div>
                        <a href="{{url('admin/faq')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red-500">
                        <div class="inner">
                        <h3>{{ $total_pages }}</h3>

                        <p>Total Pages (active)</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-android-checkbox-outline" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('admin/page') }}" class="small-box-footer">
                        See all <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-gradient-indigo">
                        <div class="inner">
                        <h3>{{ $total_services }}</h3>

                        <p>Total Services</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-android-attach" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('admin/service') }}" class="small-box-footer">
                        See all <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-gradient-olive">
                        <div class="inner">
                        <h3>{{ $total_subs }}</h3>

                        <p>Total Subscribers</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-person-stalker" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('admin/subscribers') }}" class="small-box-footer">
                        See all <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
@endsection
