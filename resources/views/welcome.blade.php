@extends('layouts.app')

@section('content')

    <section class="container">
        <div class="uk-background-cover uk-light header-content" data-src="{{ asset('images/background/img8.jpg') }}"
            uk-img>
            <div class="uk-width-1-1 uk-margin-xlarge-top uk-padding-small">
                <div class="uk-width-1-2@m uk-align-right uk-margin-xlarge-top uk-padding uk-text-center welcome-content">
                    <div class="uk-text-large uk-text-bold uk-text-italic mySlides fade">"Agriculture is the greatest and
                        fundamentally the
                        most important
                        of our industries. The cities are
                        but
                        the
                        branches of the tree of national life, the roots of which go deeply into the land. We all flourish
                        or
                        decline with the farmer."
                    </div>
                    <div class="uk-text-bold mySlides fade">
                        <p class="uk-text-large uk-text-italic uk-margin-bottom">"The farmer is the
                            only man in our
                            economy who
                            buys
                            everything at retail, sells everything at wholesale, and pays the freight both ways."</p>
                        <a class="uk-flex uk-flex-middle uk-flex-center"><i
                                class="uk-text-large uk-margin-right ri-message-3-line"></i>Post some Ideas to help the
                            Farmers</a>
                    </div>
                    <div class="uk-text-large uk-text-bold uk-text-italic mySlides fade">
                        <i class="uk-text-large uk-margin-right ri-user-smile-fill"></i>
                        Know More About Us
                    </div>
                </div>
                <div
                    class="uk-width-1-2@m uk-align-right uk-margin-left uk-margin-right uk-padding uk-text-bold uk-text-center">
                    <button class="uk-padding-small uk-margin-right uk-text-bold uk-text-large welcome-btn"
                        uk-toggle="target: #signup-form">Getting
                        Started</button>
                </div>
                <div>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('scripts')
    <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 6000); // Change image every 2 seconds
        }

    </script>
@endsection
