@extends('layouts.admin')

@push('title', get_phrase('Create Student'))

@push('meta')
@endpush

@push('css')
@endpush


@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Create Student') }}
                </h4>

                <a href="{{ route('admin.student.index') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-alt-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
    <div class="ol-card p-4">
        <h4 class="title fs-16px mb-20px">{{ get_phrase('Student Info') }}</h4>
        <div class="ol-card-body">
            <form action="{{ route('admin.student.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex gap-3 flex-wrap flex-md-nowrap">
                    <div class="ol-sidebar-tab">
                        <div class="nav flex-column nav-pills" id="myv-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link text-start active" id="v-pills-tab1-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tab1" type="button" role="tab" aria-controls="v-pills-tab1" aria-selected="true">
                                <span class="icon fi-rr-duplicate"></span>
                                <span>{{ get_phrase('Basic') }}</span>
                            </button>
                            <button class="nav-link text-start" id="v-pills-tab2-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tab2" type="button" role="tab" aria-controls="v-pills-tab2" aria-selected="false">
                                <span class="fi-rr-key"></span>
                                <span>{{ get_phrase('Login Credentials') }}</span>
                            </button>

                            <button class="nav-link text-start" id="v-pills-tab4-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tab4" type="button" role="tab" aria-controls="v-pills-tab4" aria-selected="false">
                                <span class="fi-rr-link"></span>
                                <span>{{ get_phrase('Social Links') }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="tab-content w-100" id="myv-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1-tab" tabindex="0">
                            <div class="dashboard-tab-conTent">
                                @include('admin.student.create_student_basic')
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-tab2" role="tabpanel" aria-labelledby="v-pills-tab2-tab" tabindex="0">
                            <div class="dashboard-tab-conTent">
                                @include('admin.student.create_login')
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-tab4" role="tabpanel" aria-labelledby="v-pills-tab4-tab" tabindex="0">
                            <div class="dashboard-tab-conTent">
                                @include('admin.student.create_social')
                            </div>
                        </div>

                        <button type="submit" class="btn ol-btn-primary mt-3">
                            <span>{{ get_phrase('Create Student') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Admin area -->
@endsection
