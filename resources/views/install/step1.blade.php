@extends('install.index')

@section('content')
    <?php
    $db_file_write_perm = is_writable('config/database.php');
    $routes_file_write_perm = is_writable('routes/web.php');
    $curl_enabled = function_exists('curl_version');
    if ($db_file_write_perm == false || $routes_file_write_perm == false || $curl_enabled == false) {
        $valid = false;
    } else {
        $valid = true;
    }
    ?>
    <div class="row justify-content-center ins-two">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default ins-three" data-collapsed="0">
                        <!-- panel body -->
                        <div class="panel-body ins-four">
                            <h6 class="ins-four mb-2">
                                {{ __('We ran diagnosis on your server.') .
                                    ' ' .
                                    __('Review the items that have a red mark on it.') .
                                    ' ' .
                                    __('If everything is green, you
                                                                                                			              are good to go to the next step.') }}
                            </h6>
                            <br>
                            <p class="ins-four mb-2">
                                <i class="fas fafas fa-check ins-nine text-success"></i>
                                <strong>{{ __('config/database.php') }}
                            </p>
                            <p class="ins-four mb-2">
                                <i class="fas fafas fa-check ins-nine text-success"></i>
                                <strong>{{ __('routes/web.php') }}
                            </p>
                            <p class="ins-four mb-2">
                                <i class="fas fafas fa-check ins-nine text-success"></i>
                                <strong>{{ __('Curl Enabled') }}</strong>
                            </p>
                            <p class="ins-four mt-3">
                                <strong>{{ __('To continue the installation process, all the above requirements are needed to be checked') }}</strong>
                            </p>
                            <br>
                            <?php if ($valid == true) { ?>
                            <p>
                                <?php if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') { ?>
                                <a href="{{ route('step3') }}" class="btn btn-primary">
                                    {{ __('Continue') }}
                                </a>
                                <?php } else { ?>
                                <a href="{{ route('step2') }}" class="btn btn-primary">
                                    {{ __('Continue') }}
                                </a>
                                <?php } ?>
                            </p>
                            <?php } ?>

                            <?php if ($valid != true) { ?>
                            <p>
                                <?php if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') { ?>
                                <a href="{{ route('step3') }}" class="btn btn-primary" disabled>
                                    {{ __('Continue') }}
                                </a>
                                <?php } else { ?>
                                <a href="{{ route('step2') }}" class="btn btn-primary" disabled>
                                    {{ __('Continue') }}
                                </a>
                                <?php } ?>
                                <a href="{{ route('step1') }}" class="btn btn-primary">
                                    <i class="mdi mdi-refresh"></i>{{ __('Reload') }}
                                </a>
                            </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
