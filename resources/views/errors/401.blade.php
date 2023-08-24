@extends('layouts.errors')

@section('errors-content')

        <!-- 401 Start -->
        <div class="container-xxl py-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container text-center">
                <div class="row mb-sm-5 mb-4 border-bottom border-secondary">
                    <div class="col-lg-3 col-sm-4 col-8 mx-auto pt-lg-4 pt-3">
                        <div class="bg-image mb-sm-5 mb-4 d-flex justify-content-center">
                            <img src="{{ asset('assets/img/logo-text.png') }}" alt="ACR" class="img-fluid">
                            <div class="mask"><a href="{{ route('home') }}"></a></div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h1 class="display-1 fw-bold acr-text-red-2">401</h1>
                        <h1 class="mb-4">{{ __('notifications.401_title') }}</h1>
                        <p class="mb-4">{{ __('notifications.401_description') }}</p>
                        <a href="{{ route('home') }}" class="btn acr-btn-yellow rounded-pill py-3 px-5">{{ __('miscellaneous.back_home') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- 401 End -->
@endsection
