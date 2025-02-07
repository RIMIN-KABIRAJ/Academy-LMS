<form action="{{ route('make.paytm.order') }}" method="get" enctype="multipart/form-data">
    @csrf
    <input type="submit" value="Pay by Paytm" class="btn btn-primary">
</form>
