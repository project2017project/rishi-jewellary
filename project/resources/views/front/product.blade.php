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



<div class="breadcrumbs-wrapper text-uppercase">
                    <div class="container-fluid">
                        <div class="breadcrumbs">
                          <a href="{{route('front.index')}}" title="Back to the home page">{{ $langg->lang17 }}</a>
                          <span>|</span>
                          <a href="{{route('front.category',$productt->category->slug)}}">{{$productt->category->name}}</a>
                          <span>|</span>
                          @if($productt->subcategory_id != null)
                          <a href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}" title="Back to the {{$productt->subcategory->name}}">{{$productt->subcategory->name}}
                          </a> 
                          <span>|</span>
                          @endif
                          @if($productt->childcategory_id != null)
                          <a href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}" title="Back to the {{$productt->childcategory->name}}">{{$productt->childcategory->name}}
                          </a> 
                          <span>|</span>
                          @endif
                          <span class="fw-bold">{{ $productt->name }}</span>
                        </div>
                    </div>
                </div>

<div class="ps-page">
        <div class="container-fluid">
            <div class="ps-product--detail" data-type="default">
                <div class="row">
                     <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                           <div class="ps-product__thumbnail" data-vertical="true">
                            <div class="ps-product__gallery" data-arrow="true">
                              
                                 @foreach($productt->galleries as $mgal)
                                 <div class="item"><a href="{{asset('assets/images/galleries/'.$mgal->photo)}}"><img src="{{asset('assets/images/galleries/'.$mgal->photo)}}" alt=""></a></div>
                                 @endforeach
                            </div>
                            <div class="ps-product__preview">
                                <div class="ps-product__variants" data-item="5" data-md="3" data-sm="3" data-arrow="false">
                                    
                                        @foreach($productt->galleries as $gal)
                                             <div class="item"><img src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="product" />
                                            </div>                                                                          
                                            @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="right-area">
                <div class="product-info-area">
                  <h4 class="product-name">{{ $productt->name }}</h4>
                  <div class="info-meta-1">
                 

                       @if($productt->type == 'Physical')
                   
                     
                         <div class="pro-stockLbl">

                           @if($productt->emptyStock())

                          <span class="d-flex-center stockLbl outstock"><i class="icon an an-times-cil"></i> <span>Sold out</span></span>
                          @else
                           <span class="d-flex-center stockLbl instock"><i class="icon an an-check-cil"></i><span> In stock</span></span>

                                                      @endif


                         </div>
                     
                         
                      @endif


                      <div class="product-review mb-2 ratings">
                        <div class="float-left">
                        <div class="empty-stars"></div>
                         <div class="full-stars" style="width:{{App\Models\Rating::ratings($productt->id)}}%"></div> </div>
                         <span class="spr-badge-caption ms-2">{{count($productt->ratings)}} Reviews</span>
                     </div>



                      <div class="product-info"> 
                                        <p class="product-type">Product Category: <span><a href="{{route('front.category',$productt->category->slug)}}">{{$productt->category->name}}</a> @if($productt->subcategory_id != null) >> <a
              href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}">{{$productt->subcategory->name}}</a> @endif  @if($productt->childcategory_id != null) >> <a
              href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}">{{$productt->childcategory->name}}</a> @endif</span></p>                                       

                                    <p class="product-sku">SKU: <span class="variant-sku">{{ $productt->sku }}</span></p>
                                    </div>

                    


                  <ul>
                  @if($productt->product_condition != 0)
                     <li>
                       <div class="{{ $productt->product_condition == 2 ? 'mybadge' : 'mybadge1' }}">
                        {{ $productt->product_condition == 2 ? 'New' : 'Used' }}
                       </div>
                     </li>
                  @endif
                    </ul>
                  </div>


              <div class="product-single__price pb-1">
                                        <span class="visually-hidden">{{ $langg->lang87 }} :</span>
                                        <span class="product-price__sale--single price">
                                            <span class="product-price-old-price">{{ $productt->showPreviousPrice() }}</span><span id="sizeprice" class="product-price__price product-price__sale">{{ $attrPrice != 0 ?  $gs->currency_format == 0 ? $curr->sign.$withSelectedAtrributePrice : $withSelectedAtrributePrice.$curr->sign :$productt->showPrice() }}</span>   
                                            
                                        <div class="product__policies fw-normal mt-1">(inclusive of all taxes)</div>
                                    </div>



                                     <!-- Product Sold -->
                                    <div class="orderMsg d-flex-center">
                                       


                                         @if($productt->emptyStock())
                     <p id="quantity_message" class="ms-2 ps-2 border-start">Sorry! The product has been sold out</p>
                      @else
                       <img src="{{asset('assets/images/order-icon.jpg')}}" alt="order" />
                      <p id="quantity_message" class="ms-2 ps-2 border-start">Hurry! Only  <span class="items fw-bold">{{$productt->stock }}</span>  left in stock.</p>
                                            @endif
                                       
                                    </div>
                                    <!-- End Product Sold -->




                  <div class="info-meta-2">
                    <ul>

                      @if($productt->type == 'License')

                      @if($productt->platform != null)
                      <li>
                        <p>{{ $langg->lang82 }}: <b>{{ $productt->platform }}</b></p>
                      </li>
                      @endif

                      @if($productt->region != null)
                      <li>
                        <p>{{ $langg->lang83 }}: <b>{{ $productt->region }}</b></p>
                      </li>
                      @endif

                      @if($productt->licence_type != null)
                      <li>
                        <p>{{ $langg->lang84 }}: <b>{{ $productt->licence_type }}</b></p>
                      </li>
                      @endif

                      @endif

                    </ul>
                  </div>


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
                  
                  <div class="size-chart-wrap {{$productt->category->slug}} mb-3">
                      <a href="https://revoue.com/calculator" target="_blank">Size Calculator</a>
                  </div>
                  
                  
                   @if(!empty($productt->features))
                  <div class="product-color">
                    <p class="title">{{ $langg->lang89 }} :</p>
                    @if(!empty($productt->features))
													<div class="sell-area">
													@foreach($productt->features as $key => $data1)
													
													    <a href="{{ $productt->features[$key] }}" style="background-color:{{ $productt->colors[$key] }}" class="colorproduct">
													        &nbsp;
													    </a>
													    
													@endforeach 
													</div>
												@endif
                  </div>
                  @endif

                  @if(!empty($productt->color))
                  <div class="product-color">
                    <p class="title">{{ $langg->lang89 }} :</p>
                    <ul class="color-list">
                      @php
                      $is_first = true;
                      @endphp
                      @foreach($productt->color as $key => $data1)
                      <li class="{{ $is_first ? 'active' : '' }}">
                        <span class="box" data-color="{{ $productt->color[$key] }}" style="background-color: {{ $productt->color[$key] }}"></span>
                      </li>
                      @php
                      $is_first = false;
                      @endphp
                      @endforeach

                    </ul>
                  </div>
                  @endif

                  @if(!empty($productt->size))

                  <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
                  @else
                  @php
                  $stck = (string)$productt->stock;
                  @endphp
                  @if($stck != null)
                  <input type="hidden" id="stock" value="{{ $stck }}">
                  @elseif($productt->type != 'Physical')
                  <input type="hidden" id="stock" value="0">
                  @else
                  <input type="hidden" id="stock" value="">
                  @endif

                  @endif
                  <input type="hidden" id="product_price" value="{{ round($productt->vendorPrice() * $curr->value,2) }}">

                  <input type="hidden" id="product_id" value="{{ $productt->id }}">
                  <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                  <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">
                  <div class="info-meta-3">
                    
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




                      <ul class="meta-list">

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
                      @php
                          
                      @endphp

                      {{-- <h3>Price: {{$attrPrice}}</h3> --}}
                      @if($productt->product_type == "affiliate")

                      <li class="addtocart">
                        <a href="{{ route('affiliate.product', $productt->slug) }}" target="_blank"><i
                            class="icofont-cart"></i> {{ $langg->lang251 }}</a>
                      </li>
                      @else


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



                      @endif
                    </ul>
                  </div>


                  <div class="social-links social-sharing a2a_kit a2a_kit_size_32 d-flex-center mb-3">
                                    <span class="sharing-lbl me-2">Share :</span>
                                    <a class="facebook a2a_button_facebook" href="">
                                  <i class="fab fa-facebook-f"></i>
                               </a> &nbsp;  &nbsp; 

                               <a class="twitter a2a_button_twitter" href="">
                          <i class="fab fa-twitter"></i>
                        </a> &nbsp;  &nbsp; 
                                 


                                  <a class="linkedin a2a_button_linkedin" href="">
                          <i class="fab fa-linkedin-in"></i>
                        </a> &nbsp;  &nbsp; 


                        <a class="pinterest a2a_button_pinterest" href="">
                          <i class="fab fa-pinterest-p"></i>
                        </a> &nbsp; &nbsp; 


                                </div>

                  
                  
                  <script async src="https://static.addtoany.com/menu/page.js"></script>


                </div>
              </div>
            </div>
                    
              <div class="col-lg-2 col-md-2 col-sm-12 col-12">
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
    </div>


