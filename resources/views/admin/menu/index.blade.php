@extends('layouts.admin')
@section('title', 'All Menu List|')

@section('breadcrumb')
<li class="breadcrumb-item active">All Menu List</li>
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
    
    $("#menu_table").DataTable({
        "processing": true,
        "serverSide": true,
        "aaSorting": [],
        "responsive": true,
        "ajax": '{{url("admin/menulistapi")}}',
        "columns": [
            { "data": "id" },
            { "data": "title" },
            { 
                "targets": [ -1 ],
                "data": "link_by","render": function(data,type,full,meta){

                    
                    if(data == 'page'){
                        return 'Custom Page';
                    }else if(data == 'url'){
                        return 'Custom URL';
                    }else{
                        return 'Custom Category';
                    }
                }
            },
            {
                "targets": [ -1 ],
                "data": "status","render": function(data,type,full,meta){

                    var status = '';
                    var btn_class = '';
                    if(data == 1){
                        status = 'Active';
                        btn_class ='btn-success';
                    }else{
                        status = 'Deactive';
                        btn_class='btn-danger';
                    }
                    return '<form action="{{ route("menu.status.update",'+full.id+') }}" method="POST">'+
                      '{{csrf_field()}}'+
                      '<button type="submit" class="btn btn-xs '+btn_class+'">'
                        +status+
                      '</button>'+
                    '</form>';
                }
            },
            {
                "targets": [ -1 ],
                "data":"id", "render": function(data,type,full,meta)
                {   
                    var str ='<a href="{{url("/admin/menu/")}}/'+ data +'/edit" class="btn btn-xs btn-info"><i class="fa fa-pen"></i></a>'+
                        '&nbsp;'+
                        '<a data-toggle="modal" data-target="#'+ data +'_menu"  class="btn btn-xs btn-danger "><i class="fa fa-trash"></i></a>';
                
                    return str;
                },
                "orderable": false
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
                  <h4 class="m-0">{{__("All Menu List")}}</h4>
                </div>
                <div class="col-md-2" >
                    <a href="{{url('admin/menu/create')}}" class="btn-dark btn-sm card-btn-right">{{__("Add Menu")}}</a>
                </div>
            </div>
        </div>  
        <div class="card-body">
            <table id="menu_table" class="table table-bordered table-striped ">
                <thead>
                <tr class="table-heading-row">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Linked To</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
        
            </table>
        </div>
    </div>
</div>
@foreach($menus as $menu)
    <div id="{{ $menu->id }}_menu" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this menu? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('admin/menu/'.$menu->id)}}" class="pull-right">
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
