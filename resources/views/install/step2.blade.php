@extends('install.index')
   
@section('content')
<?php if(isset($error) && $error != "") { ?>
  <div class="row ins-seven justify-content-center">
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
      <div class="card-body px-4">
        <div class="panel panel-default ins-three" data-collapsed="0">
          <!-- panel body -->
          <div class="panel-body ins-four">
            <h6 class="ins-four mb-2">
              {{ __('Provide your codecanyon') }} <strong>{{ __('purchase code') }}</strong>
            </h6>
            <br>
            <div class="row">
              <div class="col-md-12">
                <form method="POST" enctype="multipart/form-data" class="d-block ajaxForm" action="{{ route('install.validate') }}">
                  @csrf 
                  <div class="form-group">
                    <label class="control-label">{{ __('Purchase Code') }}</label>
                      <input type="text" class="form-control eForm-control" name="purchase_code" placeholder="Product's Purchase Code"
                        required autofocus autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label"></label>
                    <button type="submit" class="btn btn-primary">{{ __('Continue') }}</button>
                  </div>
                </form>
                <br>
                <p>
                  <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">
                    <strong>{{ __('Where to get my purchase code ?') }}</strong>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection