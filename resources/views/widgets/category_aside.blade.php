<div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
    <aside class="aa-sidebar">
        <!-- single sidebar -->
        <div class="aa-sidebar-widget">
            <h3>Categories</h3>
            <ul class="aa-catg-nav panel-group">
                @foreach($all_cat as $ind => $cat)
                <li class="panel m-0">
                    <a class="panel panel-footer panel-heading" data-toggle="collapse" href="#cat_sub_{{$cat['id']}}">{{$cat['name']}}
                    <span >{{count($cat['subcategory'])>0?'('.count($cat['subcategory']).')':''}}</span>
                    </a>
                    <div id="cat_sub_{{$cat['id']}}" class="panel-collapse collapse {{$config['cat_id']==$cat['id']?'in':''}}">
                        <ul class="list-group" style="padding-left: 35px;">
                            @foreach($cat['subcategory'] as $s_ind => $subs)
                                <li style="list-style: circle;">
                                    
                                    <a href="{{url('user/subcategory/'.$subs['id'])}}" class="{{(count($subs['childcategory'])>0)?'col-xs-9':''}}" >{{$subs['name']}}</a>
                                      
                                    @if(count($subs['childcategory'])>0)
                                        <a class="panel " data-toggle="collapse" href="#sub_child_{{$subs['id']}}">
                                            <span >( {{count($subs['childcategory'])}} )</span>
                                            <span class="fa fa-caret-down" ></span>
                                        </a> 

                                        <div id="sub_child_{{$subs['id']}}" class="panel-collapse collapse {{$config['sub_id']==$subs['id']?'in':''}}">
                                            <ul class="list-group" style="padding-left: 35px;">
                                                @foreach($subs['childcategory'] as $c_ind => $child)
                                                <li style="list-style: circle;">
                                                    <a href="{{url('user/childcategory/'.$child['id'])}}" >{{$child['name']}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif 
                                
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endforeach
                
            </ul>
        </div>
        <!-- single sidebar -->
    </aside>
</div>