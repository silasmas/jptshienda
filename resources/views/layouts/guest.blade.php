<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="@lang('miscellaneous.keywords')">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="jpt-devref" content="IQmxemeH2oYJ7Rsp3yx97S8GEsCVEQdtNaWuh88dfYp66P0HJS8g2xVqEeCnFImCaWKyn733o7jOtzxwB5INSU5W26Bw63QruvZl">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">

        <!-- Font Icons Files -->
        <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/icons/boxicons/css/boxicons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/icons/remixicon/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/lonely/glightbox/css/glightbox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/icons/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css">

        <!-- Addons CSS Files -->
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/lonely/swiper/swiper-bundle.min.css') }}">

        <!-- Lonely CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.lonely.css') }}">
        <!-- Custom CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.custom.css') }}">

        <title>
@if (Route::is('home'))
            J-P TSHIENDA | @lang('miscellaneous.slogan')
@endif

@if (Route::is('account') || Route::is('account.update.password'))
            @lang('miscellaneous.menu.account_settings')
@endif

@if (Route::is('message.inbox'))
            @lang('miscellaneous.message.inbox')
@endif

@if (Route::is('message.outbox'))
            @lang('miscellaneous.message.outbox')
@endif

@if (Route::is('message.draft'))
            @lang('miscellaneous.message.draft')
@endif

@if (Route::is('message.spams'))
            @lang('miscellaneous.message.spams')
@endif

@if (Route::is('message.new'))
            @lang('miscellaneous.message.new')
@endif

@if (Route::is('message.search'))
            @lang('miscellaneous.message.search_result')
@endif

@if (Route::is('notification'))
            @lang('miscellaneous.menu.notifications')
@endif

@if (Route::is('news.home'))
            @lang('miscellaneous.menu.public.news')
@endif

@if (Route::is('works'))
            @lang('miscellaneous.menu.public.works')
@endif

@if (Route::is('donate'))
            @lang('miscellaneous.menu.public.donate')
@endif

@if (Route::is('about.home'))
            @lang('miscellaneous.public.about.title')
@endif

@if (Route::is('about.help'))
            @lang('miscellaneous.public.help.title')
@endif

@if (Route::is('about.faq'))
            @lang('miscellaneous.public.faq.title')
@endif

@if (Route::is('about.terms_of_use'))
            @lang('miscellaneous.public.terms_of_use.title')
@endif

@if (Route::is('about.privacy_policy'))
            @lang('miscellaneous.public.privacy_policy.title')
@endif
        </title>
    </head>

    <body>
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="position-relative d-flex flex-column align-items-center justify-content-center overflow-hidden">
            <h1 class="text-center">@lang('miscellaneous.foundation_name')</h1>
            <h2 class="text-yellow">@lang('miscellaneous.slogan')</h2>
            <a href="#about" class="btn-get-started scrollto"><i class="bi bi-chevron-double-down"></i></a>
            <div class="position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.5);"></div>
        </section><!-- End Hero -->

        <!-- ======= Header ======= -->
        <header id="header" class="d-flex align-items-center">
            <div class="container d-flex align-items-center justify-content-between">
                <div class="logo">
                    <h1>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="" class="img-fluid">
                            <span class="d-inline-block pt-1 align-middle fw-bold" style="font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
                                <span class="text-blue">J-P</span> <span class="text-green">TSHIENDA</span>
                            </span>
                        </a>
                    </h1>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto{{ Route::is('home') ? ' active' : '' }}" href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a></li>
                        <li><a class="nav-link scrollto{{ Route::is('about.home') ? ' active' : '' }}" href="{{ route('about.home') }}">@lang('miscellaneous.menu.public.about')</a></li>
                        <li><a class="nav-link scrollto{{ Route::is('news.home') ? ' active' : '' }}" href="{{ route('news.home') }}">@lang('miscellaneous.menu.public.news')</a></li>
                        <li><a class="nav-link scrollto{{ Route::is('works') ? ' active' : '' }}" href="{{ route('works') }}">@lang('miscellaneous.menu.public.works')</a></li>
                    </ul>
                    <a class="btn btn-outline-primary d-lg-inline-block d-none ms-lg-5 px-3 rounded-pill scrollto" href="#donate">
                        @lang('miscellaneous.menu.public.donate')
                    </a>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->
            </div>
        </header><!-- End Header -->

        <!-- ======= Main ======= -->
        <main id="main">
@yield('guest-content')

            <!-- ======= Donate Section ======= -->
            <section id="donate" class="contact section-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="contact-about">
                                <h3>@lang('miscellaneous.foundation_name')</h3>
                                <p>@lang('miscellaneous.foundation_description')</p>

                                <div class="social-links">
                                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4">
                            <div class="info">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt"></i>
                                    <p>@lang('miscellaneous.public.footer.head_office.address')</p>
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-envelope"></i>
                                    <p>@lang('miscellaneous.public.footer.head_office.email')</p>
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-phone"></i>
                                    <p>@lang('miscellaneous.public.footer.head_office.phone')</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-8">
                            <form action="" method="post" role="form" class="php-email-form mt-sm-0 mt-3">
                                <div class="form-group">
                                    <input type="text" name="register_names" id="register_names" class="form-control" placeholder="@lang('miscellaneous.names')" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="email" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="register_subject" id="register_subject" class="form-control" placeholder="@lang('miscellaneous.public.footer.message.subject')" required>
                                </div>
                                <div class="form-group mt-3">
                                    <textarea class="form-control" name="message" rows="5" placeholder="@lang('miscellaneous.public.footer.message.content')" required></textarea>
                                </div>
                                <div class="my-3">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>
                                </div>
                                <div class="text-center"><button type="submit">Send Message</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </section><!-- End Donate Section -->
        </main><!-- Main -->

        <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="container">
                <div class="copyright">
                    &copy; Copyright {{ date('Y') }} <strong><span>@lang('miscellaneous.foundation_name')</span></strong>. @lang('miscellaneous.all_right_reserved')
                </div>
                <div class="credits">
                    Designed by <a href="https://silasmas.com/">SDEV</a>
                </div>
            </div>
        </footer><!-- End  Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- JavaScript Libraries -->
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/addons/lonely/purecounter/purecounter_vanilla.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/addons/lonely/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/addons/lonely/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/addons/lonely/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/addons/lonely/waypoints/noframework.waypoints.js') }}"></script>
        <script src="{{ asset('assets/addons/lonely/php-email-form/validate.js') }}"></script>

        <!-- Lonely Javascript -->
        <script src="{{ asset('assets/js/script.lonely.js') }}"></script>
        <!-- Custom Javascript -->
        <script type="text/javascript">
            $(document).ready(function () {
                
            });
        </script>
    </body>
</html>
