<style>
    .min-w-150px {
        width: 150px;
    }
</style>

<!-- Mani section header and breadcrumb -->
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Review') }}
            </h4>

            <a href="{{ route('admin.review.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span>{{ get_phrase('Add new Review') }}</span>
            </a>
        </div>
    </div>
</div>
@php
    $user_reviews = DB::table('user_reviews')->get();
@endphp
<!-- Start Admin area -->
<div class="row">
    <div class="col-12">
        <div class="ol-card">
            <div class="ol-card-body p-3">
                <!-- Table -->
                @if (count($user_reviews) > 0)
                    <div class="table-responsive course_list" id="course_list">
                        <table class="table eTable eTable-2 print-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ get_phrase('Name') }}</th>
                                    <th scope="col">{{ get_phrase('Rating') }}</th>
                                    <th scope="col">{{ get_phrase('Review') }}</th>
                                    <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_reviews as $key => $review)
                                    @php
                                        $userInfo = App\Models\User::where('id', $review->user_id)->first();
                                        if (!$userInfo) {
                                            continue;
                                        }
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <p class="row-number">{{ $key + 1 }}</p>
                                        </th>

                                        <td>
                                            <div class="dAdmin_info_name min-w-150px">
                                                <p>{{ $userInfo->name }}</p>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="dAdmin_info_name">
                                                <p>{{ $review->rating }}</p>
                                            </div>
                                        </td>

                                        <td>

                                            <div class="dAdmin_info_name">
                                                <p>{{ $review->review }}</p>
                                            </div>
                                        </td>

                                        <td class="print-d-none">
                                            <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="fi-rr-menu-dots-vertical"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('admin.review.edit', $review->id) }}">{{ get_phrase('Edit') }}</a></li>

                                                    <li><a class="dropdown-item" href="#" onclick="confirmModal('{{ route('admin.review.delete', $review->id) }}')">{{ get_phrase('Delete') }}</a></li>


                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @include('admin.no_data')
                @endif
                <!-- Data info and Pagination -->
            </div>
        </div>
    </div>
</div>
<!-- End Admin area -->
