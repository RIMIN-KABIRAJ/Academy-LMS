<div class="ol-card p-4">
    <div class="ol-card-body">
        <h4 class="title text-16px mb-4">{{get_phrase('Create a new conversation with a new user')}}</h4>
        <form action="{{route('admin.message.thread.store')}}" method="post">
            @csrf
            <div class="input-group mb-3">
                <label class="form-label ol-form-label">{{get_phrase('Select a new user')}}</label>
                <select class="ol-select2" name="receiver_id" id="receiver">
                    <option value="">{{get_phrase('Select a user')}}</option>
                    @foreach(App\Models\User::where('id', '!=', auth()->user()->id)->get() as $user)
                        <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group mb-5">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Next') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    "use strict";

    $('.ol-select2').select2({
        dropdownParent: $("#ajaxModal")
    });
</script>