@php
    $user = App\Models\User::where('id', $id)->first();
@endphp
@if ($user)
    <div class="d-flex flex-column align-items-center justify-content-center h-100 py-4 gap-5">
        <div class="preview-image">
            <img src="{{ get_image($user->photo) }}" alt="user-photo">
        </div>

        <form action="{{ route('update.profile.picture') }}" method="post" enctype="multipart/form-data">@csrf
            <div class="form-group d-flex gap-4">
                <input type="file" class="form-control" name="photo" id="profile-photo">
                <button type="submit" class="eBtn gradient border-none">{{ get_phrase('Upload') }}</button>
            </div>
        </form>
    </div>
@else
    <p class="py-4">{{ get_phrase('Data not found.') }}</p>
@endif

<script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>
<script>
    "use strict";
    $(document).ready(function() {
        $('#profile-photo').change(function(e) {
            e.preventDefault();

            var path = URL.createObjectURL(event.target.files[0]);
            $('.preview-image img').attr('src', path);
        });
    });
</script>
