@extends('layouts.backend.template_mikapi', ['title' => 'PPP Active'])
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

        @include('mikapi.ppp.active.detail')

    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.ppp.active') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.ppp.actives.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.ppp.actives.index') }}" + param_router
        var id = 0
        var perpage = 50
        var intervalIds = {};
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
                    $('td', row).css('background-color', 'rgb(218, 212, 212)');
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
                text: '<i class="fas fa-sync"></i>',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    table.ajax.reload()
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
                        let textt = `<div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >`
                        if (row.radius) {
                            textt +=
                                '<span class="badge me-1 badge-secondary bs-tooltip" title="Radius">R</span>'
                        }
                        if (row.local) {
                            textt +=
                                '<span class="badge me-1 badge-info bs-tooltip" title="Local">L</span>'
                        }
                        textt += `</div>`
                        return textt
                    } else {
                        return data
                    }
                }
            }, {
                title: "Name",
                data: 'name',
                className: 'text-start',
            }, {
                title: "Service",
                data: 'service',
                className: 'text-start',
            }, {
                title: "Caller Id",
                data: 'caller-id',
                className: 'text-start',
            }, {
                title: "Address",
                data: 'address',
                className: 'text-start',
            }, {
                title: "Uptime",
                data: 'uptime_parse',
                className: 'text-start',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text = `<span id="up_${row.DT_RowId}">${data}</span>`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Comment",
                data: 'comment',
                className: 'text-start',
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

                    let intervalId = setInterval(() => {
                        uptime++;
                        let uptimeDays = Math.floor(uptime / 86400);
                        let uptimeHours = Math.floor((uptime % 86400) / 3600);
                        let uptimeMinutes = Math.floor((uptime % 3600) / 60);
                        let uptimeSeconds = uptime % 60;

                        // Format angka agar selalu dua digit
                        let formattedUptime =
                            `${uptimeDays > 0 ? uptimeDays + 'd ' : ''}${String(uptimeHours).padStart(2, '0')}:${String(uptimeMinutes).padStart(2, '0')}:${String(uptimeSeconds).padStart(2, '0')}`;
                        let row = table.row(`#${rowId}`);
                        if (row.length) {
                            $(`#up_\\${element.DT_RowId}`).text(formattedUptime)
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
