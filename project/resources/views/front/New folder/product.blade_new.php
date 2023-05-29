@extends('layouts.front')

@section('content')

@php
      $attrPrice = 0;

      if($productt->user_id != 0){
        $attrPrice = $productt->price + $gs->fixed_commission + ($productt->price/100) * $gs->percentage_commission ;
        }

    if(!empty($productt->size) && !empty($productt->size_price)){
          $attrPrice += $productt->size_price[0];
      }

      if(!empty($productt->attributes)){
        $attrArr = json_decode($productt->attributes, true);
      }
@endphp


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
  $withSelectedAtrributePrice = $attrPrice+$productt->price;
  $withSelectedAtrributePrice = round(($withSelectedAtrributePrice) * $curr->value,2);

@endphp



<div class="breadcrumb-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="pages">
          <li><a href="{{route('front.index')}}">{{ $langg->lang17 }}</a></li>
          <li><a href="{{route('front.category',$productt->category->slug)}}">{{$productt->category->name}}</a></li>
          @if($productt->subcategory_id != null)
          <li><a
              href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}">{{$productt->subcategory->name}}</a>
          </li>
          @endif
          @if($productt->childcategory_id != null)
          <li><a
              href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}">{{$productt->childcategory->name}}</a>
          </li>
          @endif
          <li><a href="{{ route('front.product', $productt->slug) }}">{{ $productt->name }}</a>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Product Details Area Start -->

                
                <!--Main Content-->
                <div class="container">
                    <!--Product Content-->
                    <div class="product-single">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12 col-12">
                                <div class="product-details-img thumb-left clearfix d-flex-wrap mb-3 mb-md-0">
                                    <div class="product-thumb">
                                        <div id="gallery" class="product-dec-slider-2 product-tab-left">
                                            @foreach($productt->galleries as $gal)
                                            <a data-image="{{asset('assets/images/galleries/'.$gal->photo)}}" data-zoom-image="{{asset('assets/images/galleries/'.$gal->photo)}}" class="slick-slide slick-cloned active">
                                                <img class="blur-up lazyload" data-src="{{asset('assets/images/galleries/'.$gal->photo)}}" src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="product" />
                                            </a>                                                                             
                                            @endforeach
                                            
                                            
                                        </div>
                                    </div>
                                    <div class="zoompro-wrap product-zoom-right">

                                        <div class="zoompro-span"><img id="zoompro" class="zoompro" src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" data-zoom-image="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" alt="product" /></div>


                                       
                                        @if(!empty($productt->features))
                                                    <div class="product-labels">
                                                      @foreach($productt->features as $key => $data1)
                                                        <span class=" lbl pr-label1 sale" style="background-color:{{ $productt->colors[$key] }}">{{ $productt->features[$key] }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif



                                        @if(Auth::guard('web')->check())
                      <div class="favorite product-wish">
                        <a href="javascript:;" class="add-to-wish wishIcon wishlist rounded m-0"
                          data-href="{{ route('user-wishlist-add',$productt->id) }}"><i class="icon an an-heart"></i><span class="tooltip-label left">Available in Wishlist</span></a>
                      </div>
                      @else
                      <div class="favorite product-wish">
                        <a href="javascript:;" class="wishIcon wishlist rounded m-0" data-toggle="modal" data-target="#comment-log-reg"><i class="icon an an-heart"></i><span class="tooltip-label left">Available in Wishlist</span></a>
                      </div>
                      @endif



                                        <div class="product-buttons">
                                             @if($productt->youtube != null)
                                            <a href="{{ $productt->youtube }}" class="mfpbox mfp-with-anim btn rounded popup-video"><i class="icon an an-video"></i><span class="tooltip-label">Watch Video</span></a>
                                              @endif

                                            <a href="#" class="btn rounded prlightbox"><i class="icon an an-expand-l-arrows"></i><span class="tooltip-label">Zoom Image</span></a>

                                        </div>


                                    </div>
                                    <div class="lightboximages">
                                        @foreach($productt->galleries as $gal)
                                        <a href="{{asset('assets/images/galleries/'.$gal->photo)}}" data-size="1000x1280"></a>
                                         @endforeach
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                                <!-- Product Info -->
                                <div class="product-single__meta">
                                    <h1 class="product-single__title">{{ $productt->name }}</h1>
                                   

                      @if($productt->type == 'Physical')
                      @if($productt->emptyStock())
                      <div class="product-outstook product-single__subtitle">
                        <p>
                          <i class="icofont-close-circled"></i>
                          {{ $langg->lang78 }}
                        </p>
                      </div>
                      @else
                      <div class="product-isstook product-single__subtitle">
                        <p>
                          <i class="icofont-check-circled"></i>
                          {{ $gs->show_stock == 0 ? '' : $productt->stock }} {{ $langg->lang79 }}
                        </p>
                      </div>
                      @endif
                      @endif


                                    <!-- Product Reviews -->                               
                                     <div class="ratings product-review mb-2">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{App\Models\Rating::ratings($productt->id)}}%"></div>
                        </div>
                                    <!-- End Product Reviews -->



                                    <!-- Product Info -->
                                    <div class="product-info"> 
                                        <p class="product-type">Product Category: <span><a href="{{route('front.category',$productt->category->slug)}}">{{$productt->category->name}}</a> @if($productt->subcategory_id != null) >> <a
              href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}">{{$productt->subcategory->name}}</a> @endif  @if($productt->childcategory_id != null) >> <a
              href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}">{{$productt->childcategory->name}}</a> @endif</span></p>                                       

                                    <p class="product-sku">SKU: <span class="variant-sku">{{ $productt->sku }}</span></p>
                                    </div>
                                    <!-- End Product Info -->



                                    <!-- Product Price -->
                                    <div class="product-single__price pb-1">
                                        <span class="visually-hidden">{{ $langg->lang87 }} :</span>
                                        <span class="product-price__sale--single price">
                                            <span class="product-price-old-price">{{ $productt->showPreviousPrice() }}</span><span id="sizeprice" class="product-price__price product-price__sale">{{ $attrPrice != 0 ?  $gs->currency_format == 0 ? $curr->sign.$withSelectedAtrributePrice : $withSelectedAtrributePrice.$curr->sign :$productt->showPrice() }}</span>   
                                            
                                        <div class="product__policies fw-normal mt-1">Tax included.</div>
                                    </div>
                                    <!-- End Product Price -->






                                    


                                    <!-- Product Sold -->
                                    <div class="orderMsg d-flex-center">
                                       


                                         @if($productt->emptyStock())
                     <p id="quantity_message" class="ms-2 ps-2 border-start">Sorry! The product has been sold out</p>
                      @else
                       <img src="assets/images/order-icon.jpg" alt="order" />
                      <p id="quantity_message" class="ms-2 ps-2 border-start">Hurry! Only  <span class="items fw-bold">{{ $gs->show_stock == 0 ? '' : $productt->stock }}</span>  left in stock.</p>
                                            @endif
                                       
                                    </div>
                                    <!-- End Product Sold -->




                                </div>
                                <!-- End Product Info -->
                                <!-- Product Form -->
                                <form method="post" action="#" class="product-form hidedropdown">
                                    <!-- Swatches Color -->
                                     @if(!empty($productt->color))
                                    <div class="swatches-image swatch clearfix swatch-0 option1" data-option-index="0">
                                        <div class="product-form__item">
                                            <label class="label d-flex">{{ $langg->lang89 }}</label>
                                            <ul class="swatches d-flex-wrap list-unstyled clearfix">
                                                  @php
                                                  $is_first = true;
                                                  @endphp
                                                  @foreach($productt->color as $key => $data1)                            
                                                <li class="swatch-element {{ $is_first ? 'active' : '' }}">
                                                    <label class="swatchLbl rounded color xlarge green" title="Green" style="background-color: {{ $productt->color[$key] }}"></label>
                                                    <span class="tooltip-label top">Green</span>
                                                </li>
                                                @php
                                                $is_first = false;
                                                @endphp
                                                @endforeach                          
                                               
                                            </ul>
                                        </div>
                                    </div>
                                     @endif
                                    <!-- End Swatches Color -->



                                @if(!empty($productt->size))
                  <div class="product-size">
                    <p class="title">{{ $langg->lang88 }} :</p>
                    <ul class="siz-list">
                      @php
                      $is_first = true;
                      @endphp
                      @foreach($productt->size as $key => $data1)
                      <li class="{{ $is_first ? 'active' : '' }}">
                        <span class="box">{{ $data1 }}
                          <input type="hidden" class="size" value="{{ $data1 }}">
                          <input type="hidden" class="size_qty" value="{{ $productt->size_qty[$key] }}">
                          <input type="hidden" class="size_key" value="{{$key}}">
                          <input type="hidden" class="size_price"
                            value="{{ round($productt->size_price[$key] * $curr->value,2) }}">
                        </span>
                      </li>
                      @php
                      $is_first = false;
                      @endphp
                      @endforeach
                      <li>
                    </ul>
                  </div>
                  @endif



