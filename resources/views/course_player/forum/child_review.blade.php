@php
    $replies = App\Models\Forum::join('users', 'forums.user_id', 'users.id')
        ->select('forums.*', 'users.name as user_name', 'users.photo as user_photo')
        ->latest('forums.id')
        ->where('forums.parent_id', $question->id)
        ->get();
@endphp
<div class="child-review ps-5">
    @foreach ($replies as $child)
        <div class="child-review mb-3">
            <div class="user">
                <div class="image">
                    <img src="{{ get_image($child->user_photo) }}">
                </div>
                <h1 class="w-100 d-flex flex-column">
                    <span>{{ $child->user_name }}</span>
                    <small>{{ timeAgo($child->created_at) }}</small>

                </h1>

                @if ($child->user_id == auth()->user()->id)
                    <div class="d-flex gap-3">
                        <a href="javascript:void(0)" class="show-form" id="reply-edit" data-reply-id="{{ $child->id }}">
                            <div class="edit edit">
                                <i class="fi fi-rr-edit d-inline-flex"></i>
                            </div>
                        </a>

                        <a href="{{ route('forum.question.delete', $child->id) }}">
                            <i class="fi fi-rr-trash d-inline-flex"></i></a>
                    </div>
                @endif
            </div>
            <div class="">
                <p>{{ strip_tags($child->description) }}</p>
            </div>
        </div>
    @endforeach
</div>
