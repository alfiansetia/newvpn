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


    <link href="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/src/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
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
        var id = 0
        var perpage = 50

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
                        return `<span class="${row.type == 'in' ? 'text-success' : 'text-danger'}">${row.type == 'in' ? '+' : '-'}</span> Rp. ${hrg(data)}`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Desc",
                data: 'desc',
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

        // });
    </script>

    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
