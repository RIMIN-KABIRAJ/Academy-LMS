@extends('layouts.admin')
@push('title', get_phrase('Instructor Setting'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Public Instructor Settings') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('Instructor settings') }}</h3>
                <div class="ol-card-body">
                    <form action="{{ route('admin.instructor.setting.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="first" value="item_1">
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Allow public instructor') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="allow_instructor" required>
                                <option value="1" @if ($allow_instructor->description == 1) selected @endif>
                                    {{ get_phrase('Yes') }}</option>
                                <option value="0" @if ($allow_instructor->description == 0) selected @endif>
                                    {{ get_phrase('No') }}</option>
                            </select>
                        </div>
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="instructor_application_note">{{ get_phrase('Instructor application note') }}</label>

                            <textarea class="form-control ol-form-control" name="instructor_application_note" rows="8" cols="80">{{ $application_note->description }}</textarea>
                        </div>

                        <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Update settings') }}</button>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-xl-6">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('Revenue settings') }}</h3>
                <div class="ol-card-body">
                    <form action="{{ route('admin.instructor.setting.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="second" value="item_2">
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="instructor_revenue">{{ get_phrase('Instructor revenue percentage') }}</label>
                            <div class="input-group">
                                <input type="number" name = "instructor_revenue" id = "instructor_revenue" class="form-control ol-form-control"
                                    onkeyup="calculateAdminRevenue(this.value)" min="0" max="100" value="{{ $instructor_revenue->description }}">
                                <div class="input-group-append">
                                    <span class="input-group-text ol-form-control">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="admin_revenue">{{ get_phrase('Admin revenue percentage') }}</label>
                            <div class="input-group">
                                <input type="number" name = "admin_revenue" id = "admin_revenue" class="form-control ol-form-control" value="0" disabled>
                                <div class="input-group-append">
                                    <span class="input-group-text ol-form-control">%</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Update settings') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        "use strict";

        $(document).ready(function() {
            var instructor_revenue = $('#instructor_revenue').val();
            calculateAdminRevenue(instructor_revenue);
        });

        function calculateAdminRevenue(instructor_revenue) {
            if (instructor_revenue <= 100) {
                var admin_revenue = 100 - instructor_revenue;
                $('#admin_revenue').val(admin_revenue);
            } else {
                $('#admin_revenue').val(0);
            }
        }
    </script>
@endpush
