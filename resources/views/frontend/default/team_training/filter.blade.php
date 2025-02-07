<div class="sidebar">
    <div class="row mb-4">
        <div class="col-6">
            {{ get_phrase('Filter') }}
        </div>
        <div class="col-6 text-end">
            @if (count(request()->all()) > 0)
                <a href="{{ route('team.packages') }}">{{ get_phrase('Clear') }}</a>
            @endif
        </div>
    </div>
    <form class="mb-4" action="{{ route('team.packages') }}" method="get">
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
                @php $route_queries['course_category'] = $parent_category->slug; @endphp

                <li class="category @if ($parent_category->slug == $active_category) active @endif" id="{{ $parent_category->slug }}">
                    <a href="{{ route('team.packages', $route_queries) }}"
                        class="d-flex align-items-center justify-content-between">
                        <span>{{ $parent_category->title }}</span>
                        <span>{{ team_packages_by_course_category($parent_category->id) }}</span>
                    </a>
                </li>

                <ul class="entry-widget ms-3" id="child-category">
                    @foreach (DB::table('categories')->where('parent_id', $parent_category->id)->get() as $child_category)
                        @php $route_queries['course_category'] = $child_category->slug; @endphp

                        <li class="category @if ($child_category->slug == $active_category) active @endif"
                            id="{{ $child_category->slug }}">
                            <a href="{{ route('team.packages', $route_queries) }}"
                                class="d-flex align-items-center justify-content-between">
                                <span>{{ $child_category->title }}</span>
                                <span>{{ team_packages_by_course_category($child_category->id) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </ul>
        <div class="down-text" id="see-more">
            {{ get_phrase('Show More') }}
        </div>
    </div>
    <!------------------- categories end ------------------->
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
        });
    </script>
@endpush
