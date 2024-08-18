@extends('frontend.master_dashboard')
@section('title')
    | User Dashboard
@endsection
@section('main')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 m-auto">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        @include('frontend.userDashboard.dashboard_navigation')
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    @include('frontend.userDashboard.dashboard')
                                    @include('frontend.userDashboard.order')
                                    @include('frontend.userDashboard.return_order')
                                    @include('frontend.userDashboard.track_order')
                                    @include('frontend.userDashboard.account_details')
                                    @include('frontend.userDashboard.change_password')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
