@php
    $related_blogs = App\Models\Blog::where('keywords', $blog_details->keywords)
        ->latest('id')
        ->take(6)
        ->get();
@endphp

<section class="blog-wrapper section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="res-control d-flex align-items-center justify-content-between">
                    <div class="section-title mb-0">
                        <span class="title-head mb-10">{{ get_phrase('Our Blog') }}</span>
                        <h2 class="title">{{ get_phrase('Have a look on our news') }}</h2>
                    </div>
                    <a href="{{ route('blogs') }}" class="eBtn gradient">{{ get_phrase('View All Blogs') }}</a>
                </div>
            </div>
        </div>
        <div class="row mt-50">
            @foreach ($related_blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-6 mb-20">
                    @include('frontend.default.blog.card')
                </div>
            @endforeach
        </div>
    </div>
</section>
