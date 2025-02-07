@extends('layouts.instructor')
@push('title', get_phrase('Blogs'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Manage Blogs') }}
                </h4>
                <a href="{{ route('instructor.blog.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new blog') }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card p-3">
                <div class="ol-card-body">
                    <div class="row print-d-none mt-3 mb-4">
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            <div class="custom-dropdown ms-2">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.print-table', 'blogs')"><i class="fi-rr-file-pdf"></i>
                                            {{ get_phrase('PDF') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form class="form-inline" action="{{ route('instructor.blogs') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-md-9">
                                        <div class="mb-3 position-relative position-relative">
                                            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search Title') }}" class="ol-form-control form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (count($blogs) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($blogs) . ' ' . get_phrase('of') . ' ' . $blogs->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive course_list" id="course_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Creator') }}</th>
                                        <th scope="col">{{ get_phrase('Title') }}</th>
                                        <th scope="col">{{ get_phrase('Category') }}</th>
                                        <th scope="col">{{ get_phrase('Status') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $key => $blog)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px gap-1">
                                                    <div class="dAdmin_profile_img">
                                                        <img class="img-fluid rounded-circle image-45" width="45" height="45" src="{{ get_image($blog->thumbnail) }}" id="blog-thumbnail" />
                                                    </div>
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ get_user_info($blog->user_id)->name }}
                                                        </h4>
                                                        <p>{{ get_user_info($blog->user_id)->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <h4 class="title fs-14px">
                                                        <a href="{{ route('blog.details', slugify($blog->title)) }}">
                                                            {{ $blog->title }}</a>
                                                    </h4>
                                                    <p>{{ date('D, d-M-Y', strtotime($blog->created_at)) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                @php
                                                    $category = DB::table('blog_categories')
                                                        ->where('id', $blog->category_id)
                                                        ->first();
                                                @endphp
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p>{{ $category->title }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p><span class="badge {{ $blog->status ? 'bg-success' : 'bg-danger' }} text-white">{{ get_phrase($blog->status ? 'Active' : 'Inactive') }}</span>
                                                    </p>
                                                </div>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>

                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('instructor.blog.edit', ['id' => $blog->id]) }}">{{ get_phrase('Edit') }}</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#" onclick="confirmModal('{{ route('instructor.blog.delete', $blog->id) }}')">{{ get_phrase('Delete') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('instructor.no_data')
                    @endif
                    <!-- Data info and Pagination -->
                    @if (count($blogs) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($blogs) . ' ' . get_phrase('of') . ' ' . $blogs->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin area -->
@endsection
@push('js')@endpush
