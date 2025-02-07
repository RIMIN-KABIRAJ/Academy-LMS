@extends('install.index')

@section('content')
    <div class="row justify-content-center ins-two">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default ins-three" data-collapsed="0">
                        <!-- panel body -->
                        <div class="panel-body ins-four">
                            <h6 class="ins-four mb-4">
                                {{ __('Welcome to Sociopro social platform Installation. You will need to know the following items before proceeding.') }}
                            </h6>
                            <ol class="list-group list-group-flush">
                                <li class="mb-2"> <i class="fi-rr-arrow-small-right"></i> {{ __('Codecanyon purchase code') }}</li>
                                <li class="mb-2"> <i class="fi-rr-arrow-small-right"></i> {{ __('Database Name') }}</li>
                                <li class="mb-2"> <i class="fi-rr-arrow-small-right"></i> {{ __('Database Username') }}</li>
                                <li class="mb-2"> <i class="fi-rr-arrow-small-right"></i> {{ __('Database Password') }}</li>
                                <li class="mb-2"> <i class="fi-rr-arrow-small-right"></i> {{ __('Database Hostname') }}</li>
                            </ol>
                            <p class="ins-four mb-3 mt-3">
                                {{ __('We are going to use the above information to write database.php file which will connect the application to your database.') . ' ' . __('During the installation process, we will check if the files that are needed to be written') }}
                                (<strong>{{ __('config/database.php') }}</strong>) {{ __('have') }}
                                <strong>{{ __('write permission') }}</strong>. {{ __('We will also check if') }} <strong>{{ __('curl') }}</strong> {{ __('and') }}
                                <strong>{{ __('php mail functions') }}</strong>
                                {{ __('are enabled on your server or not.') }}
                            </p>
                            <p class="ins-four">
                                {{ __('Gather the information mentioned above before hitting the start installation button. If you are ready....') }}
                            </p>
                            <br>
                            <p>
                                <a href="{{ route('step1') }}" class="btn btn-primary">
                                    {{ __('Start Installation Process') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
