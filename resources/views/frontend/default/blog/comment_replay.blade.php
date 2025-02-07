<div class="reply-comment">
    <div class="single-comment d-flex">
        <div class="cUser-img">
            <img src="{{ get_image($replay->replier_photo) }}" alt="replier-photo">
        </div>
        <div class="cUser-info">
            <h5>{{ $replay->replier_name }}</h5>
            <div class="date-pack">
                <p>
                    {{ date('d M, Y', strtotime($replay->created_at)) }}
                    {{ get_phrase('at') }}
                    {{ date('h:i A', strtotime($replay->created_at)) }}
                </p>

                @isset(auth()->user()->id)
                    @if ($replay->user_id == auth()->user()->id)
                        <a onclick="ajaxModal('{{ route('modal', ['frontend.default.blog.comment_edit', 'id' => $replay->id]) }}', '{{ get_phrase('Edit comment') }}')"
                            href="javascript: void(0);">{{ get_phrase('Edit') }}</a>
                        <a onclick="confirmModal('{{ route('blog.comment.delete', $replay->id) }}')" data-bs-toggle="tooltip"
                            title="{{ get_phrase('Delete') }}" href="javascript: void(0);">{{ get_phrase('Delete') }}</a>
                    @endif
                @endisset
            </div>
            <p class="description">{{ $replay->comment }}</p>
        </div>
    </div>
</div>