<!-- Product Details Area Start -->
<section class="product-details-page">
  <div class="container-fluid">
    <div class="row">
    <div class="col-lg-{{ $gs->reg_vendor == 1 ? '9' : '12' }}">
        
          <div class="row">
              <div class="col-lg-12">

                <div class="template-product ">
                      <div class="tabs-listing mt-2 mt-md-5">
                        <ul class="product-tabs list-unstyled d-flex-wrap border-bottom m-0 d-none d-md-flex">
                            <li rel="description" class="active"><a class="tablink">Description</a></li>
                            <li rel="shipping-return"><a class="tablink">Shipping &amp; Return</a></li>
                            <li rel="reviews"><a class="tablink">Reviews</a></li>
                        </ul>
                        <div class="tab-container">
                            <h3 class="tabs-ac-style d-md-none active" rel="description">Description</h3>
                            <div id="description" class="tab-content">
                                <div class="product-description">
                                    <div class="row">
                                        <div class="col-12 mb-md-0">
                                           {!! $productt->details !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                          

                            <h3 class="tabs-ac-style d-md-none" rel="shipping-return">Shipping &amp; Return</h3>
                            <div id="shipping-return" class="tab-content">
                                {!! $productt->policy !!}
                            </div>

                            <h3 class="tabs-ac-style d-md-none" rel="reviews">Review</h3>
                            <div id="reviews" class="tab-content">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="spr-reviews">
                                            <h4 class="spr-form-title text-uppercase mb-3">Customer Reviews</h4>
                                            <div class="heading-area">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                  
                </div>
          </div>
    </div>
    @if($gs->reg_vendor == 1)
    <div class="col-lg-3">

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


      <div class="seller-info mt-3">
        <div class="content">
          <h4 class="title">
            {{ $langg->lang246 }}
          </h4>

          <p class="stor-name">
           @if( $productt->user_id  != 0)
              @if(isset($productt->user))
                {{ $productt->user->shop_name }}

                @if($productt->user->checkStatus())
                <br>
                <a class="verify-link" href="javascript:;"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang783 }}">
                  {{--  {{ $langg->lang783 }}  --}}
                  <i class="fas fa-check-circle"></i>
                
                </a>
                @endif

              @else
                {{ $langg->lang247 }}
              @endif
          @else
              {{ App\Models\Admin::find(1)->shop_name }}
          @endif
          </p>

          <div class="total-product">

           @if( $productt->user_id  != 0)
              <p>{{ App\Models\Product::where('user_id','=',$productt->user_id)->get()->count() }}</p>
          @else
              <p>{{ App\Models\Product::where('user_id','=',0)->get()->count() }}</p>
          @endif
            <span>{{ $langg->lang248 }}</span>
          </div>
        </div>
    @if( $productt->user_id  != 0)
        <a href="{{ route('front.vendor',str_replace(' ', '-', $productt->user->shop_name)) }}" class="view-stor">{{ $langg->lang249 }}</a>
    @endif

                  {{-- CONTACT SELLER --}}



                  <div class="contact-seller">

                    {{-- If The Product Belongs To A Vendor --}}

                    @if($productt->user_id != 0)


                    <ul class="list">


                      @if(Auth::guard('web')->check())

                      <li>

                        @if(
                        Auth::guard('web')->user()->favorites()->where('vendor_id','=',$productt->user->id)->get()->count() >
                        0)

                        <a  class="view-stor" href="javascript:;">
                          <i class="icofont-check"></i>
                          {{ $langg->lang225 }}
                        </a>

                        @else

                        <a class="favorite-prod view-stor"
                          data-href="{{ route('user-favorite',[Auth::guard('web')->user()->id,$productt->user->id]) }}"
                          href="javascript:;">
                          <i class="icofont-plus"></i>
                          {{ $langg->lang224 }}
                        </a>


                        @endif

                      </li>

                      <li>
                        <a  class="view-stor" href="javascript:;" data-toggle="modal" data-target="#vendorform1">
                          <i class="icofont-ui-chat"></i>
                          {{ $langg->lang81 }}
                        </a>
                      </li>
                      @else

                      <li>

                        <a  class="view-stor" href="javascript:;" data-toggle="modal" data-target="#comment-log-reg">
                          <i class="icofont-plus"></i>
                          {{ $langg->lang224 }}
                        </a>


                      </li>

                      <li>

                        <a  class="view-stor" href="javascript:;" data-toggle="modal" data-target="#comment-log-reg">
                          <i class="icofont-ui-chat"></i>
                          {{ $langg->lang81 }}
                        </a>
                      </li>

                      @endif

                    </ul>


                    {{-- VENDOR PART ENDS HERE :) --}}
                    @else


                    {{-- If The Product Belongs To Admin  --}}

                    <ul class="list">
                      @if(Auth::guard('web')->check())
                      <li>
                        <a class="view-stor"  href="javascript:;" data-toggle="modal" data-target="#vendorform">
                          <i class="icofont-ui-chat"></i>
                          {{ $langg->lang81 }}
                        </a>
                      </li>
                      @else
                      <li>
                        <a class="view-stor" href="javascript:;" data-toggle="modal" data-target="#comment-log-reg">
                          <i class="icofont-ui-chat"></i>
                          {{ $langg->lang81 }}
                        </a>
                      </li>

                      @endif

                    </ul>

                    @endif

                  </div>

                  {{-- CONTACT SELLER ENDS --}}

      </div>



    </div>
    @endif
    </div>
   
  </div>



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
          @include('includes.product.related')
          @endforeach
                        </div>
                    </div>
                </section>
                <!--End You May Also Like Products-->





  <!-- Trending Item Area Start -->

