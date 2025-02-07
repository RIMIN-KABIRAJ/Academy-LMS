@php
    $my_id = auth()->user()->id;
    if (isset($search)) {
        $my_threads = App\Models\MessageThread::where(function ($query) use ($my_id) {
            $query->where('contact_one', $my_id)->orWhere('contact_two', $my_id);
        })
            ->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
                });
            })
            ->orderBy('updated_at', 'desc')->get();
    } else {
        $my_threads = App\Models\MessageThread::where('contact_one', $my_id)->orWhere('contact_two', $my_id)->orderBy('updated_at', 'desc')->get();
    }

@endphp
@foreach ($my_threads as $thread)
    @php
        $last_message = $thread->messages()->orderBy('id', 'desc')->firstOrNew();
        $number_of_unread_message = $thread->messages()->where('read', '!=', 1)->count();
    @endphp
    <li>
        <a href="{{ route('admin.message', ['message_thread' => $thread->code]) }}" class="message-sidebar-message @if ($thread_code == $thread->code) active @endif">
            <div class="user">
                <img src="{{ get_image($thread->user->photo) }}" alt="">
            </div>
            <div class="details d-flex justify-content-between">
                <div class="name-message">
                    <h6 class="name">{{ $thread->user->name }}</h6>
                    <p class="message ellipsis-line-2">{{ ellipsis($last_message->message, 160) }}</p>
                </div>
                @if ($last_message->created_at)
                    <div class="time text-end">
                        @if($number_of_unread_message > 0)
                            <span class="badge bg-danger">{{$number_of_unread_message}}</span>
                        @endif
                        <p class="mt-2">{{ timeAgo($last_message->created_at) }}</p>
                    </div>
                @endif
            </div>
        </a>
    <li>
@endforeach
