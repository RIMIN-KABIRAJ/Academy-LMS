@php
    $participants = DB::table('quiz_submissions')
        ->join('users', 'quiz_submissions.user_id', 'users.id')
        ->where('quiz_submissions.quiz_id', $id)
        ->select('users.name', 'users.id')
        ->distinct('quiz_submissions.user_id')
        ->get();
@endphp

<form action="{{ route('admin.course.quiz.store') }}" method="post">@csrf
    <div class="row mb-3">
        <div class="col-sm-5 fpb-7">
            <label class="form-label ol-form-label">
                {{ get_phrase('Participants') }}
            </label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="participant">
                <option value="">{{ get_phrase('Select an option') }}</option>
                @foreach ($participants as $participant)
                    <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-5 fpb-7">
            <label class="form-label ol-form-label">
                {{ get_phrase('Submissions') }}
            </label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="submission">
                <option value="">{{ get_phrase('First select a participant') }}</option>
            </select>
        </div>

        <div class="col-sm-2 d-flex align-items-end flex-fill">
            <div class="fpb7">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Result') }}</button>
            </div>
        </div>
    </div>
</form>

<div class="result-preview"></div>

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
@include('admin.init')
