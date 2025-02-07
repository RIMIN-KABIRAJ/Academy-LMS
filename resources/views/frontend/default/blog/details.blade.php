@extends('layouts.default')
@push('title', get_phrase('Blog Details'))
@push('meta')@endpush
@push('css')
    <style>
        .playing-breadcum {
            height: 350px;
        }

        .breadcum-area {
            z-index: -1;
        }
    </style>
@endpush
@section('content')
    @php
        $total_comments = count_comments_by_blog_id($blog_details->id);
        $total_likes = count_likes_by_blog_id($blog_details->id);
    @endphp
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area playing-breadcum details-breadcum">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('blogs') }}">{{ get_phrase('Blogs') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Blog Details') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->

    <!------------------- Blog Details Area Start  --------->
    <section class="blog-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ps-box blog-box">

                        <div class="details-intro">
                            <h4 class="g-title text-center f-40 mt-4">{{ $blog_details->title }}</h4>
                            <ul class="course-motion-top flex-wrap gap-4 justify-content-center">
                                <li>
                                    <div class="figar d-flex align-items-center mb-0 me-auto">
                                        <img src="{{ get_image($blog_details->author_photo) }}" alt="author-image">
                                        <p class="description">{{ $blog_details->author_name }}</p>
                                    </div>
                                </li>
                                @if ($blog_details->keywords)
                                    <li>
                                        <img class="pro-20" src="{{ asset('assets/frontend/default/image/elearn.png') }}" alt="blog-tag">
                                        @php
                                            $tags = json_decode($blog_details->keywords, true);
                                            if (is_array($tags) && count($tags) > 0) {
                                                $tags = array_column($tags, 'value');
                                            }
                                        @endphp
                                        {{ $tags ? implode(', ', $tags) : '' }}
                                    </li>
                                @endif
                                <li>
                                    <img class="pro-20" src="{{ asset('assets/frontend/default/image/elearn2.png') }}" alt="blog-comment">
                                    {{ $total_comments }}
                                </li>
                                <li>
                                    <img class="pro-20" src="{{ asset('assets/frontend/default/image/elearn3.png') }}" alt="created-date">
                                    {{ date('d M, Y', strtotime($blog_details->created_at)) }}
                                </li>
                            </ul>
                        </div>


                        <div class="blog-f-image">
                            <img src="{{ get_image($blog_details->banner) }}" alt="blog-thumbnail">
                            <div class="description description-style">{!! removeScripts($blog_details->description) !!}</div>
                            <ul class="tags">
                                @php
                                    $tags = $blog_details->keywords ? json_decode($blog_details->keywords, true) : [];
                                    if (is_array($tags) && count($tags) > 0) {
                                        $tags = array_column($tags, 'value');
                                    } else {
                                        $tags = [];
                                    }
                                @endphp
                                @foreach ($tags as $tag)
                                    <li><a href="#">{{ ucfirst($tag) }}</a></li>
                                @endforeach
                            </ul>
                            @auth
                                <div class="details-socialsLink d-flex justify-content-between">
                                    <span>
                                        @php
                                            $is_liked = App\Models\BlogLike::where('blog_id', $blog_details->id)
                                                ->where('user_id', auth()->user()->id)
                                                ->first();
                                        @endphp
                                        <div class="like-svg @if ($is_liked) active @endif">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.01026 17.0834V7.0626L10.5038 2.6732C10.7389 2.43816 10.9932 2.29419 11.2667 2.2413C11.5402 2.18841 11.7907 2.23276 12.0182 2.37432C12.2458 2.51588 12.406 2.73008 12.499 3.01693C12.5919 3.30379 12.5978 3.61495 12.5166 3.95041L11.7859 7.0626H17.1609C17.5711 7.0626 17.9386 7.22499 18.2634 7.54978C18.5882 7.87456 18.7506 8.24208 18.7506 8.65235V9.99847C18.7506 10.0859 18.7463 10.1796 18.7378 10.2796C18.7292 10.3796 18.7041 10.4659 18.6625 10.5385L16.2743 16.1324C16.1687 16.4128 15.9733 16.6413 15.6878 16.8182C15.4023 16.995 15.1044 17.0834 14.7942 17.0834H6.01026ZM7.3644 7.61547V15.7501H14.7346C14.7934 15.7501 14.8534 15.734 14.9149 15.702C14.9763 15.6699 15.0231 15.6165 15.0551 15.5417L17.4173 10.0626V8.65235C17.4173 8.57755 17.3933 8.51612 17.3452 8.46803C17.2971 8.41995 17.2357 8.39591 17.1609 8.39591H10.0808L11.1465 3.91193L7.3644 7.61547ZM3.67373 17.0834C3.23655 17.0834 2.8623 16.9277 2.55098 16.6164C2.23965 16.3051 2.08398 15.9308 2.08398 15.4936V8.65235C2.08398 8.21517 2.23965 7.84092 2.55098 7.5296C2.8623 7.21826 3.23655 7.0626 3.67373 7.0626H6.01026L6.03109 8.39591H3.67373C3.59894 8.39591 3.53751 8.41995 3.48942 8.46803C3.44134 8.51612 3.4173 8.57755 3.4173 8.65235V15.4936C3.4173 15.5684 3.44134 15.6299 3.48942 15.6779C3.53751 15.726 3.59894 15.7501 3.67373 15.7501H6.03109V17.0834H3.67373Z"
                                                    fill="#6B7385" />
                                            </svg>
                                        </div>
                                        <span id="total-blog-likes">{{ $total_likes }}</span>
                                    </span>
                                </div>
                            @endauth
                        </div>

                        <div class="comment-wrap">
                            @include('frontend.default.blog.author_details')

                            <div class="comment-head">
                                <h4 class="g-title"> {{ $total_comments }} </h4>
                            </div>

                            @isset(auth()->user()->id)
                                <h4 class="g-title g_font mt-5 mb-0">{{ get_phrase('Post A Comment') }}</h4>
                                <form action="{{ route('blog.comment.store') }}" class="comment-form" method="post">@csrf
                                    <input type="hidden" name="blog_id" value="{{ $blog_details->id }}">
                                    <textarea name="comment" id="comment" class="form-control" placeholder="{{ get_phrase('Write your comment ...') }}"></textarea>
                                    <button type="submit" class="eBtn gradient">{{ get_phrase('Post Comment') }}</button>
                                </form>
                            @endisset

                            @foreach ($blog_comments as $comment)
                                @include('frontend.default.blog.comment')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Blog Details Area End  --------->
@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.replay').on('click', function(e) {
                e.preventDefault();
                let comment_id = $(this).attr('id');

                if ($('#replay-' + comment_id).hasClass('d-none')) {
                    $('#replay-' + comment_id).removeClass('d-none');
                } else {
                    $('#replay-' + comment_id).addClass('d-none');
                }
                $('.replay-form:not(#replay-' + comment_id + ')').addClass('d-none');
            });

            $('.like-svg').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('blog.like') }}",
                    data: {
                        blog_id: "{{ $blog_details->id }}",
                    },
                    success: function(response) {
                        let likes = +($('#total-blog-likes').text());
                        if (response.like) {
                            $('.like-svg').addClass('active');
                        } else {
                            $('.like-svg').removeClass('active');
                        }
                    }
                });
            });
        });
    </script>
@endpush
