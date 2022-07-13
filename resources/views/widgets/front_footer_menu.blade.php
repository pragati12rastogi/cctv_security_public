<div class="row">
    @foreach($footer as $fin => $fdata)
        <div class="col-md-3 col-sm-6">
        <div class="aa-footer-widget">
            <h3>{{$fdata['widget']}}</h3>
            <ul class="aa-footer-nav">
            @if($fdata['link_type'] == 'category')

                @foreach($fdata['category'] as $cat_ind =>$cat_data)

                    <li><a href="{{url('user/category/'.$cat_data['id'])}}">{{$cat_data['name']}}</a></li>

                @endforeach

            @elseif($fdata['link_type'] == 'page')

                @foreach($fdata['page'] as $page_ind =>$page_data)

                    <li><a href="{{url('user/page/'.$page_data['slug'])}}">{{$page_data['name']}}</a></li>

                @endforeach

            @elseif($fdata['link_type'] == 'url')

                @foreach($fdata['links'] as $link_name =>$link_url)

                    <li><a href="{{$link_url}}">{{$link_name}}</a></li>

                @endforeach

            @endif
            </ul>
        </div>
        </div>
    @endforeach   
</div>