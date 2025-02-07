<form action="{{ route('instructor.bootcamp.live.class.store') }}" method="post">@csrf
    <div class="fpb7 mb-3">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input class="form-control ol-form-control" type="text" id="title" name="title" required>
    </div>

    <div class="row mb-3">
        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('Date') }}</label>
            <input type="date" class="form-control ol-form-control" name="date" required />
        </div>

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('Start time') }}</label>
            <input type="time" class="form-control ol-form-control" name="start_time" required />
        </div>

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('End time') }}</label>
            <input type="time" class="form-control ol-form-control" name="end_time" required />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-6 fpb-7">
            <label class="form-label ol-form-label">{{ get_phrase('Module') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="module_id">
                <option value="">{{ get_phrase('Select an option') }}</option>
                @foreach (App\Models\BootcampModule::where('bootcamp_id', $id)->get() as $module)
                    <option value="{{ $module->id }}">{{ $module->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-6 fpb-7">
            <label class="form-label ol-form-label">{{ get_phrase('Status') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status">
                <option value="">{{ get_phrase('Select an option') }}</option>
                <option value="upcoming">{{ get_phrase('Upcoming') }}</option>
                <option value="live">{{ get_phrase('live') }}</option>
                <option value="completed">{{ get_phrase('Completed') }}</option>
            </select>
        </div>
    </div>

    <div class="fpb-7 mb-3">
        <label for="description"
            class="form-label ol-form-label col-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="description" rows="5" class="form-control ol-form-control text_editor"></textarea>
    </div>

    <div class="fpb7">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add class') }}</button>
    </div>
</form>

@include('instructor.init')
