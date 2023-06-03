									@if(Session::has('cart'))


									<div id="cart-drawer" class="block block-cart">
                            <div class="minicart-header">
                                <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
                                <h4 class="fs-6">Your cart (<span class="cart-quantity">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }} </span>Items)</h4>
                            </div>
                            <div class="minicart-content">
                                <ul class="clearfix dropdown-cart-products">

                                	@foreach(Session::get('cart')->items as $product)
                                   
                                		<li class="item d-flex-custom justify-content-center align-items-center product cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
    <a class="product-image" href="{{ route('front.product', $product['item']['slug']) }}">
        <img class="blur-up lazyload" src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" data-src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="image" title="">
    </a>
    <div class="product-details">
        <a class="product-title" href="{{ route('front.product',$product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 45 ? mb_substr($product['item']['name'],0,45,'utf-8').'...' : $product['item']['name']}}</a>
        <div class="variant-cart">{{ $product['item']['measure'] }}</div>
        <div class="priceRow">
            <div class="product-price">
                <span class="money" id="prct{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ App\Models\Product::convertPrice($product['item_price']) }}</span>
            </div>
        </div>
    </div>
    <div class="qtyDetail text-center">
        <div class="wrapQtyBtn">
            <div class="qtyField">
                
                <input type="text" name="quantity" value="{{$product['qty']}}" class="qty" readonly>
            </div>
        </div>
        <!-- <a href="#" class="edit-i remove"><i class="icon an an-edit-l" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a> -->
        <a href="javascript:;" class="cart-remove remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}" title="Remove Product"><i class="an an-times-r" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
    </div>
</li>


                                	@endforeach


                                   
                                </ul>
                            </div>
                            <div class="minicart-bottom">
                                <!-- <div class="shipinfo text-center mb-3 text-uppercase">
                                    <p class="freeShipMsg"><i class="an an-truck fs-5 me-2 align-middle"></i>SPENT <b>$199.00</b> MORE FOR FREE SHIPPING</p>
                                </div> -->
                                <div class="subtotal dropdown-cart-total">
                                    <span>Total:</span>
                                    <span class="product-price"><span class="cart-total-price">
                                                            <span class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}</span> </span> </span>
                                </div>
                                <a href="{{ route('front.checkout') }}" class="w-100 p-2 my-2 btn btn-outline-primary proceed-to-checkout rounded">Proceed to Checkout</a>
                                <a href="{{ route('front.cart') }}" class="w-100 btn btn-primary cart-btn rounded">View Cart</a>
                            </div>
                        </div>





										
									@else 
									<div id="cartEmpty" class="cartEmpty d-flex-justify-center flex-column text-center p-3 text-muted">
                            <div class="minicart-header d-flex-center justify-content-between w-100">
                                <h4 class="fs-6">Your cart (0 Items)</h4>
                                <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
                            </div>
                            <div class="cartEmpty-content mt-4">
                                <i class="icon an an-sq-bag fs-1 text-muted"></i> 
                                <p class="my-3">No Products in the Cart</p>
                                <a href="category-4columns.html" class="btn btn-primary cart-btn rounded">Continue shopping</a>
                            </div>
                        </div>
									@endif