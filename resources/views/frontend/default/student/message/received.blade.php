<li class="message message-to-me d-flex justify-content-start align-items-start g-14">
    <div class="message-text">
        <ul class="message-list">
            <li>
                @if (!empty($conversation->message))
                    <p>{{ $conversation->message }}</p>
                @endif

                @php $received_files = get_files($conversation->id); @endphp
                @if ($received_files)
                    <div class="message-upload-images d-flex flex-wrap g-20">
                        @foreach ($received_files as $file)
                            <div class="message-upload-image">
                                <img src="{{ asset('uploads/message/' . $thread . '/' . $file->file_name) }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </li>
        </ul>
        <div class="message-user  d-flex align-items-center g-20 pb-17">
            <p class="fz-13-m-grayish">{{ timeAgo($conversation->created_at) }}</p>
        </div>
    </div>
</li>
