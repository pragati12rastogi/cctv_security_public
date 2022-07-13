<a class="aa-cart-link" href="{{url('user/add-to-cart')}}">
    <span class="fa fa-shopping-basket"></span>
    <span class="aa-cart-title">SHOPPING CART</span>
    <span class="aa-cart-notify">{{count($user_cart_list)}}</span>
</a>
<div class="aa-cartbox-summary">
    <ul>
        @php $cart_total = 0; @endphp
        @foreach($user_cart_list as $cart_index => $cart_list)
        <li>
            <a class="aa-cartbox-img" href="{{url('user/product/'.$cart_list['product']['id'])}}"><img src="{{url('assets/uploads/product_photos/'.$cart_list['product']['photos'][0]['image'])}}" alt="img"></a>
            <div class="aa-cartbox-info">
            <h4><a href="{{url('user/product/'.$cart_list['product']['id'])}}">{{$cart_list['product']['name']}}</a></h4>
            <p>{{$cart_list['qty']}} x Rs.{{$cart_list['actual_price']}}</p>
            </div>
            
            <a class="aa-remove-product" onclick="event.preventDefault();document.getElementById('cart-widget-item-delete').submit();"><span class="fa fa-times"></span></a>
            
            <form id="cart-widget-item-delete" action="{{url('user/add-to-cart/'.$cart_list['id'])}}" method="POST" class="logout-form display-none">
                {{csrf_field()}}
                {{method_field("DELETE")}}
            </form>
        </li>
            @php
                $cart_total = $cart_total+($cart_list['qty']*$cart_list['actual_price']);
            @endphp
        @endforeach              
        <li>
            <span class="aa-cartbox-total-title">
            Total
            </span>
            <span class="aa-cartbox-total-price">
            Rs.{{$cart_total}}
            </span>
        </li>
    </ul>
        <a class="aa-cartbox-checkout aa-primary-btn" href="{{url('user/checkout')}}">Checkout</a>
</div>