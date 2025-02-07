@php
    $review = App\Models\Review::where('id', $id)
        ->where('user_id', auth()->user()->id)
        ->first();
@endphp

@if ($review)
    <div class="write-review mb-5">
        <form action="{{ route('review.update', $id) }}" method="POST">@csrf
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="description">{{ get_phrase('Rate this course : ') }}</p>
                <div class="d-flex align-items-center justify-content-end gap-4">
                    <ul class="d-flex gap-1 rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <li>
                                <i class="@if ($i <= $review->rating) fa @else fa-regular @endif fa-star rating-star" id="me-{{ $i }}"></i>
                            </li>
                        @endfor
                    </ul>
                    <span class="gradient" id="remove-stars">{{ get_phrase('Remove all') }}</span>
                </div>
            </div>

            <input type="hidden" name="rating" value="0">
            <input type="hidden" name="course_id" value="{{ $review->course_id }}">
            <textarea type="text" name="review" class="form-control mb-3" rows="5" placeholder="{{ get_phrase('Write a reveiw ...') }}"required>{{ $review->review }}</textarea>
            <input type="submit" class="eBtn gradient border-none w-100" value="{{ get_phrase('Update') }}">
        </form>
    </div>
@else
    <p class="text-center">{{ get_phrase('Data not found.') }}</p>
@endif

<!-- Jquery Js -->
<script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>
<script>
    "use strict";
    $(document).ready(function() {
        let rating_stars = $('.rating-stars i');

        rating_stars.on('click', function(e) {
            e.preventDefault();
            let star = $(this).attr('id').substring(3);
            $('.write-review input[name="rating"]').val(star);

            rating_stars.removeClass('fa').addClass('fa-regular');
            for (let i = 1; i <= star; i++) {
                console.log('#item_id-' + i);
                $('#me-' + i).removeClass('fa-regular').addClass('fa');
            }
        });

        $('#remove-stars').on('click', function(e) {
            e.preventDefault();
            rating_stars.removeClass('fa fa-regular').addClass('fa-regular');
            $('.write-review input[name="rating"]').val(0);
        });
    });
</script>
