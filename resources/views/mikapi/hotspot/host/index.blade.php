@extends('layouts.backend.template_mikapi', ['title' => 'Hotspot Host'])
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

        @include('mikapi.hotspot.host.detail')

    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.hotspot.host') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.hotspot.hosts.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.hotspot.hosts.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>

    <script>
        // $(document).ready(function() {

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
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }, {
                text: '<i class="fas fa-sync"></i>',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    table.ajax.reload()
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
                        if (row.authorized) {
                            text +=
                                '<span class="badge me-1 badge-success bs-tooltip" title="Authorized">A</span>'
                        }
                        if (row.bypassed) {
                            text +=
                                '<span class="badge me-1 badge-success bs-tooltip" title="Bypassed">P</span>'
                        }
                        if (row.blocked) {
                            text +=
                                '<span class="badge me-1 badge-danger bs-tooltip" title="Bloked">B</span>'
                        }
                        if (row.static) {
                            text +=
                                '<span class="badge me-1 badge-secondary bs-tooltip" title="Static">S</span>'
                        }
                        if (row['DHCP']) {
                            text +=
                                '<span class="badge me-1 badge-secondary bs-tooltip" title="DHCP">H</span>'
                        }
                        if (row.dynamic) {
                            text +=
                                '<span class="badge me-1 badge-secondary bs-tooltip" title="Dynamic">D</span>'
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
                title: "MAC",
                data: 'mac-address',
                className: "text-start",
            }, {
                title: "Address",
                data: 'address',
                className: "text-start",
            }, {
                title: "To Addr",
                data: 'to-address',
                className: "text-start",
            }, {
                title: "Uptime",
                data: 'uptime_parse',
                className: "text-start",
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
                // tooltip()
            },
            initComplete: function() {
                feather.replace();
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

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
