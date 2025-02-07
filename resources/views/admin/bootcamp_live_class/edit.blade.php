@php
    $class = App\Models\BootcampLiveClass::where('id', $id)->first();
    $bootcamp_id = App\Models\BootcampModule::where('id', $class->module_id)->value('bootcamp_id');
    date_default_timezone_set('Asia/Dhaka');
@endphp
<form action="{{ route('admin.bootcamp.live.class.update', $id) }}" method="post">@csrf
    <div class="fpb7 mb-3">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $class->title }}"
            required>
    </div>

    <div class="row mb-3">
        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('Date') }}</label>
            <input type="date" class="form-control ol-form-control" name="date"
                value="{{ date('Y-m-d', $class->start_time) }}" required />
        </div>

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('Start time') }}</label>
            <input type="time" class="form-control ol-form-control" name="start_time"
                value="{{ date('H:i', $class->start_time) }}" required />
        </div>

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('End time') }}</label>
            <input type="time" class="form-control ol-form-control" name="end_time"
                value="{{ date('H:i', $class->end_time) }}" required />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-6 fpb-7">
            <label class="form-label ol-form-label">{{ get_phrase('Module') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="module_id">
                <option value="">{{ get_phrase('Select an option') }}</option>
                @foreach (App\Models\BootcampModule::where('bootcamp_id', $bootcamp_id)->get() as $module)
                    <option value="{{ $module->id }}" @if ($class->module_id == $module->id) selected @endif>
                        {{ $module->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-6 fpb-7">
            <label class="form-label ol-form-label">{{ get_phrase('Status') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status">
                <option value="">{{ get_phrase('Select an option') }}</option>
                <option value="upcoming" @if ($class->status == 'upcoming') selected @endif>{{ get_phrase('Upcoming') }}
                </option>
                <option value="live" @if ($class->status == 'live') selected @endif>{{ get_phrase('Live') }}
                </option>
                <option value="completed" @if ($class->status == 'completed') selected @endif>
                    {{ get_phrase('Completed') }}</option>
            </select>
        </div>
    </div>

    <div class="fpb-7 mb-3">
        <label for="description"
            class="form-label ol-form-label col-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="description" rows="5" class="form-control ol-form-control text_editor">{!! $class->description !!}</textarea>
    </div>

    <div class="fpb7">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update class') }}</button>
    </div>
</form>

@include('admin.init')
