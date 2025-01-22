@extends('layouts.backend.template_mikapi', ['title' => 'Hotspot Profile'])
@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ asset('backend/src/plugins/datatable/datatables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/table/datatable/dt-global_style.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />


    <link href="{{ asset('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/src/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ asset('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">

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
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_table">
            <div class="widget-content widget-content-area br-8">
                <form action="" id="formSelected">
                    <table id="tableData" class="table dt-table-hover table-hover" style="width:100%; cursor: pointer;">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        @include('mikapi.hotspot.profile.add')
        @include('mikapi.hotspot.profile.edit')
        @include('mikapi.hotspot.profile.detail')
    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ asset('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/moment/moment-with-locales.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ asset('backend/src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.hotspot.profile') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.hotspot.profiles.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.hotspot.profiles.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        // $(document).ready(function() {

        function remove_space(el) {
            let new_name = el.value.replace(/\s/g, "-");
            el.value = new_name;
        }

        $('#expired_mode').change(function() {
            let exp_mode = $(this).val()
            if (exp_mode == '' || exp_mode == 0) {
                $('#row_limit').hide()
            } else {
                $('#row_limit').show()
            }
        })

        $('#edit_expired_mode').change(function() {
            let exp_mode = $(this).val()
            if (exp_mode == '' || exp_mode == 0) {
                $('#edit_row_limit').hide()
            } else {
                $('#edit_row_limit').show()
            }
        })

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

        var f1 = $('#time_limit').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            defaultDate: "today",
            disableMobile: true,
            time_24hr: true,
            enableSeconds: true
        })

        var f2 = $('#edit_time_limit').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            defaultDate: "today",
            disableMobile: true,
            time_24hr: true,
            enableSeconds: true
        })

        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });

        var tomse_data = null;
        document.querySelectorAll('.tomse-parent').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'name',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Parent Queue",
                allowEmptyOption: true,
                options: [{
                    name: 'none'
                }],
                load: function(query, callback) {
                    if (tomse_data) {
                        callback(tomse_data);
                        return;
                    }
                    var url = '{{ route('api.mikapi.queues.index') }}' + param_router +
                        '&limit=' +
                        perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            tomse_data = json.data
                            callback(json.data);
                        }).catch(() => {
                            callback();
                        });
                },
            });
        });

        var tomse_pool_data = null;
        document.querySelectorAll('.tomse-pool').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'name',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Address Pool",
                allowEmptyOption: true,
                options: [{
                    name: 'none'
                }],
                load: function(query, callback) {
                    if (tomse_pool_data) {
                        callback(tomse_pool_data);
                        return;
                    }
                    var url = '{{ route('api.mikapi.pools.index') }}' + param_router +
                        '&limit=' +
                        perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            tomse_pool_data = json.data
                            callback(json.data);
                        }).catch(() => {
                            callback();
                        });
                },
            });
        });


        $('#reset').click(function() {
            document.getElementById('parent').tomselect.clear()
            document.getElementById('pool').tomselect.clear()
        })


        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_api_router,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponse(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            lengthChange: false,
            buttons: [{
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }, {
                text: '<i class="fas fa-plus"></i> Add',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    show_card_add()
                    input_focus('name')
                },
            }, {
                text: '<i class="fas fa-caret-down"></i>',
                extend: 'collection',
                className: 'btn btn-warning',
                buttons: [{
                    text: 'Delete Selected Data',
                    action: function(e, dt, node, config) {
                        delete_batch(url_index_api_router);
                    }
                }, {
                    text: 'Refresh Data',
                    action: function(e, dt, node, config) {
                        table.ajax.reload()
                    }
                }]
            }],
            dom: dom,
            stripeClasses: [],
            lengthMenu: length_menu,
            pageLength: 10,
            oLanguage: o_lang,
            sPaginationType: 'simple_numbers',
            columns: [{
                width: "30px",
                title: 'Id',
                data: 'DT_RowId',
                className: "",
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text = `<div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >`
                        if (row.disabled) {
                            text +=
                                '<span class="badge me-1 badge-danger bs-tooltip" title="Disabled">X</span>'
                        }
                        if (row.default) {
                            text +=
                                '<span class="badge me-1 badge-info bs-tooltip" title="Default">*</span>'
                        }
                        text += `</div>`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Name",
                data: 'name',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text =
                            `<i class="fa fa-ci fa-circle text-${row.scheduler ? 'success' : 'danger'} bs-tooltip" title="Scheduler Mikhmon ${row.scheduler ? 'Available' : 'Unavailable'}"></i> ${data}`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Shared User",
                data: 'shared-users',
                className: "text-center",
            }, {
                title: "Rate Limit",
                data: 'rate-limit',
                className: "text-center",
            }, {
                title: "Expired Mode",
                data: 'mikhmon',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        if (data != null) {
                            return data.exp_mode_parse
                        }
                    } else {
                        return '';
                    }
                }
            }, {
                title: "Validity",
                data: 'mikhmon',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        if (data != null) {
                            return data.validity
                        }
                    } else {
                        return '';
                    }
                }
            }, {
                title: "Price",
                data: 'mikhmon',
                className: "text-end",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        if (data != null) {
                            return hrg(data.price)
                        }
                    } else {
                        return '';
                    }
                }
            }, {
                title: "Selling Price",
                data: 'mikhmon',
                className: "text-end",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        if (data != null) {
                            return hrg(data.selling_price)
                        }
                    } else {
                        return '';
                    }
                }
            }, {
                title: "Lock User",
                data: 'mikhmon',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        if (data != null) {
                            return data.lock
                        }
                    } else {
                        return 'Disable';
                    }
                }
            }, ],
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = `
                <div class="form-check form-check-primary d-block new-control">
                    <input class="form-check-input chk-parent" type="checkbox" id="customer-all-info">
                </div>`
            },
            drawCallback: function(settings) {
                feather.replace();
                tooltip()
            },
            initComplete: function() {
                feather.replace();
            }
        });

        $('#btn_refresh').click(function() {
            table.ajax.reload()
        })

        $('#edit_delete').after(btn_detail)

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id() + param_router
            $('#formEdit').attr('action', url_index_api + "/" + id)
            edit(true)
        });

        function edit(show = false) {
            clear_validate('formEdit')
            $.ajax({
                url: url_index_api + "/" + id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    $('#edit_name').val(result.data.name);
                    $('#edit_shared_users').val(result.data['shared-users']);
                    $('#edit_rate_limit').val(result.data['rate-limit']);

                    // $('#edit_data_day').val(result.data.session_timeout_parse_array.day);
                    // f2.setDate(result.data.session_timeout_parse_array.time);
                    let tom = document.getElementById('edit_parent').tomselect
                    let tom_pool = document.getElementById('edit_pool').tomselect
                    if (result.data['parent-queue'] == null) {
                        tom.clear()
                    } else {
                        tom.addOption({
                            name: result.data['parent-queue']
                        })
                        tom.setValue(result.data['parent-queue'])
                    }
                    if (result.data['address-pool'] == null) {
                        tom_pool.clear()
                    } else {
                        tom_pool.addOption({
                            name: result.data['address-pool']
                        })
                        tom_pool.setValue(result.data['address-pool'])
                    }

                    if (result.data.mikhmon == null) {
                        $('#edit_expired_mode').val(0)
                        $('#edit_lock_user').val('Disable').change()
                        $('#edit_data_day').val(0);
                        f2.setDate('00:00:00');
                        $('#edit_price').val(0);
                        $('#edit_selling_price').val(0);
                    } else {
                        $('#edit_expired_mode').val(result.data.mikhmon.exp_mode)
                        $('#edit_lock_user').val(result.data.mikhmon.lock).change()
                        $('#edit_data_day').val(result.data.mikhmon.validity_parse.day);
                        f2.setDate(result.data.mikhmon.validity_parse.time);
                        $('#edit_price').val(result.data.mikhmon.price);
                        $('#edit_selling_price').val(result.data.mikhmon.selling_price);
                    }
                    $('#edit_expired_mode').change()
                    add_detail(result.data, 'tbl_detail')
                    if (show) {
                        show_card_edit()
                        input_focus('name')
                    }
                },
                beforeSend: function() {
                    block();
                },
                error: function(xhr, status, error) {
                    unblock();
                    handleResponse(xhr)
                }
            });
        }
        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
