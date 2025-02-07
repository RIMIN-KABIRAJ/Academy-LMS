@php
    $participants = DB::table('quiz_submissions')
        ->join('users', 'quiz_submissions.user_id', 'users.id')
        ->where('quiz_submissions.quiz_id', $id)
        ->select('users.name', 'users.id')
        ->distinct('quiz_submissions.user_id')
        ->get();
@endphp

<style>
    .participants {
        min-height: 500px;
    }

    input[type="radio"]:checked {
        border-color: initial;
    }

    .gradient-border {
        background: #fff;
        border: 2px solid #2f57ef;
        color: #212529;
        transition: .3s;
    }

    .gradient-border:hover {
        color: #fff;
        background: #2f57ef;
    }

    .serial {
        width: 30px;
        height: 30px;
        background: #F2F3F5;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>


<div class="row">
    <div class="col-sm-3 border-end">
        <div class="participants">
            @foreach ($participants as $participant)
                <input type="radio" class="btn-check" name="participants" id="{{ $participant->id }}" autocomplete="off">
                <label class="btn btn-outline-dark border-0 w-100 text-capitalize fs-14px py-2"
                    for="{{ $participant->id }}" onclick="loadResult(this)">{{ $participant->name }}</label>
            @endforeach
        </div>
    </div>

    <div class="col-sm-9">
        <div class="result-preview"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('select[name="participant"]').change(function(e) {
            e.preventDefault();

            let userId = $(this).val();
            let quizId = "{{ $id }}";

            if (userId && quizId) {
                $.ajax({
                    type: "get",
                    url: "{{ route('admin.quiz.participant.result') }}",
                    data: {
                        quizId: quizId,
                        participant: userId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('select[name="submission"]').html(response);
                    }
                });
            }
        });

        $('select[name="submission"]').change(function(e) {
            e.preventDefault();

            let submitId = $(this).val();
            if (submitId) {
                $.ajax({
                    type: "get",
                    url: "{{ route('admin.quiz.result.preview') }}",
                    data: {
                        submitId: submitId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('.result-preview').html(response);
                    }
                });
            }
        });
    });
</script>

<script>
    function loadResult(elem) {
        let participantId = $(elem).attr('for');
        let quizId = "{{ $id }}";

        if (quizId && participantId) {
            $.ajax({
                type: "get",
                url: "{{ route('admin.quiz.result.preview') }}",
                data: {
                    quizId: quizId,
                    participantId: participantId,
                },
                success: function(response) {
                    $('.result-preview').html(response);
                }
            });
        }
    }
</script>
@include('admin.init')
