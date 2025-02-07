<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ get_phrase('Course Playing Page') }}| {{ config('app.name') }}</title>
    <!-- all the meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- all the css files -->
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/course_player/vendors/fontawesome/fontawesome.css') }}" />
    <!-- Player CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plyr/plyr.css') }}" />
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/course_player/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/course_player/css/custom.css') }}" />
    <!-- FlatIcons Css -->
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />

    <!-- Summernote Css -->
    <link rel="stylesheet" href="{{ asset('assets/global/summernote/summernote.min.css') }}">

    <!-- Yaireo Tagify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/tagify-master/dist/tagify.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Start Course Playing Header -->
    <header class="playing-header-section">
        @include('course_player.header')
    </header>
    <!-- End Course Playing Header -->

    <!-- Start Course Playing Video and Playlist Area -->
    <section class="video-playlist-section">
        <div class="my-container">
            <div class="row">
                <div class="col-lg-8" id="player_content">
                    @include('course_player.player_page')
                    <!-- Tab -->
                    <div class="course-video-navtab">
                        @include('course_player.tab_bar')
                    </div>
                </div>
                <div class="col-lg-4" id="player_side_bar">
                    @include('course_player.side_bar')
                </div>
            </div>
        </div>
    </section>
    <!-- End Course Playing Video and Playlist Area -->

    <!-- Main Jquery -->
    <script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap bundle with popper -->
    <script src="{{ asset('assets/frontend/default/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Summernote Css -->
    <script src="{{ asset('assets/global/summernote/summernote.min.js') }}"></script>

    <!-- Fontawesome JS -->
    <script src="{{ asset('assets/global/course_player/vendors/fontawesome/fontawesome.all.min.js') }}"></script>

    <!-- Player JS -->
    <script src="{{ asset('assets/global/plyr/plyr.js') }}"></script>

    <!-- Yaireo Tagify -->
    <script src="{{ asset('assets/global/tagify-master/dist/tagify.min.js') }}"></script>

    <!-- Jquery form -->
    <script type="text/javascript" src="{{ asset('assets/global/jquery-form/jquery.form.min.js') }}"></script>

    <!-- toster file -->
    @include('frontend.default.toaster')

    <!-- Custom Script -->
    <script src="{{ asset('assets/global/course_player/js/script.js') }}"></script>

    @include('course_player.init')
    @stack('js')
</body>

</html>
