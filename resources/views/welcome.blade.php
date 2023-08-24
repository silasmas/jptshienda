@extends('layouts.guest')

@section('guest-content')

        <!-- Carousel Start -->
        <div class="container-fluid px-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="bg-image">
                            <img class="w-100" src="{{ asset('assets/img/slides/slide-1.png') }}" alt="">
                            <div class="mask" style="background: linear-gradient(45deg, hsla(202, 95%, 34%, 0.5), hsla(0, 0%, 0%, 0.5) 100%);"></div>
                        </div>
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-lg-start justify-content-center">
                                    <div class="col-lg-8 text-lg-start text-center">
                                        <p class="fs-4 text-white">@lang('miscellaneous.public.home.slide1.title')</p>
                                        <h1 class="display-1 text-white mb-5 animated slideInRight">@lang('miscellaneous.public.home.slide1.content')</h1>
                                        <a href="" class="btn btn-light rounded-pill py-3 px-5 shadow-0 animated slideInRight">@lang('miscellaneous.see_more')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="bg-image">
                            <img class="w-100" src="{{ asset('assets/img/slides/slide-2.png') }}" alt="">
                            <div class="mask" style="background: linear-gradient(45deg, hsla(0, 0%, 0%, 0.5), hsla(202, 95%, 34%, 0.5) 100%);"></div>
                        </div>
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-lg-end justify-content-center">
                                    <div class="col-lg-8 text-lg-end text-center">
                                        <p class="fs-4 text-white">@lang('miscellaneous.public.home.slide2.title')</p>
                                        <h1 class="display-1 text-white mb-5 animated slideInRight">@lang('miscellaneous.public.home.slide2.content')</h1>
                                        <a href="" class="btn btn-light rounded-pill py-3 px-5 shadow-0 animated slideInLeft">@lang('miscellaneous.see_more')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="bg-image">
                            <img class="w-100" src="{{ asset('assets/img/slides/slide-3.png') }}" alt="">
                            <div class="mask" style="background: linear-gradient(45deg, hsla(202, 95%, 34%, 0.5), hsla(0, 0%, 0%, 0.5) 100%);"></div>
                        </div>
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-lg-start justify-content-center">
                                    <div class="col-lg-8 text-lg-start text-center">
                                        <p class="fs-4 text-white">@lang('miscellaneous.public.home.slide3.title')</p>
                                        <h1 class="display-1 text-white mb-5 animated slideInRight">@lang('miscellaneous.public.home.slide3.content')</h1>
                                        <a href="" class="btn btn-light rounded-pill py-3 px-5 shadow-0 animated slideInRight">@lang('miscellaneous.see_more')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">@lang('pagination.previous')</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">@lang('pagination.next')</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- About Start -->
        <div class="container-xxl py-4">
            <div class="container">
                <div class="row g-5 align-items-end">
                    <div class="col-lg-6">
                        <div class="row g-2">
                            <div class="col-6 position-relative wow fadeIn" data-wow-delay="0.7s">
                                <div class="about-experience acr-bg-yellow-transparent p-4 rounded text-center">
                                    <h1 class="display-3 fw-bold mb-1">
                                        <span class="acr-text-red-2">A</span><span class="acr-text-yellow">C</span><span class="acr-text-blue">R</span>
                                    </h1>
                                    <p class="acr-line-height-1_4 m-0">@lang('miscellaneous.public.about.slogan')</p>
                                </div>
                            </div>
                            <div class="col-6 wow fadeInUp" data-wow-delay="0.1s">
                                <img class="img-fluid rounded" src="{{ asset('assets/img/about/about-1.png') }}">
                            </div>
                            <div class="col-6 wow fadeInUp" data-wow-delay="0.3s">
                                <img class="img-fluid rounded" src="{{ asset('assets/img/about/about-2.png') }}">
                            </div>
                            <div class="col-6 wow fadeInUp" data-wow-delay="0.5s">
                                <img class="img-fluid rounded" src="{{ asset('assets/img/about/about-3.png') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                        <h5 class="section-title bg-white text-start acr-text-red-2 my-4 pe-3">@lang('miscellaneous.public.about.title')</h5>
                        <h1 class="mb-4">@lang('miscellaneous.public.about.subtitle')</h1>
                        <p class="mb-3">@lang('miscellaneous.public.about.description')</p>

                        <div class="row g-5 mb-5">
                            <div class="col-sm-6">
                                <i class="bi bi-sun fs-1 acr-text-red-1"></i>
                                <h5 class="mb-3 fw-bold">@lang('miscellaneous.public.about.comment.title1')</h5>
                                <p class="m-0 small">@lang('miscellaneous.public.about.comment.content1')</p>
                            </div>
                            <div class="col-sm-6">
                                <i class="bi bi-people fs-1 acr-text-red-1"></i>
                                <h5 class="mb-3 fw-bold">@lang('miscellaneous.public.about.comment.title2')</h5>
                                <p class="m-0 small">@lang('miscellaneous.public.about.comment.content2')</p>
                            </div>
                        </div>

                        <a class="btn btn-secondary rounded-pill py-3 px-5" href="{{ route('about.home') }}">@lang('miscellaneous.see_more')</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Download App Start -->
        <div class="container-fluid banner my-5 py-4" style="background-color: rgba(0, 0, 0, 0.7);" data-parallax="scroll" data-image-src="{{ asset('assets/img/pubs/app-mobile.jpg') }}">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-7 col-sm-6 wow fadeInUp text-sm-start text-center" data-wow-delay="0.3s">
                        <h1 class="h1 mb-4 fw-bold text-white">@lang('miscellaneous.public.home.download_mobile_app.title')</h1>
                        <p class="lead m-0 text-white">@lang('miscellaneous.public.home.download_mobile_app.content')</p>
                    </div>
                    <div class="col-lg-5 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="bg-image mb-4">
                            <img src="{{ asset('assets/img/button-playstore-white.png') }}" alt="" class="img-fluid">
                            <div class="mask"><a href="{{ asset('mobile_app/acr-rdc-v1_0_0.apk') }}" class="stretched-link"></a></div>
                        </div>

                        <div class="bg-image">
                            <img src="{{ asset('assets/img/button-applestore-white.png') }}" alt="" class="img-fluid">
                            <div class="mask"><a href="#" class="stretched-link"></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Download App End -->

        <!-- Why Us Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="section-title bg-white text-start acr-text-blue mb-4 pe-3">@lang('miscellaneous.public.about.why_us.title')</h5>
                        <h1 class="mb-4">@lang('miscellaneous.public.about.why_us.subtitle')</h1>
                        <p class="mb-4">@lang('miscellaneous.public.about.why_us.content')</p>
                        <p><i class="fa fa-check acr-text-blue me-3"></i><strong>@lang('miscellaneous.public.about.why_us.item1')</strong>@lang('miscellaneous.colon_after_word') @lang('miscellaneous.public.about.why_us.item1_description')</p>
                        <p><i class="fa fa-check acr-text-blue me-3"></i><strong>@lang('miscellaneous.public.about.why_us.item2')</strong>@lang('miscellaneous.colon_after_word') @lang('miscellaneous.public.about.why_us.item2_description')</p>
                        <p><i class="fa fa-check acr-text-blue me-3"></i><strong>@lang('miscellaneous.public.about.why_us.item3')</strong>@lang('miscellaneous.colon_after_word') @lang('miscellaneous.public.about.why_us.item3_description')</p>
                        <a class="btn btn-secondary rounded-pill py-3 px-5 mt-3" href="{{ route('about.home') }}">@lang('miscellaneous.see_more')</a>
                    </div>

                    <div class="col-lg-6">
                        <div class="rounded overflow-hidden">
                            <div class="row g-0">
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                    <div class="text-center acr-bg-blue-transparent py-5 px-4">
                                        <img class="mb-4 opacity-75" src="{{ asset('assets/img/about/motto-1.png') }}" alt="@lang('miscellaneous.public.about.why_us.item1')" width="90">
                                        <p class="m-0 fs-5 fw-semi-bold acr-text-blue text-uppercase">@lang('miscellaneous.public.about.why_us.item1')</p>
                                    </div>
                                </div>

                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                    <div class="text-center acr-bg-blue py-5 px-4">
                                        <img class="mb-4 opacity-75" src="{{ asset('assets/img/about/motto-2.png') }}" alt="@lang('miscellaneous.public.about.why_us.item2')</" width="90">
                                        <p class="m-0 fs-5 fw-semi-bold text-white text-uppercase">@lang('miscellaneous.public.about.why_us.item2')</p>
                                    </div>
                                </div>

                                <div class="col-sm-6"></div>
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="text-center acr-bg-blue-transparent py-5 px-4">
                                        <img class="mb-4 opacity-75" src="{{ asset('assets/img/about/motto-3.png') }}" alt="@lang('miscellaneous.public.about.why_us.item3')</" width="90">
                                        <p class="m-0 fs-5 fw-semi-bold acr-text-blue text-uppercase">@lang('miscellaneous.public.about.why_us.item3')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Why Us End -->

    @if (empty(Auth::user()))
        <!-- Register as a member Start -->
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <div class="row g-5">
                    <div class="col-12 text-sm-center wow fadeInUp" data-wow-delay="0.1s">
                        <h1 class="display-5 fw-bold acr-text-blue mb-4">@lang('miscellaneous.public.home.register_member.title')</h1>
                        <p class="m-0 px-sm-5 fs-5 text-black acr-line-height-1_4">@lang('miscellaneous.public.home.register_member.content1')</p>
                    </div>

                    <div class="col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <p class="mb-4">@lang('miscellaneous.public.home.register_member.content2')</p>
                        <a href="{{ route('login') }}" class="btn acr-btn-outline-blue d-sm-inline-block d-block px-5 py-3 rounded-pill shadow-0">@lang('miscellaneous.public.home.register_member.login')</a>
                    </div>

                    <div class="col-sm-6 order-sm-1 wow fadeInUp" data-wow-delay="0.5s">
                        <h2 class="h2 mb-4 pt-4 d-sm-none border-top border-secondary fw-bold text-uppercase">@lang('miscellaneous.register_title1')</h2>

                        <form method="POST" action="{{ route('register') }}">
        @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" required>
                                        <label for="register_firstname">@lang('miscellaneous.firstname')</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.surname')">
                                        <label for="register_lastname">@lang('miscellaneous.lastname')</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-lg-5">
                                            <div class="form-floating pt-0">
                                                <select name="select_country" id="select_country1" class="form-select pt-2 shadow-0">
                                                    <option class="small" selected disabled>@lang('miscellaneous.choose_country')</option>
        @forelse ($countries as $country)
                                                    <option value="+{{ $country->country_phone_code }}">{{ $country->country_name }}</option>
        @empty
                                                    <option>@lang('miscellaneous.empty_list')</option>
        @endforelse
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-7">
                                            <div class="input-group">
                                                <span id="phone_code_text1" class="input-group-text d-inline-block h-100 bg-light" style="padding-top: 0.3rem; padding-bottom: 0.5rem; line-height: 1.35;">
                                                    <small class="text-secondary m-0 p-0" style="font-size: 0.85rem; color: #010101;">@lang('miscellaneous.phone_code')</small><br>
                                                    <span class="text-value">xxxx</span> 
                                                </span>

                                                <div class="form-floating">
                                                    <input type="hidden" id="phone_code1" name="phone_code_new_member" value="">
                                                    <input type="tel" name="phone_number_new_member" id="phone_number_new_member" class="form-control" placeholder="@lang('miscellaneous.phone')" required>
                                                    <label for="phone_number_new_member">@lang('miscellaneous.phone')</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-secondary btn-sm-inline-block btn-block rounded-pill mb-4 py-3 px-5 shadow-0" type="submit">@lang('miscellaneous.public.home.register_member.register')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register as a member End -->
    @endif

        <!-- Gallery Start -->
        <div class="container-xxl py-5 px-0">
            <div class="row g-0">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-5.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-5.png') }}" alt="">
                            </a>
                        </div>

                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-1.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-1.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-2.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-2.png') }}" alt="">
                            </a>
                        </div>
                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-6.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-6.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-7.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-7.png') }}" alt="">
                            </a>
                        </div>
                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-3.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-3.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-4.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-4.png') }}" alt="">
                            </a>
                        </div>
                        <div class="col-12">
                            <a class="d-block" href="{{ asset('assets/img/gallery/gallery-8.png') }}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{ asset('assets/img/gallery/gallery-8.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery End -->
@endsection
