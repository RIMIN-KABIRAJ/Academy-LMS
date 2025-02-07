<div class="sidebar blog-sidebar" action="#">
    <form class="mb-4" action="{{ route('blogs') }}" method="get">
        <div class="widget">
            <div class="search">
                <input type="text" class="form-control" name="search" placeholder="{{ get_phrase('Search...') }}" @if (request()->has('search')) value="{{ request()->input('search') }}" @endif>
                <button type="submit" class="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
    </form>


    <div class="widget border-bottom">
        <h4 class="widget-title pb-15 border-none">{{ get_phrase('Categories') }}</h4>
        <ul class="entry-widget" id="blog-category">
            @php
                $active_category = request()->route()->parameter('category');
                $route_queries = request()->query();
            @endphp
            @foreach (App\Models\BlogCategory::latest()->get() as $category)
                @php $route_queries['category'] = $category->slug; @endphp
                <li class="category @if ($category->slug == $active_category) active @endif" id="{{ $category->slug }}">
                    <a href="{{ route('blogs', $route_queries) }}" class="d-flex align-items-center justify-content-between">
                        <span>{{ $category->title }}</span>
                        <span>{{ count_blogs_by_category($category->id) }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="down-text mb-30 mt-4" id="see-more">
            {{ get_phrase('Show More') }} <i class="fi-rr-plus-small"></i>
        </div>
    </div>
    <div class="widget border-bottom">
        <h4 class="widget-title pb-15 border-none">{{ get_phrase('Popular Post') }}</h4>
        <ul class="entry-widget blog-widget blog-widget-post">
            @foreach (App\Models\Blog::where('status', 1)->latest()->take(4)->get() as $blog)
                <li class="d-flex mb-20">
                    <a href="{{ route('blog.details', $blog->slug) }}">
                        <div class="widget-post-bx">
                            <div class="widget-posts popular-blogs">
                                <div class="ttr-post-media"> <img src="{{ get_image($blog->thumbnail) }}" alt="blog-thumbnail">
                                </div>
                                <div class="ttr-post-info">
                                    <div class="ttr-post-header">
                                        <span>{{ date('d M, Y', strtotime($blog->created_at)) }}</span>
                                        <h6 class="post-titles ellipsis-2">{{ ucfirst($blog->title) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="widget">
        <h4 class="widget-title pb-15 border-none">{{ get_phrase('Tags') }}</h4>
        <ul class="tags overlay-content mt-0">
            @foreach (get_blog_tags() as $tag)
                <li><a class="@if (isset($_GET['tag']) && $_GET['tag'] == $tag) active @endif" href="{{ route('blogs', ['tag' => $tag]) }}">{{ ucfirst($tag) }}</a></li>
            @endforeach
        </ul>
    </div>
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
                    $('#blog-category').css('height', 'auto');
                    $('#blog-category').css('max-height', 'max-content');
                    $(this).css('margin-top', '20px');
                    $(this).html('Show Less <i class="fi-rr-minus-small"></i>');
                } else {
                    $('#blog-category').css('height', 'auto');
                    $('#blog-category').css('max-height', '400px');
                    $(this).css('margin-top', '0px');
                    $(this).html('Show More <i class="fi-rr-plus-small"></i>');
                }
            });
        });
    </script>
@endpush
