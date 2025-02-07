<div class="message-send-option d-flex align-items-center g-12 pt-40">
    <div class="message-input d-flex justify-content-start align-items-center">
        <form action="{{ route('message.store') }}" method="post" class="w-100" enctype="multipart/form-data">@csrf
            <div><input type="hidden" name="receiver_id" id="receiver_id" value="{{ $contact_details->id }}">
                <input type="hidden" name="thread" id="thread" value="{{ $thread_info->id }}">
                <textarea name="message" id="type-msg" cols="30" rows="2" class="form-control ol-form-control" placeholder="{{ get_phrase('Type something ...') }}"></textarea>
            </div>
            <ul class="ic-control d-flex ">
                <li>
                    <label for="gallery"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.49935 18.3334H12.4993C16.666 18.3334 18.3327 16.6667 18.3327 12.5001V7.50008C18.3327 3.33341 16.666 1.66675 12.4993 1.66675H7.49935C3.33268 1.66675 1.66602 3.33341 1.66602 7.50008V12.5001C1.66602 16.6667 3.33268 18.3334 7.49935 18.3334Z" stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M7.50065 8.33333C8.42113 8.33333 9.16732 7.58714 9.16732 6.66667C9.16732 5.74619 8.42113 5 7.50065 5C6.58018 5 5.83398 5.74619 5.83398 6.66667C5.83398 7.58714 6.58018 8.33333 7.50065 8.33333Z" stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M2.22461 15.7916L6.33294 13.0332C6.99128 12.5916 7.94128 12.6416 8.53294 13.1499L8.80794 13.3916C9.45794 13.9499 10.5079 13.9499 11.1579 13.3916L14.6246 10.4166C15.2746 9.85822 16.3246 9.85822 16.9746 10.4166L18.3329 11.5832" stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </label>
                    <input type="file" name="media_files[]" id="gallery" class="d-none" multiple="multiple">
                </li>
            </ul>
        </form>
    </div>
    <button class="send_message_btn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.39969 6.31991L15.8897 3.48991C19.6997 2.21991 21.7697 4.29991 20.5097 8.10991L17.6797 16.5999C15.7797 22.3099 12.6597 22.3099 10.7597 16.5999L9.91969 14.0799L7.39969 13.2399C1.68969 11.3399 1.68969 8.22991 7.39969 6.31991Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            </path>
            <path d="M10.1094 13.6501L13.6894 10.0601" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </button>
</div>
