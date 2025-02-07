@extends('install.index')

@section('content')
    <div class="row justify-content-center ins-two">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default ins-three" data-collapsed="0">
                        <!-- panel body -->
                        <div class="panel-body ins-four">
                            <h3>{{ __('Success') }}!!</h3>
                            <br>
                            <p class="ins-four">
                                <strong class="text-success">{{ __('Installation was successfull.') . ' ' . __('Please login to continue..') }}</strong>
                            </p>
                            <br>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="ins-eight"><strong class="mb-2 d-inline-block">{{ __('Administrator Email') }} </strong></td>
                                        <td class="ins-eight"><span class="mx-4 mb-2 d-inline-block">|</span></td>
                                        <td class="ins-eight"><span class="mb-2 d-inline-block">{{ $admin_email }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ins-eight"><strong>{{ __('Password') }} </strong></td>
                                        <td class="ins-eight"><span class="mx-4">|</span></td>
                                        <td class="ins-eight">{{ __('Your chosen password') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <p>
                                <a href="{{ route('login') }}" class="btn btn-success">
                                    {{ __('Log In') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
