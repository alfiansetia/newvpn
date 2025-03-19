@extends('layouts.backend.template', ['title' => 'Data Transaction'])
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

    <link href="{{ cdn('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <style>
        .flatpickr-calendar {
            z-index: 1056 !important;
        }

        .tba {
            width: 35%;
            word-wrap: break-word;
            white-space: normal;
            text-align: left;
        }

        .tbb {
            width: 65%;
            word-wrap: break-word;
            white-space: normal;
            text-align: left;
        }

        .tbb::before {
            content: ": ";
        }

        .form-control.flatpickr-input {
            background-image: none !important;
        }
    </style>
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_table">
            <div class="row widget-statistic mb-2">
                <div class="col-xl-4 col-lg-4 col-md-4 col-12 layout-spacing">
                    <div class="widget widget-one_hybrid widget-engagement">
                        <div class="widget-heading mb-0">
                            <div class="w-title bs-tooltip mb-0" title="Total Income" id="filter_income"
                                style="cursor: pointer">
                                <div class="w-icon">
                                    <i data-feather="download"></i>
                                </div>
                                <div class="">
                                    <p class="w-value" id="data_income">Loading...</p>
                                    <h5 class="">Total Income</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-12 layout-spacing">
                    <div class="widget widget-one_hybrid widget-referral">
                        <div class="widget-heading mb-0">
                            <div class="w-title bs-tooltip mb-0" title="Total Outcome" id="filter_outcome"
                                style="cursor: pointer">
                                <div class="w-icon">
                                    <i data-feather="upload"></i>
                                </div>
                                <div class="">
                                    <p class="w-value" id="data_outcome">Loading...</p>
                                    <h5 class="">Total Outcome</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-12 layout-spacing">
                    <div class="widget widget-one_hybrid widget-followers">
                        <div class="widget-heading mb-0">
                            <div class="w-title bs-tooltip mb-0" title="Total Diff" id="filter_diff"
                                style="cursor: pointer">
                                <div class="w-icon">
                                    <i data-feather="trending-up"></i>
                                </div>
                                <div class="">
                                    <p class="w-value" id="data_diff">Loading...</p>
                                    <h5 class="">Total Diff</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
        @include('transaction.add')
        @include('transaction.edit')
    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/moment/moment-with-locales.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>

    <script>
        // $(document).ready(function() {

        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });

        const url_index = "{{ route('transactions.index') }}"
        const url_index_api = "{{ route('api.transactions.index') }}"
        const url_index_summary = "{{ route('api.transactions.summary') }}"
        var id = 0
        var perpage = 50

        get_data()

        setInterval(() => {
            get_data()
        }, 10000);

        var f1 = flatpickr(document.getElementById('date'), {
            defaultDate: "today",
            disableMobile: true,
        });

        var f2 = flatpickr(document.getElementById('edit_date'), {
            defaultDate: "today",
            disableMobile: true,
        });

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

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: {
                url: url_index_api,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
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
                    input_focus('desc')
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
                        delete_batch(url_index_api);
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
                data: 'id',
                className: "",
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >
                    </div>`
                }
            }, {
                title: "Date",
                data: 'date',
                className: "text-start",
            }, {
                title: "Amount",
                data: 'amount',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="${row.type == 'in' ? 'text-success' : 'text-danger'} bs-tooltip" title="${row.type == 'in' ? 'IN' : 'OUT'}">${row.type == 'in' ? '+' : '-'}</span> Rp. ${hrg(data)}`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Desc",
                data: 'desc',
                className: "text-start",
            }, {
                title: "Type",
                data: 'type',
                visible: false,
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

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id()
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
                    f2.setDate(result.data.date);
                    $('#edit_type').val(result.data.type).change();
                    $('#edit_amount').val(result.data.amount);
                    $('#edit_desc').val(result.data.desc);
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

        function filterTable(type) {
            if (type == 'in') {
                table.column(4).search('in').draw();
            } else if (type === 'out') {
                table.column(4).search('out').draw();
            } else {
                table.column(4).search('').draw();
                table.search('').draw();
            }
        }

        $('#filter_income').on('click', function() {
            filterTable('in');
        });

        $('#filter_outcome').on('click', function() {
            filterTable('out');
        });

        $('#filter_diff').on('click', function() {
            filterTable('all');
        });

        function get_data() {
            $.get(url_index_summary).done(function(result) {
                $('#data_income').text(hrg(result.data.income))
                $('#data_outcome').text(hrg(result.data.outcome))
                $('#data_diff').text(hrg(result.data.diff))
            })
        }

        // });
    </script>

    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
