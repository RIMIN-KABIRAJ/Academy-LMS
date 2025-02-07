@extends('layouts.admin')
@push('title', get_phrase('Add Review'))
@push('meta')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Review') }}</span>
                </h4>
                <a href="{{ route('admin.website.settings', ['tab' => 'reviews'])}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>



    <div class="row ">
        <div class="col-md-8">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route('admin.review.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="blog_category_id">{{ get_phrase('Select User') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="user_id" id="blog_category_id" required>
                                <option value="">{{ get_phrase('Select an user') }}</option>
                                @foreach ($userList as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="blog_category_id">{{ get_phrase('Rating') }}</label>
                            <select class="form-control ol-form-control " data-toggle="select2" name="rating" id="blog_category_id" required>
                                <option value="">{{ get_phrase('Select a Rating') }}</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="summernote-basic">{{ get_phrase('Review') }}</label>
                            <textarea name="review" class="form-control ol-form-control"></textarea>
                        </div>


                        <div class="fpb-7 mb-3">
                            <button type="submit" class="ol-btn-primary">{{ get_phrase('Add Review') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
