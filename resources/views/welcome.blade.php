@extends('layouts.guest')

@section('guest-content')

            <!-- ======= About Section ======= -->
            <section id="about" class="about">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start rounded-5"></div>
                        <div class="col-xl-7 ps-0 ps-lg-5 pe-lg-1 d-flex align-items-stretch">
                            <div class="content d-flex flex-column justify-content-center">
                                <h3>@lang('miscellaneous.public.home.who_are_we.title')</h3>
                                <p class="mb-4">@lang('miscellaneous.public.home.who_are_we.content')</p>

                                <div class="row">
                                    <div class="col-md-6 d-md-flex align-items-md-stretch">
                                        <div class="count-box">
                                            <i class="bi bi-people"></i>
                                            <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter"></span>
                                            <p><strong>@lang('miscellaneous.public.home.who_are_we.children.title')</strong> @lang('miscellaneous.public.home.who_are_we.children.content')</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-md-flex align-items-md-stretch">
                                        <div class="count-box">
                                            <i class="bi bi-puzzle"></i>
                                            <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1" class="purecounter"></span>
                                            <p><strong>@lang('miscellaneous.public.home.who_are_we.partners.title')</strong> @lang('miscellaneous.public.home.who_are_we.partners.content')</p>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <a href="{{ route('about.home') }}" class="btn btn-outline-warning rounded-pill py-2 px-4 text-dark">
                                            @lang('miscellaneous.see_more')<i class="bi bi-chevron-double-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- End .content-->
                        </div>
                    </div>
                </div>
            </section><!-- End About Section -->

            <!-- ======= Download Mobile App Section ======= -->
            <section id="about" class="about" style="background-color: rgba(0, 0, 0, 0.7);" data-parallax="scroll" data-image-src="{{ asset('assets/img/pubs/app-mobile.jpg') }}">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-7 col-sm-6 wow fadeInUp text-sm-start text-center" data-wow-delay="0.3s">
                            <h1 class="h1 mb-4 fw-bold text-white">@lang('miscellaneous.public.home.download_mobile_app.title')</h1>
                            <p class="lead m-0 text-white">@lang('miscellaneous.public.home.download_mobile_app.content')</p>
                        </div>

                        <div class="col-lg-5 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="bg-image mb-4">
                                <img src="{{ asset('assets/img/button-playstore-white.png') }}" alt="" class="img-fluid">
                                <div class="mask"><a href="#" class="stretched-link"></a></div>
                            </div>

                            <div class="bg-image">
                                <img src="{{ asset('assets/img/button-applestore-white.png') }}" alt="" class="img-fluid">
                                <div class="mask"><a href="#" class="stretched-link"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Download Mobile App Section -->

            <!-- ======= Join Us Section ======= -->
            <section id="services" class="services section-bg">
                <div class="container">
                    <div class="section-title">
                        <h2>@lang('miscellaneous.public.home.join_us.title')</h2>
                    </div>

                    <div class="row g-5">
                        <div class="col-sm-6">
                            <p class="lead mb-4">@lang('miscellaneous.public.home.join_us.content')</p>
                            <p>
                                <a href="{{ route('login') }}" class="btn btn-outline-warning py-2 px-4 rounded-pill text-dark">
                                    @lang('miscellaneous.go_login')<i class="bi bi-chevron-double-right ms-3"></i>
                                </a>
                            </p>
                        </div>

                        <div class="col-sm-6">
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
                                            <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')">
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
                                        <button class="btn btn-success btn-sm-inline-block btn-block rounded-pill mb-4 shadow-0" type="submit">@lang('miscellaneous.register')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
    
                    </div>
                </div>
            </section><!-- End Join Us Section -->

            <!-- ======= Project Section ======= -->
            <section id="portfolio" class="portfolio section-bg">
                <div class="container">
                    <div class="section-title">
                        <h2>@lang('miscellaneous.public.home.projects.title')</h2>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <ul id="portfolio-flters">
                                <li data-filter="*" class="filter-active">@lang('miscellaneous.public.home.projects.all')</li>
                                <li data-filter=".filter-app">@lang('miscellaneous.public.home.projects.project1')</li>
                                <li data-filter=".filter-card">@lang('miscellaneous.public.home.projects.project2')</li>
                                <li data-filter=".filter-web">@lang('miscellaneous.public.home.projects.project3')</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row portfolio-container">
                        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub003.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>App 1</h4>
                                    <p>App</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub003.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 1"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub001.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Web 3</h4>
                                    <p>Web</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub001.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 3"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub012.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>App 2</h4>
                                    <p>App</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub012.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 2"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub004.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Card 2</h4>
                                    <p>Card</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub004.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 2"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub006.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Web 2</h4>
                                    <p>Web</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub006.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 2"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub011.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>App 3</h4>
                                    <p>App</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub011.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 3"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub005.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Card 1</h4>
                                    <p>Card</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub005.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 1"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub010.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Card 3</h4>
                                    <p>Card</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub010.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 3"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                            <div class="portfolio-wrap">
                                <img src="{{ asset('assets/img/pubs/pub007.jpg') }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>Web 3</h4>
                                    <p>Web</p>
                                </div>
                                <div class="portfolio-links">
                                    <a href="{{ asset('assets/img/pubs/pub007.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 3"><i class="bx bx-plus"></i></a>
                                    <a href="{{ route('work.datas', ['id' => 0]) }}" title="@lang('miscellaneous.see_more')"><i class="bx bx-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Project Section -->
  
@endsection
