@extends('layouts.backend.template_mikapi', ['title' => 'Hotspot Active'])
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

        @include('mikapi.hotspot.active.detail')

    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.hotspot.active') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.hotspot.actives.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.hotspot.actives.index') }}" + param_router
        var id = 0
        var perpage = 50

        var intervalIds = {};
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#refresh').click(function() {
                table.ajax.reload()
            })

            // setInterval(() => {
            //     table.ajax.reload()
            // }, 10000);
        })

        $('#edit_save').remove()

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_api_router,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponse(jqXHR)
                },
            },
            createdRow: function(row, data, dataIndex) {
                if (data.blocked == true) {
                    $('td', row).addClass('table-active');
                }
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
                        if (row.radius) {
                            text +=
                                '<span class="badge me-1 badge-success bs-tooltip" title="Radius">R</span>'
                        }
                        if (row.blocked) {
                            text +=
                                '<span class="badge me-1 badge-danger bs-tooltip" title="Bloked">B</span>'
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
                title: "User",
                data: 'user',
                className: "text-start",
            }, {
                title: "MAC",
                data: 'mac-address',
                className: "text-start",
            }, {
                title: "Address",
                data: 'address',
                className: "text-start",
            }, {
                title: "Uptime",
                data: 'uptime_parse',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text = `<span id="up_${row.DT_RowId}">${data}</span>`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Time Left",
                data: 'session_time_left_parse',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text = `<span id="stl_${row.DT_RowId}">${data}</span>`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "IN",
                data: 'bytes-in',
                className: "text-center",
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
                className: "text-center",
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
                tooltip()
            },
            initComplete: function() {
                feather.replace();
                tooltip()
                startUpdatingTime()
            }
        });

        $('#btn_refresh').click(function() {
            table.ajax.reload()
        })

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id() + param_router
            $('#formEdit').attr('action', url_index_api + "/" + id)
            edit(true)
        });

        function edit(show = false) {
            $.ajax({
                url: url_index_api + "/" + id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    add_detail(result.data, 'tbl_detail')
                    if (show) {
                        show_card_detail()
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

        function clearAllIntervals() {
            Object.values(intervalIds).forEach(clearInterval);
            intervalIds = {};
        }

        function startUpdatingTime() {
            let data = table.rows().data().toArray();
            data.forEach((element, index) => {
                let rowId = element.DT_RowId;
                if (!intervalIds[rowId]) {
                    let uptime = element.uptime_parse_all.s +
                        (element.uptime_parse_all.m * 60) +
                        (element.uptime_parse_all.h * 3600) +
                        (element.uptime_parse_all.d * 86400);

                    let sessionTimeLeft = element.session_time_left_parse_all.s +
                        (element.session_time_left_parse_all.m * 60) +
                        (element.session_time_left_parse_all.h * 3600) +
                        (element.session_time_left_parse_all.d * 86400);

                    let intervalId = setInterval(() => {
                        uptime++;
                        sessionTimeLeft = Math.max(sessionTimeLeft - 1, 0);

                        let uptimeDays = Math.floor(uptime / 86400);
                        let uptimeHours = Math.floor((uptime % 86400) / 3600);
                        let uptimeMinutes = Math.floor((uptime % 3600) / 60);
                        let uptimeSeconds = uptime % 60;

                        let sessionDays = Math.floor(sessionTimeLeft / 86400);
                        let sessionHours = Math.floor((sessionTimeLeft % 86400) / 3600);
                        let sessionMinutes = Math.floor((sessionTimeLeft % 3600) / 60);
                        let sessionSeconds = sessionTimeLeft % 60;

                        // Format angka agar selalu dua digit
                        let formattedUptime =
                            `${uptimeDays > 0 ? uptimeDays + 'd ' : ''}${String(uptimeHours).padStart(2, '0')}:${String(uptimeMinutes).padStart(2, '0')}:${String(uptimeSeconds).padStart(2, '0')}`;
                        let formattedSessionLeft =
                            `${sessionDays > 0 ? sessionDays + 'd ' : ''}${String(sessionHours).padStart(2, '0')}:${String(sessionMinutes).padStart(2, '0')}:${String(sessionSeconds).padStart(2, '0')}`;

                        let row = table.row(`#${rowId}`);
                        if (row.length) {
                            $(`#up_\\${element.DT_RowId}`).text(formattedUptime)
                            $(`#stl_\\${element.DT_RowId}`).text(formattedSessionLeft)
                        } else {
                            clearInterval(intervalIds[rowId]);
                            delete intervalIds[rowId];
                        }

                    }, 1000);

                    intervalIds[rowId] = intervalId;
                }
            });
        }

        table.on('xhr.dt', function() {
            Object.values(intervalIds).forEach(clearInterval);
            intervalIds = {};
            setTimeout(() => {
                startUpdatingTime();
            }, 500);
        });


        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
