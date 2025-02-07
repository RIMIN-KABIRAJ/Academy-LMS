<div class="questions d-flex flex-column gap-4">
    @foreach ($questions as $question)
        <div class="review">
            <div class="parent-review">
                <div class="user">
                    <div class="image">
                        <img src="{{ get_image($question->user_photo) }}">
                    </div>
                    <h1 class="w-100 d-flex flex-column">
                        <span>{{ $question->user_name }}</span>
                        <small>{{ timeAgo($question->created_at) }}</small>
                    </h1>
                    <div class="three-dot">
                        <span class="icon">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </span>

                        <ul class="group-menu">
                            @if ($question->user_id == auth()->user()->id)
                                <li>
                                    <a href="javascript:void(0)" class="show-form" id="edit-question"
                                        data-question-id="{{ $question->id }}">
                                        <i class="fi fi-rr-edit d-inline-flex"></i>
                                        <span>{{ get_phrase('Edit') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if ($question->user_id == auth()->user()->id)
                                <li>
                                    <a href="{{ route('forum.question.delete', $question->id) }}">
                                        <i class="fi fi-rr-trash d-inline-flex"></i>
                                        <span>{{ get_phrase('Delete') }}</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="fi fi-rr-exclamation d-inline-flex"></i>
                                    <span>{{ get_phrase('Report') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="">
                    @php
                        $likes = $question->likes ? json_decode($question->likes, true) : [];
                        $dislikes = $question->dislikes ? json_decode($question->dislikes, true) : [];
                    @endphp

                    <h5 class="mt-3 fs-6 mb-3">{{ $question->title }}</h5>
                    <p class="m-0">{!! removeScripts($question->description) !!}</p>
                    <div class="d-flex gap-4">
                        <a href="{{ route('forum.question.likes', $question->id) }}">

                            <div
                                class="d-flex align-items-center gap-1 like @if (in_array(auth()->user()->id, $likes)) active @endif">
                                <span class="d-inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24"
                                        width="512" height="512">
                                        <path
                                            d="M22.773,7.721A4.994,4.994,0,0,0,19,6H15.011l.336-2.041A3.037,3.037,0,0,0,9.626,2.122L7.712,6H5a5.006,5.006,0,0,0-5,5v5a5.006,5.006,0,0,0,5,5H18.3a5.024,5.024,0,0,0,4.951-4.3l.705-5A5,5,0,0,0,22.773,7.721ZM2,16V11A3,3,0,0,1,5,8H7V19H5A3,3,0,0,1,2,16Zm19.971-4.581-.706,5A3.012,3.012,0,0,1,18.3,19H9V7.734a1,1,0,0,0,.23-.292l2.189-4.435A1.07,1.07,0,0,1,13.141,2.8a1.024,1.024,0,0,1,.233.84l-.528,3.2A1,1,0,0,0,13.833,8H19a3,3,0,0,1,2.971,3.419Z" />
                                    </svg>
                                </span>
                                <span>{{ get_phrase('Like') }} </span>
                                <span>{{ count($likes) > 0 ? format_count(count($likes)) : '' }}</span>
                            </div>
                        </a>
                        <a href="{{ route('forum.question.dislikes', $question->id) }}">

                            <div
                                class="d-flex align-items-center gap-1 dislike @if (in_array(auth()->user()->id, $dislikes)) active @endif">
                                <span class="d-inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24"
                                        width="512" height="512">
                                        <path
                                            d="M23.951,12.3l-.705-5A5.024,5.024,0,0,0,18.3,3H5A5.006,5.006,0,0,0,0,8v5a5.006,5.006,0,0,0,5,5H7.712l1.914,3.878a3.037,3.037,0,0,0,5.721-1.837L15.011,18H19a5,5,0,0,0,4.951-5.7ZM5,5H7V16H5a3,3,0,0,1-3-3V8A3,3,0,0,1,5,5Zm16.264,9.968A3,3,0,0,1,19,16H13.833a1,1,0,0,0-.987,1.162l.528,3.2a1.024,1.024,0,0,1-.233.84,1.07,1.07,0,0,1-1.722-.212L9.23,16.558A1,1,0,0,0,9,16.266V5h9.3a3.012,3.012,0,0,1,2.97,2.581l.706,5A3,3,0,0,1,21.264,14.968Z" />
                                    </svg>
                                </span>
                                <span>{{ get_phrase('Dislike') }} </span>
                                <span>{{ count($dislikes) > 0 ? format_count(count($dislikes)) : '' }}</span>
                            </div>
                        </a>

                        <a href="javascript:void(0)" class="show-form" id="reply"
                            data-parent-question-id="{{ $question->id }}">
                            <div class="reply">
                                <span class="d-inline-flex">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.87435 10.6253L7.91602 12.667C8.06879 12.8198 8.14518 12.9969 8.14518 13.1982C8.14518 13.3996 8.06879 13.58 7.91602 13.7395C7.76324 13.8856 7.58615 13.9587 7.38477 13.9587C7.18338 13.9587 7.00629 13.8823 6.85352 13.7295L3.52018 10.3962C3.3674 10.2484 3.29102 10.0761 3.29102 9.87912C3.29102 9.68215 3.3674 9.50727 3.52018 9.35449L6.85352 6.02116C7.00629 5.86838 7.18454 5.79199 7.38824 5.79199C7.59194 5.79199 7.76786 5.86838 7.91602 6.02116C8.06879 6.16931 8.14518 6.34524 8.14518 6.54893C8.14518 6.75264 8.06879 6.93088 7.91602 7.08366L5.87435 9.12533H12.9993C14.106 9.12533 15.0493 9.51533 15.8293 10.2953C16.6094 11.0753 16.9993 12.0187 16.9993 13.1253V15.3753C16.9993 15.5878 16.9279 15.766 16.785 15.9097C16.6421 16.0535 16.465 16.1253 16.2537 16.1253C16.0425 16.1253 15.8639 16.0535 15.7181 15.9097C15.5723 15.766 15.4993 15.5878 15.4993 15.3753V13.1253C15.4993 12.4309 15.2563 11.8406 14.7702 11.3545C14.2841 10.8684 13.6938 10.6253 12.9993 10.6253H5.87435Z"
                                            fill="#6B7385" />
                                    </svg>
                                </span>
                                <span>{{ get_phrase('Reply') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            @include('course_player.forum.child_review')
        </div>
    @endforeach
</div>
