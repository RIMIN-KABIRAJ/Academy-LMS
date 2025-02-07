@php
    $reviews = App\Models\Review::join('users', 'reviews.user_id', '=', 'users.id')
        ->select(
            'reviews.*',
            'reviews.user_id as reviewer_id',
            'users.name as reviewer_name',
            'users.email as reviewer_email',
            'users.photo as reviewer_photo',
        )
        ->where('reviews.course_id', $course_details->id)
        ->where('reviews.review_type', 'course')
        ->latest('id')
        ->get();
@endphp

<div class="ps-box p-0 shadow-none">
    <h4 class="g-title mb-20">{{ get_phrase('Reviews') }}</h4>
    <div class="review">

        <div class="write-review mb-5">
            <form action="{{ route('review.store') }}" method="POST">@csrf

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <p class="description">{{ get_phrase('Rate this course : ') }}</p>
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-4">
                        <ul class="d-flex gap-1 rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <li>
                                    <i class="fa-regular fa-star rating-star" id="id-{{ $i }}"></i>
                                </li>
                            @endfor
                        </ul>
                        <span class="gradient" id="remove-stars">{{ get_phrase('Remove all') }}</span>
                    </div>
                </div>

                <input type="hidden" name="rating" value="0">
                <input type="hidden" name="course_id" value="{{ $course_details->id }}">
                <textarea type="text" name="review" class="form-control mb-3" rows="5"
                    placeholder="{{ get_phrase('Write a reveiw ...') }}" required></textarea>
                <input type="submit" class="eBtn gradient border-none w-100">
            </form>
        </div>

        <div class="reviews">
            @foreach ($reviews as $review)
                <div class="E-review" id="review-{{ $review->id }}">
                    <div class="istructor-info">
                        <div class="ins-left">
                            <img src="{{ get_image($review->reviewer_photo) }}" alt="reviewer-img">
                            <div class="ins-designation">
                                <h5>{{ $review->reviewer_name }}</h5>
                                <ul class="d-flex re-star">
                                    @for ($i = 0; $i < 5; $i++)
                                        <li>
                                            <i
                                                class="@if ($i < $review->rating) fa fa-star @else fa-regular fa-star @endif">
                                            </i>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                        <div class="ins-right flex-column align-items-end">
                            @auth
                                @php
                                    $status = App\Models\LikeDislikeReview::where('review_id', $review->id)
                                        ->where('user_id', auth()->user()->id)
                                        ->first();
                                @endphp
                                <div class="action">
                                    <a onclick="ajaxModal('{{ route('modal', ['frontend.default.course.review_edit', 'id' => $review]) }}', '{{ get_phrase('Add new category') }}')"
                                        class="" href="javascript: void(0);">{{ get_phrase('Edit') }}</a>
                                    <a onclick="confirmModal('{{ route('review.delete', $review->id) }}')"
                                        class="@isset($status->disliked) active @endisset"
                                        data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}"
                                        href="javascript: void(0);">{{ get_phrase('Delete') }}</a>
                                </div>
                            @endauth
                            <p>{{ date('d M, Y', strtotime($review->created_at)) }}</p>
                        </div>
                    </div>
                    <p class="description mb-20">{{ $review->review }}</p>
                    <ul class="entry-like d-flex align-items-center">
                        @php
                            $total_likes = App\Models\LikeDislikeReview::where('review_id', $review->id)
                                ->where('liked', 1)
                                ->count();
                        @endphp
                        <li>
                            {{ $total_likes }}
                            <a href="{{ route('review.like', $review->id) }}" id="liked"
                                class="@if (isset($status) && $status->liked == 1) active @endif">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.00964 17.0834V7.0626L10.5032 2.6732C10.7383 2.43816 10.9925 2.29419 11.266 2.2413C11.5395 2.18841 11.7901 2.23276 12.0176 2.37432C12.2452 2.51588 12.4054 2.73008 12.4984 3.01693C12.5913 3.30379 12.5972 3.61495 12.516 3.95041L11.7852 7.0626H17.1602C17.5705 7.0626 17.938 7.22499 18.2628 7.54978C18.5876 7.87456 18.75 8.24208 18.75 8.65235V9.99847C18.75 10.0859 18.7457 10.1796 18.7372 10.2796C18.7286 10.3796 18.7035 10.4659 18.6619 10.5385L16.2737 16.1324C16.1681 16.4128 15.9726 16.6413 15.6872 16.8182C15.4017 16.995 15.1038 17.0834 14.7935 17.0834H6.00964ZM7.36379 7.61547V15.7501H14.734C14.7927 15.7501 14.8528 15.734 14.9143 15.702C14.9757 15.6699 15.0225 15.6165 15.0545 15.5417L17.4167 10.0626V8.65235C17.4167 8.57755 17.3926 8.51612 17.3446 8.46803C17.2965 8.41995 17.235 8.39591 17.1602 8.39591H10.0801L11.1459 3.91193L7.36379 7.61547ZM3.67312 17.0834C3.23594 17.0834 2.86169 16.9277 2.55037 16.6164C2.23904 16.3051 2.08337 15.9308 2.08337 15.4936V8.65235C2.08337 8.21517 2.23904 7.84092 2.55037 7.5296C2.86169 7.21826 3.23594 7.0626 3.67312 7.0626H6.00964L6.03048 8.39591H3.67312C3.59833 8.39591 3.5369 8.41995 3.48881 8.46803C3.44073 8.51612 3.41669 8.57755 3.41669 8.65235V15.4936C3.41669 15.5684 3.44073 15.6299 3.48881 15.6779C3.5369 15.726 3.59833 15.7501 3.67312 15.7501H6.03048V17.0834H3.67312Z"
                                        fill="#6B7385" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            @php
                                $total_dislikes = App\Models\LikeDislikeReview::where('review_id', $review->id)
                                    ->where('disliked', 1)
                                    ->count();
                            @endphp
                            {{ $total_dislikes }}
                            <a href="{{ route('review.dislike', $review->id) }}" id="disliked"
                                class="@if (isset($status) && $status->disliked == 1) active @endif">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.83973 12.9373C2.42947 12.9373 2.06194 12.7749 1.73717 12.4501C1.41239 12.1253 1.25 11.7578 1.25 11.3475V10.0014C1.25 9.91396 1.25427 9.82025 1.26281 9.72028C1.27135 9.62032 1.29646 9.53401 1.33813 9.46136L3.72631 3.86748C3.83184 3.58714 4.02733 3.35855 4.31279 3.18173C4.59826 3.00491 4.89615 2.9165 5.20644 2.9165H13.9903V12.9373L9.49675 17.3267C9.26171 17.5617 9.00744 17.7057 8.73394 17.7586C8.46044 17.8115 8.20991 17.7671 7.98235 17.6256C7.7548 17.484 7.59455 17.2698 7.50161 16.983C7.40865 16.6961 7.40277 16.3849 7.48398 16.0495L8.21473 12.9373H2.83973ZM12.6362 12.3844V4.24982H5.266C5.20724 4.24982 5.14714 4.26584 5.08571 4.2979C5.02426 4.32996 4.97751 4.38338 4.94546 4.45817L2.58329 9.93732V11.3475C2.58329 11.4223 2.60733 11.4838 2.65542 11.5319C2.7035 11.5799 2.76494 11.604 2.83973 11.604H9.91983L8.85413 16.088L12.6362 12.3844ZM16.3269 2.9165C16.764 2.9165 17.1383 3.07217 17.4496 3.3835C17.7609 3.69482 17.9166 4.06907 17.9166 4.50625V11.3475C17.9166 11.7847 17.7609 12.159 17.4496 12.4703C17.1383 12.7816 16.764 12.9373 16.3269 12.9373H13.9903L13.9695 11.604H16.3269C16.4016 11.604 16.4631 11.5799 16.5112 11.5319C16.5593 11.4838 16.5833 11.4223 16.5833 11.3475V4.50625C16.5833 4.43146 16.5593 4.37002 16.5112 4.32194C16.4631 4.27386 16.4016 4.24982 16.3269 4.24982H13.9695V2.9165H16.3269Z"
                                        fill="#6B7385" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
        @if ($reviews->count() > 6)
            <a href="javascript: void(0);" class="see-more d-inline-block mt-4" id="see-more">
                {{ get_phrase('See More') }}<i class="fa-solid fa-angle-right me-2"></i>
            </a>
        @endif
    </div>
</div>

@push('js')
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
                    $('#id-' + i).removeClass('fa-regular').addClass('fa');
                }
            });

            $('#remove-stars').on('click', function(e) {
                e.preventDefault();
                rating_stars.removeClass('fa fa-regular').addClass('fa-regular');
                $('.write-review input[name="rating"]').val(0);
            });

            $('#see-more').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');

                let items = $('.reviews .E-review').length;

                if ($(this).hasClass('active')) {
                    $('.reviews').css('max-height', (items * 189) + 'px');
                    $(this).text('Show Less');
                } else {
                    $('.reviews').css('max-height', 910 + 'px');
                    $(this).html('Show More <i class="fa-solid fa-chevron-right"></i>');
                }
            });
        });
    </script>
@endpush
