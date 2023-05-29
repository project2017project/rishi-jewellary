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




<div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 ">
                        <div class="ps-product">
                            <div class="ps-product__thumbnail">
                                
                                    <a class="ps-product__overlay" href="{{ route('front.product', $prod->slug) }}"></a>
                                    <img data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="">
                                <ul class="ps-product__actions">
                                    
                                    <li>
                                        @if(Auth::guard('web')->check())
                                        <span class="btn-icon wishlist add-to-wishlist rounded add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right">
                                            <i class="icon-heart-o"></i>
 								<span class="tooltip-label">Add To Wishlist</span>
							</span>
                                        
                                        @else
                                        	<a class="btn-icon wishlist add-to-wishlist rounded" href="{{ route('user.login') }}">
 								<i class="icon-heart-o"></i>
 								<span class="tooltip-label">Add To Wishlist</span>
 							</a>
                                        
                                         @endif
                                         
                                        </li>
                                       
                                  <!--  <li>
                                        <a href="javascript:;" title="{{ $langg->lang55 }}" class="btn-icon quick-view-popup quick-view rounded" data-toggle="modal" data-href="{{ route('product.quick',$prod->id) }}" data-target="#quickview">
 								<i class="icon-eye3"></i>
 								<span class="tooltip-label">Quick View</span>
 							</a>
                                        </li>-->
                                </ul>
                                	@if($prod->product_type == "affiliate")
							<span class=" ps-product__shopping add-to-cart-btn affilate-btn btn-icon btn btn-addto-cart pro-addtocart-popup rounded"
								data-href="{{ route('affiliate.product', $prod->slug) }}"><i class="icofont-cart"></i>
								{{ $langg->lang251 }}
							</span>
						@else
							@if($prod->stock === 0)
							<span class=" ps-product__shopping add-to-cart-btn cart-out-of-stock btn-icon btn btn-addto-cart pro-addtocart-popup rounded">
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
                                <!--<a class="ps-product__shopping" href="cart.html">+ Quick add</a>-->
                            </div>
                            <div class="ps-product__content">
                                <a class="ps-product__title" href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>
                                <p class="ps-product__price">
                                    {{ $attrPrice != 0 ?  $gs->currency_format == 0 ? $curr->sign.$withSelectedAtrributePrice : $withSelectedAtrributePrice.$curr->sign :$prod->showPrice() }} <del><small>{{ $prod->showPreviousPrice() }}</small></del>
                                    <!--<del>$168.99</del>- $178.99-->
                                </p>
                              
                            </div>
                        </div>
                    </div>









