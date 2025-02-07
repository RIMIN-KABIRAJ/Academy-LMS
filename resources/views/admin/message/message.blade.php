@extends('layouts.admin')
@push('title', get_phrase('Private Message'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="row g-4">
        <div class="col-xl-5 col-lg-6 col-md-5">
            <div class="message-sidebar-area">
                <div class="message-sidebar-header">
                    <div class="back-and-plus mb-3 d-flex align-items-center justify-content-between flex-wrap">
                        <div class="back-title d-flex align-items-center">
                            <p class="title fs-16px">{{ get_phrase('Chat List') }}</p>
                        </div>
                        <a href="#" onclick="ajaxModal('{{ route('modal', ['view_path' => 'admin.message.message_new']) }}', '{{ get_phrase('Create a new thread') }}')" data-bs-toggle="tooltip" title="{{ get_phrase('New message') }}" class="btn ol-btn-light ol-icon-btn ol-icon-btn-sm">
                            <span class="fi-rr-plus"></span>
                        </a>
                    </div>
                    <!-- Search -->
                    <form action="">
                        <div class="message-sidebar-search">
                            <label for="message-sideSearch" class="form-label sideSearch-label">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.58464 18.7918C4.8763 18.7918 1.04297 14.9584 1.04297 10.2501C1.04297 5.54175 4.8763 1.70842 9.58464 1.70842C14.293 1.70842 18.1263 5.54175 18.1263 10.2501C18.1263 14.9584 14.293 18.7918 9.58464 18.7918ZM9.58464 2.95842C5.55964 2.95842 2.29297 6.23342 2.29297 10.2501C2.29297 14.2668 5.55964 17.5418 9.58464 17.5418C13.6096 17.5418 16.8763 14.2668 16.8763 10.2501C16.8763 6.23342 13.6096 2.95842 9.58464 2.95842Z" fill="#4B5675"></path>
                                    <path d="M18.3315 19.6249C18.1732 19.6249 18.0148 19.5666 17.8898 19.4416L15.1148 16.5499C14.8732 16.3082 14.8732 15.9082 15.1148 15.6665C15.3565 15.4249 15.7565 15.4249 15.9982 15.6665L18.7732 18.5582C19.0148 18.7999 19.0148 19.1999 18.7732 19.4416C18.6482 19.5666 18.4898 19.6249 18.3315 19.6249Z" fill="#4B5675"></path>
                                </svg>
                            </label>
                            <input type="search" class="form-control" onkeyup="loadView('{{ route('view', ['path' => 'admin.message.message_left_side_bar']) }}?thread_code={{ $thread_code ? $thread_code : '' }}&search='+$(this).val(), '#message-user-list')" id="message-sideSearch" placeholder="{{ get_phrase('Search Here') }}">
                            <button type="submit" hidden=""></button>
                        </div>
                    </form>
                </div>
                <!-- Messages -->
                <ul class="message-sidebar-messages" id="message-user-list">
                    @include('admin.message.message_left_side_bar')
                </ul>
            </div>
        </div>
        <div class="col-xl-7 col-lg-6 col-md-7">
            @if ($thread_details)
                @include('admin.message.message_body')
            @else
                @include('admin.no_data')
            @endif
        </div>
    </div>
@endsection
@push('js')
@endpush
