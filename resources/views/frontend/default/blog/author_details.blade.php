<div class="eInstructor">
    <div class="istructor-info ">
        <div class="ins-left">
            <div class="Eins_image">
                <img src="{{ get_image($blog_details->author_photo) }}" alt="author_photo">
            </div>
            <div class="E_desig">
                <div class="ins-designation">
                    <h5>{{ $blog_details->author_name }}</h5>
                    @php
                        $skills = json_decode($blog_details->author_skills, true);
                        if(is_array($skills) && count($skills) > 0){
                            $skills = array_column($skills, 'value');
                        }
                    @endphp

                    <p class="description">{{ $skills ? implode(', ', $skills) : '' }}</p>
                </div>
                <p class="description mt-20 mb-5">{!! $blog_details->author_biography !!}</p>
                <ul class="f-socials d-flex mb-3">
                    <li><a href="{{ $blog_details->author_twitter }}"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="{{ $blog_details->author_facebook }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="{{ $blog_details->author_linkedin }}"><i class="fa-brands fa-linkedin-in"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
