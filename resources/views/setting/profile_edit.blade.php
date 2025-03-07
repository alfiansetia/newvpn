@php
    $user = user();
@endphp
@extends('layouts.backend.template', ['title' => 'Setting Profile'])

@push('css')
    <link href="{{ cdn('backend/src/assets/css/light/components/tabs.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/elements/alert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/components/tabs.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/elements/alert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="account-settings-container layout-top-spacing">
        <div class="account-content">
            <div class="row mb-3">
                <div class="col-md-12">
                    <ul class="nav nav-pills" id="animateLine" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="animated-underline-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home-icon">
                                <i data-feather="user"></i> Preferences
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="animated-underline-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-social-icon">
                                <i data-feather="at-sign"></i> Social
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="animated-underline-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-pass-icon">
                                <i data-feather="lock"></i> Password
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel"
                    aria-labelledby="animated-underline-home-tab" tabindex="0">

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="form_general" class="section general-info was-validated"
                                action="{{ route('api.profile.update.general') }}" method="POST">
                                <div class="info">
                                    <h6 class="">General Information</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class=" col-lg-12 col-md-12 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="name">Full Name</label>
                                                                    <input type="text"
                                                                        class="form-control mb-3 maxlength" name="name"
                                                                        id="name" placeholder="Full Name"
                                                                        value="{{ $user->name }}" minlength="3"
                                                                        maxlength="50" required autofocus>
                                                                    <span class="error invalid-feedback err_name"
                                                                        style="display: hide;"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="text"
                                                                        class="form-control mb-3 maxlength" name="email"
                                                                        id="email" placeholder="Write your email here"
                                                                        value="{{ $user->email }}" disabled readonly>
                                                                    <span class="error invalid-feedback err_email"
                                                                        style="display: hide;"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="gender">Gender</label>
                                                                    <select class="form-select mb-3" name="gender"
                                                                        id="gender" required>
                                                                        <option
                                                                            {{ $user->gender == 'male' ? 'selected' : '' }}
                                                                            value="male">Male</option>
                                                                        <option
                                                                            {{ $user->gender == 'female' ? 'selected' : '' }}
                                                                            value="female">Female</option>
                                                                    </select>
                                                                    <span class="error invalid-feedback err_gender"
                                                                        style="display: hide;"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="phone">Phone/Whatsapp</label>
                                                                    <input type="tel"
                                                                        class="form-control mb-3 maxlength" name="phone"
                                                                        id="phone"
                                                                        placeholder="Write your phone number here"
                                                                        value="{{ $user->phone }}" minlength="8"
                                                                        maxlength="15" required>
                                                                    <span class="error invalid-feedback err_phone"
                                                                        style="display: hide;"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="address">Address</label>
                                                                    <textarea class="form-control mb-3 maxlength" name="address" id="address" placeholder="Your Address"
                                                                        minlength="3" maxlength="150" required>{{ $user->address }}</textarea>
                                                                    <span class="error invalid-feedback err_address"
                                                                        style="display: hide;"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 mt-1">
                                                                <div class="form-group text-end">
                                                                    <button type="submit" class="btn btn-secondary">
                                                                        <i class="fas fa-paper-plane me-1 bs-tooltip"
                                                                            title="Save"></i>Save
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="pills-social-icon" role="tabpanel"
                    aria-labelledby="animated-underline-social-tab" tabindex="0">

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="form_social" class="section social was-validated"
                                action="{{ route('api.profile.update.social') }}" method="POST">
                                <div class="info">
                                    <h5 class="">Social</h5>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group social-linkedin mb-3">
                                                        <span class="input-group-text me-3" id="linkedin">
                                                            <i data-feather="linkedin"></i></span>
                                                        <input type="text" name="linkedin"
                                                            class="form-control maxlength" placeholder="Linkedin Username"
                                                            aria-label="Username" aria-describedby="linkedin"
                                                            value="{{ $user->linkedin }}" minlength="3" maxlength="30"
                                                            required>
                                                        <span class="error invalid-feedback err_linkedin"
                                                            style="display: hide;"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="input-group social-tweet mb-3">
                                                        <span class="input-group-text me-3" id="tweet">
                                                            <i data-feather="instagram"></i></span>
                                                        <input type="text" name="instagram"
                                                            class="form-control maxlength"
                                                            placeholder="Instagram Username" aria-label="Username"
                                                            aria-describedby="tweet" value="{{ $user->instagram }}"
                                                            minlength="3" maxlength="30" required>
                                                        <span class="error invalid-feedback err_instagram"
                                                            style="display: hide;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-11 mx-auto">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group social-fb mb-3">
                                                        <span class="input-group-text me-3" id="fb">
                                                            <i data-feather="facebook"></i></span>
                                                        <input type="text" name="facebook"
                                                            class="form-control maxlength" placeholder="Facebook Username"
                                                            aria-label="Username" aria-describedby="fb"
                                                            value="{{ $user->facebook }}" minlength="3" maxlength="30"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="input-group social-github mb-3">
                                                        <span class="input-group-text me-3" id="github">
                                                            <i data-feather="github"></i></span>
                                                        <input type="text" name="github"
                                                            class="form-control maxlength" placeholder="Github Username"
                                                            aria-label="Username" aria-describedby="github"
                                                            value="{{ $user->github }}" minlength="3" maxlength="30"
                                                            required>
                                                        <span class="error invalid-feedback err_github"
                                                            style="display: hide;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-11 mx-auto">
                                            <div class="form-group text-end">
                                                <button type="submit" class="btn btn-secondary">
                                                    <i class="fas fa-paper-plane me-1 bs-tooltip" title="Save"></i>Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="pills-pass-icon" role="tabpanel"
                    aria-labelledby="animated-underline-pass-tab" tabindex="0">

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 layout-spacing">
                            <div class="section general-info">
                                <div class="info">
                                    <h6 class="">Info</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class=" col-lg-12 col-md-8 mt-md-0">
                                                    <ul class="list-icon mb-4">
                                                        <li>
                                                            <i class="fas fa-arrow-right"></i>
                                                            <span class="list-text">Password harus lebih dari 8
                                                                karakter.</span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-arrow-right"></i>
                                                            <span class="list-text">Gunakan kombinasi huruf dan angka atau
                                                                simbol.</span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-arrow-right"></i>
                                                            <span class="list-text">Hindari password dengan kata
                                                                umum.</span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-arrow-right"></i>
                                                            <span class="list-text">Jangan menggunakan Password yang
                                                                sama.</span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-arrow-right"></i>
                                                            <span class="list-text">Gunakan istilah yang mudah anda
                                                                ingat.</span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-arrow-right"></i>
                                                            <span class="list-text">Password akan dienkripsi untuk
                                                                menghindari penyalahgunaan data.</span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-arrow-right"></i>
                                                            <span class="list-text">Harap hati-hati dalam mengubah password
                                                                !</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-8 col-md-12 layout-spacing">
                            <form id="form_password" class="section general-info was-validated"
                                action="{{ route('api.profile.update.password') }}" method="POST">
                                <div class="info">
                                    <h6 class="">Password Setting</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class=" col-lg-12 col-md-12 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password">New Password</label>
                                                                    <input type="password" name="password" id="password"
                                                                        class="form-control mb-3 maxlength"
                                                                        placeholder="New Password" minlength="8"
                                                                        maxlength="100" required autofocus
                                                                        autocomplete="new-password">
                                                                    <span class="error invalid-feedback err_password"
                                                                        style="display: hide;"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password_confirmation">Confirm
                                                                        Password</label>
                                                                    <input type="password" name="password_confirmation"
                                                                        id="password_confirmation"
                                                                        placeholder="Confirm Password"
                                                                        class="form-control mb-3 maxlength "
                                                                        minlength="8" maxlength="100" required
                                                                        autocomplete="new-password">
                                                                    <span
                                                                        class="error invalid-feedback err_password_confirmation"
                                                                        style="display: hide;"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-1">
                                                                <div class="form-group text-end">
                                                                    <button type="submit" class="btn btn-secondary">
                                                                        <i class="fas fa-paper-plane me-1 bs-tooltip"
                                                                            title="Save"></i>Save
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
@endsection

@push('jslib')
    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
@endpush

@push('js')
    <script src="{{ asset('js/v2/func.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.maxlength').maxlength({
                placement: "top",
                alwaysShow: true
            });

            $('#form_general').submit(function(event) {
                event.preventDefault();
            }).validate({
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                },
                submitHandler: function(form) {
                    send_ajax_only('form_general', 'POST')
                }
            });

            $('#form_social').submit(function(event) {
                event.preventDefault();
            }).validate({
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                },
                submitHandler: function(form) {
                    send_ajax_only('form_social', 'POST')
                }
            });

            $('#form_password').submit(function(event) {
                event.preventDefault();
            }).validate({
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                },
                submitHandler: function(form) {
                    send_ajax_only('form_password', 'POST')
                }
            });

        });
    </script>
@endpush
