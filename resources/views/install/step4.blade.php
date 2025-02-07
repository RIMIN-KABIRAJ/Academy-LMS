@extends('install.index')

@section('content')
    <?php if(isset($error)) { ?>
    <div class="row justify-content-center ins-seven">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <strong>{{ $error }}</strong>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row justify-content-center ins-two">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default ins-three" data-collapsed="0">
                        <!-- panel body -->
                        <div class="panel-body ins-four">
                            <p class="ins-four mb-3">
                                {!! __("The provided information will be written into your application's <b>config/database.php</b> file, so click the Confirm button to write the file")!!}.
                            </p>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" id="install_button" class="btn btn-primary">
                                        {{ __('Confirm') }}
                                    </button>
                                    <div class="mt-3" id="loader">
                                        {{ __('Configuring the database....') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        "use strict";

        $(document).ready(function() {
            $('#loader').hide();
            $('#install_button').on('click', function() {
                $('#loader').fadeIn();
                setTimeout(
                    function() {
                        window.location.href = "{{ route('step4.confirm_import', ['confirm_import' => 'confirm_install']) }}";
                    }, 5000);
            });
        });
    </script>
@endsection
