<li class="message message-for-me d-flex justify-content-start align-items-start g-14 flex-row-reverse">
    <div class="message-text">
        <ul class="message-list">
            <li>
                @if (!empty($conversation->message))
                    <p>{{ $conversation->message }}</p>
                @endif

                @php $send_files = get_files($conversation->id); @endphp
                @if ($send_files)
                    <div class="message-upload-images d-flex flex-wrap g-20">
                        @foreach ($send_files as $file)
                            <div class="message-upload-image">
                                <img src="{{ asset('uploads/message/' . $thread . '/' . $file->file_name) }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </li>
        </ul>
        <div class="message-user d-flex align-items-center g-20 flex-row-reverse pb-17">
            <p class="fz-13-m-grayish">{{ timeAgo($conversation->created_at) }}</p>
        </div>
    </div>
</li>
