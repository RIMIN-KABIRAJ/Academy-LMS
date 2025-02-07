<style>
.payment-mobile-bar{
	top: 0;
	z-index: 3000;
}
</style>
<div class="payment-mobile-bar container-fluid position-fixed py-2 bg-light">
	<div class="row mx-1">
		<div class="col-auto p-0">
			<a class="btn ol-btn-secondary fw-bold w-100 text-start" href="{{session('app_url')}}">
				<i class="fi-rr-arrow-alt-left"></i>  {{ get_phrase('Back to mobile app') }}
			</a>
		</div>
		<div class="col-auto ms-auto p-0">
			<a class="btn ol-btn-secondary" href="{{route('closed_back_to_mobile_ber')}}"><i class="fi-rr-cross-circle"></i></a>
		</div>
	</div>
</div>
<div class="container-fluid py-4"></div>