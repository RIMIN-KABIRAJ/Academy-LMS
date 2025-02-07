
<div class="messenger-area">
    <div class="messenger-header d-flex align-items-center justify-content-between">
        <div class="user-wrap d-flex align-items-center">
            <div class="profile">
                <img src="{{ get_image($thread_details->user->photo) }}" alt="">
            </div>
            <div class="name-status">
                <h6 class="name">{{ $thread_details->user->name }}</h6>
                <!-- for offline just remove active class  -->
                <span class="text-12px">
                    {{ $thread_details->user->email }}
                </span>
            </div>
        </div>
    </div>
    <ul class="messenger-body" id="scrollAbleContent">
        @php
            $my_data = auth()->user();
        @endphp
        @foreach ($thread_details->messages as $message)

            @if ($message->sender_id == $my_data->id)
                <li>
                    <div class="single-message recipient-user">
                        <div class="user-wrap mb-3 d-flex align-items-center">
                            <div class="profile">
                                <img src="{{ get_image($my_data->photo) }}" alt="">
                            </div>
                            <div class="name-time d-flex align-items-center flex-wrap">
                                <h6 class="name">{{$my_data->name}}</h6>
                                <p class="time">{{timeAgo($message->created_at)}}</p>
                            </div>
                        </div>
                        <p class="message">{{$message->message}}</p>
                    </div>
                </li>
            @else
                <li>
                    <div class="single-message ">
                        <div class="user-wrap mb-3 d-flex align-items-center">
                            <div class="profile">
                                <img src="{{ get_image($thread_details->user->photo) }}" alt="">
                            </div>
                            <div class="name-time d-flex align-items-center flex-wrap">
                                <h6 class="name">{{$thread_details->user->name}}</h6>
                                <p class="time">{{timeAgo($message->created_at)}}</p>
                            </div>
                        </div>
                        <p class="message">{{$message->message}}</p>
                    </div>
                </li>
            @endif
        @endforeach
    </ul>
    <div class="messenger-footer">
        <form action="{{route('admin.message.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sender_id" value="{{$my_data->id}}">
            <input type="hidden" name="receiver_id" value="{{$thread_details->user->id}}">
            <input type="hidden" name="thread_id" value="{{$thread_details->id}}">

            <div class="messenger-footer-inner d-flex align-items-center">
                <input type="text" name="message" class="form-control form-control-message" placeholder="Type your message here...">

                <button type="submit" class="btn ol-btn-primary d-flex align-items-center cg-10px">
                    <span class="fi-rr-rocket"></span>
                    <span>{{get_phrase('Send')}}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    "use strict";

    let divElement = document.getElementById('scrollAbleContent');
    // Scroll to the bottom of the div
    divElement.scrollTop = divElement.scrollHeight;
</script>
