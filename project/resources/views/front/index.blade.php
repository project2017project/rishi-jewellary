@extends('layouts.front')

@section('content')

	@if($ps->slider == 1)
		@if(count($sliders))
			@include('includes.slider-style')
		@endif
	@endif
	
	
    @if(count($sliders_top))	
        <div class="main-slide-banner">
            <div class="container-fluid">
                <div class="slick">
                    <div class="row">
                        <div class="col-12">
                            <div class="bannerslide">
                                @foreach($sliders_top as $sdata)
                                    <div class="banner-image">
                                        <a href="{{$sdata->link}}"><img src="{{asset('assets/images/sliders/'.$sdata->photo)}}" alt="{{$sdata->title_text}}"></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

  <div class="container policy-wrapper">
      <div class="slick">
            <div class="row pt-3 pb-3">
                <div class="policy-slides">
                <div class="col-lg-3 col-md-6 pb-4 pt-4">
                    <div class="service-icon-text">
                        <div class="image-service">
                            <img src="img/free.png">
                        </div>
                        <div class="service-content">
                            <h5>Free Shipping All Over India</h5>
                            <span>On all orders</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-4 pt-4">
                    <div class="service-icon-text">
                        <div class="image-service">
                            <img src="img/eas.png">
                        </div>
                        <div class="service-content">
                            <h5>EASY 15 DAYS RETURNS</h5>
                            <span>30 days money back</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-4 pt-4">
                    <div class="service-icon-text">
                        <div class="image-service">
                            <img src="img/check.png">
                        </div>
                        <div class="service-content">
                            <h5>100% SECURE CHECKOUT</h5>
                            <span>with CCavenue Payment Gateway</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-4 pt-4">
                    <div class="service-icon-text">
                        <div class="image-service">
                            <img src="img/supp.png">
                        </div>
                        <div class="service-content">
                            <h5>24/7 EXCELLENT SUPPORT</h5>
                            <span>To help you with all queries</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>


	

  <div class="ps-section ps-about-us pb-5">
            <div class="container">
                <div class="ps-section__content">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12  "><img src="{{asset('assets/images/'.$gs->about_image1)}}" alt="">
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12  ">
                                <div class="ps-section__header text-left ps-5">
                    <h3>About Us</h3>
                    <p>Elevate Your style</p>
                </div>
                                <p class="ps-5">{{$gs->about_content}}</p><img src="{{asset('assets/images/'.$gs->about_image2)}}" alt="">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
      



<div class="main-categoery-slide pb-5">
    <div class="container-fluid">
        <div class="slick">
            <div class="row pt-5 pb-5">
               <div class="section-header-left text-center pb-5">
 					<h2>ACCESSORIES</h2>
 					<p>ITEMS THAT WORTH THE HYPE</p>
 				</div>
                @if(count($accessories_sliders))
                <div class="categoeryslide">
                    @foreach($accessories_sliders as $accessories_slider)
                        <div class="col-lg-3">
                             <div class="banner-image">
                                <img src="{{asset('assets/images/accessories-slider/'.$accessories_slider->photo)}}" alt="{{$accessories_slider->title}}">
                                <div class="cate-btn">
                                    <a href="{{$accessories_slider->url}}"><button>{{$accessories_slider->title}}</button></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="ps-section ps-home-feature pt-5" style="background-image:url('img/sem-banner.jpg')">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12  ">
                        <div class="ps-section__header">
                            <h3>Featured</h3>
                            <p>items that worth the hype</p>
                        </div>
                        <div class="ps-section__content">
                            <p>{{$gs->featured_content}}</p><a class="ps-btn ps-btn--black" href="#">Shop Now</a>
                        </div>
                    </div>
                    @foreach($feature_products as $prod)
								@include('includes.product.slider-product')
				    @endforeach
                </div>
            </div>
        </div>



