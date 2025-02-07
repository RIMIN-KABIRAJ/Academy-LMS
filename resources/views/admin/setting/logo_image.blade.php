<div class="row">
    <div class="col-xl-4 col-lg-6">
        <div class="ol-card p-4 ol-card p-4-2">
            <div class="ol-card-body">
                <div class="col-xl-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data" class="text-center">
                            @csrf
                            <input type="hidden" name="type" value="banner_image">
                            <div class="form-group mb-2">
                                <div class="wrapper-image-preview  d-flex justify-content-center">
                                    <div class="box">
                                        <div class="upload-options">
                                            @php
                                                $bannerData = json_decode(get_frontend_settings('banner_image'));
                                                $banneractive = get_frontend_settings('home_page');

                                                if ($bannerData !== null && is_object($bannerData) && property_exists($bannerData, $banneractive)) {
                                                    $banner = json_decode(get_frontend_settings('banner_image'))->$banneractive;
                                                } elseif (!get_frontend_settings('home_page')) {
                                                    $banner = get_frontend_settings('banner_image');
                                                }
                                            @endphp
                                            @if (isset($banner))
                                                <img src="{{ asset($banner) }}" alt="">
                                            @endif
                                            <label for="banner_image" class="btn ol-card p-4-text">

                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z" fill="#797c8b" />
                                                </svg>
                                                <small>{{ get_phrase('Click here to choose a banner image') }}</small>
                                                <small class="d-block">(1000 X 700)</small> </label>
                                            <input id="banner_image" type="file" class="image-upload d-none" name="banner_image" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn ol-btn-primary w-100">{{ get_phrase('Save changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-4 col-lg-6">
        <div class="ol-card p-4 ol-card p-4-2">
            <div class="ol-card-body">
                <div class="col-xl-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data" class="text-center">
                            @csrf
                            <input type="hidden" name="type" value="light_logo">
                            <div class="form-group mb-2">
                                <div class="wrapper-image-preview  d-flex justify-content-center">
                                    <div class="box">
                                        <div class="upload-options">
                                            <img src="{{ asset(get_frontend_settings('light_logo')) }}" alt="" class="bg-dark radious-15px px-2 py-2">
                                            <label for="light_logo" class="btn ol-card p-4-text">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z" fill="#797c8b" />
                                                </svg>
                                                <small>{{ get_phrase('Click here to choose a light logo') }}</small>
                                                <small class="d-block">(330 X 70)</small> </label>
                                            <input id="light_logo" type="file" class="image-upload d-none" name="light_logo" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn ol-btn-primary w-100">{{ get_phrase('Save changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6">
        <div class="ol-card p-4 ol-card p-4-2">
            <div class="ol-card-body">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data" class="text-center">
                            @csrf
                            <input type="hidden" name="type" value="dark_logo">
                            <div class="form-group mb-2">
                                <div class="wrapper-image-preview  d-flex justify-content-center">
                                    <div class="box">
                                        <div class="upload-options">
                                            <img src="{{ asset(get_frontend_settings('dark_logo')) }}" alt="">
                                            <label for="dark_logo" class="btn ol-card p-4-text">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z" fill="#797c8b" />
                                                </svg>
                                                <small>{{ get_phrase('Click here to choose a dark logo') }}</small>
                                                <small class="d-block">(330 X 70)</small> </label>
                                            <input id="dark_logo" type="file" class="image-upload d-none" name="dark_logo" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn ol-btn-primary w-100">{{ get_phrase('Save changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6">
        <div class="ol-card p-4 ol-card p-4-2">
            <div class="ol-card-body">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <form action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data" class="text-center">
                            @csrf
                            <input type="hidden" name="type" value="favicon">
                            <div class="form-group mb-2">
                                <div class="wrapper-image-preview d-flex justify-content-center">
                                    <div class="box">
                                        <img width="100px" src="{{ asset(get_frontend_settings('favicon')) }}" alt="">
                                        <div class="upload-options">
                                            <label for="favicon" class="btn ol-card p-4-text">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z" fill="#797c8b" />
                                                </svg>
                                                <small>{{ get_phrase('Click here to choose a favicon') }}</small>
                                                <br> <small>(90 X
                                                    90)</small> </label>
                                            <input id="favicon" type="file" class="image-upload d-none" name="favicon" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn ol-btn-primary w-100">{{ get_phrase('Save changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
