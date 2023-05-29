	@php
		$attrPrice = 0;
		$sessionCur = session()->get('currency');
		$sessionCurr = DB::table('currencies')->where('id',$sessionCur)->first();
		$databaseCurr = DB::table('currencies')->where('is_default',1)->first();
		$curr = $sessionCurr ? $sessionCurr: $databaseCurr;

		if($prod->user_id != 0){
        $attrPrice = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
        }

    if(!empty($prod->size) && !empty($prod->size_price)){
          $attrPrice += $prod->size_price[0];
      }

      if(!empty($prod->attributes)){
        $attrArr = json_decode($prod->attributes, true);
      }
	@endphp
  
  @if (!empty($prod->attributes))
  @php
	$attrArr = json_decode($prod->attributes, true);
  @endphp
  @endif
  
  @if (!empty($attrArr))
	@foreach ($attrArr as $attrKey => $attrVal)
	  @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)
		@foreach ($attrVal['values'] as $optionKey => $optionVal)
		  @if ($loop->first)
			@if (!empty($attrVal['prices'][$optionKey]))
			  @php
				  $attrPrice = $attrPrice + $attrVal['prices'][$optionKey] * $curr->value;
			  @endphp
			@endif
		  @endif
		@endforeach
	  @endif
	  @endforeach
  @endif
  
@php
  $withSelectedAtrributePrice = $attrPrice+$prod->price;
  $withSelectedAtrributePrice = round(($withSelectedAtrributePrice) * $curr->value,2);

//   if($gs->currency_format == 0){
//        $curr->sign.$withSelectedAtrributePrice;
//     }
//     else{
//          $withSelectedAtrributePrice.$curr->sign;
//     }
@endphp







<div class="ps-product">
 					<!--Start Product Image-->
 					<div class="product-image">
 						
 						<!--Start Product Image-->
 						<a href="{{ route('front.product', $prod->slug) }}" class="product-img">
 							<!--Image-->
 							<img class="primary blur-up lazyload" data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="image" title="">
 							<!--End image-->
 							<!--Hover image-->
 					<!--		<img class="hover blur-up lazyload" data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="image" title="">-->
 							<!--End hover image-->


 							@if(!empty($prod->features))
								<div class="product-labels">
								@foreach($prod->features as $key => $data1)
									<span class="lbl on-sale rounded" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
									@endforeach 
								</div>
							@endif

 						


 						</a>
 						<!--End Product Image-->

 						@if($prod->discount_date)

 						   <div class="saleTime desktop" data-countdown="{{ $prod->discount_date }}"></div>

 						   @endif

 						<!--Product Button-->
 						<div class="button-set-top position-absolute style1">
 							@if(Auth::guard('web')->check())

							<span class="btn-icon wishlist add-to-wishlist rounded add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"> <i class="icon an an-heart-l"></i>
 								<span class="tooltip-label">Add To Wishlist</span>
							</span>

							@else 

							<a class="btn-icon wishlist add-to-wishlist rounded" href="{{ route('user.login') }}">
 								<i class="icon an an-heart-l"></i>
 								<span class="tooltip-label">Add To Wishlist</span>
 							</a>

							@endif
 						
 							<!--Quick View Button-->
 						<!--	<a href="javascript:;" title="{{ $langg->lang55 }}" class="btn-icon quick-view-popup quick-view rounded" data-toggle="modal" data-href="{{ route('product.quick',$prod->id) }}" data-target="#quickview">
 								<i class="icon an an-search-l"></i>
 								<span class="tooltip-label">Quick View</span>
 							</a>-->
 							<!--End Quick View Button-->


 						


 						</div>
 						<div class="button-set-bottom position-absolute style1">
 							<!--Cart Button-->
 							

 							@if($prod->product_type == "affiliate")
							<span class="add-to-cart-btn affilate-btn btn-icon btn btn-addto-cart pro-addtocart-popup rounded"
								data-href="{{ route('affiliate.product', $prod->slug) }}"><i class="icofont-cart"></i>
								{{ $langg->lang251 }}
							</span>
						@else
							@if($prod->stock === 0)
							<span class="add-to-cart-btn cart-out-of-stock btn-icon btn btn-addto-cart pro-addtocart-popup rounded">
								<i class="icofont-close-circled"></i> {{ $langg->lang78 }}
							</span>													
							@else
						<a class="ps-product__shopping rounded" href="{{ route('front.product', $prod->slug) }}">
								<i class="icofont-cart"></i>View Product
							</a>
							<!-- <span class="add-to-cart-quick add-to-cart-btn btn-icon btn btn-addto-cart pro-addtocart-popup rounded"
								data-href="{{ route('product.cart.quickadd',$prod->id) }}">
								<i class="icofont-cart"></i> {{ $langg->lang251 }}
							</span> -->
							@endif
						@endif


 							<!--End Cart Button-->
 						</div>
 						<!--End Product Button-->
 						
 					</div>
 					<!--End Product Image-->
 					<!--Start Product Details-->
 					<div class="product-details text-center">
 						<!--Product Name-->
 						<div class="product-name text-uppercase">
 							<a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>

 						</div>
 						<!--End Product Name-->
 						<!--Product Price-->
 						<div class="product-price">
 							<span class="price">{{ $attrPrice != 0 ?  $gs->currency_format == 0 ? $curr->sign.$withSelectedAtrributePrice : $withSelectedAtrributePrice.$curr->sign :$prod->showPrice() }} <del><small>{{ $prod->showPreviousPrice() }}</small></del></span>
 						</div>


 						<!--End Product Price-->
 						<!--Product Review-->
 						
 						<div class="stars product-review">
				<div class="ratings">
					<div class="empty-stars"></div>
					<div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
				</div>
			</div>
 						<!--End Product Review-->
 				
 					</div>
 					<!--End Product Details-->
 				</div>




