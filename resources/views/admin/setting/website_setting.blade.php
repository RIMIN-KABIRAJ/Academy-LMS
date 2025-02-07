@extends('layouts.admin')
@push('title', get_phrase('Website settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Website Settings') }}
                </h4>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <div class="col-md-12 pb-3">
                        <ul class="nav nav-tabs eNav-Tabs-custom eTab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="cHome-tab" data-bs-toggle="tab" data-bs-target="#cHome" type="button" role="tab" aria-controls="cHome" aria-selected="true">
                                    {{ get_phrase('Frontend Settings') }}
                                    <span></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="cMessage-tab" data-bs-toggle="tab" data-bs-target="#cMessage" type="button" role="tab" aria-controls="cMessage" aria-selected="false">
                                    {{ get_phrase('Motivational Speech') }}
                                    <span></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="cSettings-tab" data-bs-toggle="tab" data-bs-target="#cSettings" type="button" role="tab" aria-controls="cSettings" aria-selected="false">
                                    {{ get_phrase('Website FAQS') }}
                                    <span></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact_information-tab" data-bs-toggle="tab" data-bs-target="#contact_information" type="button" role="tab" aria-controls="contact_information" aria-selected="false">
                                    {{ get_phrase('Contact Information') }}
                                    <span></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews" data-bs-toggle="tab" data-bs-target="#reviews-tab" type="button" role="tab" aria-controls="reviews-tab" aria-selected="false">
                                    {{ get_phrase('User Reviews') }}
                                    <span></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="logo_images-tab" data-bs-toggle="tab" data-bs-target="#logo_images" type="button" role="tab" aria-controls="logo_images" aria-selected="false">
                                    {{ get_phrase('Logo & Images') }}
                                    <span></span>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content eNav-Tabs-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="cHome" role="tabpanel" aria-labelledby="cHome-tab">
                                <div class="tab-pane show active" id="frontendsettings">
                                    @include('admin.setting.frontend_setting')
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cMessage" role="tabpanel" aria-labelledby="cMessage-tab">
                                @include('admin.setting.motivational')
                            </div>
                            <div class="tab-pane fade" id="cSettings" role="tabpanel" aria-labelledby="cSettings-tab">
                                @include('admin.setting.webfaqs')
                            </div>
                            <div class="tab-pane fade" id="contact_information" role="tabpanel" aria-labelledby="contact_information-tab">
                                @include('admin.setting.contact_information')
                            </div>
                            <div class="tab-pane fade" id="recaptcha" role="tabpanel" aria-labelledby="recaptcha-tab">
                                @include('admin.setting.recaptcha')
                            </div>
                            <div class="tab-pane fade" id="reviews-tab" role="tabpanel" aria-labelledby="reviews">
                                @include('admin.setting.user_review_list')
                            </div>
                            <div class="tab-pane fade" id="logo_images" role="tabpanel" aria-labelledby="logo_images-tab">
                                @include('admin.setting.logo_image')
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script type="text/javascript">
        "use strict";

        let blank_faq = jQuery('#blank_faq_field').html();
        let blank_motivational_speech = jQuery('#blank_motivational_speech_field').html();
        $(document).ready(function() {

            jQuery('#blank_faq_field').hide();
            jQuery('#blank_motivational_speech_field').hide();

            <?php if(isset($_GET['tab'])): ?>
            $('a[href="#<?php echo $_GET['tab']; ?>"]').trigger('click');
            <?php endif; ?>
        });

        function appendFaq() {
            jQuery('#faq_area').append(blank_faq);
        }

        function removeFaq(faqElem) {
            jQuery(faqElem).parent().parent().remove();
        }

        function appendMotivational_speech() {
            jQuery('#motivational_speech_area').append(blank_motivational_speech);
        }

        function removeMotivational_speech(faqElem) {
            jQuery(faqElem).parent().parent().remove();
        }
    </script>
@endpush
