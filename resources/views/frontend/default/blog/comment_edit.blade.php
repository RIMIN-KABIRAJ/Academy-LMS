@php
    $comment_details = App\Models\BlogComment::where('id', $id)
        ->where('user_id', auth()->user()->id)
        ->first();
@endphp

@if ($comment_details)
    <div class="write-review mb-5">
        <form action="{{ route('blog.comment.update', $id) }}" method="POST">@csrf
            <textarea type="text" name="comment" class="form-control mb-3" rows="5"
                placeholder="{{ get_phrase('Write your comment ...') }}"required>{{ $comment_details->comment }}</textarea>
            <input type="submit" class="eBtn gradient border-none w-100" value="{{ get_phrase('Update') }}">
        </form>
    </div>
@else
    <p class="text-center">{{ get_phrase('Data not found.') }}</p>
@endif
