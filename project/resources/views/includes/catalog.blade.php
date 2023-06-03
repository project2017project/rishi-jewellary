        <div class="col-12 col-sm-12 col-md-12 col-lg-3 sidebar filterbar">
          <div class="closeFilter d-block d-lg-none"><i class="icon icon an an-times-r"></i></div>

          <div class="sidebar_tags">

 <form id="catalogForm" action="{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}" method="GET">
                @if (!empty(request()->input('search')))
                  <input type="hidden" name="search" value="{{ request()->input('search') }}">
                @endif
                @if (!empty(request()->input('sort')))
                  <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                @endif

    <!--Categories-->
    <div class="sidebar_widget categories filterBox filter-widget">
        <div class="widget-title"><h2 class="mb-0">Categories</h2></div>
        <div class="widget-content filterDD">
            <ul class="clearfix sidebar_categories mb-0">
              @foreach ($categories as $element)
              <li class="lvl-1 sub-level @if(!empty($cat) && $cat->id == $element->id) active @endif"><a href="{{route('front.category', $element->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="site-nav">{{$element->name}}</a>
                @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
                <ul class="sublinks" style="display: block;">
                    @foreach ($cat->subs as $key => $subelement)
                    <li class="level2 sub-level sub-sub-level @if(!empty($subcat) && $subcat->id == $subelement->id) active @endif"><a href="{{route('front.category', [$cat->slug, $subelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="subcategory-link" class="site-nav">{{$subelement->name}}</a>
                      @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                      <ul class="sublinks mb-0" style="display: block;">
                       @foreach ($subcat->childs as $key => $childcat)
                       <li class="level3"><a href="{{route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="site-nav">{{$childcat->name}}</a></li>
                       @endforeach
                   </ul>
                   @endif
               </li>
               @endforeach
           </ul>
           @endif
       </li>
       

       @endforeach
       
   </ul>
</div>
</div>



<div class="sidebar_widget filterBox filter-widget">
                                    <div class="widget-title"><h2 class="mb-0">Price</h2></div>
                                    <form action="#" method="post" class="price-filter filterDD">
                                        <div id="slider-range"class="price-filter-range mt-2" name="rangeInput"></div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="livecount">
                      <input type="number" min=0  name="min"  id="min_price" class="price-range-field" />
                      <span>{{$langg->lang62}}</span>
                      <input type="number" min=0  name="max" id="max_price" class="price-range-field" />
                    </div>
                                            </div>
                                            <div class="col-12 text-left mt-2">
                                                <button class="btn btn--small rounded filter-btn">filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>






</form>

</div>



          <div class="left-area">
            


            @if ((!empty($cat) && !empty(json_decode($cat->attributes, true))) || (!empty($subcat) && !empty(json_decode($subcat->attributes, true))) || (!empty($childcat) && !empty(json_decode($childcat->attributes, true))))

              <div class="tags-area">
                <div class="header-area">
                  <h4 class="title mt-5">
                      Filters
                  </h4>
                </div>
                <div class="body-area">
                  <form id="attrForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">
                    <ul class="filter">
                      <div class="single-filter">
                        @if (!empty($cat) && !empty(json_decode($cat->attributes, true)))
                          @foreach ($cat->attributes as $key => $attr)
                            <div class="my-2 sub-title">
                              <span><i class="fas fa-arrow-alt-circle-right"></i> {{$attr->name}}</span>
                            </div>
                            @if (!empty($attr->attribute_options))
                              @foreach ($attr->attribute_options as $key => $option)
                                <div class="form-check ml-0 pl-0">
                                  <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                  <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
                                </div>
                              @endforeach
                            @endif
                          @endforeach
                        @endif

                        @if (!empty($subcat) && !empty(json_decode($subcat->attributes, true)))
                          @foreach ($subcat->attributes as $key => $attr)
                          <div class="my-2 sub-title">
                            <span><i class="fas fa-arrow-alt-circle-right"></i> {{$attr->name}}</span>
                          </div>
                            @if (!empty($attr->attribute_options))
                              @foreach ($attr->attribute_options as $key => $option)
                                <div class="form-check  ml-0 pl-0">
                                  <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                  <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
                                </div>
                              @endforeach
                            @endif
                          @endforeach
                        @endif

                        @if (!empty($childcat) && !empty(json_decode($childcat->attributes, true)))
                          @foreach ($childcat->attributes as $key => $attr)
                          <div class="my-2 sub-title">
                            <span><i class="fas fa-arrow-alt-circle-right"></i> {{$attr->name}}</span>
                          </div>
                            @if (!empty($attr->attribute_options))
                              @foreach ($attr->attribute_options as $key => $option)
                                <div class="form-check  ml-0 pl-0">
                                  <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                  <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
                                </div>
                              @endforeach
                            @endif
                          @endforeach
                        @endif
                      </div>
                    </ul>
                  </form>
                </div>
              </div>
            @endif


            @if(!isset($vendor))

            {{-- <div class="tags-area">
                <div class="header-area">
                    <h4 class="title">
                        {{$langg->lang63}}
                    </h4>
                  </div>
                  <div class="body-area">
                    <ul class="taglist">
                      @foreach(App\Models\Product::showTags() as $tag)
                      @if(!empty($tag))
                      <li>
                        <a class="{{ isset($tags) ? ($tag == $tags ? 'active' : '') : ''}}" href="{{ route('front.tag',$tag) }}">
                            {{ $tag }}
                        </a>
                      </li>
                      @endif
                      @endforeach
                    </ul>
                  </div>
            </div> --}}


            @else

            <div class="service-center">
              <div class="header-area">
                <h4 class="title">
                    {{ $langg->lang227 }}
                </h4>
              </div>
              <div class="body-area">
                <ul class="list">
                  <li>
                      <a href="javascript:;" data-toggle="modal" data-target="{{ Auth::guard('web')->check() ? '#vendorform1' : '#comment-log-reg' }}">
                          <i class="icofont-email"></i> <span class="service-text">{{ $langg->lang228 }}</span>
                      </a>
                  </li>
                  <li>
                        <a href="tel:+{{$vendor->shop_number}}">
                          <i class="icofont-phone"></i> <span class="service-text">{{$vendor->shop_number}}</span>
                        </a>
                  </li>
                </ul>
              <!-- Modal -->
              </div>

              <div class="footer-area">
                <p class="title">
                  {{ $langg->lang229 }}
                </p>
                <ul class="list">


              @if($vendor->f_check != 0)
              <li><a href="{{$vendor->f_url}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
              @endif
              @if($vendor->g_check != 0)
              <li><a href="{{$vendor->g_url}}" target="_blank"><i class="fab fa-google"></i></a></li>
              @endif
              @if($vendor->t_check != 0)
              <li><a href="{{$vendor->t_url}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
              @endif
              @if($vendor->l_check != 0)
              <li><a href="{{$vendor->l_url}}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
              @endif
                </ul>
              </div>
            </div>


            @endif


          </div>
        </div>
