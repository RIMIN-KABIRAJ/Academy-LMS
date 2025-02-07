<div class="sidebar">
    <div class="row mb-4">
        <div class="col-6">
            <span class="d-inline-block py-1">{{get_phrase('Filter')}}</span>
        </div>
        <div class="col-6 text-end">
            @if(count(request()->all()) > 0 || !empty($category_details))
            <a class="btn d-flex align-items-center float-end border py-2" href="{{route('courses')}}"><i class="fi-rr-cross-circle me-2"></i> <span>{{get_phrase('Clear')}} @if(isset($_GET) && count($_GET) > 0)({{count($_GET)}})@endif</span></a>
            @endif
        </div>
    </div>
    <form class="mb-4" action="{{ route('courses') }}" method="get">
        <div class="widget">
            <div class="search">
                <input type="text" class="form-control" name="search" placeholder="{{ get_phrase('Search...') }}"
                    @if (request()->has('search')) value="{{ request()->input('search') }}" @endif>
                <button type="submit" class="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
    </form>


    <!------------------- categories start ------------------->
    <div class="widget overlay-content overlay-content-max-h-400">
        <h4 class="widget-title">{{ get_phrase('Categories') }}</h4>
        <ul class="entry-widget overflow-hidden" id="parent-category">
            @php
                $parent_categories = App\Models\Category::where('parent_id', 0)->get();
                $active_category = request()->route()->parameter('category');
                $route_queries = request()->query();
                $route_queries = collect($route_queries)->except('page')->all();
            @endphp
            @foreach ($parent_categories as $parent_category)
                @php $route_queries['category'] = $parent_category->slug; @endphp

                <li class="category @if ($parent_category->slug == $active_category) active @endif" id="{{ $parent_category->slug }}">
                    <a href="{{ route('courses', $route_queries) }}"
                        class="d-flex align-items-center justify-content-between">
                        <span>{{ $parent_category->title }}</span>
                        <span>{{ count_category_courses($parent_category->id) }}</span>
                    </a>
                </li>

                <ul class="entry-widget ms-3 " id="child-category">
                    @foreach (App\Models\Category::where('parent_id', $parent_category->id)->get() as $child_category)
                        @php $route_queries['category'] = $child_category->slug; @endphp

                        <li class="category @if ($child_category->slug == $active_category) active @endif"
                            id="{{ $child_category->slug }}">
                            <a href="{{ route('courses', $route_queries) }}"
                                class="d-flex align-items-center justify-content-between">
                                <span>{{ $child_category->title }}</span>
                                <span>{{ count_category_courses($child_category->id) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </ul>
    </div>
    <!------------------- categories end ------------------->


    <form action="{{ route('courses', request()->route()->parameter('category')) }}" method="get"
        id="filter-courses">

        @if (request()->has('search'))
            <input type="hidden" name="search" value="{{ request()->input('search') }}">
        @endif


        <!------------------- price filter start ------------------->
        <div class="widget">
            <h4 class="widget-title">{{ get_phrase('Price') }}</h4>
            <ul class="entry-widget">
                @foreach (['paid', 'discount', 'free'] as $price)
                    <li class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input mt-0" type="radio" name="price"
                                value="{{ $price }}" id="price-{{ $price }}"
                                @if (request()->has('price') && request()->input('price') == $price) checked @endif />
                            <label class="form-check-label"
                                for="price-{{ $price }}">{{ get_phrase(ucfirst($price)) }}</label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <!------------------- price filter end ------------------->



        <!------------------- level filter start ------------------->
        <div class="widget">
            <h4 class="widget-title">{{ get_phrase('Level') }}</h4>
            <ul class="entry-widget">
                @foreach (['beginner', 'intermediate', 'advanced'] as $level)
                    <li class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input mt-0" type="radio" name="level"
                                value="{{ $level }}" id="level-{{ $level }}"
                                @if (request()->has('level') && request()->input('level') == $level) checked @endif />
                            <label class="form-check-label"
                                for="level-{{ $level }}">{{ get_phrase(ucfirst($level)) }}</label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <!------------------- level filter end ------------------->



        <!------------------- language filter start ------------------->
        <div class="widget">
            <h4 class="widget-title">{{ get_phrase('language') }}</h4>
            <ul class="entry-widget">
                @foreach (['english', 'spanish', 'italic', 'german'] as $language)
                    <li class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input mt-0" type="radio" name="language"
                                value="{{ $language }}" id="language-{{ $language }}"
                                @if (request()->has('language') && request()->input('language') == $language) checked @endif />
                            <label class="form-check-label"
                                for="language-{{ $language }}">{{ get_phrase(ucfirst($language)) }}</label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <!------------------- language filter end ------------------->



        <!------------------- ratings start ------------------->
        <div class="widget">
            <h4 class="widget-title">{{ get_phrase('Ratings') }}</h4>
            <ul class="entry-widget">
                @for ($i = 5; $i >= 1; $i--)
                    <li class="form-check">
                        <input class="form-check-input" type="radio" name="rating" value="{{ $i }}"
                            id="raging-{{ $i }}" @if (request()->has('rating') && request()->input('rating') == $i) checked @endif />
                        <label class="form-check-label" for="raging-{{ $i }}">
                            <ul class="d-flex g-star g-5">
                                @for ($j = 1; $j <= 5; $j++)
                                    <li @if ($j <= $i) class="color-g" @endif>
                                        <i class="fa fa-star"></i>
                                    </li>
                                @endfor
                            </ul>
                        </label>
                    </li>
                @endfor


            </ul>
        </div>
        <!------------------- ratings end ------------------->
    </form>
</div>


@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('#see-more').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                let show_more = $(this).html();

                if ($(this).hasClass('active')) {
                    $(this).css('margin-top', '20px');
                    $(this).text('{{ get_phrase('Show Less') }}');
                } else {
                    $(this).css('margin-top', '0px');
                    $(this).html('{{ get_phrase('Show More') }}');
                }
            });

            var scrollTop = $(".scrollTop");
            $(scrollTop).on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 100);
                return false;
            });

            $('input[type="radio"]').change(function(e) {
                $('#filter-courses').trigger('submit');
            });
        });
    </script>
@endpush
