@extends('layouts.backend.template_mikapi', ['title' => 'Hotspot User'])
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
    <link href="{{ asset('backend/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />


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

        @include('mikapi.hotspot.user.add')
        @include('mikapi.hotspot.user.edit')
        @include('mikapi.hotspot.user.detail')
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
        // $(document).ready(function() {


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

        document.querySelectorAll('.tomse-profile').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'name',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Profile",
                allowEmptyOption: true,
                load: function(query, callback) {
                    var url = '{{ route('api.mikapi.hotspot.profiles.index') }}' + param_router +
                        '&limit=' + perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            callback(json.data);
                        }).catch(() => {
                            callback();
                        });
                },
            });
        });

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
                    var url = '{{ route('api.mikapi.hotspot.servers.index') }}' + param_router +
                        '&limit=' +
                        perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            callback(json.data);
                        }).catch(() => {
                            callback();
                        });
                },
            });
        });


        $('#reset').click(function() {
            document.getElementById('server').tomselect.clear()
            document.getElementById('profile').tomselect.clear()
        })

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url_index_api_router,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            createdRow: function(row, data, dataIndex) {
                if (data.disabled == true) {
                    $('td', row).css('background-color', 'rgb(218, 212, 212)');
                }
            },
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
                        delete_batch(url_index_api);
                    }
                }, {
                    text: 'Refresh Data',
                    action: function(e, dt, node, config) {
                        send_ajax_url("{{ route('api.mikapi.hotspot.users.refresh') }}" +
                            param_router)
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
                        let text =
                            `<div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" ${row.default ? 'disabled' : ''} name="id[]" value="${data}" >`
                        if (row.disabled) {
                            text +=
                                '<span class="badge me-1 badge-danger" title="Disabled">X</span>'
                        }
                        if (row.default) {
                            text +=
                                '<span class="badge me-1 badge-info" title="Default">*</span>'
                        }
                        text += `</div>`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Server",
                data: 'server',
                className: "text-start",
            }, {
                title: "Name",
                data: 'name',
                className: "text-start",
            }, {
                title: "Profile",
                data: 'profile',
                className: "text-start",
            }, {
                title: "MAC",
                data: 'mac-address',
                className: "text-start",
            }, {
                title: "Uptime",
                data: 'uptime_parse',
                className: "text-center",
            }, {
                title: "IN",
                data: 'bytes-in',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return formatBytes(data);
                    } else {
                        return data;
                    }
                }
            }, {
                title: "OUT",
                data: 'bytes-out',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return formatBytes(data);
                    } else {
                        return data;
                    }
                }
            }, {
                title: "Comment",
                data: 'comment',
                className: "text-start",
            }],
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = `
                <div class="form-check form-check-primary d-block new-control">
                    <input class="form-check-input chk-parent" type="checkbox" id="customer-all-info">
                </div>`
            },
            drawCallback: function(settings) {
                feather.replace();
                // tooltip()
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
                    $('#edit_password').val(result.data['password']);
                    $('#edit_rate_limit').val(result.data['rate-limit']);
                    $('#edit_comment').val(result.data.comment);
                    $('#edit_ip_address').val(result.data['address']);
                    $('#edit_data_day').val(result.data.limit_parse_array.day);
                    f2.setDate(result.data.limit_parse_array.time);
                    let limit = result.data['limit-bytes-total'];
                    if (limit > 0 && limit < 1000000) {
                        $('#edit_data_limit').val(limit / 1000);
                        $('#edit_data_type').val('K').change();
                    } else if (limit >= 1000000 && limit < 1000000000) {
                        let mb = limit / 1000000;
                        $('#edit_data_limit').val(mb);
                        $('#edit_data_type').val('M').change();
                    } else if (limit >= 1000000000) {
                        let gb = limit / 1000000000;
                        $('#edit_data_limit').val(gb);
                        $('#edit_data_type').val('G').change();
                    } else {
                        $('#edit_data_limit').val(0);
                        $('#edit_data_type').val('K').change();
                    }
                    let tom_server = document.getElementById('edit_server').tomselect
                    let tom_profile = document.getElementById('edit_profile').tomselect
                    if (result.data.default) {
                        tom_server.disable()
                        tom_profile.disable()
                    } else {
                        tom_server.enable()
                        tom_profile.enable()
                    }
                    if (result.data.server == null) {
                        tom_server.clear()
                    } else {
                        tom_server.addOption({
                            name: result.data.server
                        })
                        tom_server.setValue(result.data.server)
                    }
                    if (result.data.profile == null) {
                        tom_profile.clear()
                    } else {
                        tom_profile.addOption({
                            name: result.data.profile
                        })
                        tom_profile.setValue(result.data.profile)
                    }
                    if (result.data['mac-address'] == null) {
                        $('#edit_mac').val('');
                    } else {
                        $('#edit_mac').val(result.data['mac-address']);
                    }

                    if (result.data.disabled == false) {
                        $('#edit_is_active').prop('checked', true).change();
                    } else {
                        $('#edit_is_active').prop('checked', false).change();
                    }

                    let disabled = ['edit_server', 'edit_profile', 'edit_name', 'edit_password',
                        'edit_ip_address', 'edit_mac', 'edit_data_day', 'edit_time_limit',
                        'edit_data_limit', 'edit_data_type', 'edit_comment', 'edit_is_active', 'edit_save',
                        'edit_delete',
                    ]
                    disabled.forEach(element => {
                        $(`#${element}`).prop('disabled', result.data.default);
                    });

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
