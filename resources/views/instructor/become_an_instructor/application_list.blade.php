<h4 class="mb-3 header-title">{{ get_phrase('Your application') }}</h4>
<div class="table-responsive-sm mt-4">
    <table id="basic-datatable" class="table table-striped table-centered mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ get_phrase('name') }}</th>
                <th>{{ get_phrase('document') }}</th>
                <th>{{ get_phrase('details') }}</th>
                <th>{{ get_phrase('status') }}</th>
            </tr>
        </thead>
        <tbody>
            @php
                $applications = App\Models\Application::where('user_id', Auth()->user()->id)->get();
            @endphp
            @foreach ($applications as $key => $application)
                <tr class="gradeU">
                    <td>{{ ++$key }}</td>
                    <td>{{ get_user_info($application->user_id)->name }}</td>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-primary"
                            onclick="ajaxModal('{{ route('modal', ['admin.instructor.show_document', 'id' => $application->id]) }}', '{{ get_phrase('Applicant details') }}')">
                            <i class="fa fa-info-circle"></i>{{ get_phrase('Application details') }}
                        </a>
                    </td>
                    <td>

                        <a href="" class="btn btn-info">
                            <i class="fa fa-download"></i> {{ get_phrase('download') }}
                        </a>

                    </td>
                    <td class="text-center">
                        @if ($application->status == 0)
                            <div class="badge badge-danger">{{ get_phrase('Pending') }}</div>
                        @elseif($application->status == 1)
                            <div class="badge badge-success">{{ get_phrase('Approved') }}</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