@if (!empty($productt->attributes))
                        @php
                          $attrArr = json_decode($productt->attributes, true);
                        @endphp
                      @endif
                      @if (!empty($attrArr))
                        <div class="product-attributes my-4">
                          <div class="row">
                          @foreach ($attrArr as $attrKey => $attrVal)
                            @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)

                          <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <strong for="" class="text-capitalize">{{ str_replace("_", " ", $attrKey) }} :</strong>
                                <div class="">
                                @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                @if ($loop->first)
                                  @if (!empty($attrVal['prices'][$optionKey]))
                                    @php
                                        $attrPrice = $attrPrice + $attrVal['prices'][$optionKey] * $curr->value;
                                    @endphp
                                  @endif
                                @endif
                                  <div class="custom-control custom-radio">
                                    <input type="hidden" class="keys" value="">
                                    <input type="hidden" class="values" value="">
                                    <input type="radio" id="{{$attrKey}}{{ $optionKey }}" name="{{ $attrKey }}" class="custom-control-input product-attr"  data-key="{{ $attrKey }}" data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}" value="{{ $optionVal }}" {{ $loop->first ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="{{$attrKey}}{{ $optionKey }}">{{ $optionVal }}
                                 
                                    @if (!empty($attrVal['prices'][$optionKey]))
                                      +
                                      {{$curr->sign}} {{$attrVal['prices'][$optionKey] * $curr->value}}
                                    @endif
                                    </label>
                                  </div>
                                @endforeach
                                </div>
                              </div>
                          </div>
                            @endif
                          @endforeach
                          </div>
                        </div>
                      @endif


                                    <!-- Product Action -->
                                    <div class="product-action w-100 clearfix ">


                                  <div class="product-action w-100 clearfix ">
 @if($productt->product_type != "affiliate")
                      <div class="product-form__item--quantity d-flex-center mb-3 d-block count {{ $productt->type == 'Physical' ? '' : 'd-none' }}">
                        <div class="qty qtyField">
                          
                              <a class="qtyBtn minus qtminus">
                                <i class="icofont-minus"></i>
                              </a>
                              <span class="product-form__input qty qttotal extra-input-same">1</span>
                          
                              <a class="qtyBtn plus qtplus">
                                <i class="icofont-plus"></i>
                              </a>
                        </div>
                      </div>
                      @endif
                    </div>



                                         @if($productt->emptyStock())
                                         <div class="product-form__item--submit">
                      <button type="submit" name="add" class="btn rounded product-form__sold-out d-none" disabled="disabled">Sold out</button>
                  </div>
                      @else

                      <div class="addtocart product-form__item--submit">
                        <a href="javascript:;" id="addcrt" class="btn rounded product-form__cart-submit"><i class="icofont-cart"></i>{{ $langg->lang90 }}</a>
                      </div>

                      <div class="addtocart product-form__item--buyit clearfix">
                        <a id="qaddcrt" href="javascript:;" class="btn rounded btn-outline-primary proceed-to-checkout">
                          <i class="icofont-cart"></i>{{ $langg->lang251 }}
                        </a>
                      </div>

                 
                      @endif                                    
                                   
                                    </div>



                                    
                                </form>
                                <!-- End Product Form -->
                                <!-- Social Sharing -->
                                <div class="social-sharing d-flex-center mb-3">
                                    <span class="sharing-lbl me-2">Share :</span>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Facebook">
                                    <i class="icon an an-facebook mx-1"></i>
                                    <span class="share-title d-none">Facebook</span>
                                </a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-twitter" data-bs-toggle="tooltip" data-bs-placement="top" title="Tweet on Twitter">
                                    <i class="icon an an-twitter mx-1"></i>
                                    <span class="share-title d-none">Tweet</span>
                                </a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-pinterest" data-bs-toggle="tooltip" data-bs-placement="top" title="Pin on Pinterest">
                                    <i class="icon an an-pinterest-p mx-1"></i> 
                                    <span class="share-title d-none">Pin it</span>
                                </a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-linkedin" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Linkedin">
                                    <i class="icon an an-linkedin mx-1"></i>
                                    <span class="share-title d-none">Linkedin</span>
                                </a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-email" data-bs-toggle="tooltip" data-bs-placement="top" title="Share by Email">
                                    <i class="icon an an-envelope-l mx-1"></i>
                                    <span class="share-title d-none">Email</span>
                                </a>
                                </div>
                                <!-- End Social Sharing -->

                                 <div class="shippingMsg"><i class="icon an an-clock-r" aria-hidden="true"></i>Estimated Delivery <b id="fromDate">{{ $productt->ship }}</b>.</div>
                              
                            </div>
                        </div>
                    </div>
                    <!--Product Content-->

                   

                    <!--Product Tabs-->
                    <div class="tabs-listing mt-2 mt-md-5">
                        <ul class="product-tabs list-unstyled d-flex-wrap border-bottom m-0 d-none d-md-flex">
                            <li rel="description" class="active"><a class="tablink">{{ $langg->lang92 }}</a></li>
                            <li rel="size-chart"><a class="tablink">{{ $langg->lang93 }}</a></li>
                            <li rel="shipping-return"><a class="tablink">{{ $langg->lang94 }}({{ count($productt->ratings) }})</a></li>
                        </ul>
                        <div class="tab-container">
                            <h3 class="tabs-ac-style d-md-none active" rel="description">{{ $langg->lang92 }}</h3>
                            <div id="description" class="tab-content">
                                <div class="product-description">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 mb-4 mb-md-0">
                                            {!! $productt->details !!}

                                            @if(!empty($productt->whole_sell_qty))
      <div class="table-area wholesell-details-page">
        <h3>{{ $langg->lang770 }}</h3>
        <table class="table">
          <tr>
            <th>{{ $langg->lang768 }}</th>
            <th>{{ $langg->lang769 }}</th>
          </tr>
          @foreach($productt->whole_sell_qty as $key => $data1)
          <tr>
            <td>{{ $productt->whole_sell_qty[$key] }}+</td>
            <td>{{ $productt->whole_sell_discount[$key] }}% {{ $langg->lang771 }}</td>
          </tr>
          @endforeach
        </table>
      </div>
      @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="tabs-ac-style d-md-none" rel="size-chart">{{ $langg->lang93 }}</h3>
                            <div id="size-chart" class="tab-content">
                                <p>{!! $productt->policy !!}</p>
                                
                            </div>

                            <h3 class="tabs-ac-style d-md-none" rel="shipping-return">{{ $langg->lang96 }}</h3>
                            <div id="shipping-return" class="tab-content">
                                <div class="heading-area">
                          <h4 class="title">
                            {{ $langg->lang96 }}
                          </h4>
                          <div class="reating-area">
                            <div class="stars"><span id="star-rating">{{App\Models\Rating::rating($productt->id)}}</span> <i
                                class="fas fa-star"></i></div>
                          </div>
                        </div>

                        <div id="replay-area">
                          <div id="reviews-section">
                            @if(count($productt->ratings) > 0)
                            <ul class="all-replay">
                              @foreach($productt->ratings as $review)
                              <li>
                                <div class="single-review">
                                  <div class="left-area">
                                    <img
                                      src="{{ $review->user->photo ? asset('assets/images/users/'.$review->user->photo):asset('assets/images/noimage.png') }}"
                                      alt="">
                                    <h5 class="name">{{ $review->user->name }}</h5>
                                    <p class="date">
                                      {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$review->review_date)->diffForHumans() }}
                                    </p>
                                  </div>
                                  <div class="right-area">
                                    <div class="header-area">
                                      <div class="stars-area">
                                        <ul class="stars">
                                          <div class="ratings">
                                            <div class="empty-stars"></div>
                                            <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                                          </div>
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="review-body">
                                      <p>
                                        {{$review->review}}
                                      </p>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                              </li>
                            </ul>
                            @else
                            <p>{{ $langg->lang97 }}</p>
                            @endif
                          </div>
                          @if(Auth::guard('web')->check())
                          <div class="review-area">
                            <h4 class="title">{{ $langg->lang98 }}</h4>
                            <div class="star-area">
                              <ul class="star-list">
                                <li class="stars" data-val="1">
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="2">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="3">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="4">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars active" data-val="5">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="write-comment-area">
                            <div class="gocover"
                              style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            <form id="reviewform" action="{{route('front.review.submit')}}"
                              data-href="{{ route('front.reviews',$productt->id) }}" method="POST">
                              @include('includes.admin.form-both')
                              {{ csrf_field() }}
                              <input type="hidden" id="rating" name="rating" value="5">
                              <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
                              <input type="hidden" name="product_id" value="{{$productt->id}}">
                              <div class="row">
                                <div class="col-lg-12">
                                  <textarea name="review" placeholder="{{ $langg->lang99 }}" required=""></textarea>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  <button class="submit-btn" type="submit">{{ $langg->lang100 }}</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          @else
                          <div class="row">
                            <div class="col-lg-12">
                              <br>
                              <h5 class="text-center"><a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg"
                                  class="btn login-btn mr-1">{{ $langg->lang101 }}</a> {{ $langg->lang102 }}</h5>
                              <br>
                            </div>
                          </div>
                          @endif
                        </div>
                            </div>

                        </div>
                    </div>
                    <!--End Product Tabs-->
                </div>
                <!--End Container-->







                <!--You May Also Like Products-->
                <section class="section product-slider pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="section-header col-12">
                                <h2 class="text-transform-none">You May Also Like</h2>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                           
                            @foreach($productt->category->products()->where('status','=',1)->where('id','!=',$productt->id)->take(8)->get()
          as $prod)
          @include('includes.product.slider-product')
          @endforeach
                            
                        </div>
                    </div>
                </section>
                <!--End You May Also Like Products-->

           

            </div>
            <!--End Body Container-->







                
           

