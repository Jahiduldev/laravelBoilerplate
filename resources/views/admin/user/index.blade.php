@extends('layouts/layoutMaster')

@section('title', 'user')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
          'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
    ])
@endsection

@section('page-style')
    <!-- Page -->
    @vite([])
@endsection

@section('vendor-script')
    @vite([
          'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
          'resources/assets/vendor/libs/moment/moment.js',
          'resources/assets/vendor/libs/flatpickr/flatpickr.js',
          'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
      ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/user.js'
    ])
@endsection

@section('content')

    <!-- In your Blade template -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <!-- Add a data attribute to an HTML element -->
    <div id="routeData" data-url="{{ route('user-list') }}"></div>

    <!-- Advanced Search -->
    <div class="card">

        <x-data-table-header-card title="user" :buttons="$buttons" />

        <div class="card-body">
            <form class="dt_adv_search" method="POST">
                <div class="row">
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-4">
                                <label class="form-label">Name:</label>
                                <input type="text"
                                       class="form-control dt-input dt-full-name"
                                       data-column=1
                                       placeholder="name"
                                       data-column-index="0">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <hr class="mt-0">
        <x-datatable.table-list :headers="$headers" />
    </div>
    <!--/ Advanced Search -->
@endsection
