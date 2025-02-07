<style>
    .button {
        display: flex;
        align-items: center;
        gap: 6.5px;
        font-weight: 500;
    }

    .heading h1 {
        margin-top: 30px;
        font-weight: 600;
        font-size: 18px;
        color: #192335;
    }

    h1 {
        font-weight: 600;
        font-size: 18px;
        color: #192335;
    }

    .search-box input {
        margin-top: 12px;
        margin-bottom: 30px;
    }

    .summernote h1 {
        margin-bottom: 12px;
    }

    .summernote button {
        margin-top: 20px;
    }
</style>

<div class="">
    <form action="{{ route('forum.question.store') }}" method="POST">
        @csrf
        <input type="hidden" name="title" value="reply">
        <input type="hidden" name="parent_id" value="{{ $parent_question_id }}">
        <div class="search-box">
            <div class="summernote">
                <h1>{{ get_phrase('Reply') }}</h1>
                <textarea name="description" class="form-control" id="summernote" cols="30" rows="10"></textarea>
            </div>

            <div class="d-flex align-items-center justify-content-end gap-3 mt-4">
                <button class="eBtn gradient border-0 d-flex align-items-center gap-3" id="questions">
                    <span class="button">
                        <svg width="12" height="11" viewBox="0 0 12 11" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M-4.25114e-06 5.5C0.00405081 5.93842 0.180699 6.35758 0.491663 6.66666L4.06666 10.25C4.2228 10.4052 4.43401 10.4923 4.65416 10.4923C4.87432 10.4923 5.08553 10.4052 5.24166 10.25C5.31977 10.1725 5.38177 10.0804 5.42407 9.97881C5.46638 9.87726 5.48816 9.76834 5.48816 9.65833C5.48816 9.54832 5.46638 9.4394 5.42407 9.33785C5.38177 9.2363 5.31977 9.14413 5.24166 9.06666L2.5 6.33333L10.8333 6.33333C11.0543 6.33333 11.2663 6.24553 11.4226 6.08925C11.5789 5.93297 11.6667 5.72101 11.6667 5.5C11.6667 5.27898 11.5789 5.06702 11.4226 4.91074C11.2663 4.75446 11.0543 4.66666 10.8333 4.66666L2.5 4.66666L5.24166 1.925C5.39858 1.76918 5.48718 1.55741 5.48796 1.33628C5.48874 1.11514 5.40164 0.902751 5.24583 0.745831C5.09001 0.588911 4.87824 0.500314 4.65711 0.499533C4.43597 0.498751 4.22358 0.58585 4.06666 0.741665L0.491662 4.325C0.178672 4.63612 0.00185633 5.05868 -4.25114e-06 5.5Z"
                                fill="white" />
                        </svg>
                    </span>
                    <span>{{ get_phrase('Back') }}</span>
                </button>
                <button type="submit" class="eBtn gradient border-0">
                    {{ get_phrase('Publish') }}
                </button>
            </div>
        </div>
    </form>
</div>
