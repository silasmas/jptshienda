@extends('layouts.guest')

@section('guest-content')

        <!-- ======= Hero Section ======= -->
        <section id="hero" class="position-relative d-flex flex-column align-items-center justify-content-center overflow-hidden">
            <h1 class="text-center">@lang('miscellaneous.foundation_name')</h1>
            <h2 class="text-yellow">@lang('miscellaneous.slogan')</h2>
            <a href="#about" class="btn-get-started scrollto"><i class="bi bi-chevron-double-down"></i></a>
            <div class="position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.5);"></div>
        </section><!-- End Hero -->


@endsection
