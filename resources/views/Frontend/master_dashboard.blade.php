<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta name="csrf_token" content="{{ csrf_token() }}"/>
    <!-- Favicon -->
    @include('partials.frontend.header_link')
</head>

<body>
    <!-- Modal -->

    <!-- Quick view -->
    @include('frontend.body.quick_view')

    <!-- Header  -->
    @include('frontend.body.header')

    <!-- End Header  -->
    <!--End header-->

    <main class="main">
        @yield('main')
    </main>



    @include('frontend.body.footer')
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    @include('partials.frontend.foot_script')
</body>

</html>
