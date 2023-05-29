
@if($ps->service == 1)

<!--Store Feature-->
                <section class="store-features pb-5 ps-site-features">
                    <!--div class="container" style="margin-bottom : 60px;"><div class="row"> <div class="col-lg-2"></div> <div class="col-sm-8"><div class="ps-video"><a href="#"><img src="img/banner/a2.jpg" alt=""></a><a class="ps-video__link" href="#"><i class="icon-play-circle"></i></a></div></div> </div></div-->
                    <div class="container-fluid">
                        		@foreach($services->chunk(4) as $chunk)
                        <div class="row store-info">
@foreach($chunk as $service)
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-5 my-sm-3">
                                <a class="d-flex clr-none" href="#">
                                    <img src="{{ asset('assets/images/services/'.$service->photo) }}">
                                    <div class="detail">
                                        <h5 class="fs-6 text-uppercase mb-1">{{ $service->title }}</h5>
                                        <p class="sub-text">{!! $service->details !!}</p>
                                    </div>
                                </a>
                            </div>
                           	@endforeach
                        </div>

                          	@endforeach
                    </div>
                </section>
                <!--End Store Feature-->

@endif	


        
@if($ps->review_blog == 1)
<!-- Blog Area Start -->
<section class="section home-blog-post ps-our-blogs" style="background-image:url('img/sem-banner.jpg')">
                    <div class="container">
                        <div class="section-header">
                            <h2>OUR BLOGS</h2>
                            <p>ITEMS THAT WORTH THE HYPE</p>
                        </div>
                        <div class="row">
                            
                                @foreach(DB::table('blogs')->orderby('views','desc')->take(3)->get() as $blogg)
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 pb-5">
                                    <div class="blogpost-item">
                                        <a href="#" class="post-thumb">
                                            <img class="blur-up lazyload" src="{{ $blogg->photo ? asset('assets/images/blogs/'.$blogg->photo):asset('assets/images/noimage.png') }}" data-src="{{ $blogg->photo ? asset('assets/images/blogs/'.$blogg->photo):asset('assets/images/noimage.png') }}" alt="image" title=""/>
                                        </a>
                                        <div class="post-detail">
                                            <h3 class="post-title mb-3"><a href="{{route('front.blogshow',$blogg->id)}}">{{mb_strlen($blogg->title,'utf-8') > 40 ? mb_substr($blogg->title,0,40,'utf-8')."...":$blogg->title}}</a></h3>
                                            <ul class="publish-detail d-flex-center mb-3">
                                                <li class="d-flex align-items-center"><i class="an an-calendar me-2"></i> <span class="article__date">{{date('M d, Y', strtotime($blogg->created_at))}}</span></li>
                                                
                                            </ul>
                                            <p class="exceprt">{{substr(strip_tags($blogg->details),0,170)}}</p>
                                            <a href="{{route('front.blogshow',$blogg->id)}}" class="btn-small">Read more</a>
                                        </div>
                                    </div>
                                     </div>
                                   @endforeach
                                   
                               
                        </div>
                    </div>
                </section>
<!-- Blog Area start-->
@endif



 <div class="ps-subscribe ps-subscribe--gray bg--cover" style="background-image:url('img/bg/subscribe-gray.jpg')">
            <div class="container">
                <form class="ps-form--subscribe" action="http://nouthemes.net/html/voye/do_action" method="post">
                    <p><strong>Subscribe Now</strong> For Coupons, Newsletters, and More!</p>
                    <div class="form-group">
                        <div class="form-group__content"><i class="icon-envelope4"></i>
                            <input class="form-control" type="text" placeholder="Enter email address...">
                        </div>
                        <div class="form-group__submit">
                            <button class="ps-btn">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        
        


 

<!--@if($ps->review_blog == 1)-->
 
<!-- <section class="section testimonial-slider style1">-->
<!-- 	<div class="container">-->
<!-- 		<div class="row">-->
<!-- 			<div class="col-12 section-header style1">-->
<!-- 				<div class="section-header-left">-->
<!-- 					<h2>Testimonials</h2>-->
<!-- 				</div>-->
<!-- 			</div>-->
<!-- 		</div>-->
<!-- 		<div class="quote-wraper">-->
 		
<!-- 			<div class="quotes-slider">-->
<!-- 				@foreach($reviews as $review)-->
<!-- 				<div class="quotes-slide">-->
<!-- 					<blockquote class="quotes-slider__text text-center">             -->
<!-- 						<div class="testimonial-image"><img class="blur-up lazyload" data-src="{{ $review->photo ? asset('assets/images/reviews/'.$review->photo) : asset('assets/images/noimage.png') }}" src="{{ $review->photo ? asset('assets/images/reviews/'.$review->photo) : asset('assets/images/noimage.png') }}" alt="{{ $review->title }}" title="{{ $review->title }}" /></div>-->
<!-- 						<div class="rte-setting"><p>{!! $review->details !!}</p></div>-->
<!-- 						<div class="product-review">-->
<!-- 							<i class="an an-star"></i>-->
<!-- 							<i class="an an-star"></i>-->
<!-- 							<i class="an an-star"></i>-->
<!-- 							<i class="an an-star"></i>-->
<!-- 							<i class="an an-star"></i>-->
<!-- 						</div>-->
<!-- 						<p class="authour">{{ $review->title }}</p>-->
<!-- 						<p class="cmp-name">{{ $review->subtitle }}</p>-->
<!-- 					</blockquote>-->
<!-- 				</div>-->
<!-- 				@endforeach-->
 			

 				
<!-- 			</div>-->
 			
<!-- 		</div>-->
<!-- 	</div>-->
<!-- </section>-->
 

<!--@endif-->


	




<!--<div class="ps-instagram" style="background-image:url('img/sem-banner.jpg')">-->
<!--            <div class="owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="1000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="8" data-owl-item-xs="5" data-owl-item-sm="6" data-owl-item-md="8" data-owl-item-lg="8" data-owl-duration="1000" data-owl-mousedrag="on">-->
<!--                <a href="#"><img src="img/instagram/i1.jpg" alt=""></a>-->
<!--                <a href="#"><img src="img/instagram/i2.jpg" alt=""></a>-->
<!--                <a href="#"><img src="img/instagram/i3.jpg" alt=""></a>-->
<!--                <a href="#"><img src="img/instagram/i4.jpg" alt=""></a>-->
<!--                <a href="#"><img src="img/instagram/i5.jpg" alt=""></a>-->
<!--                <a href="#"><img src="img/instagram/i6.jpg" alt=""></a>-->
<!--                <a href="#"><img src="img/instagram/i7.jpg" alt=""></a>-->
<!--                <a href="#"><img src="img/instagram/i8.jpg" alt=""></a>-->
<!--                </div>-->
<!--        </div>-->










<!-- main -->
<script src="{{asset('assets/front/js/mainextra.js')}}"></script>
