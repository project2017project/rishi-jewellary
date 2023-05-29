			@if (count($prods) > 0)
					@foreach ($prods as $key => $prod)
									
<div class="col-6 col-sm-6 col-md-4 col-lg-4 item">
 					<!--Start Product Image-->
 					<div class=" ps-product">
 					<div class="ps-product__thumbnail">
 						
 						<!--Start Product Image-->
 						<a href="{{ route('front.product', $prod->slug) }}" class="product-img">
 							<!--Image-->
 							<img class="primary blur-up lazyload" data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="image" title="">
 							<!--End image-->
 							<!--Hover image-->
 						<!--	<img class="hover blur-up lazyload" data-src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="image" title="">-->
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
 							<span class="price">{{ $prod->setCurrency() }} <del><small>{{ $prod->showPreviousPrice() }}</small></del></span>
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
 				</div>

				@endforeach
				<div class="col-lg-12">
					<div class="page-center mt-5">
						{!! $prods->appends(['search' => request()->input('search')])->links() !!}
					</div>
				</div>
			@else
				<div class="col-lg-12">
					<div class="page-center">
						 <h4 class="text-center">{{ $langg->lang60 }}</h4>
					</div>
				</div>
			@endif


@if(isset($ajax_check))


<script type="text/javascript">


// Tooltip Section


    $('[data-toggle="tooltip"]').tooltip({
      });
      $('[data-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });




      $('[rel-toggle="tooltip"]').tooltip();

      $('[rel-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });


// Tooltip Section Ends

</script>

@endif