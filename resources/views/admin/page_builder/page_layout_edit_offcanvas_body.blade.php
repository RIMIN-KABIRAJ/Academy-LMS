@php $files = array_diff(scandir(base_path('/resources/views/components/home_made_by_developer')), array('.', '..')); @endphp
<div class="row g-2">
    @foreach ($files as $file)
        @php
            $file_name = str_replace('.blade.php', '', $file);
        @endphp
        <div class="col-md-12 position-relative">
            <div class="builder-blocks">
                @include('components.home_made_by_developer.' . $file_name)
            </div>
            <button onclick="add_block_html_content_by_select_from_offcanvas('{{ $file_name }}')" class="builder-block-placeholder" type="button"><i class="fi-rr-plus"></i></button>
        </div>
    @endforeach
</div>