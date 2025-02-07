<div class="comment-entry">
    <div class="single-comment d-flex">
        <div class="cUser-img">
            <img src="{{ get_image($comment->commentator_photo) }}" alt="commentator-photo">
        </div>
        <div class="cUser-info">
            <h5>{{ $comment->commentator_name }}</h5>
            <div class="date-pack">
                <p>
                    {{ date('d M, Y', strtotime($comment->created_at)) }}
                    {{ get_phrase('at') }}
                    {{ date('h:i A', strtotime($comment->created_at)) }}
                </p>

                @isset(auth()->user()->id)
                    <p class="replay cursor-pointer" id="{{ $comment->id }}">
                        {{ get_phrase('Reply') }}</p>

                    @if ($comment->user_id == auth()->user()->id)
                        <a onclick="ajaxModal('{{ route('modal', ['frontend.default.blog.comment_edit', 'id' => $comment->id]) }}', '{{ get_phrase('Edit comment') }}')"
                            href="javascript: void(0);">{{ get_phrase('Edit') }}</a>
                        <a onclick="confirmModal('{{ route('blog.comment.delete', $comment->id) }}')"
                            data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}"
                            href="javascript: void(0);">{{ get_phrase('Delete') }}</a>
                    @endif
                @endisset
            </div>
            <p class="description">{{ $comment->comment }}</p>
        </div>
    </div>

    @php
        $replies = App\Models\BlogComment::join('users', 'blog_comments.user_id', '=', 'users.id')
            ->select('blog_comments.*', 'users.name as replier_name', 'users.photo as replier_photo')
            ->where('blog_comments.parent_id', $comment->id)
            ->get();
    @endphp
    @foreach ($replies as $replay)
        @include('frontend.default.blog.comment_replay')
    @endforeach
</div>
<form action="{{ route('blog.comment.store') }}" class="replay-form d-none" id="replay-{{ $comment->id }}"
    method="POST">@csrf
    <input type="hidden" name="blog_id" value="{{ $blog_details->id }}">
    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
    <textarea type="text" name="comment" class="form-control mb-3" rows="5"
        placeholder="{{ get_phrase('Replay to the comment ...') }}"required></textarea>
    <input type="submit" class="eBtn gradient border-none" value="{{ get_phrase('Comment') }}">
</form>
