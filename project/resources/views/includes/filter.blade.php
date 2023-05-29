						<div class="toolbar">
                                <div class="filters-toolbar-wrapper">
                                    <ul class="list-unstyled d-flex align-items-center">

                                        <li class="product-count d-flex align-items-center">
                                            <button type="button" class="btn btn-filter an an-slider-3 d-inline-flex d-lg-none me-2 me-sm-3"><span class="hidden">Filter</span></button>
                                            <div class="filters-toolbar__item">
                                                <span class="filters-toolbar__product-count d-none d-sm-block">Showing: {{count($prods)}} products</span>
                                            </div>
                                        </li>

                                         <li class="collection-view ms-sm-auto">
                                           
                                        </li>
                                       
                                        <li class="filters-sort ms-auto ms-sm-0">
                                            <div class="filters-toolbar__item">
                                                <label for="SortBy" class="hidden">Sort by:</label>
                                                <select id="sortby" name="sort" class="short-item filters-toolbar__input filters-toolbar__input--sort">
                                                    <option value="date_desc">{{$langg->lang65}}</option>
								                    <option value="date_asc">{{$langg->lang66}}</option>
								                    <option value="price_asc">{{$langg->lang67}}</option>
								                    <option value="price_desc">{{$langg->lang68}}</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>



			
