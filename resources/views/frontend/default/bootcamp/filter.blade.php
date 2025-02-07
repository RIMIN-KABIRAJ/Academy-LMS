@php
    $categories = App\Models\BootcampCategory::get();
    $active_category = request()->route()->parameter('category');
    $route_queries = request()->query();
    $route_queries = collect($route_queries)->except('page')->all();
@endphp

<div class="sidebar">
    <form class="mb-4" action="{{ route('bootcamps', $active_category) }}" method="get">
        <div class="widget">
            <div class="search">
                <input type="text" class="form-control" name="search" placeholder="{{ get_phrase('Search...') }}"
                    value="{{ request('search') }}">
                <button type="submit" class="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
    </form>


    <!------------------- categories start ------------------->
    <div class="widget overlay-content overlay-content-max-h-400">
        <h4 class="widget-title">{{ get_phrase('Categories') }}</h4>
        <ul class="entry-widget overflow-hidden" id="parent-category">
            @foreach ($categories as $category)
                @php $route_queries['category'] = $category->slug; @endphp

                <li class="category @if ($category->slug == $active_category) active @endif" id="{{ $category->slud }}">
                    <a href="{{ route('bootcamps', $route_queries) }}"
                        class="d-flex align-items-center justify-content-between">
                        <span>{{ $category->title }}</span>
                        <span>{{ count_bootcamps_by_category($category->id) }}</span>
                    </a>
                </li>
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
        $(document).ready(function() {
            $('#see-more').click(function(e) {
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
            $(scrollTop).click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 100);
                return false;
            });

            $('input[type="radio"]').change(function(e) {
                $('#filter-bootcamps').submit();
            });
        });
    </script>
@endpush
