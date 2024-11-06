@extends('layouts.backend.template_mikapi', ['title' => 'User Active'])
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

        @include('mikapi.system.user_active.detail')

    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.system.user_active') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.system.user_actives.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.system.user_actives.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        // $(document).ready(function() {
        $('#edit_save').remove()
        $('#edit_delete').remove()

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_api_router,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
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
            }, ],
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
                            text += '<span class="badge me-1 badge-info" title="Radius">R</span>'
                        }
                        if (row['by-romon']) {
                            text += '<span class="badge me-1 badge-secondary" title="By Romon">M</span>'
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
            }, {
                title: "At",
                data: 'when',
                className: "text-start",
            }, {
                title: "From",
                data: 'address',
                className: "text-start",
            }, {
                title: "Via",
                data: 'via',
                className: "text-start",
            }, {
                title: "Group",
                data: 'group',
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

        multiCheck(table)

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
