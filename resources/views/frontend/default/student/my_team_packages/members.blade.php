<div class="tab-pane fade show active" id="members" role="tabpanel" aria-labelledby="members-tab" tabindex="0">
    <div class="row">
        <div class="col-md-6 offset-md-6">
            <div class="search-members">
                <form method="get" class="Esearch_entry p-0">
                    <input type="text" name="search" class="form-control" placeholder="{{ get_phrase('Search team members') }}" autocomplete="off">
                    <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <div class="search-result">
                    <p class="fs-4 response-msg px-4 py-2">{{ get_phrase('Enter member\'s email ...') }}</p>
                    <div class="search-placeholder"></div>
                </div>
            </div>
        </div>
    </div>



    @if (count($members) > 0)
        <div class="table-responsive mt-4">
            <table class="eTable table">
                <thead>
                    <th>{{ get_phrase('Member') }}</th>
                    <th>{{ get_phrase('Joined') }}</th>
                    <th>{{ get_phrase('Progress') }}</th>
                    <th class="text-center">{{ get_phrase('Options') }}</th>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <img class="rounded-circle" width="45px" src="{{ get_image($member->photo) }}" alt="">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span>{{ $member->name }}</span>
                                        <small>{{ $member->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ date('d-M-Y', strtotime($member->created_at)) }}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ progress_bar($member->course_id, $member->member_id) }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-center">
                                    {{ progress_bar($member->course_id, $member->member_id) }}%
                                </p>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="confirmModal('{{ route('my.team.packages.members.action', ['remove', 'package_id' => $package->id, 'user_id' => $member->member_id]) }}')" class="btn btn-primary text-18 d-inline-flex p-3 text-white">
                                    <i class="fi fi-rr-trash d-inline-flex"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        @include('frontend.default.empty')
    @endif
</div>


@push('js')
    <script>
        $(document).ready(function() {
            const searchInput = $('input[name="search"]');
            const searchResult = $('.search-placeholder');
            const responseMsg = $('.response-msg');

            // Show search results when clicking on the search input
            searchInput.click(function(e) {
                e.stopPropagation();
                searchResult.parent().addClass('active');
            });

            // Perform AJAX search when typing in the search input
            searchInput.keyup(function(e) {
                let inputValue = $(this).val();

                if (inputValue.includes('@')) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('search.package.members') }}/" + "{{ $package->id }}",
                        data: {
                            email: inputValue
                        },
                        success: function(response) {
                            if (response == '') {
                                searchResult.empty();
                                responseMsg.removeClass('d-none').text("{{ get_phrase('No data found!') }}");
                            } else {
                                responseMsg.addClass('d-none');
                                searchResult.empty().append(response);
                            }
                        }
                    });
                }
            });

            // Hide search results when clicking outside
            $(document).click(function() {
                searchResult.parent().removeClass('active');
            });

            // Prevent hiding search results when clicking inside the search results
            searchResult.parent().click(function(e) {
                e.stopPropagation();
            });
        });
    </script>
@endpush
