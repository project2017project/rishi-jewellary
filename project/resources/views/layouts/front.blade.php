<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($page->meta_tag) && isset($page->meta_description))
    <meta name="keywords" content="{{ $page->meta_tag }}">
    <meta name="description" content="{{ $page->meta_description }}">
    <title>{{$gs->title}}</title>
    @elseif(isset($blog->meta_tag) && isset($blog->meta_description))
    <meta name="keywords" content="{{ $blog->meta_tag }}">
    <meta name="description" content="{{ $blog->meta_description }}">
    <title>{{$gs->title}}</title>
    @elseif(isset($productt))
    <meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): '' }}">
    <meta name="description"
        content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}">
    <meta property="og:title" content="{{$productt->name}}" />
    <meta property="og:description"
        content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
    <meta property="og:image" content="{{asset('assets/images/thumbnails/'.$productt->thumbnail)}}" />
    <meta name="author" content="GeniusOcean">
    <title>{{substr($productt->name, 0,11)."-"}}{{$gs->title}}</title>
    @else
    <meta name="keywords" content="{{ $seo->meta_keys }}">
    <meta name="author" content="GeniusOcean">
    <title>{{$gs->title}}</title>
    @endif
    <!-- favicon -->
    <meta name="facebook-domain-verification" content="8802xmvc8erwmdaw5jcleei2r8y7qp" />
    <!--	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />-->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}" />
    @if($langg->rtl == "1")
    <!-- stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/front/css/rtl/all.css')}}">
    <!--Updated CSS-->
    <link rel="stylesheet"
        href="{{ asset('assets/front/css/rtl/styles.php?color='.str_replace('#','',$gs->colors).'&amp;'.'header_color='.str_replace('#','',$gs->header_color).'&amp;'.'footer_color='.str_replace('#','',$gs->footer_color).'&amp;'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&amp;'.'menu_color='.str_replace('#','',$gs->menu_color).'&amp;'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}">
    @else
    <!-- stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/front/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/fplugins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/frontplugins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/plugins/lightGallery-master/dist/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/frontstyle.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/revouefrontstyle.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/plugins/voye-icons/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/fresponsive.css')}}">
    <!--Updated CSS-->
    <link rel="stylesheet"
        href="{{ asset('assets/front/css/styles.php?color='.str_replace('#','',$gs->colors).'&amp;'.'header_color='.str_replace('#','',$gs->header_color).'&amp;'.'footer_color='.str_replace('#','',$gs->footer_color).'&amp;'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&amp;'.'menu_color='.str_replace('#','',$gs->menu_color).'&amp;'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}">
    @endif
    @yield('styles')
