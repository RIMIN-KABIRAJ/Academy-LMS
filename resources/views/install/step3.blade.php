@extends('install.index')

@section('content')
    <?php if(isset($db_connection) && $db_connection != "") { ?>
    <div class="row ins-seven justify-content-center">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <strong>{{ $db_connection }}</strong>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row justify-content-center ins-two">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body px-4">
                    <div class="panel panel-default ins-three" data-collapsed="0">
                        <!-- panel body -->
                        <div class="panel-body ins-four">
                            <h6 class="ins-four">
                                {{ __('Below you should enter your database connection details.') . ' ' . __('If you’re not sure about these, contact your host.') }}
                            </h6>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-horizontal form-groups" method="post" action="{{ route('step3') }}">
                                        @csrf
                                        <hr>
                                        <div class="form-group">
                                            <label class="control-label">{{ __('Database Name') }}</label>
                                            <input type="text" class="form-control eForm-control" name="dbname" placeholder="" required autofocus>
                                            <small class="text-muted">
                                                {{ __('The name of the database you want to use with this application') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="control-label">{{ __('Username') }}</label>
                                            <input type="text" class="form-control eForm-control" name="username" placeholder="" required>
                                            <small class="text-muted">
                                                {{ __('Your database Username') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="control-label">{{ __('Password') }}</label>
                                            <input type="password" class="form-control eForm-control" name="password" placeholder="">
                                            <small class="text-muted">
                                                {{ __('Your database Password') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="control-label">{{ __('Database Host') }}</label>
                                            <input type="text" class="form-control eForm-control" name="hostname" placeholder="" required>
                                            <small class="text-muted">
                                                {{ __("If 'localhost' does not work, you can get the hostname from web host") }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <button type="submit" class="btn btn-primary">{{ __('Continue') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