<!-- Product Details Area End -->



{{-- MESSAGE MODAL --}}
<div class="message-modal">
  <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel">{{ $langg->lang118 }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12">
                <div class="contact-form">
                  <form id="emailreply1">
                    {{csrf_field()}}
                    <ul>
                      <li>
                        <input type="text" class="input-field" id="subj1" name="subject"
                          placeholder="{{ $langg->lang119}}" required="">
                      </li>
                      <li>
                        <textarea class="input-field textarea" name="message" id="msg1"
                          placeholder="{{ $langg->lang120 }}" required=""></textarea>
                      </li>
                      <input type="hidden"  name="type" value="Ticket">
                    </ul>
                    <button class="submit-btn" id="emlsub" type="submit">{{ $langg->lang118 }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- MESSAGE MODAL ENDS --}}


  @if(Auth::guard('web')->check())

  @if($productt->user_id != 0)

  {{-- MESSAGE VENDOR MODAL --}}


  <div class="modal" id="vendorform1" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel1">{{ $langg->lang118 }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12">
                <div class="contact-form">
                  <form id="emailreply">
                    {{csrf_field()}}
                    <ul>

                      <li>
                        <input type="text" class="input-field" readonly=""
                          placeholder="Send To {{ $productt->user->shop_name }}" readonly="">
                      </li>

                      <li>
                        <input type="text" class="input-field" id="subj" name="subject"
                          placeholder="{{ $langg->lang119}}" required="">
                      </li>

                      <li>
                        <textarea class="input-field textarea" name="message" id="msg"
                          placeholder="{{ $langg->lang120 }}" required=""></textarea>
                      </li>

                      <input type="hidden" name="email" value="{{ Auth::guard('web')->user()->email }}">
                      <input type="hidden" name="name" value="{{ Auth::guard('web')->user()->name }}">
                      <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                      <input type="hidden" name="vendor_id" value="{{ $productt->user->id }}">

                    </ul>
                    <button class="submit-btn" id="emlsub1" type="submit">{{ $langg->lang118 }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- MESSAGE VENDOR MODAL ENDS --}}


  @endif

  @endif

