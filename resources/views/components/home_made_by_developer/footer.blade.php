{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="footer-content">
                    <img src="{{ get_image(get_frontend_settings('light_logo')) }}" alt="system logo">
                    <p class="description builder-editable" builder-identity="1">{{get_phrase('It is a long established fact that a reader will be the distract by the read content of a page layout')}}.</p>

                    <ul class="f-socials d-flex">
                        <li><a href="{{ get_frontend_settings('twitter') }}"><i class="fa-brands fa-twitter"></i></a>
                        </li>
                        <li><a href="{{ get_frontend_settings('facebook') }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="{{ get_frontend_settings('linkedin') }}"><i class="fa-brands fa-linkedin-in"></i></a></li>
                    </ul>
                    <div class="gradient-border2">
                        <a href="{{ route('contact.us') }}" class="gradient-border-btn">
                            {{ get_phrase('Contact with Us') }}
                            <i class="fa-solid fa-arrow-right-long ms-2"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h4>{{ get_phrase('Top Categories') }}</h4>
                            <ul>
                                @foreach (top_categories() as $category)
                                    <li>
                                        <a href="{{ route('courses', $category->slug) }}">
                                            {{ ucfirst($category->title) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h4>{{ get_phrase('Useful links') }}</h4>
                            <ul>
                                <li><a href="{{ route('courses') }}">{{ get_phrase('Course') }}</a></li>
                                <li><a href="{{ route('blogs') }}">{{ get_phrase('Blog') }}</a></li>
                                <li><a href="{{ route('knowledge.base.topicks') }}">{{ get_phrase('Knowledge Base') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer-widget">
                            <h4>{{ get_phrase('Company') }}</h4>
                            <ul>
                                <li>
                                    <a href="#">
                                        {{ get_phrase('Phone : ') }}
                                        {{ get_settings('phone') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        {{ get_phrase('Email : ') }}
                                        {{ get_settings('system_email') }}
                                    </a>
                                </li>
                            </ul>
                            <div class="newslater-bottom">
                                <h4 class="builder-editable" builder-identity="2">{{ get_phrase('Newsletter') }}</h4>
                                <p class="description builder-editable" builder-identity="3">{{ get_phrase("Subscribe to stay tuned for new web design and latest updates. Let's do it!") }}</p>
                                <form action="{{ route('newsletter.store') }}" method="post" class="newslater-form">
                                    @csrf
                                    <input type="text" name="email" class="form-control" placeholder="{{ get_phrase('Email address') }}">
                                    <button class="eBtn gradient">{{ get_phrase('Submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <ul class="footer-policy">
                        <li><a href="{{ route('about.us') }}">{{ get_phrase('About Us') }}</a></li>
                        <li><a href="{{ route('privacy.policy') }}">{{ get_phrase('Privacy Policy') }}</a></li>
                        <li><a href="{{ route('terms.condition') }}">{{ get_phrase('Terms And Use') }}</a></li>
                        <li><a href="{{ route('refund.policy') }}">{{ get_phrase('Sales and Refunds') }}</a></li>
                        <li><a href="{{ route('cookie.policy') }}">{{ get_phrase('Cookie Policy') }}</a></li>
                        <li><a href="{{ route('faq') }}">{{ get_phrase('FAQ') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="copyright-text">
                        <p class="builder-editable" builder-identity="4">{{ get_phrase('© 2024 All Rights Reserved') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
