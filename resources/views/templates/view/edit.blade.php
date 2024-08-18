@extends('layouts/layoutMaster')

@section('title', '{{ name }}')

@section('vendor-style')
    @vite([
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
            'resources/assets/vendor/libs/select2/select2.scss',
            'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
            'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
            'resources/assets/vendor/libs/tagify/tagify.scss',
            'resources/assets/vendor/libs/@form-validation/form-validation.scss'
    ])
@endsection

@section('page-style')
    <!-- Page -->
    @vite([  ])
@endsection

@section('vendor-script')
    @vite([
              'resources/assets/vendor/libs/select2/select2.js',
              'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
              'resources/assets/vendor/libs/moment/moment.js',
              'resources/assets/vendor/libs/flatpickr/flatpickr.js',
              'resources/assets/vendor/libs/typeahead-js/typeahead.js',
              'resources/assets/vendor/libs/tagify/tagify.js',
              'resources/assets/vendor/libs/@form-validation/popular.js',
              'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
              'resources/assets/vendor/libs/@form-validation/auto-focus.js'
      ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/notice-validation.js',
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


    <div class="row mb-4">
        <!-- Bootstrap Validation -->
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">{{ name }}</h5>
                <div class="card-body">
                    <form class="needs-validation"
                          method="POST"
                          action="{{ route('{{ name }}-update') }}"
                          enctype="multipart/form-data"
                          novalidate>

                        <input type="hidden" name="id" value="{{ $data->id }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="bs-validation-name"
                                   placeholder=""
                                   required
                                   maxlength="200"
                                   minlength="2"
                                   name="name"
                                   value="{{ $data->name }}"
                            />
                            <div class="valid-feedback"> Looks good!</div>
                            <div class="invalid-feedback"> Please enter your name.</div>

                            @error('name')
                            {!! '<div class="invalid-feedback was-validated">' . $message . '</div>' !!}
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox"
                                       name="status"
                                       class="switch-input"
                                    {{ $data->status === \App\Models\Designation::STATUS_ACTIVE ? 'checked' : '' }}
                                />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                  </span>
                                <span class="switch-label">Active now</span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Bootstrap Validation -->
    </div>
@endsection
