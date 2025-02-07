@extends('layouts.admin')
@push('title', get_phrase('Assign Permission'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Admin Permissions') }}
                </h4>

                <a href="{{ route('admin.admins.index') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-alt-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>
    @php
        // MAKE SURE TO KEEP A PERMISSION FOR USERS AND THEME
        $routes = [
            'admin.dashboard' => get_phrase('Dashboard'),
            'admin.categories' => get_phrase('Category'),
            'admin.courses' => get_phrase('Course'),
            'admin.student.enroll' => get_phrase('Enrollment'),
            'admin.enroll.history' => get_phrase('Enroll History'),
            'admin.revenue' => get_phrase('Admin Revenue'),
            'admin.instructor.revenue' => get_phrase('Instructor Revenue'),
            'admin.purchase.history' => get_phrase('Purchase history'),
            'admin.instructor.index' => get_phrase('Instructor'),
            'admin.admins.index' => get_phrase('Admin'),
            'admin.student.index' => get_phrase('Student'),
            'admin.message' => get_phrase('Message'),
            'admin.newsletter' => get_phrase('Newsletter'),
            'admin.subscribed_user' => get_phrase('Newsletter Subscriber'),
            'admin.contact' => get_phrase('Contact User'),
            'admin.offline.payments' => get_phrase('Offline Payment'),
            'admin.coupons' => get_phrase('Coupon'),
            'admin.blog' => get_phrase('Blog'),
            'admin.pending.blog' => get_phrase('Pending Blog List'),
            'admin.blog.category' => get_phrase('Blog Category'),
            'admin.blog.settings' => get_phrase('Blog Settings'),

            'admin.system.settings' => get_phrase('System Settings'),
            'admin.website.settings' => get_phrase('Website Settings'),
            'admin.payment.settings' => get_phrase('Payment Settings'),
            'admin.manage.language' => get_phrase('Language Settings'),
            'admin.live.class.settings' => get_phrase('Live Class Settings'),
            'admin.certificate.settings' => get_phrase('Certificate'),
            'admin.open.ai.settings' => get_phrase('Open AI Settings'),
            'admin.seo.settings' => get_phrase('SEO Settings'),
            'admin.about' => get_phrase('About'),
        ];
        $permission_row = DB::table('permissions')
            ->where('admin_id', $admin->id)
            ->first();
        $permissions = json_decode($permission_row->permissions ?? '{}', true);
    @endphp

    <div class="row">
        <div class="col-xl-8">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <div class="col-6 pt-3">
                        <p class="column-title">{{ get_phrase('Assign permission for') }}: {{ $admin->name }}</p>
                    </div>
                    <div class="pb-3">
                        <small> <strong>{{ get_phrase('Note') }}</strong> :
                            {{ get_phrase('You can toggle the switch for enabling or disabling a feature to access') }}</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table eTable">
                            <thead>
                                <tr>
                                    <th>{{ get_phrase('Feature') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routes as $route => $title)
                                    <tr>
                                        <td>{{ $title }}</td>
                                        <td>
                                            <!-- Bool Switch-->
                                            <input type="checkbox" class="form-check-input" id="{{ $admin->id . '-' . $route }}" data-switch="bool" onchange="setPermission('{{ $admin->id }}', '{{ $route }}')" @if (is_array($permissions) && in_array($route, $permissions)) checked @endif>
                                            <label for="{{ $admin->id . '-' . $route }}" data-on-label="On" data-off-label="Off"></label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
@endsection
@push('js')
    <script>
        "use strict";

        function setPermission(user_id, permission) {
            $.ajax({
                type: "post",
                url: "{{ route('admin.admins.permission.store') }}/" + user_id,
                data: {
                    user_id: user_id,
                    permission: permission,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response == 1) {
                        success("{{ get_phrase('Permission updated') }}");
                    }
                }
            });
        }
    </script>
@endpush