</div>


@if($gs->is_report)

@if(Auth::check())

{{-- REPORT MODAL SECTION --}}

<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

 <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                    <div class="login-area">
                        <div class="header-area forgot-passwor-area">
                            <h4 class="title">{{ $langg->lang777 }}</h4>
                            <p class="text">{{ $langg->lang778 }}</p>
                        </div>
                        <div class="login-form">

                            <form id="reportform" action="{{ route('product.report') }}" method="POST">

                              @include('includes.admin.form-login')

                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                <div class="form-input">
                                    <input type="text" name="title" class="User Name" placeholder="{{ $langg->lang779 }}" required="">
                                    <i class="icofont-notepad"></i>
                                </div>

                                <div class="form-input">
                                  <textarea name="note" class="User Name" placeholder="{{ $langg->lang780 }}" required=""></textarea>
                                </div>

                                <button type="submit" class="submit-btn">{{ $langg->lang196 }}</button>
                            </form>
                        </div>
                    </div>
      </div>
    </div>
  </div>
</div>

{{-- REPORT MODAL SECTION ENDS --}}

@endif

@endif

@endsection


@section('scripts')

<script type="text/javascript">

  $(document).on("submit", "#emailreply1", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var $type  = $(this).find('input[name=type]').val();
    $('#subj1').prop('disabled', true);
    $('#msg1').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "{{URL::to('/user/admin/user/send/message')}}",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'type'   : $type
      },
      success: function (data) {
        $('#subj1').prop('disabled', false);
        $('#msg1').prop('disabled', false);
        $('#subj1').val('');
        $('#msg1').val('');
        $('#emlsub').prop('disabled', false);
        if(data == 0)
          toastr.error("Oops Something Goes Wrong !!");
        else
          toastr.success("Message Sent !!");
        $('.close').click();
      }

    });
    return false;
  });

</script>


<script type="text/javascript">

  $(document).on("submit", "#emailreply", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var email = $(this).find('input[name=email]').val();
    var name = $(this).find('input[name=name]').val();
    var user_id = $(this).find('input[name=user_id]').val();
    var vendor_id = $(this).find('input[name=vendor_id]').val();
    $('#subj').prop('disabled', true);
    $('#msg').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "{{URL::to('/vendor/contact')}}",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'email': email,
        'name': name,
        'user_id': user_id,
        'vendor_id': vendor_id
      },
      success: function () {
        $('#subj').prop('disabled', false);
        $('#msg').prop('disabled', false);
        $('#subj').val('');
        $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        toastr.success("{{ $langg->message_sent }}");
        $('.ti-close').click();
      }
    });
    return false;
  });

</script>

@endsection