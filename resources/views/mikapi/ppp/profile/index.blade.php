@extends('layouts.backend.template_mikapi', ['title' => 'PPP Profile'])
@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ cdn('backend/src/plugins/datatable/datatables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/table/datatable/dt-global_style.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"
        href="{{ cdn('backend/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link href="{{ cdn('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/src/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet" type="text/css">

    <style>
        .row-disabled {
            background-color: rgb(218, 212, 212)
        }

        .form-control.flatpickr-input,
        .form-control.flatpickr-input:disabled {
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

        @include('mikapi.ppp.profile.add')
        @include('mikapi.ppp.profile.edit')
        @include('mikapi.ppp.profile.detail')
    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>
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
        const url_index = "{{ route('mikapi.ppp.profile') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.ppp.profiles.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.ppp.profiles.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        // $(document).ready(function() {
        $(document).ready(function() {
            $('#refresh').click(function() {
                table.ajax.reload()
            })

            setInterval(() => {
                table.ajax.reload()
            }, 20000);
        })

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
            tomse.setValue('none')
        });

        $('#reset').click(function() {
            document.getElementById('parent').tomselect.setValue('none');
        })

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

        Inputmask("ip").mask($(".mask_ip"));

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
                    'title': 'Change Page Length'
                },
                className: 'btn btn-sm btn-info bs-tooltip'
            }, {
                text: '<i class="fas fa-plus"></i> Add',
                className: 'btn btn-primary bs-tooltip',
                attr: {
                    'title': 'Add New Data'
                },
                action: function(e, dt, node, config) {
                    show_card_add()
                    input_focus('name')
                },
            }, {
                text: '<i class="fas fa-caret-down"></i>',
                extend: 'collection',
                className: 'btn btn-warning bs-tooltip',
                attr: {
                    'title': 'More Action'
                },
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
            }, {
                title: "Local Address",
                data: 'local-address',
            }, {
                title: "Remote Address",
                data: 'remote-address',
            }, {
                title: "Rate Limit",
                data: 'rate-limit',
            }, {
                title: "Session Timeout",
                data: 'session-timeout',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return dtm(data);
                    } else {
                        return data;
                    }
                }
            }, {
                title: "Only One",
                data: 'only-one',
            }, {
                title: "Comment",
                data: 'comment',
            }],
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
                    $('#default').val((result.data.default ? 'yes' : 'no'));
                    $('#edit_name').val(result.data.name);
                    $('#edit_comment').val(result.data.comment);
                    $('#edit_rate_limit').val(result.data['rate-limit']);
                    $('#edit_local_address').val(result.data['local-address']);
                    $('#edit_remote_address').val(result.data['remote-address']);
                    $('#edit_only_one').val(result.data['only-one']).trigger('change');
                    $('#edit_data_day').val(result.data.session_timeout_parse_array.day);
                    f2.setDate(result.data.session_timeout_parse_array.time);
                    let tom = document.getElementById('edit_parent').tomselect
                    if (result.data['parent-queue'] == null) {
                        tom.clear()
                    } else {
                        tom.addOption({
                            name: result.data['parent-queue']
                        })
                        tom.setValue(result.data['parent-queue'])
                    }
                    if (result.data.default) {
                        $('#edit_name').prop('disabled', true);
                    } else {
                        $('#edit_name').prop('disabled', false);
                    }
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
