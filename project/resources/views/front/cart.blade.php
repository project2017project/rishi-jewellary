@extends('layouts.front')
@section('content')
<!-- Breadcrumb Area Start -->
<div class="breadcrumbs-wrapper text-uppercase">
    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ route('front.index') }}">{{ $langg->lang17 }}</a>

            <span>|</span>
            <a href="{{ route('front.cart') }}">{{ $langg->lang121 }}</a>



        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->
<!-- Cart Area Start -->
<section class="cartpage">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="left-area cart">
                    <div class="cart-table">
                        <table class="align-middle">
                            @include('includes.form-success')
                            <thead class="cart__row cart__header small--hide">
                                <tr>
                                    <th class="action">&nbsp;</th>
                                    <th colspan="2" class="text-start">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if(Session::has('cart'))
                                @php $totalQty = 0; @endphp
                                @foreach($products as $product)
                                <tr
                                    class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }} cart__row border-bottom line1 cart-flex border-top">
                                    <td class="cart-delete text-center small--hide">
                                        <span
                                            data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}"
                                            data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}"
                                            class="removecart cart-remove btn btn--secondary cart__remove remove-icon position-static"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Remove item"><i
                                                class="icon an an-times-r"></i></span>
                                    </td>
                                    <td class="cart__image-wrapper cart-flex-item">
                                        <a href="{{ route('front.product', $product['item']['slug']) }}"><img
                                                class="cart__image blur-up lazyload"
                                                data-src="{{ $product['item']['photo'] ? asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}"
                                                src="{{ $product['item']['photo'] ? asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}"
                                                alt="" width="80" /></a>

                                    </td>
                                    <td class="cart__meta small--text-left cart-flex-item">
                                        <div class="list-view-item__title">
                                            <a
                                                href="product-layout1.html">{{mb_strlen($product['item']['name'],'utf-8') > 800 ? mb_substr($product['item']['name'],0,800,'utf-8').'...' : $product['item']['name']}}</a>
                                        </div>

                                        <div class="cart__meta-text">
                                            @if(!empty($product['color']))
                                            Color: <span id="color-bar"
                                                style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                                            @endif<br>
                                            @if(!empty($product['size']))
                                            Size:
                                            {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}}
                                            @endif
                                            @if(!empty($product['size']))
                                            <b>{{ $langg->lang312 }}</b>:
                                            {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}}
                                            <br>
                                            @endif

                                            @if(!empty($product['keys']))
                                            @foreach( array_combine(explode(',', $product['keys']), explode(',',
                                            $product['values'])) as $key => $value)
                                            <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} <br>
                                            @endforeach
                                            @endif
                                        </div>


                                        <div class="cart-price d-md-none">
                                            <span
                                                class="money fw-500">{{ App\Models\Product::convertPrice($product['item_price']) }}</span>
                                        </div>
                                    </td>

                                    <td class="cart__price-wrapper cart-flex-item text-center small--hide">
                                        <span class="money">
                                            {{ App\Models\Product::convertPrice($product['item_price']) }}
                                        </span>
                                    </td>
                                    <td class="cart__update-wrapper cart-flex-item text-end text-md-center">
                                        @if($product['item']['type'] == 'Physical')
                                        @php $totalQty = $totalQty + $product['qty']; @endphp
                                        <div class="qty cart__qty d-flex justify-content-end justify-content-md-center">
                                            <div class="qtyField">
                                                <input type="hidden" class="prodid" value="{{$product['item']['id']}}">
                                                <input type="hidden" class="itemid"
                                                    value="{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                                                <input type="hidden" class="size_qty" value="{{$product['size_qty']}}">
                                                <input type="hidden" class="size_price"
                                                    value="{{$product['size_price']}}">

                                                <span class="qtminus1 reducing qtyBtn minus">
                                                    <i class="icon an an-minus-r"></i>
                                                </span>

                                                <span class="qttotal1 cart__qty-input qty"
                                                    id="qty{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ $product['qty'] }}</span>

                                                <span class="qtplus1 adding qtyBtn plus">
                                                    <i class="icon an an-plus-r"></i>
                                                </span>

                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                    @if($product['size_qty'])
                                    <input type="hidden"
                                        id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                        value="{{$product['size_qty']}}">
                                    @elseif($product['item']['type'] != 'Physical')
                                    <input type="hidden"
                                        id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                        value="1">
                                    @else
                                    <input type="hidden"
                                        id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                        value="{{$product['stock']}}">
                                    @endif
                                    <td class="cart-price cart-flex-item text-center small--hide">
                                        <span
                                            id="prc{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}"
                                            class="money fw-500">
                                            {{ App\Models\Product::convertPrice($product['price']) }}
                                        </span>
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if(Session::has('cart'))
            <div class="col-lg-4">
                <div class="right-area">
                    <div class="order-box cart_info">
                        <h4 class="title">{{ $langg->lang127 }}</h4>
                        <ul class="order-list">
                            <li>
                                <p>
                                    {{ $langg->lang128 }}
                                </p>
                                <P>
                                    <b
                                        class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}</b>
                                </P>
                            </li>
                            <li>
                                <p>
                                    {{ $langg->lang129 }}
                                </p>
                                <P>
                                    <b class="discount">{{ App\Models\Product::convertPrice(0)}}</b>
                                    <input type="hidden" id="d-val" value="{{ App\Models\Product::convertPrice(0)}}">
                                </P>
                            </li>
                            <li>
                                <p>
                                    {{ $langg->lang130 }}
                                </p>
                                <P>
                                    <b>{{$tx}}%</b>
                                </P>
                            </li>
                        </ul>
                        <div class="total-price">
                            <p>
                                {{ $langg->lang131 }}
                            </p>
                            <p>
                                <span
                                    class="main-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}</span>
                            </p>
                        </div>

                        <form id="coupon-form" class="coupon">
                            <div class="form-group mb-0">
                                <label for="address_zip">Enter your coupon code if you have one.</label>
                                <div class="input-group flex-nowrap">
                                    <input type="text" placeholder="{{ $langg->lang133 }}" id="code" required=""
                                        autocomplete="off" class="input-group__field">
                                    <input type="hidden" class="coupon-total" id="grandtotal"
                                        value="{{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}">
                                    <span class="input-group__btn">
                                        <button type="submit" id="codebtnapply"
                                            class="btn rounded-end text-nowrap">{{ $langg->lang134 }}</button>
                                    </span>
                                </div>
                            </div>


                        </form>

                        <div class="coupon-code-wrap pb-4">
                            @foreach($coupans as $coupon)
                            @php
                            $today = date('Y-m-d');
                            $from = date('Y-m-d',strtotime($coupon->start_date));
                            $to = date('Y-m-d',strtotime($coupon->end_date));
                            $minvalue = $coupon->cart_value;
                            $mincart = $coupon->cart_qty;
                            @endphp
                            @if($from <= $today && $to>= $today)
                                @if($mincart <= $totalQty) @if((preg_replace('/\D/', '' , (Session::has('cart') ?
                                    App\Models\Product::convertPrice($mainTotal) : '0.00' )))>= $minvalue)

                                    <div class="coupon-values-wrap">
                                        <h5 id="checkcolor">{{$coupon->code}}</h5>
                                        <p>{{$coupon->description}}</p>
                                    </div>
                                    @endif
                                    @endif
                                    @endif
                                    @endforeach
                        </div>
                        <a href="{{ route('front.checkout') }}" class="btn rounded get-rates w-100">
                            {{ $langg->lang135 }}
                        </a>
                        <a href="{{ route('front.checkout') }}" class="btn rounded get-rates w-100">
                            Send For Quotation
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Cart Area End -->
@endsection