<div id="homepage-4">
	 <div class="ps-home-banner">
            <div class="ps-section__left">
                @if($ps->slider == 1)
                @if(count($sliders))
                <div class="owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
                    @foreach($sliders as $data)
                    <a href="{{$data->link}}"><img src="{{asset('assets/images/sliders/'.$data->photo)}}" alt=""></a>
                    @endforeach
                </div>
                @endif
                	@endif
            </div>
            <div class="ps-section__right">
                @if($ps->bottom_small == 1)
                @foreach($top_small_banners->chunk(3) as $chunk)
                @foreach($chunk as $img)
                <a class="ps-collection" href="{{ $img->link }}">
                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="">
                </a>
                
                @endforeach
                @endforeach
                @endif
            </div>
        </div>
	 </div>





 
 <!--@if($ps->bottom_small == 1)-->

 <!--<section class="collection-banners ps-home-feature style1 pt-5 pb-5 d-none d-md-block d-lg-block" style="margin-top:0px; background-image:url('img/sem-banner.jpg')">-->
 <!--	<div class="container">-->
 <!--		<div class="grid-masonary banner-grid grid-mr-20 fgf">-->
 <!--			<div class="grid-sizer col-md-3 col-lg-3"></div>-->

 <!--			@foreach($bottom_small_banners->chunk(3) as $chunk)-->
 <!--			<div class="row">-->

 <!--				@foreach($chunk as $img)-->

 <!--				<div class="col-12 col-sm-6 col-md-6 col-lg-6 banner-item cl-item">-->
 <!--					<div class="collection-grid-item">-->
 <!--						<a href="{{ $img->link }}">-->
 <!--							<div class="img">-->

 <!--								<img class="blur-up lazyload" data-src="{{asset('assets/images/banners/'.$img->photo)}}" src="{{asset('assets/images/banners/'.$img->photo)}}" alt="SUMMER" title="SUMMER" />-->
 <!--							</div>-->

 <!--						</a>-->
 <!--					</div>-->
 <!--				</div>-->

 <!--				@endforeach-->

 <!--			</div>-->

 <!--			@endforeach-->

 <!--		</div>-->
 <!--	</div>-->
 <!--</section>-->
 <!--@endif-->



@if($ps->featured == 1)
	<section class="section product-slider ps-new-arrivals" style="background-image:url('img/sem-banner.jpg')">
 	<div class="container">
 		<div class="row">
 			<div class="col-12 section-header style1">
 				<div class="section-header-left">
 					<h2>NEW ARRIVALS</h2>
 					<p>ITEMS THAT WORTH THE HYPE</p>
 				</div>
 			</div>
 		</div>
 		<div class="grid-products">
 			<div class="row">
 			    
 				
 					@foreach($latest_products as $prod)
								@include('includes.product.slider-product')
				@endforeach
 				



 			</div>
 			<!--<div class="row">-->
 			<!--	<div class="col-12 text-center mt-3">-->
 			<!--		<a href="{{ route('front.index') }}/?rgsearch%5Bcategory%5D=&search=#" class="btn-primary btn-lg rounded">View All Product</a>-->
 			<!--	</div>-->
 			<!--</div>-->
 		</div>
 	</div>
 </section>
@endif




          <!--div class="ps-home-collection pb-5">
            <div class="container">
                <div class="row pb-5">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12  ">
                        <div class="ps-block--collection">
                            <div class="ps-block__thumbnail"><a href="product-listing.html"><img src="img/collection/home vo1.jpg" alt=""></a></div>
                            <div class="ps-block__content">
                                <h5>Sale up to 20% off on all</h5>
                                <h3>Women’s</h3>
                                <p>Praesent volutpat ut nisl in hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Etiam porttitor, lacus in luctus molestie</p><a class="ps-block__morelink" href="product-listing.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12  ">
                        <div class="ps-block--collection ps-block--reverse">
                            <div class="ps-block__thumbnail"><a href="product-listing.html"><img src="img/collection/home vo2.jpg" alt=""></a></div>
                            <div class="ps-block__content">
                                <h5>Sale up to 20% off on all</h5>
                                <h3>Men’s</h3>
                                <p>Praesent volutpat ut nisl in hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Etiam porttitor, lacus in luctus molestie</p><a class="ps-block__morelink" href="product-listing.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div-->


	<section id="extraData">
		<div class="text-center">
			<img src="{{asset('assets/images/'.$gs->loader)}}">
		</div>
	</section>






	


@endsection

@section('scripts')
	<script>
        $(window).on('load',function() {

            setTimeout(function(){

                $('#extraData').load('{{route('front.extraIndex')}}');

            }, 500);
        });

	</script>

	<script>
	
	$('.bannerslide').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  dots:true,
  infinite: true,
  autoplaySpeed: 2000
});
		
</script>

<script>
  $('.policy-slides').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  autoplay: true,
  dots:true,
  arrows:false,
  infinite: true,
  autoplaySpeed: 2000,
  responsive: [
   {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        }
      },
  {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        }
       
    }


        ]
});
</script>

	<script>
	
	$('.categoeryslide').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  dots:false,
  infinite: true,
  autoplaySpeed: 2000,
   responsive: [
   {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        }
      },
  {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        }
       
    }


        ]
});
		
</script>
@endsection