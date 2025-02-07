@extends('layouts.default')
@push('title', get_phrase('Become an instructor'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------ My profile area start  ------------>
    <section class="course-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('Become an instructor') }}</h4>
                    <div class="my-panel message-panel edit_profile">
                        <form action="{{ route('become.instructor.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">{{ get_phrase('Phone Number') }}</label>
                                        <input type="tel" class="form-control @error('phone') border border-danger @enderror " name="phone" id="phone" placeholder="{{ get_phrase('+0 (123) 456 - 7890') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label for="document" class="form-label">{{ get_phrase('Document') }}</label>
                                        <input type="file" class="form-control @error('document') border border-danger @enderror" name="document" id="document">
                                        <small class="ps-3 text-secondary">{{ get_phrase('Documents of qualification. Max-size : 5MB (DOC, DOCX, PDF, TXT, PNG, JPG, JPEG)') }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label for="description" class="form-label">{{ get_phrase('Description') }}</label>
                                        <textarea name="description" class="form-control @error('description') border border-danger @enderror" id="description" cols="30" rows="5" placeholder="{{ get_phrase('Your description here...') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="eBtn btn gradient mt-10">{{ get_phrase('Apply for instructor') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ My profile area end  ------------>
@endsection
@push('js')

@endpush
