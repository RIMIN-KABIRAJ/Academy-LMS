{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<section class="category-wrapper section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <span class="title-head builder-editable" builder-identity="1">{{get_phrase('Categories')}}</span>
                    <h2 class="title builder-editable" builder-identity="2">{{get_phrase('Explore Top Courses Caterories')}}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach (App\Models\Category::where('parent_id', 0)->take(32)->get() as $category)
                <div class="col-md-4 col-sm-6 mb-30">
                    <a href="{{ route('courses', $category->slug) }}" class="single-category">
                        <div class="single-category-logo">
                            <img src="{{ get_image($category->category_logo) }}" alt="">
                        </div>
                        <div class="single-category-name">
                            <h4>{{ $category->title }}</h4>
                            <p>{{ count_category_courses($category->id) }} {{get_phrase('courses')}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
