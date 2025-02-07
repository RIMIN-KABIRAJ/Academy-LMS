    <div class="msg-sidebar">
        <div class="message-intro position-relative">
            <div class="search-box">
                <form action="" class="Esearch_entry">
                    @csrf
                    <input type="text" name="user_email" id="search_student" class="form-control" placeholder="{{get_phrase('Search email')}}">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <ul class="" id="msg-search-list">
                    <li>{{ get_phrase('Search user email...') }}</li>
                </ul>
            </div>
        </div>
        <div class="message-left">
            <div class="contacts d-flex flex-column">
                @php
                    $my_id = auth()->user()->id;
                    $my_threads = App\Models\MessageThread::where('contact_one', $my_id)->orWhere('contact_two', $my_id)->orderBy('updated_at', 'desc')->get();
                @endphp
                @foreach ($my_threads as $thread)
                    @php
                        $last_message = $thread->messages()->orderBy('id', 'desc')->firstOrNew();
                        $number_of_unread_message = $thread->messages()->where('read', '!=', 1)->count();
                    @endphp

                    <a href="{{ route('message', ['inbox' => $thread->code, 'instructor' => $thread->user->id]) }}" class="contact border-start mb-3 @if ($thread->code == request()->query('inbox')) active @endif">
                        <div class="ins-nav">

                            <div class="ins-left align-items-start">
                                <div class="active-image no-status">
                                    <img class="image-30" src="{{ get_image($thread->user->photo) }}" alt="user-photo">
                                </div>
                                <div class="ins-figure">
                                    <h4>{{ ucfirst($thread->user->name) }}</h4>
                                    <small class=" text-12px">{{ timeAgo($last_message->created_at) }}</small>
                                </div>
                            </div>

                        </div>
                        <div class="text-start w-100 text-12px mt-1 px-1">
                            <span class="ellipsis-1 text-12px">{{ $last_message->message }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
