<form action="{{ route('admin.reply') }}" method="post">
    @csrf
    <input type="hidden" name="send_to" value="{{ $user_id }}">
    <input type="hidden" name="subject" value="{{ get_phrase('Send reply') }}">
    <div class="fpb-7 mb-3">
        <textarea class="form-control ol-form-control" name="reply_message" rows="10"></textarea>
    </div>
    <div>
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Send reply') }}</button>
    </div>
</form>
