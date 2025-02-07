@extends('install.index')

@section('content')
    <div class="row justify-content-center ins-two">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body px-4">
                    <div class="panel panel-default ins-three" data-collapsed="0">
                        <!-- panel body -->
                        <div class="panel-body ins-four">

                            <i class="entypo-thumbs-up ins-five"></i>
                            <h4>{{ __('Congratulations!! The installation was successfull') }}</h4>

                            <br>

                            <p>
                                {{ __("Before you start using your application, make it yours. Set your application name and title, admin login email and password. Remember the login credentials which you will need later on for signing into your account. After this step, you will be redirected to application's login page.") }}
                            </p>

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-horizontal form-groups" method="post" action="{{ route('finalizing_setup') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('System Name') }}</label>

                                            <input type="text" class="form-control eForm-control" name="system_name" required autofocus>
                                            <small class="text-muted">
                                                {{ __('The name of your application') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your name') }}</label>

                                            <input type="text" class="form-control eForm-control" name="admin_name" placeholder="Ex: John Doe" required>
                                            <small class="text-muted">
                                                {{ __('Full name of Administrator') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your Email') }}</label>

                                            <input type="email" class="form-control eForm-control" name="admin_email" placeholder="Ex: john@example.com" required>
                                            <small class="text-muted">
                                                {{ __('Email address for administrator login') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Password') }}</label>

                                            <input type="password" class="form-control eForm-control" name="admin_password" placeholder="" required>
                                            <small class="text-muted">
                                                {{ __('Admin login password') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your Address') }}</label>

                                            <input type="text" class="form-control eForm-control" name="admin_address" placeholder="Ex: Your Address" required>
                                            <small class="text-muted">
                                                {{ __('Address of Administrator') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('Your Phone') }}</label>

                                            <input type="text" class="form-control eForm-control" name="admin_phone" placeholder="Ex: +9020040060" required>
                                            <small class="text-muted">
                                                {{ __('Phone of Administrator') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">{{ __('TimeZone') }}</label>

                                            <select class="form-select eForm-select eChoice-multiple-with-remove" id="timezone" name="timezone">
                                                <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                                                <?php foreach ($tzlist as $tz): ?>
                                                <option value="{{ $tz }}" {{ $tz == 'Asia/Dhaka' ? 'selected' : '' }}>{{ $tz }}</option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="text-muted">
                                                {{ __('Choose System TimeZone') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-7">
                                                <button type="submit" class="btn btn-primary">{{ __('Set me up') }}</button>
                                            </div>
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
