<style>
    input.daterangepicker {
        width: calc(100% - 2rem);
    }

    .ol-form-control {
        border: 1px solid var(--borderColor) !important;
        border-radius: 8px !important;
        padding: 10px 15px !important;
        font-weight: 400 !important;
        font-size: 14px !important;
        line-height: 20px !important;
        color: var(--grayColor) !important;
        transition: .3s !important;
    }

    .daterangepicker td.active,
    .daterangepicker td.active:hover {
        background-color: #1b84ff !important;
    }
</style>

<form action="{{ route('instructor.bootcamp.module.store') }}" method="post">@csrf
    <input type="hidden" name="bootcamp_id" value="{{ $id }}">
    <div class="fpb7 mb-3">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input class="form-control ol-form-control" type="text" id="title" name="title" required>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Module Restriction') }}</label>
        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="restriction">
            <option value="0">{{ get_phrase('Select an option') }}</option>
            <option value="1">{{ get_phrase('Until start date, keep this module locked.') }}</option>
            <option value="2">{{ get_phrase('Keep this module open only within the selected date range.') }}
            </option>
        </select>
    </div>

    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label d-block">{{ get_phrase('Validity') }}</label>
        <input type="text" class="form-control ol-form-control daterangepicker"
            name="validity"value="{{ date('m/d/Y', strtotime('now')) . ' - ' . date('m/d/Y', strtotime('now')) }}"
            required />
    </div>

    <div class="fpb7 mb-2 mt-5 pt-4">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add module') }}</button>
    </div>
</form>
@push('js')
    <script type="text/javascript">
        function update_date_range() {
            var x = $("#selectedValue").html();
            $("#date_range").val(x);
        }
    </script>
@endpush

{{-- Date range picker --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendors/daterangepicker/daterangepicker.css') }}"
    rel="stylesheet" type="text/css" />
{{-- Date range picker --}}
<script src="{{ asset('assets/backend/vendors/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendors/daterangepicker/daterangepicker.js') }}"></script>

@include('instructor.init')