</head>
<body>
    @if($gs->is_loader == 1)
    <div id="pre-loader"><img src="{{asset('assets/images/'.$gs->loader)}}" alt="Loading..." /></div>
    @endif
    @if($gs->is_popup== 1)
    @if(isset($visited))
    <div style="display:none">
        <img src="{{asset('assets/images/'.$gs->popup_background)}}">
    </div>
    <!--  Starting of subscribe-pre-loader Area   -->
    <div class="subscribe-preloader-wrap" id="subscriptionForm" style="display: none;">
        <div class="subscribePreloader__thumb"
            style="background-image: url({{asset('assets/images/'.$gs->popup_background)}});">
            <span class="preload-close"><i class="fas fa-times"></i></span>
            <div class="subscribePreloader__text text-center">
                <h1>{{$gs->popup_title}}</h1>
                <p>{{$gs->popup_text}}</p>
                <form action="{{route('front.subscribe')}}" id="subscribeform" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="email" name="email" placeholder="{{ $langg->lang741 }}" required="">
                        <button id="sub-btn" type="submit">{{ $langg->lang742 }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  Ending of subscribe-pre-loader Area   -->
    @endif
    @endif
    <header class="header header--2 header--2-full" data-sticky="true"
        style="background-image:url('{{asset('img/sem-banner.jpg')}}'); background-color: #f1d7d6!important;">
        <div class="navigation">
            <div class="navigation__center"><a class="ps-logo" href="{{ route('front.index') }}"><img
                        src="{{asset('assets/images/'.$gs->logo)}}" alt=""></a></div>
            <div class="navigation__left nav-desktop-wrapper">
                <ul class="menu desktop-menu">
                    @php
                    $i=1;
                    @endphp
                    @foreach($categories as $category)
                    <li class="menu-item-has-children {{ $category->slug }}">
                        @if(count($category->subs) > 0)
                        <a href="{{ route('front.category',$category->slug) }}">{{ $category->name }} </a><span
                            class="sub-toggle"><i class="fa fa-angle-down"></i></span>
                        @if(count($category->subs) > 0)
                        @endif
                        @else
                        <a href="{{ route('front.category',$category->slug) }}"> {{ $category->name }}</a>
                        @endif
                        @if(count($category->subs) > 0)
                        @php
                        $ck = 0;
                        @endphp
                        <ul class="sub-menu">
                            @foreach($category->subs as $subcat)
                            <li>
                                <a
                                    href="{{ route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}</a>
                                @if(count($subcat->childs) > 0)
                                <ul class="inner-sub-menu">
                                    @foreach($subcat->childs as $childcat)
                                    <li class="innner-li-sub"><a
                                            href="{{ route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a>
                                        <div class="inner-img-sub-wrap">
                                            <img src="{{asset('assets/images/childcategory/'.$childcat->photo)}}">
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @php
                            $ck++;
                            @endphp
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @php
                    $i++;
                    @endphp
                    @if($i == 15)
                    <li>
                        <a href="{{ route('front.categories') }}"><i class="fas fa-plus"></i> {{ $langg->lang15 }} </a>
                    </li>
                    @break
                    @endif
                    @endforeach
                    <li class="menu-item">
                        <a href="https://revoue.com/calculator">Size Calculator</a>
                    </li>
                </ul>
            </div>
            <div class="navigation__right">
                <ul class="menu">
                    <li class="menu-item-has-children"><a href="blog-fullwidth.html">Blog</a><span class="sub-toggle"><i
                                class="fa fa-angle-down"></i></span>
                        <ul class="sub-menu">
                            <li><a href="blog-fullwidth.html">Blog Fullwidth</a></li>
                            <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                            <li><a href="blog-detail.html">Blog Detail</a></li>
                            <li><a href="blog-detail-modern.html">Blog Detail Modern</a></li>
                        </ul>
                    </li>
                    <li><a href="about-us.html">About Us</a></li>
                    <li><a href="contact-us.html">Contact Us</a></li>
                </ul>
                <div class="header__actions">
                    @if(!Auth::guard('web')->check())
                    <a class="header__login" href="{{ route('user.login') }}">
                        <i class="icon-user3"></i>
                        <span class="log-reg">Login</span>
                    </a>
                    @else
                    <a class="header__login" href="{{ route('user-dashboard') }}">
                        <i class="icon-user3"></i>
                    </a>
                    @endif
                    <div class="ps-cart">
                        <a class="ps-cart__toggle" href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#minicart-drawer">
                            <span
                                id="cart-count"><i>{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</i></span>
                            <i class="icon-cart3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--End Header-->
    <header class="header--mobile" style="background-image:url('{{asset('img/sem-banner.jpg')}}')">
        <nav class="navigation">
            <div class="container">
                <button type="button"
                    class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open me-3 d-lg-none"><i
                        class="icon an an-times-l"></i><i class="icon an an-bars-l"></i></button>
                <a class="ps-logo" href="{{ route('front.index') }}"><img src="{{asset('assets/images/'.$gs->logo)}}"
                        alt=""></a>
                <div class="header__actions">
                    @if(!Auth::guard('web')->check())
                    <a class="header__login" href="{{ route('user.login') }}">
                        <i class="icon-user3"></i>
                    </a>
                    @else
                    <a class="header__login" href="{{ route('user-dashboard') }}">
                        <i class="icon-user3"></i>
                    </a>
                    @endif
                    <div class="ps-cart">
                        <a class="ps-cart__toggle" href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#minicart-drawer">
                            <span
                                id="cart-count"><i>{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</i></span>
                            <i class="icon-cart3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="mobile-nav-wrapper" role="navigation">
        <div class="closemobileMenu"><i class="icon an an-times-l pull-right"></i> Close Menu</div>
        <ul id="MobileNav" class="mobile-nav">
            @php
            $i=1;
            @endphp
            @foreach($categories as $category)
            <li class="lvl1 parent dropdown">
                @if(count($category->subs) > 0)
                <a href="{{ route('front.category',$category->slug) }}">{{ $category->name }} <i
                        class="an an-angle-down-l"></i></a>
                @else
                <a href="{{ route('front.category',$category->slug) }}"> {{ $category->name }}</a>
                @endif
                @if(count($category->subs) > 0)
                @php
                $ck = 0;
                @endphp
                <ul class="dropdown">
                    @foreach($category->subs as $subcat)
                    <li class="menu-item menu-item-has-children">
                        @if(count($subcat->childs) > 0)
                        <a class="site-nav"
                            href="{{ route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}
                            <i class="an an-angle-right-l"></i></a>
                        @else
                        <a class="site-nav"
                            href="{{ route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}
                        </a>
                        @endif
                        @if(count($subcat->childs) > 0)
                        <ul class="dropdown">
                            @foreach($subcat->childs as $childcat)
                            <li class="menu-item"><a class="site-nav"
                                    href="{{ route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @php
                    $ck++;
                    @endphp
                    @endforeach
                </ul>
                @endif
            </li>
            @php
            $i++;
            @endphp
            @endforeach
            <li class="menu-item-has-children"><a href="https://revoue.com/calculator">Size Calcular</a>
            </li>
            <!--   <li class="menu-item-has-children"><a href="#">Customise your pack</a>                        
                    </li>-->
        </ul>
    </div>
    @yield('content')
    <div class="what-wrapper">
        <a href="https://api.whatsapp.com/send?phone=9310726427" class="float-whats-wrap" target="_blank">
            <i class="an an-whatsapp my-float"></i>
        </a>
    </div>
    <style>
    .float-whats-wrap {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 20px;
        right: 40px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }
    .float-whats-wrap i {
        font-size: 30px !important;
    }
    .my-float {
        margin-top: 16px;
    }
    </style>
    <!--Footer-->
    <footer class="ps-footer">
        <div class="ps-footer__content" style="background-image:url('{{asset('img/sem-banner.jpg')}}')">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12  ">
                        <div class="ps-site-info">
                            <h3>Contact Info</h3>
                            <p>Our products are painstakingly created to exude the spirit of femininity and elegance
                                while emphasising a woman's body's curves and contours</p>
                            <figure>
                                <p><i class="icon-paperplane"></i> C-29, C Block, Sector 6, Noida, Uttar Pradesh 201301
                                </p>
                                <p><i class="icon-phone"></i> +91-9310726427 </p>
                                <p><i class="icon-envelope-o"></i><a href="mailto:info@revoue.com">info@revoue.com</a>
                                </p>
                            </figure>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12  ">
                        <div class="widget widget_footer widget_footer-posts">
                            <h3 class="widget-title">Recent Post</h3>
                            @foreach(DB::table('blogs')->orderby('views','desc')->take(3)->get() as $blogg)
                            <div class="ps-post--footer">
                                <div class="ps-post__thumbnail"><a href="#"><img
                                            src="{{ $blogg->photo ? asset('assets/images/blogs/'.$blogg->photo):asset('assets/images/noimage.png') }}"
                                            alt=""></a></div>
                                <div class="ps-post__content"><a
                                        href="{{route('front.blogshow',$blogg->id)}}">{{mb_strlen($blogg->title,'utf-8') > 40 ? mb_substr($blogg->title,0,40,'utf-8')."...":$blogg->title}}</a>
                                    <p><span>{{date('M d, Y', strtotime($blogg->created_at))}}</span>
                                        <!--<span>1 Comment</span>-->
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 ">
                        <div class="widget widget_footer">
                            <h3 class="widget-title">Customer Services</h3>
                            <ul>
                                @if($gs->is_faq == 1)
                                <li><a href="{{ route('front.faq') }}">{{ $langg->lang19 }}</a></li>
                                @endif
                                @if($gs->is_contact == 1)
                                <li><a href="{{ route('front.contact') }}">{{ $langg->lang20 }}</a></li>
                                @endif
                                <li><a href="{{ route('front.index') }}/orders-and-returns">Orders and Returns</a></li>
                                <li><a href="{{ route('front.contact') }}">Support Center</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 ">
                        <div class="widget widget_footer">
                            <h3 class="widget-title">Quick Shop</h3>
                            <ul>
                                @php
                                $i=1;
                                @endphp
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('front.category',$category->slug) }}">{{ $category->name }}</a>
                                </li>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 ">
                        <div class="widget widget_footer">
                            <h3 class="widget-title">{{ $langg->lang21 }}</h3>
                            <ul>
                                <li>
                                    @if(!Auth::guard('web')->check())
                                    <a href="{{ route('user.login') }}">My Account</a>
                                    @else
                                    <a href="{{ route('user-dashboard') }}">My Account</a>
                                    @endif
                                </li>
                                <li><a href="{{ route('front.index') }}/about">About us</a></li>
                                <li>
                                    @if(!Auth::guard('web')->check())
                                    <a href="{{ route('user.login') }}">Login</a>
                                    @else
                                    <a href="{{ route('user-dashboard') }}">My Account</a>
                                    @endif
                                </li>
                                <li><a href="{{ route('front.index') }}/privacy">Privacy policy</a></li>
                                <li><a href="{{ route('front.index') }}/terms">Terms &amp; condition</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ps-footer__copyright">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12  "><a class="ps-logo"
                            href="{{ route('front.index') }}"><img src="{{asset('assets/images/'.$gs->footer_logo)}}"
                                alt=""></a>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12  ">
                        <div class="ps-footer__social">
                            <ul class="ps-list--social">
                                @if($socialsetting->f_status == 1)
                                <li><a class="facebook" href="{{ $socialsetting->facebook }}"><i
                                            class="icon-facebook2"></i></a></li>
                                @endif
                                @if($socialsetting->t_status == 1)
                                <li><a class="twitter" href="{{ $socialsetting->twitter }}"><i
                                            class="icon-twitter"></i></a></li>
                                @endif
                                @if($socialsetting->d_status == 1)
                                <li><a class="instagram" href="{{ $socialsetting->dribble }}"><i
                                            class="icon-instagram"></i></a></li>
                                @endif
                                @if($socialsetting->g_status == 1)
                                <li><a class="vimeo" href="{{ $socialsetting->gplus }}"><i class="icon-vimeo"></i></a>
                                </li>
                                @endif
                                @if($socialsetting->l_status == 1)
                                <li><a class="linkedin" href="{{ $socialsetting->linkedin }}"><i
                                            class="icon-linkedin2"></i></a></li>
                                @endif
                            </ul>
                            <p>{!! $gs->copyright !!}</p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12  ">
                        <div class="ps-footer__payment"><img src="{{asset('assets/images/payment.png') }}" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--End Footer-->
    <!--Sticky Menubar Mobile-->
    <div class="menubar-mobile d-flex align-items-center justify-content-between d-lg-none">
        <div class="menubar-shop menubar-item">
            <a href="{{ route('front.index') }}/category"><i class="menubar-icon an an-th-large-l"></i><span
                    class="menubar-label">Shop</span></a>
        </div>
        <div class="menubar-account menubar-item">
            @if(!Auth::guard('web')->check())
            <a href="{{ route('user.login') }}"><span class="menubar-icon an an-user-expand"></span><span
                    class="menubar-label">Account</span></a>
            @else
            <a href="{{ route('user-dashboard') }}"><span class="menubar-icon an an-user-expand"></span><span
                    class="menubar-label">Account</span></a>
            @endif
        </div>
        <div class="menubar-search menubar-item">
            <a href="{{ route('front.index') }}"><span class="menubar-icon an an-home-l"></span><span
                    class="menubar-label">Home</span></a>
        </div>
        <div class="menubar-wish menubar-item">
            @if(Auth::guard('web')->check())
            <a href="{{ route('user-wishlists') }}">
                <span class="span-count position-relative text-center"><span
                        class="menubar-icon an an-heart-l"></span><span
                        class="menubar-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle">{{ Auth::user()->wishlistCount() }}</span></span>
                <span class="menubar-label">Wishlist</span>
            </a>
            @else
            <a href="javascript:;">
                <span class="span-count position-relative text-center"><span
                        class="menubar-icon an an-heart-l"></span><span
                        class="menubar-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle">0</span></span>
                <span class="menubar-label">Wishlist</span>
            </a>
            @endif
        </div>
        <div class="menubar-cart menubar-item">
            <a href="javascript:;" class="cartBtn" data-bs-toggle="modal" data-bs-target="#minicart-drawer">
                <span class="span-count position-relative text-center"><span
                        class="menubar-icon an an-sq-bag"></span><span
                        class="menubar-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle cart-quantity"
                        id="cart-countm">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span></span>
                <span class="menubar-label">Cart</span>
            </a>
        </div>
    </div>
    <!--End Sticky Menubar Mobile-->
    <!-- Back to Top Start -->
    <div class="bottomtotop">
        <i class="fas fa-chevron-right"></i>
    </div>
    <!-- Back to Top End -->
    <!-- FORGOT MODAL -->
    <div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login-area">
                        <div class="header-area forgot-passwor-area">
                            <h4 class="title">{{ $langg->lang191 }} </h4>
                            <p class="text">{{ $langg->lang192 }} </p>
                        </div>
                        <div class="login-form">
                            @include('includes.admin.form-login')
                            <form id="mforgotform" action="{{route('user-forgot-submit')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-input">
                                    <input type="email" name="email" class="User Name"
                                        placeholder="{{ $langg->lang193 }}" required="">
                                    <i class="icofont-user-alt-5"></i>
                                </div>
                                <div class="to-login-page">
                                    <a href="javascript:;" id="show-login">
                                        {{ $langg->lang194 }}
                                    </a>
                                </div>
                                <input class="fauthdata" type="hidden" value="{{ $langg->lang195 }}">
                                <button type="submit" class="submit-btn">{{ $langg->lang196 }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FORGOT MODAL ENDS -->
    <!-- Product Quick View Modal -->
    <div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog quickview-modal modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img src="{{asset('assets/images/'.$gs->loader)}}" alt="">
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container quick-view-modal">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Quick View Modal -->
    <!-- Order Tracking modal Start-->
    <div class="modal fade" id="track-order-modal" tabindex="-1" role="dialog" aria-labelledby="order-tracking-modal"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"> <b>{{ $langg->lang772 }}</b> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="order-tracking-content">
                        <form id="track-form" class="track-form">
                            {{ csrf_field() }}
                            <input type="text" id="track-code" placeholder="{{ $langg->lang773 }}" required="">
                            <button type="submit" class="mybtn1">{{ $langg->lang774 }}</button>
                            <a href="#" data-toggle="modal" data-target="#order-tracking-modal"></a>
                        </form>
                    </div>
                    <div>
                        <div class="submit-loader d-none">
                            <img src="{{asset('assets/images/'.$gs->loader)}}" alt="">
                        </div>
                        <div id="track-order">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Tracking modal End -->
    <!--MiniCart Drawer-->
    <div class="minicart-right-drawer modal right fade" id="minicart-drawer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="my-dropdown-menu" id="cart-items">
                    @include('load.cart')
                </div>
            </div>
        </div>
    </div>
    <!--End MiniCart Drawer-->
    <script type="text/javascript">
    var mainurl = "{{url('/')}}";
    var gs = {
        !!json_encode(\App\ Models\ Generalsetting::first() - > makeHidden(['stripe_key', 'stripe_secret',
            'smtp_pass', 'instamojo_key', 'instamojo_token', 'paystack_key', 'paystack_email',
            'paypal_business', 'paytm_merchant', 'paytm_secret', 'paytm_website', 'paytm_industry',
            'paytm_mode', 'molly_key', 'razorpay_key', 'razorpay_secret'
        ])) !!
    };
    var langg = {
        !!json_encode($langg) !!
    };
    </script>
    <!-- jquery -->
    {{-- <script src="{{asset('assets/front/js/all.js')}}"></script> --}}
    <script src="{{asset('assets/front/js/jquery.js')}}"></script>
    <!-- <script src="{{asset('assets/front/js/vue.js')}}"></script> -->
    <script src="{{asset('assets/front/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- popper -->
    <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
    <!-- bootstrap -->
    <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
    <!-- plugin js-->
    <script src="{{asset('assets/front/js/plugin.js')}}"></script>
    <script src="{{asset('assets/front/js/xzoom.min.js')}}"></script>
    <script src="{{asset('assets/front/js/jquery.hammer.min.js')}}"></script>
    <script src="{{asset('assets/front/js/setup.js')}}"></script>
    <script src="{{asset('assets/front/js/toastr.js')}}"></script>
    <script src="{{asset('assets/front/js/plugins.js')}}"></script>
    <script src="{{asset('assets/front/js/frontmain.js')}}"></script>
    <!-- main -->
    <script src="{{asset('assets/front/js/main.js')}}"></script>
    <!-- custom -->
    <script src="{{asset('assets/front/js/custom.js')}}"></script>
    <script src="{{asset('assets/front/plugins/plugins.min.js')}}"></script>
    <script src="{{asset('assets/front/js/revouemain.js')}}"></script>
    <!-- <script>
	function newsletter_popup() {
		var cookieSignup = "cookieSignup", date = new Date();
		if ($.cookie(cookieSignup) != 'true' && window.location.href.indexOf("challenge#newsletter-modal") <= -1) {
			setTimeout(function () {
				$.magnificPopup.open({
					items: {
						src: '#newsletter-modal'
					}
					, type: 'inline', removalDelay: 300, mainClass: 'mfp-zoom-in'
				}
				);
			}
			, 5000);
		}
		$.magnificPopup.instance.close = function () {
			if ($("#dontshow").prop("checked") == true) {
				$.cookie(cookieSignup, 'true', {
					expires: 1, path: '/'
				}
				);
			}
			$.magnificPopup.proto.close.call(this);
		}
	}
	newsletter_popup();
</script>
-->
    {!! $seo->google_analytics !!}
    @if($gs->is_talkto == 1)
    <!--Start of Tawk.to Script-->
    {!! $gs->talkto !!}
    <!--End of Tawk.to Script-->
    @endif
    @yield('scripts')
    <script>
    $(document).ready(function() {
        if (window.matchMedia('(max-width: 767px)').matches) {
            $(".header--2").remove();
        }
    });
    </script>
</body>
</html>