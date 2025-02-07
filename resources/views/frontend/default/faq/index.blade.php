@extends('layouts.default')
@push('title', get_phrase('Frequently asked questions'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Start Breadcrumb -->
    <section class="py-56" data-background="{{ asset('assets/frontend/images/breadcrumb.png') }}">
        <div class="container">
            <ul class="ul-ol d-flex align-items-center cg-17 pb-20">
                <li class="d-flex align-items-center cg-12">
                    <div class="d-flex">
                        <img src="{{ asset('assets/frontend/images/icon/home.svg') }}" alt="" />
                    </div>
                    <p class="fz-16 fw-500 lh-30 text-white">{{ get_phrase('Home') }}</p>
                </li>
                <li class="d-flex align-items-center cg-12">
                    <div class="d-flex">
                        <img src="{{ asset('assets/frontend/images/icon/arrow-right-white.svg') }}" alt="" />
                    </div>
                    <p class="fz-16 fw-500 lh-30 text-white">{{ get_phrase('FAQ') }}</p>
                </li>
            </ul>
            <h4 class="fz-56 fw-600 lh-64 text-white">{{ get_phrase('Frequently asked questions') }} </h4>
        </div>
    </section>
    <!-- End Breadcrumb -->

    <!-- Frequently Asked Questions Area Start -->
    <section>
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <h1 class="title mb-4">{{ get_phrase('Frequently Asked Questions?') }}</h1>
                    <p class="info">
                        {{ get_phrase("FAQ provides quick answers to common inquiries, helping users resolve doubts efficiently.") }}
                    </p>
                </div>
            </div>
            <div class="row mb-110 mt-5">
                @php
                    $faqs = json_decode(get_frontend_settings('website_faqs'), true);
                    $faqs = count($faqs) > 0 ? $faqs : [['question' => '', 'answer' => '']];
                @endphp
                <div class="col-md-12">
                    <div class="accordion qnaaccordion-two" id="accordionExampleLeft">
                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeft{{ $key }}" aria-expanded="true" aria-controls="collapseLeft{{ $key }}">
                                        {{ $faq['question'] }}
                                    </button>
                                </h2>
                                <div id="collapseLeft{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExampleLeft">
                                    <div class="accordion-body">
                                        <p class="answer">{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Frequently Asked Questions Area End -->
@endsection
@push('js')@endpush
