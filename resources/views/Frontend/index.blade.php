@extends('frontend.master_dashboard')
@section('title')
    | Home
@endsection
@section('main')
    @include('frontend.home.home_slider')
    <!--End hero slider-->
    @include('frontend.home.home_features_category')

    <!--End category slider-->

    @include('frontend.home.home_banner')
    <!--End banners-->



    @include('frontend.home.home_new_product')


    <!--Products Tabs-->


    @include('frontend.home.home_features_product')



    <!--End Best Sales-->









    <!-- TV Category -->
    @include('frontend.home.categories_wise_product')
    <!--End TV Category -->


    
    <!--End 4 columns-->
    @include('frontend.home.hot_deals')

    <!--Vendor List -->
    @include('frontend.home.home_vendor_list')


    <!--End Vendor List -->
@endsection
