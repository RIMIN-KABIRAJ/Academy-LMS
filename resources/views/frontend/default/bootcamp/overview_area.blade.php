<div class="row">
    <div class="col-lg-12" id="Overview">
        <div class="ps-box">
            <h4 class="g-title">{{ get_phrase('Bootcamp Overview') }}</h4>
            <div class="description ellipsis-4" id="ellipsis-4">
                @if (isset($bootcamp_details->description))
                    {!! $bootcamp_details->description !!}
                @else
                    <p class="text-center">{{ get_phrase('No Bootcamp Description') }}</p>
                @endif
            </div>
            @if (isset($bootcamp_details->description))
                <a href="#" class="s_stext" id="more_description">
                    {{ get_phrase('See more') }} <i class="fa-solid fa-angle-right me-2"></i>
                </a>
            @endif
        </div>
    </div>
</div>