<!-- Tranding Item Area End -->
</section>
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


 <!-- =====readmore Popup Start ======== -->




  <!-- ======= readmore Popup End ====== -->






@section('scripts')
<div class="size-chart-wrapper">
<div class="container size-inner-wrap">
    <div class="row">
        <div class="col-12">
            <div class="cross-popup-hide">
            <a href="javascript:void(0)"><i class="fas fa-times-circle"></i></a>
        </div>
        </div>
        <div class="col md-6 col-sm-6">
            <div class="head-text">
                <h2>Find Your Size</h2>
            </div>
        </div>
        <div class="col md-6 col-sm-6">
            <div class="size-tab">
               <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a href="#info" role="tab" data-toggle="tab"
           class="nav-link active">In</a>
      </li>
      <li class="nav-item">
        <a href="#ratings" role="tab" data-toggle="tab"
           class="nav-link">Cm</a>
      </li>
      
    </ul>
    
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
        <div class="tab-content">
      <div class="tab-pane active" role="tabpanel" id="info">
        <img src="../img/size-chharts-IN.jpg">
      </div>
      <div class="tab-pane" role="tabpanel" id="ratings">
        <img src="../img/size-chharts-CM.jpg">
      </div>
      
    </div>
    </div>
    </div>
    
</div>
</div>

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


<script>
		$(document).ready(function(){
  $(".size-btn-click").click(function(){
    $(".size-chart-wrapper").show();
  });
  $(".cross-popup-hide").click(function(){
    $(".size-chart-wrapper").hide();
  });
});
</script>

@endsection

