<ul class="nav navbar-nav">
  @foreach($main_menus as $menu)

    @if($menu['menu_type'] == 'cat')
      
      <li><a href="#">{{$menu['title']}} <span class="caret"></span></a>
        <ul class="dropdown-menu"> 
          @foreach($menu['parent_cat'] as $index => $parent)

            @php
              $sub_count = ($menu['cat_type'] == 'cat') ? count($parent['subcategory']) : count($parent['childcategory']);
              $sub_array =  ($menu['cat_type'] == 'cat') ? $parent['subcategory'] : $parent['childcategory'];

            @endphp

            <li><a href="{{($sub_count > 0)?'#':url('user/category/'.$parent['id'])}}">{{$parent['name']}} @php if($sub_count > 0){ @endphp <span class="caret"></span> @php } @endphp </a>
                @if($sub_count > 0)
                  <ul class="dropdown-menu">
                    @foreach($sub_array  as $in => $sub)
                    <li><a href="{{url('user/subcategory/'.$sub['id'])}}">{{$sub['name']}}</a></li>
                    @endforeach                                  
                  </ul>
                @endif
            </li>

          @endforeach
        </ul>
      </li>

    @elseif($menu['menu_type'] == 'url')
      
      <li><a href="{{$menu['link']}}">{{$menu['title']}}</a></li>

    @elseif($menu['menu_type'] == 'page')

      <li>
        <a href="#">{{$menu['title']}}<span class="caret"></span></a>
        @if(count($menu['pages']) > 0 )
          <ul class="dropdown-menu">
            @foreach($menu['pages'] as $ind => $page)
              <li><a href="{{url('/user/page/'.$page['slug'])}}">{{$page['name']}}</a></li>
            @endforeach
          </ul>
        @endif
      </li>

    @endif

  @endforeach
         
</ul>