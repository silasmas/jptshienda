@extends('layouts.guest')

@section('guest-content')

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
                            <form action="" method="post" role="form" class="php-email-form">
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

@endsection
