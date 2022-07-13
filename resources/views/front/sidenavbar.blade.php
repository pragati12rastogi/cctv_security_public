<div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
    <aside class="aa-sidebar border bg-gray-50">
        <div class="aa-sidebar-widget">
            <h3 class="p-4">•  Hi!  {{Auth::user()->name}}</h3>
            <ul class="nav nav-pills nav-sidebar">
                <li class="nav-item nav-justified navbar-static-top {{Request::routeIs('my.account') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('my.account')}}">
                        <span class="fa fa-users"></span> My Account
                    </a>
                </li>
                <li class="nav-item nav-justified navbar-static-top {{Request::routeIs('my.ship.address') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('my.ship.address')}}">
                        <span class="fa fa-compass"></span> Manage Shipping Address
                    </a>
                </li>
                <li class="nav-item nav-justified navbar-static-top {{Request::routeIs('my.bank.account') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('my.bank.account')}}">
                        <span class="fa fa-university"></span> My Bank Account
                    </a>
                </li>
                <li class="nav-item nav-justified navbar-static-top {{(Request::routeIs('my.orders')||Request::routeIs('order.view')) ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('my.orders')}}">
                        <span class="fa fa-cart-arrow-down"></span> My Orders
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</div>