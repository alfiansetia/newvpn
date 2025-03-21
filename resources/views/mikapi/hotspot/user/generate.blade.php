@php
    $param_router = '?router=' . request()->query('router');
@endphp


@extends('layouts.backend.template_mikapi', ['title' => 'Generate Hotspot User'])
@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ cdn('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/src/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet" type="text/css">

    <style>
        .row-disabled {
            background-color: rgb(218, 212, 212)
        }

        .form-control.flatpickr-input {
            background-image: none !important;
        }
    </style>
@endpush
@section('content')
    <div class="row" id="cancel-row">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-sync me-1 bs-tooltip" title="Add Data"></i>Generate Hotspot User</h5>
                    </div>
                    <div class="card-body">
                        <form id="form_gen" class="was-validated"
                            action="{{ route('api.mikapi.hotspot.users.generate') }}?router={{ request()->query('router') }}"
                            method="POST">
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <label class="control-label" for="gen_qty">Qty :</label>
                                    <input type="text" name="qty" class="form-control mask_angka" id="gen_qty"
                                        placeholder="Please Enter Price" min="1" max="1000" value="1"
                                        required>
                                    <span class="error invalid-feedback err_qty" style="display: hide;"></span>
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <label class="control-label" for="gen_server">Server :</label>
                                    <select name="server" id="gen_server" class="form-control-lg tomse-server"
                                        style="width: 100%;" required>
                                    </select>
                                    <span class="error invalid-feedback err_server" style="display: hide;"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <label class="control-label" for="gen_user_mode">User Mode :</label>
                                    <select name="user_mode" id="gen_user_mode" class="form-select form-control-lg"
                                        style="width: 100%;" required>
                                        <option value="up">User & Passw (Member)</option>
                                        <option value="vc">User = Passw (Voucher)</option>
                                    </select>
                                    <span class="error invalid-feedback err_user_mode" style="display: hide;"></span>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label class="control-label" for="gen_length">Name Length :</label>
                                    <select name="length" id="gen_length" class="form-select form-control-lg"
                                        style="width: 100%;" required>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5" selected>5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    <span class="error invalid-feedback err_length" style="display: hide;"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <label class="control-label" for="gen_prefix">Prefix :</label>
                                    <input type="text" name="prefix" class="form-control maxlength" id="gen_prefix"
                                        placeholder="Please Enter Prefix" maxlength="6" pattern="[a-zA-Z0-9]*">
                                    <span class="error invalid-feedback err_prefix" style="display: hide;"></span>
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <label class="control-label" for="gen_character">Character :</label>
                                    <select name="character" id="gen_character" class="form-select form-control-lg"
                                        style="width: 100%;" required>
                                        <option value="num">Random 23456</option>
                                        <option value="low">Random abcd</option>
                                        <option value="up">Random ABCD</option>
                                        <option value="uplow">Random aBcD</option>
                                        <option value="numlow" selected>Random 5ab2c34d</option>
                                        <option value="numup">Random 5AB2C34D</option>
                                        <option value="numlowup">Random 5aB2c34D</option>
                                    </select>
                                    <span class="error invalid-feedback err_character" style="display: hide;"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <label class="control-label" for="gen_profile">Profile :</label>
                                    <select name="profile" id="gen_profile" class="form-control-lg tomse-profile"
                                        style="width: 100%;" required>
                                    </select>
                                    <small id="profile_helper" class="form-text text-muted"></small>
                                    <span class="error invalid-feedback err_profile" style="display: hide;"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 mb-2">
                                    <label class="control-label" for="gen_data_day">Day Limit :</label>
                                    <input type="text" name="data_day" class="form-control mask_angka"
                                        id="gen_data_day" placeholder="Please Enter Day Limit" value="0">
                                    <span class="error invalid-feedback err_data_day" style="display: hide;"></span>
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label class="control-label" for="gen_time_limit">Time Limit :</label>
                                    <input type="text" name="time_limit" class="form-control" id="gen_time_limit"
                                        placeholder="Please Enter Time Limit" value="00:00:00" required>
                                    <span class="error invalid-feedback err_time_limit" style="display: hide;"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 mb-2">
                                    <label class="control-label" for="gen_data_limit">Data Limit :</label>
                                    <input type="text" name="data_limit" class="form-control mask_angka"
                                        id="gen_data_limit" placeholder="Please Enter Data Limit" value="0">
                                    <span class="error invalid-feedback err_data_limit" style="display: hide;"></span>
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label class="control-label" for="gen_data_type">Type :</label>
                                    <select name="data_type" id="gen_data_type" class="form-control select2">
                                        <option value="">KB</option>
                                        <option value="M">MB</option>
                                        <option value="G">GB</option>
                                        <option value="B">Bytes</option>
                                    </select>
                                    <span class="error invalid-feedback err_data_type" style="display: hide;"></span>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="control-label" for="gen_comment">Comment :</label>
                                <textarea name="comment" class="form-control maxlength" id="gen_comment" minlength="0" maxlength="100"
                                    placeholder="Please Enter Comment"></textarea>
                                <span class="error invalid-feedback err_comment" style="display: hide;"></span>
                            </div>
                            <div class="card-footer text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ route('mikapi.voucher.index') }}{{ $param_router }}"
                                            class="btn btn-secondary mb-2">
                                            <i class="fas fa-arrow-left me-1 bs-tooltip"
                                                title="Back to User List"></i>Back</a>
                                        <button type="reset" id="reset" class="btn btn-warning mb-2">
                                            <i class="fas fa-undo me-1 bs-tooltip" title="Reset"></i>Reset</button>
                                        <button type="submit" class="btn btn-primary mb-2">
                                            <i class="fas fa-paper-plane me-1 bs-tooltip" title="Save"></i>Save</button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('jslib')
    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/moment/moment-with-locales.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ cdn('backend/src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.hotspot.user') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.hotspot.users.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.hotspot.users.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        $(document).ready(function() {
            document.getElementById('gen_profile').tomselect.on('change', function(value) {
                if (!value) return;
                let selectedData = this.options[value];
                $('#profile_helper').text('')
                if (selectedData.mikhmon != null) {
                    $('#profile_helper').text(
                        `Validity : ${selectedData.mikhmon.validity} | Price : ${hrg(selectedData.mikhmon.price)} | Selling Price ${hrg(selectedData.mikhmon.selling_price)} : | Lock User : ${selectedData.mikhmon.lock}`
                    )
                }
            });
        })

        document.getElementById("gen_comment").onkeypress = function(e) {
            var chr = String.fromCharCode(e.which);
            if (" _!@#$%^&*()+=;|?,.~".indexOf(chr) >= 0)
                return false;
        };


        $('.mask_angka').inputmask({
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
            digits: 0,
            rightAlign: false,
            removeMaskOnSubmit: true,
            autoUnmask: true,
            min: 0,
        });

        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });

        Inputmask("ip").mask($(".mask_ip"));
        Inputmask("mac").mask($(".mask_mac"));

        var f3 = $('#gen_time_limit').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            defaultDate: "today",
            disableMobile: true,
            time_24hr: true,
            enableSeconds: true
        })

        var tomse_data_profile = null;
        document.querySelectorAll('.tomse-profile').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'name',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Profile",
                allowEmptyOption: true,
                load: function(query, callback) {
                    if (tomse_data_profile) {
                        callback(tomse_data_profile);
                        return;
                    }
                    var url = '{{ route('api.mikapi.hotspot.profiles.index') }}' + param_router +
                        '&limit=' + perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            tomse_data_profile = json.data
                            callback(json.data);
                        }).catch(() => {
                            callback();
                        });
                },
            });
        });

        var tomse_data_server = null;
        document.querySelectorAll('.tomse-server').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'name',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Server",
                allowEmptyOption: true,
                options: [{
                    name: 'all'
                }],
                load: function(query, callback) {
                    if (tomse_data_server) {
                        callback(tomse_data_server);
                        return;
                    }
                    var url = '{{ route('api.mikapi.hotspot.servers.index') }}' + param_router +
                        '&limit=' +
                        perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            tomse_data_server = json.data
                            callback(json.data);
                        }).catch(() => {
                            callback();
                        });
                },
            });
            tomse.setValue('all');
        });

        $('#reset').click(function() {
            document.getElementById('gen_server').tomselect.setValue('all');
            document.getElementById('gen_profile').tomselect.clear()
        })

        $('#form_gen').submit(function(event) {
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
                send_ajax('form_gen', 'POST')
            }
        });


        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
