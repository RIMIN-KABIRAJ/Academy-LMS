<style>
    .search-item {
        display: inline-block;
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        background: #fff !important;
        transition: .3s;
    }

    .search-item:hover {
        background: #f4f7fd !important
    }
</style>

@if ($user_details)
    <a href="{{ route('message.inbox', $user_details->id) }}" class="search-item">
        <div class="ins-nav">
            <div class="ins-left">
                <div class="active-image">
                    <img src="{{ get_image($user_details->photo) }}" alt="user-photo">
                </div>
                <div class="ins-figure">
                    <h4>{{ $user_details->name }}</h4>
                    <p class="ellipsis-1 w-100">{{ $user_details->email }}</p>
                </div>
            </div>
        </div>
    </a>
@else
    <li class="ins-figure p">{{ get_phrase('Search not found...') }}</li>
@endif
